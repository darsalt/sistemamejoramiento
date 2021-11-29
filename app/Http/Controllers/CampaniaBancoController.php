<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\CampaniaBanco;
use Carbon\Carbon;

use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\CampaniaBancoFormRequest;
use DB;
use App\Exports\CampaniaBancoExport;
use Maatwebsite\Excel\Facades\Excel;

class CampaniaBancoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
    	if($request){
    		$query=trim($request->get('searchText'));
    		$campaniabanco=DB::table('campaniabanco as t')
            ->select('t.*')
            ->where ('nombre','like','%'.$query.'%') 
    		->where ('t.estado','=',1)
    		->orderBy('id','asc')
    		->paginate('10');
    		return view('admin.campaniabanco.index',["campaniabanco"=>$campaniabanco,"searchText"=>$query]);
    	}
    }

    public function create()
    {           
    	return view ("admin.campaniabanco.create");
    }

    public function store(CampaniaBancoFormRequest $request)
    {
            $campaniabanco=new CampaniaBanco;
            $campaniabanco->nombre=$request->get('nombre');
            $campaniabanco->fechainicio=$request->get('fechainicio');
            $campaniabanco->fechafin=$request->get('fechafin');
            $campaniabanco->comentarios=$request->get('comentarios');


            $campaniabanco->vigente=1;
            $campaniabanco->estado=1;

            $campaniabanco->save();

    	
    	return Redirect::to('admin/campaniabanco');
    }

    public function show($id)
    {
    	return view("admin.campaniabanco.show",["campaniabanco"=>CampaniaBanco::findOrFail($id)]);
    }

     public function edit(CampaniaBanco $campaniabanco)
    {
            return view('admin.campaniabanco.edit',compact('campaniabanco'));
    }

    public function update(CampaniaBancoFormRequest $request,$id)
    {
        $campaniabanco=CampaniaBanco::findOrFail($id);
        $campaniabanco->nombre=$request->get('nombre');
        $campaniabanco->comentarios=$request->get('comentarios');
        $campaniabanco->fechainicio=$request->get('fechainicio');
        $campaniabanco->fechafin=$request->get('fechafin');

        $campaniabanco->update();
        return Redirect::to('admin/campaniabanco');
    }

    public function destroy($id)
    {
    	$campaniabanco=CampaniaBanco::findOrFail($id);
    	$campaniabanco->estado='0';//baja
      	$campaniabanco->update();
    	return Redirect::to('admin/campaniabanco');
    }


     public function export() 
     {
         return Excel::download(new CampaniaBancoExport, 'campaniabanco.xlsx');
     }


}
