<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Tarea;
use App\Tacho;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\TareaFormRequest;
use DB;
use App\Exports\TareasExport;
use Maatwebsite\Excel\Facades\Excel;

class TareaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
    	if($request){
    		$query=trim($request->get('searchText'));
    		$tareas=DB::table('tareas as e')
            ->leftjoin('tachos as t','e.idtacho','=','t.idtacho')
            ->leftjoin('variedades as v','e.idvariedad','=','v.idvariedad')
            ->select('e.idtarea','e.idvariedad','t.codigo','t.subcodigo','v.nombre as nombrevariedad','e.idtipotarea','e.fecharealizacion','e.idestado','e.observaciones')
            ->where ('v.nombre','like','%'.$query.'%') 
    		//->where ('activo','=',1)
    		->orderBy('e.idtacho','desc')
    		->paginate('3');

            return view('admin.tareas.index',["tareas"=>$tareas,"searchText"=>$query]);
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
            //->where('t.estado','=','1')
            ->get();

    	return view ("admin.tareas.create",["variedades"=>$variedades,"tachos"=>$tachos]);
    }

    // public function store(TareaFormRequest $request)
    // {
    // 	$tarea=new Tarea;
    //     $tarea->idtacho=$request->get('idtacho');
    //     $tarea->idvariedad=$request->get('idvariedad');
    //     $tarea->idtipotarea=$request->get('idtipotarea');
    //     $tarea->fecharealizacion=$request->get('fecharealizacion');
    //     $tarea->observaciones=$request->get('observaciones');
    // 	$tarea->idestado=$request->get('idestado');
    // 	$tarea->save();
    // 	return Redirect::to('admin/tareas');
    // }
    public function store(TareaFormRequest $request){
        //dd($request);
        if($request->get('portacho')==1){
        $tarea=new Tarea;
        $tarea->idexportacion=$request->get('idexportacion');
        $tarea->idimportacion=$request->get('idimportacion');
        $tarea->idtacho=$request->get('idtacho');
        $tarea->idvariedad=$request->get('idvariedad');
        $tarea->idtipotarea=$request->get('idtipotarea');
        $tarea->producto=$request->get('producto');
        $tarea->dosis=$request->get('dosis');
        $tarea->fecharealizacion=$request->get('fecharealizacion');
        $tarea->observaciones=$request->get('observaciones');
        // $tarea->idestado=$request->get('idestado');
        $tarea->save();
        if($tarea->idexportacion!=null)
            return Redirect::to('admin/exportaciones/tareas/'.$request->get('idexportacion').'/');
        else
            return Redirect::to('admin/importaciones/tareas/'.$request->get('idimportacion').'/');
        }else{
          //  dd($request);
            $tachos = DB::table('tachos as t')
            ->leftjoin('exportaciones as e','t.idtacho','=','e.idtacho')
            ->leftjoin('importaciones as i','t.idtacho','=','i.idtacho')
            ->select('t.idtacho',DB::raw('CONCAT(codigo,"-",subcodigo) as nombretacho'),'t.idubicacion','expo','impo','idexportacion','idimportacion')
            ->where('t.idubicacion','=',$request->get('idubicacion'))
            ->get();
            $cont=0;
            while($cont<count($tachos)){
                $tacho=Tacho::findOrFail($tachos[$cont]->idtacho);
                $tarea=new Tarea;
                $tarea->idexportacion=$tachos[$cont]->idexportacion;
                $tarea->idimportacion=$tachos[$cont]->idimportacion;
                $tarea->idtacho=$tacho->idtacho;
                $tarea->idvariedad=$tacho->idvariedad;
                $tarea->idtipotarea=$request->get('idtipotarea');
                $tarea->producto=$request->get('producto');
                $tarea->dosis=$request->get('dosis');
                $tarea->fecharealizacion=$request->get('fecharealizacion');
                $tarea->observaciones=$request->get('observaciones');
                // $tarea->idestado=$request->get('idestado');
                $tarea->save();

                $cont = $cont+1;
            } 
            //dd($tacho->expo);
            if($tacho->expo==1)
                return Redirect::to('admin/ubicacionesexpo/tareas/'.$request->get('idubicacion').'/');
            else
                return Redirect::to('admin/ubicacionesimpo/tareas/'.$request->get('idubicacion').'/'); 

        }
       

    }

    public function show($id)
    {
    	return view("admin.tareas.show",["tarea"=>Tarea::findOrFail($id)]);
    }

     public function edit(Tarea $tarea)
    {
            $variedades = DB::table('variedades as v')
            ->select('v.idvariedad','v.nombre')
            //->where('v.estado','=','1')
            ->get();

            $tachos = DB::table('tachos as t')
            ->select('t.idtacho','t.codigo','t.subcodigo')
            //->where('t.estado','=','1')
            ->get();
        return view('admin.tareas.edit',compact('tarea'),["variedades"=>$variedades,"tachos"=>$tachos]);
    }

    public function update(TareaFormRequest $request,$id)
    {
        $tarea=Tarea::findOrFail($id);
        $tarea->idtacho=$request->get('idtacho');
        $tarea->idvariedad=$request->get('idvariedad');
        $tarea->idtipotarea=$request->get('idtipotarea');
        $tarea->fecharealizacion=$request->get('fecharealizacion');
        $tarea->observaciones=$request->get('observaciones');
        $tarea->idestado=$request->get('idestado');

        $tarea->update();
        return Redirect::to('admin/tareas');
    }

    public function destroy($id)
    {
    	$tarea=Tarea::findOrFail($id);
    	$tarea->idestado='0';//baja
      	$tarea->update();
    	return Redirect::to('admin/tareas');
    }


    public function export() 
    {
        return Excel::download(new tareasExport, 'tareas.xlsx');
    }
}
