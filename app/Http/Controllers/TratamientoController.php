<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Tratamiento;
use App\Registros;
use Illuminate\Support\Facades\Redirect;
use DB;
use App\Exports\TratamientosExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\RegistrosImport;
use App\Http\Requests\TratamientoFormRequest;

class TratamientoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
    	if($request){
    		$query=trim($request->get('searchText'));
    		$tratamientos=DB::table('tratamientos as t')
            ->select('t.*')
            ->where ('nombre','like','%'.$query.'%') 
    		->where ('t.estado','=',1)
    		->orderBy('idtratamiento','asc')
    		->paginate('10');
    		return view('admin.tratamientos.index',["tratamientos"=>$tratamientos,"searchText"=>$query]);
    	}
    }

    public function create()
    {   
    	return view ("admin.tratamientos.create");
    }

    public function store(TratamientoFormRequest $request)
    {
        $file = $request->file('registros');
        if($file != null){
            $tratamiento=new Tratamiento();
            $tratamiento->nombre=$request->get('nombre');
            $tratamiento->descripcion=$request->get('descripcion');
            $tratamiento->estado=1;
            $tratamiento->save();
            
            Excel::import(new RegistrosImport, $file);
            DB::table('registrostratamiento')->where('idtratamiento', Auth()->user()->id)->update(['idtratamiento'=>$tratamiento->idtratamiento]);
            
        }
    	return Redirect::to('admin/tratamientos');
    }

    public function show($id)
    {
    	return view("admin.tratamientos.show",["tratamiento"=>Tratamiento::findOrFail($id)]);
    }

     public function edit(Tratamiento $tratamiento)
    {
        $registros = DB::table('registrostratamiento as r')
        ->select('r.fecha','r.fecha','r.amanecer','r.atardecer','r.fotoperiodo')
        ->where('r.idtratamiento','=', $tratamiento->idtratamiento)
        ->get();

        return view('admin.tratamientos.edit',compact('tratamiento'),["registros"=>$registros]);
    }

    public function update(TratamientoFormRequest $request,$id)
    {
        
        $tratamiento=Tratamiento::findOrFail($id);
        $tratamiento->nombre=$request->get('nombre');
        $tratamiento->descripcion=$request->get('descripcion');

       // $tratamiento->estado=$request->get('estado');

        $tratamiento->update();

        $file = $request->file('registros');
        if($file != null){
            $registros= DB::table('registrostratamiento')->where('idtratamiento', $id)->delete(); // borrar las filas del tratamiento 
            Excel::import(new RegistrosImport, $file); // importar las nuevas filas del tratameinto
            DB::table('registrostratamiento')->where('idtratamiento', Auth()->user()->id)->update(['idtratamiento'=>$id]); // reemplazar el id del usario que creo hizo el import por el id del tratamiento
        }

        return Redirect::to('admin/tratamientos');
    }

    public function destroy($id)
    {
    	$tratamiento=Tratamiento::findOrFail($id);
    	$tratamiento->estado='0';//baja
      	$tratamiento->update();
    	return Redirect::to('admin/tratamientos');
    }


     public function export() 
     {
         return Excel::download(new TratamientosExport, 'tratamientos.xlsx');
     }


}
