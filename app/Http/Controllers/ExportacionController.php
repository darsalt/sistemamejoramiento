<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Exportacion;
use App\Tacho;

use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ExportacionFormRequest;
use DB;
use App\Exports\exportacionesExport;
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
    		$exportaciones=DB::table('exportaciones as e')
            ->leftjoin('tachos as t','e.idtacho','=','t.idtacho')
            ->leftjoin('variedades as v','e.idvariedad','=','v.idvariedad')
            ->select('e.idexportacion','e.idvariedad','t.codigo','t.subcodigo','v.nombre as nombrevariedad','e.idubicacion','e.fechaingreso','e.fechaegreso','e.estado','e.observaciones')
            ->where ('v.nombre','like','%'.$query.'%') 
    		->where ('e.estado','=','Sigue en Cuarentena')
    		->orderBy('e.idtacho','desc')
    		->paginate('10');

            return view('admin.exportaciones.index',["exportaciones"=>$exportaciones,"searchText"=>$query]);
    	}
    }

    public function create()
    {
            $variedades = DB::table('variedades as v')
            ->select('v.idvariedad','v.nombre')
            //->where('v.estado','=','1')
            ->get();

            $tachos = DB::table('tachos as t')
            ->select('t.idtacho','t.codigo','t.subcodigo')
            ->where('t.estado','=','Ocupado')
            ->get();

            $ubicaciones = DB::table('ubicaciones as u')
            ->select('u.idubicacion','u.nombreubicacion')
            ->where('u.expo','=','1')
            ->where('u.estado','=','1')
            ->get();

    	return view ("admin.exportaciones.create",["variedades"=>$variedades,"tachos"=>$tachos,"ubicaciones"=>$ubicaciones]);
    }

    public function store(ExportacionFormRequest $request)
    {
    	$exportacion=new Exportacion;
    	$exportacion->idvariedad=$request->get('idvariedad');
        $exportacion->idtacho=$request->get('idtacho');
        $exportacion->idubicacion=$request->get('idubicacion');
        $exportacion->fechaingreso=$request->get('fechaingreso');
        $exportacion->fechaegreso=$request->get('fechaegreso');
        $exportacion->observaciones=$request->get('observaciones');
    	// $exportacion->estado='1'; // continua en la cuarentena
    	$exportacion->save();

        $tacho=Tacho::findOrFail($request->get('idtacho'));
        $tacho->expo=1;
        $tacho->idubicacion=$request->get('idubicacion');
        $tacho->update();



    	return Redirect::to('admin/exportaciones');
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
    	$exportacion->estado='0';//baja
      	$exportacion->update();
    	return Redirect::to('admin/exportaciones');
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


}
