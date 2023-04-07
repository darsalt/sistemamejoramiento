<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Variedad;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\VariedadFormRequest;
use DB;
use App\Exports\variedadesExport;
use Maatwebsite\Excel\Facades\Excel;

class VariedadController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
    	if($request){
    		$query=trim($request->get('searchText'));
    		$variedades=DB::table('variedades')->where ('nombre','like','%'.$query.'%') 
    		//->where ('estado','=',1)
    		->orderBy('nombre','asc')
    		->paginate('10');
    		return view('admin.variedades.index',["variedades"=>$variedades,"searchText"=>$query]);
    	}
    }

    public function create()
    {
        $tachoslibres = DB::table('tachos as t')
        ->select('t.idtacho','t.codigo','t.subcodigo')
        ->where('t.estado','=','libre')
        ->get();
    	return view ("admin.variedades.create",["tachoslibres"=>$tachoslibres]);
    }

    public function store(VariedadFormRequest $request)
    {
    	$variedad=new Variedad;
    	$variedad->nombre=$request->get('nombre');
        $variedad->madre=$request->get('madre');
        $variedad->padre=$request->get('padre');
        $variedad->fechaalta=$request->get('fechaalta');
        //$variedad->idtacho=$request->get('idtacho');

        $variedad->tonelaje=$request->get('tonelaje');
        $variedad->azucar=$request->get('azucar');
        $variedad->floracion=$request->get('floracion');
        //$variedad->resistencia=$request->get('resistencia');
        $variedad->suelos=$request->get('suelos');
        $variedad->fibra=$request->get('fibra');
        $variedad->deshojado=$request->get('deshojado');
        $variedad->vuelco=$request->get('vuelco');

        $variedad->carbon=$request->get('carbon');
        $variedad->escaladura=$request->get('escaladura');
        $variedad->estriaroja=$request->get('estriaroja');
        $variedad->mosaico=$request->get('mosaico');
        $variedad->royamarron=$request->get('royamarron');
        $variedad->royanaranja=$request->get('royanaranja');
        $variedad->pokkaboeng=$request->get('pokkaboeng');
        $variedad->amarillamiento=$request->get('amarillamiento');
        $variedad->manchaparda=$request->get('manchaparda');

        $variedad->observaciones=$request->get('observaciones');
    	$variedad->estado='1';
    	$variedad->save();
    	return Redirect::to('admin/variedades');
    }

    public function show($id)
    {
    	return view("admin.variedades.show",["variedad"=>Variedad::findOrFail($id)]);
    }

     public function edit(Variedad $variedad)
    {

        return view('admin.variedades.edit',compact('variedad'));
    }

    public function view(Variedad $variedad)
    {
        return view('admin.variedades.view',compact('variedad'));
    }

    public function update(VariedadFormRequest $request,$id)
    {
        $variedad=Variedad::findOrFail($id);
        $variedad->nombre=$request->get('nombre');
        $variedad->madre=$request->get('madre');
        $variedad->padre=$request->get('padre');
        $variedad->fechaalta=$request->get('fechaalta');
        //$variedad->idtacho=$request->get('idtacho');
        $variedad->tonelaje=$request->get('tonelaje');
        $variedad->azucar=$request->get('azucar');
        $variedad->floracion=$request->get('floracion');
        $variedad->resistencia=$request->get('resistencia');
        $variedad->suelos=$request->get('suelos');
        $variedad->fibra=$request->get('fibra');
        $variedad->deshojado=$request->get('deshojado');
        $variedad->vuelco=$request->get('vuelco');

        $variedad->carbon=$request->get('carbon');
        $variedad->escaladura=$request->get('escaladura');
        $variedad->estriaroja=$request->get('estriaroja');
        $variedad->mosaico=$request->get('mosaico');
        $variedad->royamarron=$request->get('royamarron');
        $variedad->royanaranja=$request->get('royanaranja');
        $variedad->pokkaboeng=$request->get('pokkaboeng');
        $variedad->amarillamiento=$request->get('amarillamiento');
        $variedad->manchaparda=$request->get('manchaparda');

        
        $variedad->observaciones=$request->get('observaciones');
        //$variedad->estado=1;//$request->get('estado');
       // dd($request->get('estado'));
        $variedad->estado=$request->get('estado');

        $variedad->update();
        return Redirect::to('admin/variedades');
    }

    public function destroy($id)
    {
    	$variedad=Variedad::findOrFail($id);
    	$variedad->estado='0';//baja
      	$variedad->update();
    	return Redirect::to('admin/variedades');
    }


    public function export() 
    {

        return Excel::download(new variedadesExport, 'variedades.xlsx');
    }

    public function BuscarTachosConIdVariedad($id)
    {
        $tachos=DB::table('tachos as t')
            //->leftjoin('area_proyecto as ap','p.idproyecto','=','ap.idproyecto')
            ->select('t.idtacho','t.codigo','t.subcodigo')
            ->where('t.idvariedad','=',$id)
            ->get();

        return response()->json($tachos);
    }
}