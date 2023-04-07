<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Sanitaria;
use App\DatoSanitario;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\SanitariaFormRequest;
use DB;
//use App\Exports\sanitariaExport;
use Maatwebsite\Excel\Facades\Excel;

class SanitariaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
    	if($request){
    		$query=trim($request->get('searchText'));

    		$sanitarias=DB::table('sanitarias as a')->where ('t.nombre','like','%'.$query.'%') 
            ->select('a.id','b.nombre as banco','t.nombre','a.fechageneracion','a.observaciones')
            ->leftjoin('bancos as b','b.idbanco','=','a.idbanco')
            ->leftjoin('tipossanitarias as t','t.id','=','a.idnombre')
    		->where ('a.estado','=',1)
    		->orderBy('id','desc')
    		->paginate('10');

    		return view('admin.bancos.sanitarias.index',["sanitarias"=>$sanitarias,"searchText"=>$query]);
    	}
    }

    public function create()
    {

        $variedades=DB::table('variedades')
        ->where ('estado','=',1)
        ->count();
        //dd($variedades);

        $tipos=DB::table('tipossanitarias')
        ->where ('estado','=',1)
        ->get();

        $bancos=DB::table('bancos')
        ->select('idbanco','nombre')
        ->where ('estado','=',1)
        ->orderBy('idbanco','desc')
        ->first();

    	return view ("admin.bancos.sanitarias.create",["variedades"=>$variedades,"bancos"=>$bancos,"tipos"=>$tipos]);
    }

    public function store(SanitariaFormRequest $request)
    {

    	$sanitaria=new Sanitaria;
    	$sanitaria->idbanco=$request->get('idbanco');
        $sanitaria->idnombre=$request->get('idnombre');
        $sanitaria->fechageneracion=$request->get('fechageneracion');
        $sanitaria->observaciones=$request->get('observaciones');
    	$sanitaria->estado='1';
    	$sanitaria->save();

        $key = $sanitaria->id;

        $variedadesbanco=DB::table('variedadesbanco as v')
        ->select('id','idbanco','tabla','tablita','surco','parcela','va.nombre as nombrevariedad','testigo')
        ->leftjoin('variedades as va','va.idvariedad','=','v.idvariedad')
        ->where ('v.idbanco','=',$request->get('idbanco'))
        ->where ('v.estado','=',1)
        ->get();
        $array = [];

             foreach ($variedadesbanco as $vb){
                        // $datossanitaria=new DatoSanitario;
                        // $datossanitaria->idevaluacion=$sanitaria->id;
                        // $datossanitaria->idbanco=$vb->idbanco;
                        // $datossanitaria->idubicacion=$vb->id;
                        // $datossanitaria->carbon=0;
                        // $datossanitaria->escaladura=0;
                        // $datossanitaria->estriaroja=0;
                        // $datossanitaria->mosaico=0;
                        // $datossanitaria->royamarron=0;
                        // $datossanitaria->royaanaranjada=0;
                        // $datossanitaria->pokkaboeng=0;
                        // $datossanitaria->amarillamiento=0;
                        // $datossanitaria->manchaparda=0;
                        // $datossanitaria->otra="";

                        // $datossanitaria->save();

    $array []= array("idevaluacion" => $key, "idbanco" => $vb->idbanco,"idubicacion"=> $vb->id);

                    }

       DB::table('datossanitarios')->insert($array);


    	return Redirect::to('bancos/sanitarias');



    }

    public function show($id)
    {
    	return view("admin.bancos.sanitarias.show",["Sanitaria"=>Sanitaria::findOrFail($id)]);
    }

     public function edit(Sanitaria $sanitaria)
    {
       // dd($sanitaria);
        $tipos=DB::table('tipossanitarias')
        ->where ('estado','=',1)
        ->get();

        $sanitaria=DB::table('sanitarias as a')
        ->select('a.id as idsanitaria','a.idnombre','t.nombre','a.fechageneracion','a.observaciones','b.idbanco','b.nombre as nombrebanco')
        ->leftjoin('bancos as b','b.idbanco','=','a.idbanco')
        ->leftjoin('tipossanitarias as t','t.id','=','a.idnombre')
        ->where ('a.id','=',$sanitaria->id)
        ->where ('a.estado','=',1)
        ->first();
        //dd($sanitaria);
        return view('admin.bancos.sanitarias.edit',compact('sanitaria'),["sanitaria"=>$sanitaria,"tipos"=>$tipos]);

    }

    public function view(Sanitaria $sanitaria)
    {
        return view('admin.banco.sanitarias.view',compact('sanitaria'));
    }

    public function update(SanitariaFormRequest $request,$id)
    {
        $sanitaria=Sanitaria::findOrFail($id);
        $sanitaria->idnombre=$request->get('idnombre');
        $sanitaria->fechageneracion=$request->get('fechageneracion');
        $sanitaria->observaciones=$request->get('observaciones');
        $sanitaria->estado=1;//$request->get('estado');

        $sanitaria->update();
        return Redirect::to('admin/sanitarias');
    }

    public function destroy($id)
    {
    	$sanitaria=Sanitaria::findOrFail($id);
    	$sanitaria->estado='0';//baja
      	$sanitaria->update();
    	return Redirect::to('admin/sanitarias');
    }


    public function export() 
    {

        return Excel::download(new bancosExport, 'bancos.xlsx');
    }

    public function ubicacionesasociadas(Request $request,$id)
    {
        $datosasociados=DB::table('datossanitarios as d')
        ->select('vb.*','d.*','v.idvariedad','v.nombre as nombrevariedad')
 //       ->select('d.*')
        ->join('bancos as b','b.idbanco','=','d.idbanco')
        ->join('sanitarias as a','a.id','=','d.idevaluacion')
        ->join('variedadesbanco as vb','vb.id','=','d.idubicacion')
        ->leftjoin('variedades as v','v.idvariedad','=','vb.idvariedad')
        ->where ('d.idevaluacion','=',$id)
        ->orderBy('d.id','asc')
        ->paginate('100');

     //   dd($datosasociados);
        $data = '';




        if ($request->ajax()) {
            $data .= '<div class="table-responsive"><table class="table table-striped table-bordered table-condensed table-hover">';
            $data.='<thead><th>T.</th><th><div class="sizem">Ubicación</div></th><th><div class="sizem">Variedad</div></th><th><div class="sizem">Carbón</div></th><th><div class="sizem">Escaldadura</div></th><th><div class="sizem">Estría roja</div></th><th><div class="sizem">Mosaico</div></th><th><div class="sizem">Roya marrón</div></th><th><div class="sizem">Roya anaranjada</div></th><th><div class="sizem">Pokka boeng</div></th><th><div class="sizem">Amarillamiento</div></th><th><div class="sizem">Mancha parda</div></th><th><div class="sizem">Otra</div></th></thead>';
            foreach ($datosasociados as $datos) {
                if ($datos->testigo==1) 
                    $t='value = 1 checked';
                else
                    $t='value = 0';
                $data.='<tr>';
                $data.='<td><input type="checkbox" name="t" id="t" '.$t.'  disabled> </td>';
                $data.='<td><label for="tabla">'.$datos->tabla.'-'.$datos->tablita.'-'.$datos->surco.'-'.$datos->parcela.'</label></td>';
                $data.='<td><label for="tabla">'.$datos->nombrevariedad.'</label></td>';
                $data.='<td><input type="text" name="c'.$datos->id.'" id="c'.$datos->id.'"class="form-control" value="'.$datos->carbon.'"></td>';
                $data.='<td><input type="text" name="e'.$datos->id.'" id="e'.$datos->id.'"class="form-control" value="'.$datos->escaladura.'"></td>';
                $data.='<td><input type="text" name="er'.$datos->id.'" id="er'.$datos->id.'"class="form-control" value="'.$datos->estriaroja.'"></td>';
                $data.='<td><input type="text" name="m'.$datos->id.'" id="m'.$datos->id.'"class="form-control" value="'.$datos->mosaico.'"></td>';
                $data.='<td><input type="text" name="rm'.$datos->id.'" id="rm'.$datos->id.'"class="form-control" value="'.$datos->royamarron.'"></td>';
                $data.='<td><input type="text" name="ra'.$datos->id.'" id="ra'.$datos->id.'"class="form-control" value="'.$datos->royaanaranjada.'"></td>';
                $data.='<td><input type="text" name="pb'.$datos->id.'" id="pb'.$datos->id.'"class="form-control" value="'.$datos->pokkaboeng.'"></td>';
                $data.='<td><input type="text" name="a'.$datos->id.'" id="a'.$datos->id.'"class="form-control" value="'.$datos->amarillamiento.'"></td>';
                $data.='<td><input type="text" name="mp'.$datos->id.'" id="mp'.$datos->id.'"class="form-control" value="'.$datos->manchaparda.'"></td>';
                $data.='<td><input type="text" name="o'.$datos->id.'" id="o'.$datos->id.'"class="form-control" value="'.$datos->otra.'" onblur="guardavariedad(this.name)"></td>';

                $data.='</tr>';
            }
            $data.='</table></div>';
            return $data;
        }
        return view("admin.bancos.ubicaciones.ubicaciones",compact("banco"),["banco"=>$banco,"ubicacionesasociadas"=>$ubicacionesasociadas]);
       


    }

    public function datosasociados($id)
    {
        $sanitaria=Sanitaria::findOrFail($id);



        $datosasociados=DB::table('datossanitarios as d')
        ->select('vb.*','d.*','v.idvariedad','v.nombre as nombrevariedad', 'ts.nombre')
 //       ->select('d.*')
        ->join('bancos as b','b.idbanco','=','d.idbanco')
        ->join('sanitarias as a','a.id','=','d.idevaluacion')
        ->join('tipossanitarias as ts','ts.id','=','a.id')
        ->join('variedadesbanco as vb','vb.id','=','d.idubicacion')
        ->leftjoin('variedades as v','v.idvariedad','=','vb.idvariedad')
        ->where ('d.idevaluacion','=',$id)
        ->orderBy('d.id','asc')
        ->get();


    //dd($datosasociados);


        return view("admin.bancos.sanitarias.datos.datos",compact("sanitaria"),["sanitaria"=>$sanitaria,"datosasociados"=>$datosasociados]);
        //return Redirect::to('admin/importaciones/inspecciones/'.$request->get('idimportacion').'/');


    }

    public function editardatos(SanitariaFormRequest $request,$id)
    {
        $datossanitaria=DB::table('datossanitarios')
        ->select('id')
        ->where ('idevaluacion','=',$request->get('idevaluacion'))
        ->get();

        foreach ($datossanitaria as $d){

            $datosanitario=DatoSanitario::findOrFail($d->id);
            $datosanitario->carbon=$request->get('c'.$d->id);
            $datosanitario->escaladura=$request->get('e'.$d->id);
            $datosanitario->estriaroja=$request->get('er'.$d->id);
            $datosanitario->mosaico=$request->get('m'.$d->id);
            $datosanitario->royamarron=$request->get('rm'.$d->id);
            $datosanitario->royaanaranjada=$request->get('ra'.$d->id);
            $datosanitario->pokkaboeng=$request->get('p'.$d->id);
            $datosanitario->amarillamiento=$request->get('a'.$d->id);
            $datosanitario->manchaparda=$request->get('mp'.$d->id);
            $datosanitario->otra=$request->get('o'.$d->id);


         //   dd($datosanitario);
            $datosanitario->update();
        }



        return Redirect::to('bancos/sanitarias');

    }

    public function updateEvaluacionPost(Request $request)
    {
        $input = $request->all();
        \Log::info($input);


            $datosanitario=DatoSanitario::findOrFail($request->get('id'));
            $datosanitario->carbon=$request->get('carbon');
            $datosanitario->escaladura=$request->get('escaladura');
            $datosanitario->estriaroja=$request->get('estriaroja');
            $datosanitario->mosaico=$request->get('mosaico');
            $datosanitario->royamarron=$request->get('royamarron');
            $datosanitario->royaanaranjada=$request->get('royaanaranjada');
            $datosanitario->pokkaboeng=$request->get('pokkaboeng');
            $datosanitario->amarillamiento=$request->get('amarillamiento');
            $datosanitario->manchaparda=$request->get('manchaparda');
            $datosanitario->otra=$request->get('otra');


         //   dd($datosanitario);
            $datosanitario->update();
        return response()->json();
    }

}
