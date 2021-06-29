<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Importacion;
use App\Tacho;

use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ImportacionFormRequest;
use DB;
use App\Exports\importacionesExport;
use Maatwebsite\Excel\Facades\Excel;

class ImportacionController extends Controller
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
    		$importaciones=DB::table('importaciones as e')
            ->leftjoin('tachos as t','e.idtacho','=','t.idtacho')
            ->leftjoin('variedades as v','e.idvariedad','=','v.idvariedad')
            ->select('e.idimportacion','e.idvariedad','t.codigo','t.subcodigo','v.nombre as nombrevariedad','e.idubicacion','e.idlote','e.fechaingreso','e.fechaegreso','e.estado','e.observaciones')
            ->where ('v.nombre','like','%'.$query.'%') 
    		//->where ('activo','=',1)
    		->orderBy('e.idtacho','desc')
    		->paginate('10');

            return view('admin.importaciones.index',["importaciones"=>$importaciones,"searchText"=>$query]);
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
            ->where('u.impo','=','1')
            ->where('u.estado','=','1')
            ->get();

            $lotes = DB::table('lotes as l')
            ->select('l.idlote','l.nombrelote')
            ->where('l.estado','=','1')
            ->get();

    	return view ("admin.importaciones.create",["variedades"=>$variedades,"tachos"=>$tachos,"ubicaciones"=>$ubicaciones,"lotes"=>$lotes]);
    }

    public function store(ImportacionFormRequest $request)
    {
    	$importacion=new Importacion;
    	$importacion->idvariedad=$request->get('idvariedad');
        $importacion->idtacho=$request->get('idtacho');
        $importacion->idubicacion=$request->get('idubicacion');
        $importacion->idlote=$request->get('idlote');
        $importacion->fechaingreso=$request->get('fechaingreso');
        $importacion->fechaegreso=$request->get('fechaegreso');
        $importacion->observaciones=$request->get('observaciones');
    	// $exportacion->estado='1'; // continua en la cuarentena
    	$importacion->save();

        $tacho=Tacho::findOrFail($request->get('idtacho'));
        $tacho->impo=1;
        $tacho->idubicacion=$request->get('idubicacion');
        $tacho->update();

    	return Redirect::to('admin/importaciones');
    }

    public function show($id)
    {
    	return view("admin.importaciones.show",["importacion"=>Importacion::findOrFail($id)]);
    }

     public function edit(Importacion $importacion)
    {
            $variedades = DB::table('variedades as v')
            ->select('v.idvariedad','v.nombre')
            //->where('v.estado','=','1')
            ->get();

            $tachos = DB::table('tachos as t')
            ->select('t.idtacho','t.codigo','t.subcodigo')
            //->where('t.estado','=','1')
            ->get();

            $ubicaciones = DB::table('ubicaciones as u')
            ->select('u.idubicacion','u.nombreubicacion')
            ->where('u.impo','=','1')
            ->where('u.estado','=','1')
            ->get();

            $lotes = DB::table('lotes as l')
            ->select('l.idlote','l.nombrelote')
            ->where('l.estado','=','1')
            ->get();

        return view('admin.importaciones.edit',compact('importacion'),["variedades"=>$variedades,"tachos"=>$tachos,"ubicaciones"=>$ubicaciones,"lotes"=>$lotes]);
    }

    public function update(ImportacionFormRequest $request,$id)
    {
         $importacion=Importacion::findOrFail($id);
         $importacion->idvariedad=$request->get('idvariedad');
         $importacion->idtacho=$request->get('idtacho');
         $importacion->idubicacion=$request->get('idubicacion');
         $importacion->idlote=$request->get('idlote');
         $importacion->fechaingreso=$request->get('fechaingreso');
         $importacion->fechaegreso=$request->get('fechaegreso');
         $importacion->observaciones=$request->get('observaciones');
         // $exportacion->estado=$request->get('estado');
         $importacion->update();

        $tacho=Tacho::findOrFail($request->get('idtacho'));
        $tacho->impo=1;
        $tacho->idubicacion=$request->get('idubicacion');
        $tacho->update();

         return Redirect::to('admin/importaciones');

        //dd ($request);
    }

    public function destroy($id)
    {
    	$importacion=Importacion::findOrFail($id);
    	$importacion->estado='0';//baja
      	$importacion->update();
    	return Redirect::to('admin/importaciones');
    }


    public function export() 
    {
        return Excel::download(new importacionesExport, 'importaciones.xlsx');
    }
    
    public function BuscarImportacionConIdTacho($id)
    {

    }

    public function tareasasociadas($id)
    {
        //$exportacion=Exportacion::findOrFail($id);

        $importacion=DB::table('importaciones as e')
        ->leftjoin('tachos as t','e.idtacho','=','t.idtacho')
        ->leftjoin('variedades as v','e.idvariedad','=','v.idvariedad')
        ->select('e.idimportacion','t.idtacho','e.idvariedad','t.codigo','t.subcodigo','v.nombre as nombrevariedad','e.idubicacion')
        ->where ('idimportacion','=',$id)
        ->get();

        $tareasasociadas=DB::table('tareas as t')
        ->select('t.idtarea','tt.nombre','t.fecharealizacion','observaciones')
        ->leftjoin('tipostareas as tt','t.idtipotarea','=','tt.idtipotarea')
        ->where ('idimportacion','=',$id)
        ->orderBy('t.fecharealizacion','desc')
        ->paginate('3');


        return view("admin.importaciones.tareas",compact("importacion"),["importacion"=>$importacion,"tareasasociadas"=>$tareasasociadas]);

    }

    public function evaluacionesasociadas($id)
    {
        //$exportacion=Exportacion::findOrFail($id);

        $importacion=DB::table('importaciones as e')
        ->leftjoin('tachos as t','e.idtacho','=','t.idtacho')
        ->leftjoin('variedades as v','e.idvariedad','=','v.idvariedad')
        ->select('e.idimportacion','t.idtacho','e.idvariedad','t.codigo','t.subcodigo','v.nombre as nombrevariedad','e.idubicacion')
        ->where ('idimportacion','=',$id)
        ->get();

        $evaluacionesasociadas=DB::table('evaluaciones as e')
        ->select('e.idevaluacion','t.nombre','e.fechaevaluacion','observaciones')
        ->leftjoin('tiposevaluaciones as t','e.idtipoevaluacion','=','t.idtipoevaluacion')
        ->where ('idimportacion','=',$id)
        ->orderBy('e.fechaevaluacion','desc')
        ->paginate('3');

        return view("admin.importaciones.evaluaciones",compact("importacion"),["importacion"=>$importacion,"evaluacionesasociadas"=>$evaluacionesasociadas]);

    }

    public function inspeccionesasociadas($id)
    {
        //$exportacion=Exportacion::findOrFail($id);

        $importacion=DB::table('importaciones as e')
        ->leftjoin('tachos as t','e.idtacho','=','t.idtacho')
        ->leftjoin('variedades as v','e.idvariedad','=','v.idvariedad')
        ->select('e.idimportacion','t.idtacho','e.idvariedad','t.codigo','t.subcodigo','v.nombre as nombrevariedad','e.idubicacion')
        ->where ('idimportacion','=',$id)
        ->get();

        $inspeccionesasociadas=DB::table('inspecciones as e')
        ->select('e.idinspeccion','e.fechainspeccion','e.certificado','observaciones')
        //->leftjoin('tiposevaluaciones as t','e.idtipoevaluacion','=','t.idtipoevaluacion')
        ->where ('idimportacion','=',$id)
        ->orderBy('e.fechainspeccion','desc')
        ->paginate('3');

//dd($inspeccionesasociadas);

        return view("admin.importaciones.inspecciones",compact("importacion"),["importacion"=>$importacion,"inspeccionesasociadas"=>$inspeccionesasociadas]);
        //return Redirect::to('admin/importaciones/inspecciones/'.$request->get('idimportacion').'/');


    }




}
