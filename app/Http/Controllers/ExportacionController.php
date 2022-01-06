<?php

namespace App\Http\Controllers;

use App\BoxExportacion;
use App\CampaniaCuarentena;
use App\EnvioExportacion;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Exportacion;
use App\Tacho;

use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ExportacionFormRequest;
use DB;
use App\Exports\exportacionesExport;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;

class ExportacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
    	if($request){

            // estamos mostrando todas, ¡ solo las que estan actualmente?
    		$query=trim($request->get('searchText'));

            $exportaciones = Exportacion::where('estado', '<>', 'Baja')->paginate(10);
    		/*$exportaciones=DB::table('exportaciones as e')
            ->leftjoin('tachos as t','e.idtacho','=','t.idtacho')
            ->leftjoin('variedades as v','e.idvariedad','=','v.idvariedad')
            ->select('e.idexportacion','e.idvariedad','t.codigo','t.subcodigo','v.nombre as nombrevariedad','e.idubicacion','e.fechaingreso','e.fechaegreso','e.estado','e.observaciones')
            ->where ('v.nombre','like','%'.$query.'%') 
    		->where ('e.estado','=','Sigue en Cuarentena')
    		->orderBy('e.idtacho','desc')
    		->paginate('10');*/

            return view('admin.exportaciones.index',["exportaciones"=>$exportaciones,"searchText"=>$query]);
    	}
    }

    public function create()
    {
        $boxes = BoxExportacion::where('activo', 1)->get();
        $tachos = Tacho::where('destino', 2)->where('estado', 'Ocupado')->whereDoesntHave('exportaciones', function($q){
            $q->where('estado', '<>', 'Baja');
        })->get();
        $campanias = CampaniaCuarentena::where('estado', 1)->get();

    	return view ("admin.exportaciones.create",["tachos"=>$tachos,"boxes"=>$boxes, "campanias"=>$campanias]);
    }

    public function store(ExportacionFormRequest $request)
    {
        $ingresos = json_decode($request->ingresos);
        $ingresos = (array)$ingresos;
        
        foreach(array_keys($ingresos) as $box){
            foreach($ingresos[$box] as $tacho){
                $exportacion = new Exportacion();

                $exportacion->idtacho = $tacho->id;
                $exportacion->idbox = $box;
                $exportacion->idcampania = $request->campania;
                $exportacion->fechaingreso = $request->fechaingreso;
                $exportacion->observaciones = $request->observaciones;
                $exportacion->estado = 1;
                $exportacion->save();
            }
        }

        return redirect()->route('exportaciones.ingresos.index');
    }

    public function show($id)
    {
    	return view("admin.exportaciones.show",["exportacion"=>Exportacion::findOrFail($id)]);
    }

     public function edit(Exportacion $exportacion)
    {
            $variedades = DB::table('variedades as v')
            ->select('v.idvariedad','v.nombre')
            ->where('v.estado','=','1')
            ->get();

            $tachos = DB::table('tachos as t')
            ->select('t.idtacho','t.codigo','t.subcodigo')
            //->where('t.estado','=','1')
            ->get();

            $ubicaciones = DB::table('ubicaciones as u')
            ->select('u.idubicacion','u.nombreubicacion')
            ->where('u.expo','=','1')
            ->where('u.estado','=','1')
            ->get();

            $estados = array(
            1 => 'Sigue en Cuarentena',
            2 => 'No Sigue en Cuarentena',
            );

        return view('admin.exportaciones.edit',compact('exportacion'),["variedades"=>$variedades,"tachos"=>$tachos,"ubicaciones"=>$ubicaciones]);
    }

    public function update(ExportacionFormRequest $request,$id)
    {
         $exportacion=Exportacion::findOrFail($id);
         $exportacion->idvariedad=$request->get('idvariedad');
         $exportacion->idtacho=$request->get('idtacho');
         $exportacion->idubicacion=$request->get('idubicacion');
         $exportacion->fechaingreso=$request->get('fechaingreso');
         $exportacion->fechaegreso=$request->get('fechaegreso');
         $exportacion->observaciones=$request->get('observaciones');
         // $exportacion->estado=$request->get('estado');
         $exportacion->update();

        $tacho=Tacho::findOrFail($request->get('idtacho'));
        $tacho->expo=1;
        $tacho->idubicacion=1;
        $tacho->update();

         return Redirect::to('admin/exportaciones');

        //dd ($request);
    }

    public function destroy($id)
    {
    	$exportacion=Exportacion::findOrFail($id);
    	$exportacion->estado = 3;//baja
      	$exportacion->update();

        return redirect()->route('exportaciones.ingresos.index');
    }


    public function export() 
    {
        return Excel::download(new exportacionesExport, 'exportaciones.xlsx');
    }
    
    public function BuscarExportacionConIdTacho($id)
    {

    }

    public function tareasasociadas($id)
    {
        //$exportacion=Exportacion::findOrFail($id);

        $exportacion=DB::table('exportaciones as e')
        ->leftjoin('tachos as t','e.idtacho','=','t.idtacho')
        ->leftjoin('variedades as v','e.idvariedad','=','v.idvariedad')
        ->select('e.idexportacion','t.idtacho','e.idvariedad','t.codigo','t.subcodigo','v.nombre as nombrevariedad','e.idubicacion')
        ->where ('idexportacion','=',$id)
        ->get();

        $tareasasociadas=DB::table('tareas as t')
        ->select('t.idtarea','tt.nombre','t.fecharealizacion','observaciones')
        ->leftjoin('tipostareas as tt','t.idtipotarea','=','tt.idtipotarea')
        ->where ('idexportacion','=',$id)
        ->orderBy('t.fecharealizacion','desc')
        ->paginate('3');


        return view("admin.exportaciones.tareas",compact("exportacion"),["exportacion"=>$exportacion,"tareasasociadas"=>$tareasasociadas]);

    }

        public function evaluacionesasociadas($id)
    {
        //$exportacion=Exportacion::findOrFail($id);

        $exportacion=DB::table('exportaciones as e')
        ->leftjoin('tachos as t','e.idtacho','=','t.idtacho')
        ->leftjoin('variedades as v','e.idvariedad','=','v.idvariedad')
        ->select('e.idexportacion','t.idtacho','e.idvariedad','t.codigo','t.subcodigo','v.nombre as nombrevariedad','e.idubicacion')
        ->where ('idexportacion','=',$id)
        ->get();

        $evaluacionesasociadas=DB::table('evaluaciones as e')
        ->select('e.idevaluacion','t.nombre','e.fechaevaluacion','observaciones')
        ->leftjoin('tiposevaluaciones as t','e.idtipoevaluacion','=','t.idtipoevaluacion')
        ->where ('idexportacion','=',$id)
        ->orderBy('e.fechaevaluacion','desc')
        ->paginate('3');


        return view("admin.exportaciones.evaluaciones",compact("exportacion"),["exportacion"=>$exportacion,"evaluacionesasociadas"=>$evaluacionesasociadas]);

    }

    public function salidasasociadas($id)
    {
        //$exportacion=Exportacion::findOrFail($id);

        $exportacion=DB::table('exportaciones as e')
        ->leftjoin('tachos as t','e.idtacho','=','t.idtacho')
        ->leftjoin('variedades as v','e.idvariedad','=','v.idvariedad')
        ->select('e.idexportacion','t.idtacho','e.idvariedad','t.codigo','t.subcodigo','v.nombre as nombrevariedad','e.idubicacion')
        ->where ('idexportacion','=',$id)
        ->get();

        $salidasasociadas=DB::table('salidas as s')
        ->select('s.idexportacion','s.pais','s.programa','s.fecharealizacion','observaciones')
        //->leftjoin('tipostareas as tt','t.idtipotarea','=','tt.idtipotarea')
        ->where ('idexportacion','=',$id)
        ->orderBy('s.fecharealizacion','desc')
        ->paginate('3');


        return view("admin.exportaciones.salidas",compact("exportacion"),["exportacion"=>$exportacion,"salidasasociadas"=>$salidasasociadas]);

    }

    public function salidamasiva()
    {
        //$exportacion=Exportacion::findOrFail($id);

        $exportacion=DB::table('exportaciones as e')
        ->leftjoin('tachos as t','e.idtacho','=','t.idtacho')
        ->leftjoin('variedades as v','e.idvariedad','=','v.idvariedad')
        ->select('e.idexportacion','t.idtacho','e.idvariedad','t.codigo','t.subcodigo','v.nombre as nombrevariedad','e.idubicacion')
       // ->where ('idexportacion','=',$id)
        ->get();

        dd($exportacion);


        return view("admin.exportaciones.salidamasiva",compact("exportacion"),["exportacion"=>$exportacion]);

    }

    public function bajaTacho($idExportacion){
        $exportacion = Exportacion::findOrFail($idExportacion);

        $tacho = $exportacion->tacho;
        $tacho->estado = 'Baja';
        $tacho->save();

        $exportacion->estado = 2; // No sigue en cuarentena
        $exportacion->save();

        return redirect()->route('exportaciones.ingresos.index');
    }

    public function envios(){
        $envios = EnvioExportacion::where('estado', 1)->paginate(10);

        return view('admin.exportaciones.envios.index', compact('envios'));
    }

    public function enviosCreate(){
        $boxes = BoxExportacion::where('activo', 1)->get();

    	return view("admin.exportaciones.envios.create", compact('boxes'));
    }

    public function enviosStore(Request $request){
        $envios = json_decode($request->envios);
        $envios = (array)$envios;

        foreach($envios as $envio){
            $envioExportacion = new EnvioExportacion();
            
            $envioExportacion->idbox = $envio->idbox;
            $envioExportacion->idtacho = $envio->idtacho;
            $envioExportacion->cant_yemas = $envio->yemas;
            $envioExportacion->fecha = $request->fechaenvio;
            $envioExportacion->programa = $request->programa;
            $envioExportacion->destino = $request->destino;

            $envioExportacion->save();
        }

        return redirect()->route('exportaciones.envios.index');
    }

    public function destroyEnvio($id){
        $envio = EnvioExportacion::findOrFail($id);

        $envio->estado = 0;
        $envio->save();

        return redirect()->route('exportaciones.envios.index');
    }
}
