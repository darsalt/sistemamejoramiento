<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\CampaniaCuarentena;
use Carbon\Carbon;

use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\CampaniaCuarentenaFormRequest;
use DB;
use App\Exports\CampaniaCuarentenaExport;
use Maatwebsite\Excel\Facades\Excel;

class CampaniaCuarentenaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
    	if($request){
    		$query=trim($request->get('searchText'));
    		$campaniacuarentena=DB::table('campaniacuarentena as t')
            ->select('t.*')
            ->where ('nombre','like','%'.$query.'%') 
    		->where ('t.estado','=',1)
    		->orderBy('id','asc')
    		->paginate('10');
    		return view('admin.campaniacuarentena.index',["campaniacuarentena"=>$campaniacuarentena,"searchText"=>$query]);
    	}
    }

    public function create()
    {           
    	return view ("admin.campaniacuarentena.create");
    }

    public function store(CampaniaCuarentenaFormRequest $request)
    {
            $campaniacuarentena=new CampaniaCuarentena;
            $campaniacuarentena->nombre=$request->get('nombre');
            $campaniacuarentena->fechainicio=$request->get('fechainicio');
            $campaniacuarentena->fechafin=$request->get('fechafin');
            $campaniacuarentena->comentarios=$request->get('comentarios');


            $campaniacuarentena->vigente=1;
            $campaniacuarentena->estado=1;

            $campaniacuarentena->save();

    	
    	return Redirect::to('admin/campaniacuarentena');
    }

    public function show($id)
    {
    	return view("admin.campaniacuarentena.show",["campaniacuarentena"=>CampaniaCuarentena::findOrFail($id)]);
    }

     public function edit(CampaniaCuarentena $campaniacuarentena)
    {
            return view('admin.campaniacuarentena.edit',compact('campaniacuarentena'));
    }

    public function update(CampaniaCuarentenaFormRequest $request,$id)
    {
        $campaniacuarentena=CampaniaCuarentena::findOrFail($id);
        $campaniacuarentena->nombre=$request->get('nombre');
        $campaniacuarentena->comentarios=$request->get('comentarios');
        $campaniacuarentena->fechainicio=$request->get('fechainicio');
        $campaniacuarentena->fechafin=$request->get('fechafin');

        $campaniacuarentena->update();
        return Redirect::to('admin/campaniacuarentena');
    }

    public function destroy($id)
    {
    	$campaniacuarentena=CampaniaCuarentena::findOrFail($id);
    	$campaniacuarentena->estado='0';//baja
      	$campaniacuarentena->update();
    	return Redirect::to('admin/campaniacuarentena');
    }


     public function export() 
     {
         return Excel::download(new CampaniaCuarentenaExport, 'campaniacuarentena.xlsx');
     }


}
