<?php

namespace App\Http\Controllers;

use App\Marcotado;
use Illuminate\Http\Request;
use DB;
use App\Tallo;
use App\Tacho;
use Illuminate\Support\Facades\Log;

class MarcotadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index(Request $request)
    {	
        if($request->get('campanias')){
            $idcampania=$request->get('campanias');
            $var="si";
        }
        else{
            $idultima = DB::table('campanias')
            ->where('estado', 1)
            ->OrderBy('nombre','DESC')
            ->take(1)
            ->select('id')
            ->get();
            $var="no";
            if (!$idultima->isEmpty()){
                $idcampania = $idultima[0]->id;
             }else{
                dd("No existen campañas de cruzamiento");
                dd($idultima);            
             }

        }
//print($idcampania);


            $query=trim($request->get('searchText'));
            $ubicaciones=DB::table('ubicaciontachoxcampania as u')
            ->join('tachos','u.idtacho','=','tachos.idtacho')
            ->join('variedades','tachos.idvariedad','=','variedades.idvariedad')
            ->join('ubicacionestachos as ubi','ubi.id','=','u.idubicacion')
            ->leftjoin('zorras','ubi.idzorra','=','zorras.id')
            ->join('camaras','zorras.idcamara','=','camaras.id')
            ->join('campaniacamaratratamientoubicacion as cc','cc.id','=','u.idcctu')
            ->Where('cc.idcampania',$idcampania)
            ->where ('variedades.nombre','like','%'.$query.'%')
            ->take(500)
 //           ->select(DB::raw("CONCAT(tachos.codigo,'-',tachos.subcodigo) AS tacho"),'ubi.nombre','tachos.idtacho','cantidadtallos')
            ->select('tachos.idtacho','ubi.id','ubi.nombre','tachos.idtacho',DB::raw("CONCAT(tachos.codigo,'-',tachos.subcodigo) AS tacho"),'variedades.nombre as variedad','zorras.id as idzorra','zorras.nombre as zorranombre','camaras.nombre as nombrecamara','cantidadtallos')
            //  ->OrderBy('ubi.idzorra','asc')
            ->OrderBy('tachos.idtacho','asc')
            ->get();
       // dd($ubicaciones);
        $tallos=DB::table('tallos')
            ->select('idtacho','numero','fechafloracion')
            ->Where('tallos.idcampania',$idcampania)
            ->get();
       // dd($tallos);
        $posiciones = [1,2,3,4,5];
        $campanias = DB::table('campanias')
                    ->select('*')
                    ->where('estado', 1)
                    ->OrderBy('nombre','DESC')
                    ->get();

        $nombrecampania = DB::table('campanias')
                    ->Where('id',$idcampania)
                    ->select('nombre')
                    ->get();
        return view('admin.marcotado.index',["ubicaciones"=>$ubicaciones,"tallos"=>$tallos,"posiciones"=>$posiciones,"idcampania"=>$idcampania,"nombrecampania"=>$nombrecampania[0]->nombre,"campanias"=>$campanias]);
        
    }

    public function cambiarCampania(Request $request){
        $ubicaciones=DB::table('ubicaciontachoxcampania as u')
                        ->join('tachos','u.idtacho','=','tachos.idtacho')
                        ->join('variedades','tachos.idvariedad','=','variedades.idvariedad')
                        ->join('ubicacionestachos as ubi','ubi.id','=','u.idubicacion')
                        ->join('zorras','ubi.idzorra','=','zorras.id')
                        ->join('camaras','zorras.idcamara','=','camaras.id')
                        ->join('campaniacamaratratamientoubicacion as cc','cc.id','=','u.idcctu')
                        ->Where('cc.idcampania',$request['campanias'])
                        ->select('ubi.id','ubi.nombre','tachos.idtacho','tachos.codigo','tachos.subcodigo','variedades.nombre as variedad','zorras.id as idzorra','zorras.nombre as zorranombre','camaras.nombre as nombrecamara','cantidadtallos')
                        ->take(600)
                        ->get();

        $tallos=DB::table('tallos')
                    ->select('*')
                    ->get();
        $posiciones = [1,2,3,4,5];
        $campanias = DB::table('campanias')
                    ->select('*')
                    ->where('estado', 1)
                    ->OrderBy('nombre','DESC')
                    ->get();

        $nombrecampania = DB::table('campanias')
                            ->Where('id',$request['campanias'])
                            ->select('nombre')
                            ->get();
        $query=trim($request->get('searchText'));
        return view('admin.marcotado.index',["ubicaciones"=>$ubicaciones,"tallos"=>$tallos,"posiciones"=>$posiciones,"idcampania"=>$request['campanias'],"nombrecampania"=>$nombrecampania[0]->nombre,"campanias"=>$campanias,"searchText"=>$query]);        
       
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
                       
    }

    public function guardarcantidadtallos(Request $request)
    {
        
    	if($request->ajax()){
               
                $tacho = Tacho::findOrFail($request->id_tacho);
                $tacho->cantidadtallos=$request->cantidad;
                $tacho->update();

    		return response()->json(['tacho'=>$tacho]);
    	}
    }

    public function guardarfecha(Request $request)
    {
        $input = $request->all();
        \Log::info($input);

    	if($request->ajax()){
               
                $existeTallo = DB::table('tallos')
                ->Where('numero',$request->posicion)
                ->Where('idtacho',$request->id_tacho)
                ->Where('idcampania',$request->campania)
                ->select('id')->get();
               
                if(Count($existeTallo) === 0 ){
                    // Crear tallo
                    $tallo = new Tallo();
                    $tallo->numero = $request->posicion;
                    $tallo->fechafloracion = $request->fecha;
                    $tallo->idtacho = $request->id_tacho;
                    $tallo->polen = 0;
                    $tallo->enmasculado = 0;
                    $tallo->idcampania = $request->campania;
                    $tallo->save(); 
                }else{
                    // Modificar tallo
                    $tallo = Tallo::findOrFail($existeTallo[0]->id);
                    $tallo->fechafloracion = $request->fecha;
                    $tallo->update();
                }
                
                
                
    		return response()->json(['tallo'=>$tallo]);
    	}
    }
    /**
     * Display the specified resource.
     *
     * @param  \App\Marcotado  $marcotado
     * @return \Illuminate\Http\Response
     */
    public function show(Marcotado $marcotado)
    {
        return view('admin.marcotado.detalles');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Marcotado  $marcotado
     * @return \Illuminate\Http\Response
     */
    public function edit(Marcotado $marcotado)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Marcotado  $marcotado
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Marcotado $marcotado)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Marcotado  $marcotado
     * @return \Illuminate\Http\Response
     */
    public function destroy(Marcotado $marcotado)
    {
        //
    }
}
