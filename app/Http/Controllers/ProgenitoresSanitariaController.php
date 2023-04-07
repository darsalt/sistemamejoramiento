<?php

namespace App\Http\Controllers;

use App\Campania;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Sanitariap;
use App\Sanitaria;

use App\DatoSanitariop;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\SanitariapFormRequest;
use DB;
//use App\Exports\sanitariaExport;
use Maatwebsite\Excel\Facades\Excel;

class ProgenitoresSanitariaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if($request){
            $query=trim($request->get('searchText'));

            $sanitariasp=DB::table('sanitariasp as a')->where ('t.nombre','like','%'.$query.'%') 
            ->select('a.id','t.nombre','a.fechageneracion','a.observaciones', 'c.nombre as nombre_campania')
            ->leftjoin('tipossanitarias as t','t.id','=','a.idnombre')
            ->leftjoin('campanias as c', 'c.id', '=', 'a.idcampania')
            ->where ('a.estado','=',1)
            ->orderBy('id','desc')
            ->paginate('10');


            return view('admin.progenitores.sanitarias.index',["sanitariasp"=>$sanitariasp,"searchText"=>$query]);
        }
    }

    public function create()
    {
        $tachos=DB::table('tachos')
        ->where ('destino','=',1)
        ->where ('estado','=',1)
        ->count();
        //dd($variedades);

        $tipos=DB::table('tipossanitarias')
        ->where ('estado','=',1)
        ->get();

        $campanias = Campania::where('estado', 1)->orderByDesc('nombre')->get();

        return view ("admin.progenitores.sanitarias.create",["tachos"=>$tachos,"tipos"=>$tipos, 'campanias'=>$campanias]);

    }

    public function store(SanitariapFormRequest $request)
    {

        $sanitariap=new Sanitariap;
        // El banco=null indica que es una evaluacion de progenitores
        $sanitariap->idnombre=$request->get('idnombre');
        $sanitariap->idcampania = $request->get('campania');
        $sanitariap->fechageneracion=$request->get('fechageneracion');
        $sanitariap->observaciones=$request->get('observaciones');
        $sanitariap->estado='1';

        $sanitariap->save();

        $key = $sanitariap->id;

        $tachos=DB::table('tachos as t')
        ->select('idtacho')
        ->where ('t.destino','=',1) 
        ->where ('t.estado','=',2)
        ->get();
        $array = [];

        foreach ($tachos as $t){
            $array []= array("idevaluacion" => $key,"idtacho" => $t->idtacho);
        }

       DB::table('datossanitariosp')->insert($array);


        return Redirect::to('admin/sanitariasp');

    }

    public function show($id)
    {
        return view("admin.progenitores.sanitarias.show",["Sanitariap"=>Sanitariap::findOrFail($id)]);
    }

     public function edit($id)
    {

        $tipos=DB::table('tipossanitarias')
        ->where ('estado','=',1)
        ->get();

        $sanitariap=DB::table('sanitariasp as a')
        ->select('a.id as idsanitariap','a.idnombre','t.nombre','a.fechageneracion','a.observaciones')
        ->leftjoin('tipossanitarias as t','t.id','=','a.idnombre')
        ->where ('a.id','=',$id)
        ->where ('a.estado','=',1)
        ->first();
        return view('admin.progenitores.sanitarias.edit',compact('sanitariap'),["sanitariap"=>$sanitariap,"tipos"=>$tipos]);
 //     return view('admin.tachos.cortes.edit',compact('corte'));


    }

    public function view(Sanitariap $sanitariap)
    {
        return view('admin.progenitores.sanitarias.view',compact('sanitariap'));
    }

    public function update(SanitariapFormRequest $request,$id)
    {
        $sanitariap=Sanitariap::findOrFail($id);
        $sanitariap->idnombre=$request->get('idnombre');
        $sanitariap->fechageneracion=$request->get('fechageneracion');
        $sanitariap->observaciones=$request->get('observaciones');
        $sanitariap->estado=1;//$request->get('estado');

        $sanitariap->update();
        return Redirect::to('admin/sanitariasp');

        //return Redirect::to('admin/progenitores/sanitarias');
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
        $sanitariap=Sanitariap::findOrFail($id);

        $datosasociados=DB::table('datossanitariosp as d')
        ->select('d.*','t.codigo','t.subcodigo')
 //       ->select('d.*')
        ->join('sanitariasp as a','a.id','=','d.idevaluacion')
        ->join('tachos as t','t.idtacho','=','d.idtacho')        
        ->where ('d.idevaluacion','=',$id)
        ->whereIn('t.idtacho', DB::table('tachos_campanias as tc')->where('idcampania', $sanitariap->campania->id)->pluck('tc.idtacho'))
        ->orderBy('d.id','asc')
        ->paginate('100');
//dd($datosasociados);
        $data = '';




        if ($request->ajax()) {
            $data .= '<div class="table-responsive"><table class="table table-striped table-bordered table-condensed table-hover">';
            $data.='<thead><th><div class="sizem">Tacho</div></th><th><div class="sizem">Carbón</div></th><th><div class="sizem">Escaldadura</div></th><th><div class="sizem">Estría roja</div></th><th><div class="sizem">Mosaico</div></th><th><div class="sizem">Roya marrón</div></th><th><div class="sizem">Roya anaranjada</div></th><th><div class="sizem">Pokka boeng</div></th><th><div class="sizem">Amarillamiento</div></th><th><div class="sizem">Mancha parda</div></th><th><div class="sizem">Otra</div></th></thead>';
            foreach ($datosasociados as $datos) {

                $data.='<tr>';
                $data.='<td><label for="tabla">'.$datos->codigo.'-'.$datos->subcodigo.'</label></td>';
                $data.='<td><input type="text" name="c'.$datos->id.'" id="c'.$datos->id.'"class="form-control" value="'.$datos->carbon.'"></td>';
                $data.='<td><input type="text" name="e'.$datos->id.'" id="e'.$datos->id.'"class="form-control" value="'.$datos->escaladura.'"></td>';
                $data.='<td><input type="text" name="er'.$datos->id.'" id="er'.$datos->id.'"class="form-control" value="'.$datos->estriaroja.'"></td>';
                $data.='<td><input type="text" name="m'.$datos->id.'" id="m'.$datos->id.'"class="form-control" value="'.$datos->mosaico.'"></td>';
                $data.='<td><input type="text" name="rm'.$datos->id.'" id="rm'.$datos->id.'"class="form-control" value="'.$datos->royamarron.'"></td>';
                $data.='<td><input type="text" name="ra'.$datos->id.'" id="ra'.$datos->id.'"class="form-control" value="'.$datos->royaanaranjada.'"></td>';
                $data.='<td><input type="text" name="pb'.$datos->id.'" id="pb'.$datos->id.'"class="form-control" value="'.$datos->pokkaboeng.'"></td>';
                $data.='<td><input type="text" name="a'.$datos->id.'" id="a'.$datos->id.'"class="form-control" value="'.$datos->amarillamiento.'"></td>';
                $data.='<td><input type="text" name="mp'.$datos->id.'" id="mp'.$datos->id.'"class="form-control" value="'.$datos->manchaparda.'"></td>';
                $data.='<td><input type="text" name="o'.$datos->id.'" id="o'.$datos->id.'"class="form-control" value="'.$datos->otra.'" onblur="guardaevaluacion(this.name)"></td>';

                $data.='</tr>';
            }
            $data.='</table></div>';
            return $data;
        }
    //    return view("admin.bancos.ubicaciones.ubicaciones",compact("banco"),["banco"=>$banco,"ubicacionesasociadas"=>$ubicacionesasociadas]);
       


    }

    public function datosasociados($id)
    {
        $sanitariap=Sanitariap::findOrFail($id);

        $datosasociados=DB::table('datossanitariosp as d')
        ->select('d.*', 'ts.nombre as nombre_tipo')
        ->join('sanitariasp as a','a.id','=','d.idevaluacion')
        ->join('tipossanitarias as ts', 'ts.id', '=', 'a.idnombre')
        ->where ('d.idevaluacion','=',$id)
        ->orderBy('d.id','asc')
        ->get();

        //dd($datosasociados);

        return view("admin.progenitores.sanitarias.datos.datos",["sanitariap"=>$sanitariap,"datosasociados"=>$datosasociados]);
        //return Redirect::to('admin/importaciones/inspecciones/'.$request->get('idimportacion').'/');


    }

    public function editardatos(SanitariapFormRequest $request,$id)
    {
        $datossanitaria=DB::table('datossanitariosp')
        ->select('id')
        ->where ('idevaluacion','=',$request->get('idevaluacion'))
        ->get();

        foreach ($datossanitaria as $d){

            $datosanitario=DatoSanitariop::findOrFail($d->id);
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


            $datosanitario=DatoSanitariop::findOrFail($request->get('id'));
           // $datosanitario->idtacho=$request->get('idtacho');
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

            $datosanitario->update();
        return response()->json();
    }

}
