<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Salida;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\SalidaFormRequest;
use DB;
use App\Exports\SalidasExport;
use Maatwebsite\Excel\Facades\Excel;

class SalidaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
    	if($request){
    		$query=trim($request->get('searchText'));
    		$salidas=DB::table('salidas as s')
            ->leftjoin('exportaciones as e','e.idexportacion','=','s.idexportacion')
            ->leftjoin('variedades as v','e.idvariedad','=','v.idvariedad')
            ->select('s.idsalida','e.idvariedad','v.nombre as nombrevariedad','s.pais','s.fecharealizacion','s.observaciones')
            ->where ('v.nombre','like','%'.$query.'%') 
    		//->where ('activo','=',1)
    		->orderBy('s.fecharealizacion','desc')
    		->paginate('3');

            return view('admin.salidas.index',["salidas"=>$salidas,"searchText"=>$query]);
    	}
    }

    public function create()
    {
            // $variedades = DB::table('variedades as v')
            // ->select('v.idvariedad','v.nombre')
            // //->where('v.estado','=','1')
            // ->get();

            // $tachos = DB::table('tachos as t')
            // ->select('t.idtacho','t.codigo','t.subcodigo')
            // //->where('t.estado','=','1')
            // ->get();

    	return view ("admin.salidas.create");
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
    public function store(SalidaFormRequest $request)
    {   //dd($request);
        $salida=new Salida;
        $salida->idexportacion=$request->get('idexportacion');
        $salida->pais=$request->get('pais');
        $salida->programa=$request->get('programa');
        //$salida->idvariedad=$request->get('idvariedad');
        $salida->fecharealizacion=$request->get('fecharealizacion');
        $salida->observaciones=$request->get('observaciones');
        // $tarea->idestado=$request->get('idestado');
        $salida->save();
        return Redirect::to('admin/exportaciones/salidas/'.$request->get('idexportacion').'/');


       

    }

    public function show($id)
    {
    	return view("admin.salidas.show",["salida"=>Salida::findOrFail($id)]);
    }

     public function edit(Salida $salida)
    {
            $variedades = DB::table('variedades as v')
            ->select('v.idvariedad','v.nombre')
            //->where('v.estado','=','1')
            ->get();

            $tachos = DB::table('tachos as t')
            ->select('t.idtacho','t.codigo','t.subcodigo')
            //->where('t.estado','=','1')
            ->get();
        return view('admin.salidas.edit',compact('salida'),["variedades"=>$variedades,"tachos"=>$tachos]);
    }

    public function update(SalidaFormRequest $request,$id)
    {
        $salida=Tarea::findOrFail($id);
        $salida->idpais=$request->get('idpais');
        $salida->idvariedad=$request->get('idvariedad');
        $salida->fecharealizacion=$request->get('fecharealizacion');
        $salida->observaciones=$request->get('observaciones');

        $salida->update();
        return Redirect::to('admin/salidas');
    }

    public function destroy($id)
    {
    	$salida=Tarea::findOrFail($id);
    	//$salida->idestado='0';//baja
      	$salida->update();
    	return Redirect::to('admin/salida');
    }


    public function export() 
    {
        return Excel::download(new salidasExport, 'salidas.xlsx');
    }
}
