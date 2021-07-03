<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\CampaniaSeedling;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\CampaniaSeedlingFormRequest;
use DB;
use App\Exports\CampaniasSeedlingExport;
use Maatwebsite\Excel\Facades\Excel;

class CampaniaSeedlingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
    	if($request){
    		$query=trim($request->get('searchText'));
    		$campaniaseedling=DB::table('campaniaseedling as t')
            ->select('t.*')
            ->where ('nombre','like','%'.$query.'%') 
    		->where ('t.estado','=',1)
    		->orderBy('id','asc')
    		->paginate('10');
    		return view('admin.individual.campaniaseedling.index',["campaniaseedling"=>$campaniaseedling,"searchText"=>$query]);
    	}
    }

    public function create()
    {           
    	return view ("admin.individual.campaniaseedling.create");
    }

    public function store(CampaniaSeedlingFormRequest $request)
    {
            $campaniaseedling=new CampaniaSeedling;
            $campaniaseedling->nombre=$request->get('nombre');
            $campaniaseedling->fechainicio=$request->get('fechainicio');
            $campaniaseedling->fechafin=$request->get('fechafin');
            $campaniaseedling->comentarios=$request->get('comentarios');


            $campaniaseedling->vigente=1;
            $campaniaseedling->estado=1;

            $campaniaseedling->save();

    	
    	return Redirect::to('admin/individual/campaniaseedling');
    }

    public function show($id)
    {
    	return view("admin.individual.campaniaseedling.show",["campaniaseedling"=>CampaniaSeedling::findOrFail($id)]);
    }

     public function edit(CampaniaSeedling $campaniaseedling)
    {
            return view('admin.individual.campaniaseedling.edit',compact('campaniaseedling'));
    }

    public function update(CampaniaSeedlingFormRequest $request,$id)
    {
        $campaniaseedling=CampaniaSeedling::findOrFail($id);
        $campaniaseedling->nombre=$request->get('nombre');
        $campaniaseedling->comentarios=$request->get('comentarios');
        $campaniaseedling->fechainicio=$request->get('fechainicio');
        $campaniaseedling->fechafin=$request->get('fechafin');
        //$campania->vigente=$request->get('estado');

       // $campania->estado=$request->get('estado');

        $campaniaseedling->update();
        return Redirect::to('admin/individual/campaniaseedling');
    }

    public function destroy($id)
    {
    	$campaniaseedling=CampaniaSeedling::findOrFail($id);
    	$campaniaseedling->estado='0';//baja
      	$campaniaseedling->update();
    	return Redirect::to('admin/campaniaseedling');
    }


     public function export() 
     {
         return Excel::download(new CampaniaSeedlingExport, 'campaniaseedling.xlsx');
     }


}
