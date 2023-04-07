<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Agronomica;
use App\DatoAgronomico;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\AgronomicaFormRequest;
use DB;
//use App\Exports\agronomicaExport;
use Maatwebsite\Excel\Facades\Excel;

class AgronomicaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
    	if($request){
    		$query=trim($request->get('searchText'));

    		$agronomicas=DB::table('agronomicas as a')->where ('t.nombre','like','%'.$query.'%') 
            ->select('a.id','b.nombre as banco','t.nombre','a.fechageneracion','a.observaciones')
            ->leftjoin('bancos as b','b.idbanco','=','a.idbanco')
            ->leftjoin('tiposagronomicas as t','t.id','=','a.idnombre')
    		->where ('a.estado','=',1)
    		->orderBy('id','desc')
    		->paginate('10');

    		return view('admin.bancos.agronomicas.index',["agronomicas"=>$agronomicas,"searchText"=>$query]);
    	}
    }

    public function create()
    {

        $variedades=DB::table('variedadesbanco')
        ->where ('estado','=',1)
        ->count();

        $tipos=DB::table('tiposagronomicas')
        ->where ('estado','=',1)
        ->get();
        //dd($variedades);

        $bancos=DB::table('bancos')
        ->select('idbanco','nombre')
        ->where ('estado','=',1)
        ->orderBy('idbanco','desc')
        ->first();

    	return view ("admin.bancos.agronomicas.create",["variedades"=>$variedades,"bancos"=>$bancos,"tipos"=>$tipos]);
    }

    public function store(AgronomicaFormRequest $request)
    {

    	$agronomica=new Agronomica;
    	$agronomica->idbanco=$request->get('idbanco');
        $agronomica->idnombre=$request->get('idnombre');
        $agronomica->fechageneracion=$request->get('fechageneracion');
        $agronomica->observaciones=$request->get('observaciones');
    	$agronomica->estado='1';
    	$agronomica->save();

        $key = $agronomica->id;


        $variedadesbanco=DB::table('variedadesbanco as v')
        ->select('id','idbanco','tabla','tablita','surco','parcela','va.nombre as nombrevariedad','testigo')
        ->leftjoin('variedades as va','va.idvariedad','=','v.idvariedad')
        ->where ('v.idbanco','=',$request->get('idbanco'))
        ->where ('v.estado','=',1)
        ->get();
        $array = [];

             foreach ($variedadesbanco as $vb){
                        // $datosagronomica=new DatoAgronomico;
                        // $datosagronomica->idevaluacion=$agronomica->id;
                        // $datosagronomica->idbanco=$vb->idbanco;
                        // $datosagronomica->idubicacion=$vb->id;
                        // $datosagronomica->tallos=0;
                        // $datosagronomica->altura=0;
                        // $datosagronomica->grosor=0;
                        // $datosagronomica->vuelco=0;
                        // $datosagronomica->floracion=0;
                        // $datosagronomica->otra="";
                        // $datosagronomica->save();
$array []= array("idevaluacion" => $key, "idbanco" => $vb->idbanco,"idubicacion"=> $vb->id);
            }
       DB::table('datosagronomicos')->insert($array);


    	return Redirect::to('bancos/agronomicas');



    }

    public function show($id)
    {
    	return view("admin.bancos.agronomicas.show",["Agronomica"=>Agronomica::findOrFail($id)]);
    }

     public function edit(Agronomica $agronomica)
    {
        $tipos=DB::table('tiposagronomicas')
        ->where ('estado','=',1)
        ->get();

        $agronomica=DB::table('agronomicas as a')
        ->select('a.id as idagronomica','a.idnombre','t.nombre','a.fechageneracion','a.observaciones','b.idbanco','b.nombre as nombrebanco')
        ->leftjoin('bancos as b','b.idbanco','=','a.idbanco')
        ->leftjoin('tiposagronomicas as t','t.id','=','a.idnombre')
        ->where ('a.id','=',$agronomica->id)
        ->where ('a.estado','=',1)
        ->first();
        //dd($agronomica);
        return view('admin.bancos.agronomicas.edit',compact('agronomica'),["agronomica"=>$agronomica,"tipos"=>$tipos]);

    }

    public function view(Agronomica $agronomica)
    {
        return view('admin.banco.agronomicas.view',compact('agronomica'));
    }

    public function update(AgronomicaFormRequest $request,$id)
    {
        $agronomica=Agronomica::findOrFail($id);
        $agronomica->idnombre=$request->get('idnombre');
        $agronomica->fechageneracion=$request->get('fechageneracion');
        $agronomica->observaciones=$request->get('observaciones');
        $agronomica->estado=1;//$request->get('estado');

        $agronomica->update();
        return Redirect::to('admin/agronomicas');
    }

    public function destroy($id)
    {
    	$agronomica=Agronomica::findOrFail($id);
    	$agronomica->estado='0';//baja
      	$agronomica->update();
    	return Redirect::to('admin/agronomicas');
    }


    public function export() 
    {

        return Excel::download(new bancosExport, 'bancos.xlsx');
    }

    public function ubicacionesasociadas(Request $request,$id)
    {

        // $banco=Banco::findOrFail($id);

        // $ubicacionesasociadas=DB::table('variedadesbanco as e')
        // ->select('e.id','e.idbanco','e.tabla','e.tablita','e.surco','e.parcela','v.nombre')
        // ->leftjoin('variedades as v','v.idvariedad','=','e.idvariedad')
        // ->where ('e.idbanco','=',$id)
        // ->orderBy('e.id','asc')
        // ->get();

        // return view("admin.bancos.ubicaciones.ubicaciones",compact("banco"),["banco"=>$banco,"ubicacionesasociadas"=>$ubicacionesasociadas]);

        $datosasociados=DB::table('datosagronomicos as d')
        ->select('vb.*','d.*','v.idvariedad','v.nombre as nombrevariedad','ta.nombre')
 //       ->select('d.*')
        ->join('bancos as b','b.idbanco','=','d.idbanco')
        ->join('agronomicas as a','a.id','=','d.idevaluacion')
        ->join('tiposagronomicas as ta','ta.id','=','a.id')
        ->join('variedadesbanco as vb','vb.id','=','d.idubicacion')
        ->leftjoin('variedades as v','v.idvariedad','=','vb.idvariedad')
        ->where ('d.idevaluacion','=',$id)
        ->orderBy('d.id','asc')
        ->paginate('100');
       // dd($datosasociados);

        $data = '';

 //       dd($datosasociados);


        if ($request->ajax()) {
                $data .= '<div class="table-responsive"><table class="table table-striped table-bordered table-condensed table-hover">';
                $data .= '<thead><th width="5%">T.</th> <th width="5%">Tabla</th><th width="5%">Tablita</th><th width="5%">Surco</th><th width="5%">Parcela</th><th width="10%">Variedad</th><th width="10%">Tallos</th><th width="10%">Altura</th><th width="10%">Grosor</th><th width="10%">Vuelco</th><th width="10%">Floración</th><th width="15%">Otra</th></thead>';
            foreach ($datosasociados as $datos) {

                if ($datos->testigo==1) 
                    $t='value = 1 checked';
                else
                    $t='value = 0';
                $data.='<tr>';
                $data.='<td width=1%><input type="checkbox" name="t" id="t" '.$t.'  disabled> </td>';
                $data.='<td width=6%><label for="tabla">'.$datos->tabla.'</label></td>';
                $data.='<td width=7%><label for="tabla">'.$datos->tablita.'</label></td>';
                $data.='<td width=7%><label for="tabla">'.$datos->surco.'</label></td>';
                $data.='<td width=8%><label for="tabla">'.$datos->parcela.'</label></td>';
                $data.='<td width=9%><label for="tabla">'.$datos->nombrevariedad.'</label></td>';
                $data.='<td width=10%><input type="text" name="t'.$datos->id.'" id="t'.$datos->id.'"class="form-control" value="'.$datos->tallos.'"></td>';
                $data.='<td width=10%><input type="text" name="a'.$datos->id.'" id="a'.$datos->id.'"class="form-control" value="'.$datos->altura.'"></td>';
                $data.='<td width=10%><input type="text" name="g'.$datos->id.'" id="g'.$datos->id.'"class="form-control" value="'.$datos->grosor.'"></td>';
                $data.='<td width=10%><input type="text" name="v'.$datos->id.'" id="v'.$datos->id.'"class="form-control" value="'.$datos->vuelco.'"></td>';
                $data.='<td width=10%><input type="text" name="f'.$datos->id.'" id="f'.$datos->id.'"class="form-control" value="'.$datos->floracion.'"></td>';
                $data.='<td width=10%><input type="text" name="o'.$datos->id.'" id="o'.$datos->id.'"class="form-control" value="'.$datos->otra.'" onblur="guardavariedad(this.name)"></td>';

                $data.='</tr>';
            }
            $data.='</table></div>';


            return $data;
        }
        return view("admin.bancos.ubicaciones.ubicaciones",compact("banco"),["banco"=>$banco,"ubicacionesasociadas"=>$ubicacionesasociadas]);
       



    }

    public function datosasociados($id)
    {
        $agronomica=Agronomica::findOrFail($id);



        $datosasociados=DB::table('datosagronomicos as d')
        ->select('vb.*','d.*','v.idvariedad','v.nombre as nombrevariedad','ta.nombre')
 //       ->select('d.*')
        ->join('bancos as b','b.idbanco','=','d.idbanco')
        ->join('agronomicas as a','a.id','=','d.idevaluacion')
        ->join('tiposagronomicas as ta','ta.id','=','a.id')
        ->join('variedadesbanco as vb','vb.id','=','d.idubicacion')
        ->leftjoin('variedades as v','v.idvariedad','=','vb.idvariedad')
        ->where ('d.idevaluacion','=',$id)
        ->orderBy('d.id','asc')
        ->get();


    //dd($datosasociados);


        return view("admin.bancos.agronomicas.datos.datos",compact("agronomica"),["agronomica"=>$agronomica,"datosasociados"=>$datosasociados]);
        //return Redirect::to('admin/importaciones/inspecciones/'.$request->get('idimportacion').'/');


    }

    public function editardatos(AgronomicaFormRequest $request,$id)
    {
        $datosagronomica=DB::table('datosagronomicos')
        ->select('id')
        ->where ('idevaluacion','=',$request->get('idevaluacion'))
        ->get();

        foreach ($datosagronomica as $d){

            $datoagronomico=DatoAgronomico::findOrFail($d->id);
            $datoagronomico->tallos=$request->get('t'.$d->id);
            $datoagronomico->altura=$request->get('a'.$d->id);
            $datoagronomico->grosor=$request->get('g'.$d->id);
            $datoagronomico->vuelco=$request->get('v'.$d->id);
            $datoagronomico->floracion=$request->get('f'.$d->id);
            $datoagronomico->otra=$request->get('o'.$d->id);


         //   dd($datoagronomico);
            $datoagronomico->update();
        }



        return Redirect::to('bancos/agronomicas');

    }

    public function updateVariedad(Request $request,$id)
    {
        return view('admin/bancos/ubicaciones/data');
    }
   
    public function updateEvaluacionPost(Request $request)
    {
        $input = $request->all();
        \Log::info($input);


            $datoagronomico=DatoAgronomico::findOrFail($request->get('id'));
            $datoagronomico->tallos=$request->get('tallos');
            $datoagronomico->altura=$request->get('altura');
            $datoagronomico->grosor=$request->get('grosor');
            $datoagronomico->vuelco=$request->get('vuelco');
            $datoagronomico->floracion=$request->get('floracion');
            $datoagronomico->otra=$request->get('otras');

         //   dd($datoagronomico);
            $datoagronomico->update();
        return response()->json();
    }

}
