<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Tacho;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\TachoFormRequest;
use DB;
use App\Exports\TachosExport;
use Maatwebsite\Excel\Facades\Excel;

class TachoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
    	if($request){
    		$query=trim($request->get('searchText'));
    		$tachos=DB::table('tachos as t')
            ->leftjoin('variedades as v','t.idvariedad','=','v.idvariedad')
            ->select('t.*', 'v.nombre as nombrevariedad')
            ->where ('codigo','like','%'.$query.'%') 
    		->where ('t.estado','!=',3)//3=baja
    		->orderBy('idtacho','asc')
    		->paginate('10');
    		return view('admin.tachos.index',["tachos"=>$tachos,"searchText"=>$query]);
    	}
    }

    public function create()
    {   //mando todas las variedades
        $variedades = DB::table('variedades as v')
            ->select('v.idvariedad','v.nombre')
            //->where('v.estado','=','0')
            ->get();
        
    	return view ("admin.tachos.create",["variedades"=>$variedades]);
    }

    public function store(TachoFormRequest $request)
    {
        $subcodigos = $request->get('subcodigo');
        $cont=0;
        while($cont<count($subcodigos)){
            $tacho=new Tacho;
            $tacho->codigo=$request->get('codigo');
            $tacho->subcodigo=$subcodigos[$cont];
            $tacho->fechaalta=$request->get('fechaalta');
            $tacho->idvariedad=$request->get('idvariedad');
            $tacho->destino=$request->get('destino');
            $tacho->observaciones=$request->get('observaciones');
            if($request->get('idvariedad')==0){
               $tacho->estado='libre';
            }
            else{
                $tacho->estado='ocupado';
            }

            $tacho->save();
            $cont = $cont+1;
        }
    	
    	return Redirect::to('admin/tachos');
    }

    public function show($id)
    {
    	return view("admin.tachos.show",["tacho"=>Tacho::findOrFail($id)]);
    }

     public function edit(Tacho $tacho)
    {
        
        $variedades = DB::table('variedades as v')
        ->select('v.idvariedad','v.nombre')
            //->where('v.estado','=','0')
        ->get();
        $estados = array(
            1 => 'Libre',
            2 => 'Ocupado',
            3 => 'Baja',
        );
        //dd($estados);
        return view('admin.tachos.edit',compact('tacho'),["variedades"=>$variedades,"estados"=>$estados]);
    }

    public function update(TachoFormRequest $request,$id)
    {
        $tacho=Tacho::findOrFail($id);
        $tacho->codigo=$request->get('codigo');
        $tacho->subcodigo=$request->get('subcodigo');
        $tacho->fechaalta=$request->get('fechaalta');
        $tacho->idvariedad=$request->get('idvariedad');
        $tacho->destino=$request->get('destino');

        $tacho->observaciones=$request->get('observaciones');

        $tacho->estado=$request->get('estado');

        $tacho->update();
        return Redirect::to('admin/tachos');
    }

    public function destroy($id)
    {
    	$tacho=Tacho::findOrFail($id);
    	$tacho->estado='3';//baja
      	$tacho->update();
    	return Redirect::to('admin/tachos');
    }


    public function export() 
    {
        return Excel::download(new TachosExport, 'tachos.xlsx');
    }

    public function BuscarVariedadConIdTacho($id)
    {
        $variedad=DB::table('tachos as t')
        ->leftjoin('variedades as v','t.idvariedad','=','v.idvariedad')
            ->select('v.idvariedad','v.nombre')
            ->where('t.idtacho','=',$id)
            ->get();

        return response()->json($variedad);
    }
}
