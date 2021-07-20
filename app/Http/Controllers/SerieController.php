<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Serie;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\SerieFormRequest;
use DB;
use App\Exports\SerieExport;
use Maatwebsite\Excel\Facades\Excel;

class SerieController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
    	if($request){
    		$query=trim($request->get('searchText'));
    		$series=DB::table('series as t')
            ->select('t.*')
            ->where ('nombre','like','%'.$query.'%') 
    		->where ('t.estado','=',1)
    		->orderBy('id','asc')
    		->paginate('10');
    		return view('admin.primera.serie.index',["series"=>$series,"searchText"=>$query]);
    	}
    }

    public function create()
    {           
    	return view ("admin.primera.serie.create");
    }

    public function store(SerieFormRequest $request)
    {
            $serie=new Serie;
            $serie->nombre=$request->get('nombre');
            $serie->fechainicio=$request->get('fechainicio');
            $serie->fechafin=$request->get('fechafin');
            $serie->comentarios=$request->get('comentarios');


            $serie->vigente=1;
            $serie->estado=1;

            $serie->save();

    	
    	return Redirect::to('admin/primera/serie');
    }

    public function show($id)
    {
    	return view("admin.primera.serie.show",["serie"=>Serie::findOrFail($id)]);
    }

     public function edit(Serie $serie)
    {
            return view('admin.primera.serie.edit',compact('serie'));
    }

    public function update(SerieFormRequest $request,$id)
    {
        $serie=Serie::findOrFail($id);
        $serie->nombre=$request->get('nombre');
        $serie->comentarios=$request->get('comentarios');
        $serie->fechainicio=$request->get('fechainicio');
        $serie->fechafin=$request->get('fechafin');
        //$campania->vigente=$request->get('estado');

       // $campania->estado=$request->get('estado');

        $serie->update();
        return Redirect::to('admin/primera/serie');
    }

    public function destroy($id)
    {
    	$serie=Serie::findOrFail($id);
    	$serie->estado='0';//baja
      	$serie->update();
    	return Redirect::to('admin/primera/serie');
    }


     public function export() 
     {
         return Excel::download(new SerieExport, 'series.xlsx');
     }


}
