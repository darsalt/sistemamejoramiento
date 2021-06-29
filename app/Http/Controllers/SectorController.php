<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Sector;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\SectorFormRequest;
use DB;
use App\Exports\SectorExport;
use Maatwebsite\Excel\Facades\Excel;

class SectorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
    	if($request){
    		$query=trim($request->get('searchText'));
    		$sector=DB::table('sector as t')
            ->select('t.*')
            ->where ('nombre','like','%'.$query.'%') 
    		->where ('t.estado','=',1)
    		->orderBy('id','asc')
    		->paginate('10');
    		return view('admin.sector.index',["sector"=>$sector,"searchText"=>$query]);
    	}
    }

    public function create()
    {           
    	return view ("admin.sector.create");
    }

    public function store(SectorFormRequest $request)
    {
            $sector=new Sector;
            $sector->nombre=$request->get('nombre');
            $sector->comentarios=$request->get('comentarios');
            $sector->idsubambiente=$request->get('idsubambiente');
            $sector->estado=1;
            $sector->save();

    	
    	return Redirect::to('admin/sector');
    }

    public function show($id)
    {
    	return view("admin.sector.show",["sector"=>Sector::findOrFail($id)]);
    }

     public function edit(Sector $sector)
    {
            return view('admin.sector.edit',compact('sector'));
    }

    public function update(SectorFormRequest $request,$id)
    {
        $sector=Sector::findOrFail($id);
        $sector->nombre=$request->get('nombre');
        $sector->comentarios=$request->get('comentarios');
        $sector->idsubambiente=$request->get('idsubambiente');
        $sector->update();
        return Redirect::to('admin/sector');
    }

    public function destroy($id)
    {
    	$sector=Sector::findOrFail($id);
    	$sector->estado='0';//baja
      	$sector->update();
    	return Redirect::to('admin/sector');
    }


     public function export() 
     {
         return Excel::download(new SectorExport, 'sector.xlsx');
     }


}
