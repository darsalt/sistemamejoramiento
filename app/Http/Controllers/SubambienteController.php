<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Subambiente;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\SubambienteFormRequest;
use DB;
use App\Exports\SubambienteExport;
use Maatwebsite\Excel\Facades\Excel;

class SubambienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
    	if($request){
    		$query=trim($request->get('searchText'));
    		$subambiente=DB::table('subambientes as t')
            ->leftjoin('ambientes as a','t.idambiente','=','a.id')
            ->select('t.*','a.nombre as nombreambiente')
            ->where ('t.nombre','like','%'.$query.'%') 
    		->where ('t.estado','=',1)
    		->orderBy('id','asc')
    		->paginate('10');
    		return view('admin.subambientes.index',["subambiente"=>$subambiente,"searchText"=>$query]);
    	}
    }

    public function create()
    {           
        $ambientes = DB::table('ambientes as v')
        ->select('v.id','v.nombre')
        ->where('v.estado','=','1')
        ->get();

    	return view ("admin.subambientes.create",["ambientes"=>$ambientes]);
    }

    public function store(SubambienteFormRequest $request)
    {
            $subambiente=new Subambiente;
            $subambiente->nombre=$request->get('nombre');
            $subambiente->comentarios=$request->get('comentarios');
            $subambiente->idambiente=$request->get('idambiente');
            $subambiente->estado=1;
            $subambiente->save();
   	
    	return Redirect::to('admin/subambientes');
    }

    public function show($id)
    {
    	return view("admin.subambientes.show",["subambiente"=>Subambiente::findOrFail($id)]);
    }

     public function edit(Subambiente $subambiente)
    {
        $ambientes = DB::table('ambientes as v')
        ->select('v.id','v.nombre')
        ->where('v.estado','=','1')
        ->get();
        return view('admin.subambientes.edit',compact('subambiente'),["ambientes"=>$ambientes]);

    }

    public function update(SubambienteFormRequest $request,$id)
    {
        $subambiente=Subambiente::findOrFail($id);
        $subambiente->nombre=$request->get('nombre');
        $subambiente->comentarios=$request->get('comentarios');
        $subambiente->idambiente=$request->get('idambiente');
        $subambiente->update();
        return Redirect::to('admin/subambientes');
    }

    public function destroy($id)
    {
    	$subambiente=Subambiente::findOrFail($id);
    	$subambiente->estado='0';//baja
      	$subambiente->update();
    	return Redirect::to('admin/subambientes');
    }


     public function export() 
     {
         return Excel::download(new SubambienteExport, 'subambiente.xlsx');
     }

     public function buscarSubambienteConIdAmbiente($id)
     {
 
             $subambiente=DB::table('subambientes as s')
             ->select('s.id','s.nombre')
             ->where('s.idambiente','=',$id)
             ->get();
              return response()->json($subambiente);
 
             
     }

    public function getSubambientesDadoAmbiente(Request $request){
        $subambientes = Subambiente::where('idambiente', $request->ambiente)->where('estado', 1)->get();

        return response()->json($subambientes);
    }
    

}
