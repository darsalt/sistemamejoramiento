<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Ambiente;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\AmbienteFormRequest;
use DB;
use App\Exports\AmbienteExport;
use Maatwebsite\Excel\Facades\Excel;

class AmbienteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
    	if($request){
    		$query=trim($request->get('searchText'));
    		$ambiente=DB::table('ambientes as t')
            ->select('t.*')
            ->where ('nombre','like','%'.$query.'%') 
    		->where ('t.estado','=',1)
    		->orderBy('id','asc')
    		->paginate('10');
    		return view('admin.ambientes.index',["ambiente"=>$ambiente,"searchText"=>$query]);
    	}
    }

    public function create()
    {           
    	return view ("admin.ambientes.create");
    }

    public function store(AmbienteFormRequest $request)
    {
            $ambiente=new Ambiente;
            $ambiente->nombre=$request->get('nombre');
            $ambiente->comentarios=$request->get('comentarios');
            $ambiente->estado=1;
            $ambiente->save();

    	
    	return Redirect::to('admin/ambientes');
    }

    public function show($id)
    {
    	return view("admin.ambientes.show",["ambiente"=>Ambiente::findOrFail($id)]);
    }

     public function edit(Ambiente $ambiente)
    {
            return view('admin.ambientes.edit',compact('ambiente'));
    }

    public function update(AmbienteFormRequest $request,$id)
    {
        $ambiente=Ambiente::findOrFail($id);
        $ambiente->nombre=$request->get('nombre');
        $ambiente->comentarios=$request->get('comentarios');
        $ambiente->update();
        return Redirect::to('admin/ambientes');
    }

    public function destroy($id)
    {
    	$ambiente=Ambiente::findOrFail($id);
    	$ambiente->estado='0';//baja
      	$ambiente->update();
    	return Redirect::to('admin/ambientes');
    }


     public function export() 
     {
         return Excel::download(new AmbienteExport, 'ambiente.xlsx');
     }


}
