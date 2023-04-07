<?php

namespace App\Http\Controllers;

use App\BoxImportacion;
use App\CampaniaCuarentena;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Importacion;
use App\Tacho;

use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ImportacionFormRequest;
use DB;
use App\Exports\importacionesExport;
use App\LevantamientoCuarentena;
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

    		$importaciones = Importacion::where('estado', '<>', 'Baja')->paginate(10);

            return view('admin.importaciones.index',["importaciones"=>$importaciones,"searchText"=>$query]);
    	}
    }

    public function create()
    {
        $boxes = BoxImportacion::where('activo', 1)->get();
        $tachos = Tacho::where('destino', 2)->where('estado', 'Ocupado')->whereDoesntHave('importaciones', function($q){
            $q->where('estado', '<>', 'Baja');
        })->whereDoesntHave('exportaciones', function($q){
            $q->where('estado', '<>', 'Baja');
        })->get();
        $campanias = CampaniaCuarentena::where('estado', 1)->get();

    	return view ("admin.importaciones.create",["tachos"=>$tachos,"boxes"=>$boxes,"campanias"=>$campanias]);
    }

    public function store(ImportacionFormRequest $request)
    {
        $ingresos = json_decode($request->ingresos);
        $ingresos = (array)$ingresos;
        
        foreach(array_keys($ingresos) as $box){
            foreach($ingresos[$box] as $tacho){
                $importacion = new Importacion();

                $importacion->idtacho = $tacho->id;
                $importacion->idbox = $box;
                $importacion->idcampania = $request->campania;
                $importacion->fechaingreso = $request->fechaingreso;
                $importacion->lote_cuarentenario = $tacho->lote;
                $importacion->origen = $tacho->origen;
                $importacion->observaciones = $request->observaciones;
                $importacion->estado = 1;
                $importacion->save();
            }
        }

        return redirect()->route('importaciones.ingresos.index');
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
    	$importacion->estado = 3;//baja
      	$importacion->update();

    	return Redirect::to('admin/importaciones/ingresos');
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

    public function bajaTacho($idImportacion){
        $importacion = Importacion::findOrFail($idImportacion);

        $tacho = $importacion->tacho;
        $tacho->estado = 'Baja';
        $tacho->save();

        $importacion->estado = 2; // No sigue en cuarentena
        $importacion->save();

        return redirect()->route('importaciones.ingresos.index');
    }

    public function levantamientoIndex(){
        $levantamientos = LevantamientoCuarentena::where('estado', 1)->paginate(10);

        return view('admin.importaciones.levantamientos.index', compact('levantamientos'));  
    }

    public function levantamientoCreate(){
        $campanias = CampaniaCuarentena::where('estado', 1)->get();
        $boxes = BoxImportacion::where('activo', 1)->get();
        
    	return view('admin.importaciones.levantamientos.create', compact('campanias', 'boxes'));
    }

    public function levantamientoStore(Request $request){
        $levantamiento = new LevantamientoCuarentena();

        $levantamiento->fechalevantamiento = $request->fecha;
        $levantamiento->idbox = $request->box;
        $levantamiento->idcampania = $request->campania;
        $levantamiento->observaciones = $request->observaciones;
        $levantamiento->save();

        $archivo = $request->archivo;
        $nombre = 'LevantamientoCuarentena_' . $levantamiento->id . '.' . $archivo->extension();
        $request->archivo->move(public_path('/levantamientos'), $nombre);
        $levantamiento->archivo = $nombre;
        $levantamiento->update();

        // Poner las importaciones correspondientes en estado 'No sigue en cuarentena' y dar de baja tachos
        $importaciones = Importacion::where('idbox', $levantamiento->idbox)->where('idcampania', $levantamiento->idcampania)->get();

        foreach($importaciones as $importacion){
            $importacion->estado = 2; // No sigue en cuarentena
            $importacion->fechaegreso = $levantamiento->fechalevantamiento;
            $tacho = $importacion->tacho;

            $tacho->estado = 'Baja';
            $importacion->save();
            $tacho->save();
        }

        return redirect()->route('importaciones.levantamientos.index');
    }

    public function levantamientoDestroy($id){
        $levantamiento = LevantamientoCuarentena::findOrFail($id);

        $levantamiento->estado = 0;
        $levantamiento->save();

        // Volver atras el estado de la importacion y de los tachos
        $importaciones = Importacion::where('idbox', $levantamiento->idbox)->where('idcampania', $levantamiento->idcampania)->get();

        foreach($importaciones as $importacion){
            $importacion->estado = 1; // No sigue en cuarentena
            $importacion->fechaegreso = null;
            $tacho = $importacion->tacho;

            $tacho->estado = 'Ocupado';
            $importacion->save();
            $tacho->save();
        }

        return redirect()->route('importaciones.levantamientos.index');
    }

}
