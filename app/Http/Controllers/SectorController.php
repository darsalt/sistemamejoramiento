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
    		$sector=DB::table('sectores as t')
            ->join('subambientes as s','t.idsubambiente','=','s.id')
            ->join('ambientes as a','s.idambiente','=','a.id')
            ->select('t.*','a.nombre as nombreambiente','s.nombre as nombresubambiente')
            ->where ('t.nombre','like','%'.$query.'%') 
    		->where ('t.estado','=',1)
    		->orderBy('id','asc')
    		->paginate('10');

            //dd($sector);
    		return view('admin.sectores.index',["sector"=>$sector,"searchText"=>$query]);
    	}
    }

    public function create()
    {        
        $ambientes = DB::table('ambientes as v')
        ->select('v.id','v.nombre')
        ->where('v.estado','=','1')
        ->get();
    	return view ("admin.sectores.create",["ambientes"=>$ambientes]);   
    }

    public function store(SectorFormRequest $request)
    {
            $sector=new Sector;
            $sector->nombre=$request->get('nombre');
            $sector->comentarios=$request->get('comentarios');
            //$sector->idambiente=$request->get('idambiente');
            $sector->idsubambiente=$request->get('idsubambiente');
            $sector->estado=1;
            $sector->save();

    	
    	return Redirect::to('admin/sectores');
    }

    public function show($id)
    {
    	return view("admin.sector.show",["sector"=>Sector::findOrFail($id)]);
    }



    public function edit($id)
    {
        $ambientes = DB::table('ambientes as v')
        ->select('v.id','v.nombre')
        ->where('v.estado','=','1')
        ->get();
        $subambientes = DB::table('subambientes as v')
        ->select('v.id','v.nombre')
        ->where('v.estado','=','1')
        ->get();
        $sector = DB::table('sectores as s')
        ->leftjoin('subambientes as t','t.id','=','s.idsubambiente')
        ->leftjoin('ambientes as a','t.idambiente','=','a.id')
        ->select('s.id','s.nombre','s.comentarios','idsubambiente','idambiente')
        ->where('s.id','=',$id)
        ->get()
        ->first();
        return view('admin.sectores.edit',compact($sector),["ambientes"=>$ambientes,"subambientes"=>$subambientes,"sector"=>$sector]);

    }

    public function update(SectorFormRequest $request,$id)
    {
        $sector=Sector::findOrFail($id);
        $sector->nombre=$request->get('nombre');
        $sector->comentarios=$request->get('comentarios');
        $sector->idsubambiente=$request->get('idsubambiente');
        $sector->update();
        return Redirect::to('admin/sectores');
    }

    public function destroy($id)
    {
    	$sector=Sector::findOrFail($id);
    	$sector->estado='0';//baja
      	$sector->update();
    	return Redirect::to('admin/sectores');
    }


     public function export() 
     {
         return Excel::download(new SectorExport, 'sector.xlsx');
     }

     public function getSectoresDadoSubambiente(Request $request){
        $sectores = Sector::where('idsubambiente', $request->subambiente)->get();
      //  Log::debug($sectores);

        return response()->json($sectores);
    }


}
