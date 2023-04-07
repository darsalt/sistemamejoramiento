<?php

namespace App\Http\Controllers;

use App\Camara;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Log;

class CamaraController extends Controller
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
  
    
    public function index()
    {
        $idcampania = DB::table('campanias')
                    ->where('estado', 1)
                    ->OrderBy('nombre','DESC')
                    ->take(1)
                    ->select('id')
                    ->get();

        $cctu = DB::table('campaniacamaratratamientoubicacion as c')
                    ->join('camaras as cam','cam.id','=','c.idcamara')
                    ->join('campanias as ca','ca.id','=','c.idcampania')
                    ->join('tratamientos as t','t.idtratamiento','=','c.idtratamiento')
                    ->where('c.idcampania',$idcampania[0]->id)
                    ->Where('cam.id',1)
                    ->select('idcampania','ca.nombre as campania','c.idcamara','cam.nombre','c.idcamara','c.idtratamiento','t.nombre as tratamiento','t.descripcion as descripcion')
                    ->get();
        
        
        $ubicaciontacho = DB::table('ubicaciontachoxcampania as u')
                            ->join('ubicacionestachos as ubi','ubi.id','=','u.idubicacion')
                            ->join('tachos as ta','ta.idtacho','=','u.idtacho')
                            ->join('variedades as v','v.idvariedad','=','ta.idvariedad')
                            ->join('campaniacamaratratamientoubicacion as cc','cc.id','=','u.idcctu')
                            ->whereIn('u.idcctu', DB::table('campaniacamaratratamientoubicacion as c')
                                                    ->Where('c.idcampania',$idcampania[0]->id)
                                                    ->select('c.id'))
                            ->select('u.idubicacion','ubi.nombre as ubicacion','ubi.idzorra','u.idtacho','ta.codigo','ta.subcodigo','v.nombre as variedad','cc.idcamara')
                            ->get();
       // dd($ubicaciontacho);
        $campanias = DB::table('campanias')
                    ->select('*')
                    ->where('estado', 1)
                    ->OrderBy('nombre','DESC')
                    ->get();
        $nombrecampania = DB::table('campanias')
                    ->Where('id',$idcampania[0]->id)
                    ->select('nombre')
                    ->get();
        $tachos=DB::table('ubicaciontachoxcampania as u')
                    ->join('ubicacionestachos as ubi','ubi.id','=','u.idubicacion')
                    ->join('campaniacamaratratamientoubicacion as c','u.idcctu','=','c.id')
                    ->join('tachos as t','t.idtacho','=','u.idtacho')
                    ->join('variedades as v','t.idvariedad','=','v.idvariedad')
                    ->where('c.idcampania',$idcampania[0]->id)
                    ->where('c.idcamara','!=','6')
                    ->select('c.id','c.idcamara', 'c.idcampania','c.idtratamiento','ubi.nombre','ubi.idzorra','t.*','v.nombre as variedad', )
                    ->OrderBy('t.codigo','asc')
                    ->OrderBy('t.subcodigo','asc')
                    ->get();
        // dd($tachos);
        $tachos2=DB::table('ubicaciontachoxcampania as u')
                    ->join('campaniacamaratratamientoubicacion as c','u.idcctu','=','c.id')
                    ->join('tachos as t','t.idtacho','=','u.idtacho')
                    ->join('variedades as v','t.idvariedad','=','v.idvariedad')
                    ->where('c.idcampania',$idcampania[0]->id)
                    ->where('c.idcamara','6')
                    ->select('t.*','v.nombre as variedad', 'c.idcamara')
                    ->OrderBy('t.codigo','asc')
                    ->OrderBy('t.subcodigo','asc')
                    ->get();

        $piletones=DB::table('ubicaciontachoxcampania as u')
        ->join('campaniacamaratratamientoubicacion as c','u.idcctu','=','c.id')
        ->join('tachos as t','t.idtacho','=','u.idtacho')
        ->join('variedades as v','t.idvariedad','=','v.idvariedad')
        ->where('c.idcampania',$idcampania[0]->id)
        ->where('c.idcamara','6')
        ->select('t.*','v.nombre as variedad', 'c.idcamara','c.idcampania')
        ->OrderBy('t.codigo','asc')
        ->OrderBy('t.subcodigo','asc')
        ->get();
      //  dd($piletones);
        //print($idcampania[0]->id);

        $tachosBaCK=DB::table('tachos as t')
            ->join('variedades as v','t.idvariedad','=','v.idvariedad')
            ->whereIn('t.idtacho',function($query){
                $query->select('idtacho')->from('ubicaciontachoxcampania as u')
                ->join('campaniacamaratratamientoubicacion as c','u.idcctu','=','c.id')
 //               ->where('c.idcampania',$idcampania[0]->id)
                ->where('c.idcamara','6');
             })
            ->select('t.*','v.nombre as variedad')
            ->where ('t.inactivo','=',0)//3=baja
            ->where ('t.destino','=',1)//1=progenitores         
           // ->whereIn('t.idtacho', DB::table('ubicaciontachoxcampania as u')->join('campaniacamaratratamientoubicacion as c','c.id','=','u.idcctu')->where('idcampania', $idcampania[0]->id)->pluck('u.idtacho'))
    		->orderBy('t.codigo','asc')
            ->get();
            //dd($tachos);

        $tratamientos=DB::table('tratamientos')
            ->select('idtratamiento','nombre','descripcion')
            ->where('estado','=','1')
            ->get();
        $camaras=DB::table('camaras')
            ->select('id','nombre')
            ->where('estado',"=","1")
            ->get();
        $zorras=DB::table('zorras')
            ->select('id','nombre','idcamara')
            ->Where('idcamara',1)
            ->where('estado',"=","1")
            ->get();
        $ubicacion=DB::table('ubicacionestachos as u')
            ->join('zorras','u.idzorra','=','zorras.id')
            ->join('camaras','zorras.idcamara','=','camaras.id')
            ->Where('camaras.id',1)
            ->select('u.id','u.nombre','zorras.id as idzorra','zorras.nombre as zorranombre','camaras.id as idcamara')
            ->get();    
        return view('admin.camaras.index',["piletones"=>$piletones,"tachos"=>$tachos,"tratamientos"=>$tratamientos,"camaras"=>$camaras,"zorras"=>$zorras,"ubicacion"=>$ubicacion,"cctu"=>$cctu,"campanias"=>$campanias,"ubicaciontacho"=>$ubicaciontacho,"idcampania"=>$idcampania[0]->id,"nombrecampania"=>$nombrecampania[0]->nombre,"idcamara"=>1]);
    }

    public function CambiarCamara(Request $request)
    {
        //Log::debug("Piletones", ["piletones" =>$piletones]);
        // Log::debug("Tachos", ["tachos" =>$tachos]);   
        // Log::debug("Tratamientos", ["tratamientos" =>$tratamientos]);   
        // Log::debug("Camaras", ["Piletones" =>$piletones]);
        // Log::debug("Zorras", ["Piletones" =>$piletones]);   
        // Log::debug("ubicacion", ["Piletones" =>$piletones]); 

        // Log::debug("cctu", ["cctu" =>$cctu]);
        // Log::debug("campanias", ["campanias" =>$campanias]);   
        // Log::debug("ubicaciontacho", ["ubicaciontacho" =>$ubicaciontacho]);   
        // Log::debug("idcampania1", $request->idCa);
        // Log::debug("idcampania", [$request['campanias']]);   
        // Log::debug("idcamara", [$request->id]); 
   

     
        $cctu = DB::table('campaniacamaratratamientoubicacion as c')
                    ->join('camaras as cam','cam.id','=','c.idcamara')
                    ->join('campanias as ca','ca.id','=','c.idcampania')
                    ->join('tratamientos as t','t.idtratamiento','=','c.idtratamiento')
                    ->where('c.idcampania',$request->idCa)
                    ->Where('cam.id',$request->id)
                    ->select('idcampania','ca.nombre as campania','c.idcamara','cam.nombre','c.idcamara','c.idtratamiento','t.nombre as tratamiento')
                    ->get();

        
        $ubicaciontacho = DB::table('ubicaciontachoxcampania as u')
                            ->join('ubicacionestachos as ubi','ubi.id','=','u.idubicacion')
                            ->join('tachos as ta','ta.idtacho','=','u.idtacho')
                            ->join('variedades as v','v.idvariedad','=','ta.idvariedad')
                            ->join('campaniacamaratratamientoubicacion as cc','cc.id','=','u.idcctu')
                            ->whereIn('u.idcctu', DB::table('campaniacamaratratamientoubicacion as c')
                                                    ->Where('c.idcampania',$request->idCa)
                                                    ->select('c.id'))
                            ->select('u.idubicacion','ubi.nombre as ubicacion','ubi.idzorra','u.idtacho','ta.codigo','ta.subcodigo','v.nombre as variedad','cc.idcamara')
                            ->get();
        
        $campanias = DB::table('campanias')
                        ->select('*')
                        ->where('estado', 1)
                        ->OrderBy('nombre','DESC')
                        ->get();

        $nombrecampania = DB::table('campanias')
                    ->Where('id',$request->idCa)
                    ->select('nombre')
                    ->get();
        
                    $piletones=DB::table('ubicaciontachoxcampania as u')
                    ->join('campaniacamaratratamientoubicacion as c','u.idcctu','=','c.id')
                    ->join('tachos as t','t.idtacho','=','u.idtacho')
                    ->join('variedades as v','t.idvariedad','=','v.idvariedad')
                    ->where('c.idcampania',$request->idCa)
                    ->where('c.idcamara','6')
                    ->select('t.*','v.nombre as variedad', 'c.idcamara')
                    ->OrderBy('t.codigo','asc')
                    ->OrderBy('t.subcodigo','asc')
                    ->get();
                    $tachos=DB::table('ubicaciontachoxcampania as u')
                    ->join('ubicacionestachos as ubi','ubi.id','=','u.idubicacion')
                    ->join('campaniacamaratratamientoubicacion as c','u.idcctu','=','c.id')
                    ->join('tachos as t','t.idtacho','=','u.idtacho')
                    ->join('variedades as v','t.idvariedad','=','v.idvariedad')
                    ->where('c.idcampania',$request->idCa)
                    ->where('c.idcamara','!=','6')
                    ->select('c.id','c.idcamara', 'c.idcampania','c.idtratamiento','ubi.nombre','ubi.idzorra','t.*','v.nombre as variedad', )
                    ->OrderBy('t.codigo','asc')
                    ->OrderBy('t.subcodigo','asc')
                    ->get();


        $tratamientos=DB::table('tratamientos')
            ->select('idtratamiento','nombre')
            ->where('estado','=','1')
            ->get();
        $camaras=DB::table('camaras')
            ->select('id','nombre')
            ->where('estado',"=","1")
            ->get();
        $zorras=DB::table('zorras')
            ->select('id','nombre','idcamara')
            ->Where('idcamara',$request->id)
            ->where('estado',"=","1")
            ->get();
        $ubicacion=DB::table('ubicacionestachos as u')
            ->join('zorras','u.idzorra','=','zorras.id')
            ->join('camaras','zorras.idcamara','=','camaras.id')
            ->Where('camaras.id',$request->id)
            ->select('u.id','u.nombre','zorras.id as idzorra','zorras.nombre as zorranombre','camaras.id as idcamara')
            ->get();    

//     return view('admin.camaras.index',["piletones"=>$piletones,"tachos"=>$tachos,"tratamientos"=>$tratamientos,"camaras"=>$camaras,"zorras"=>$zorras,"ubicacion"=>$ubicacion,"cctu"=>$cctu,"campanias"=>$campanias,"ubicaciontacho"=>$ubicaciontacho,"idcampania1"=>$request->idCa,"idcampania"=>$request['campanias'],"nombrecampania"=>$nombrecampania[0]->nombre,"idcamara"=>$request->id]);

        return view('admin.camaras.index',["piletones"=>$piletones,"tachos"=>$tachos,"tratamientos"=>$tratamientos,"camaras"=>$camaras,"zorras"=>$zorras,"ubicacion"=>$ubicacion,"cctu"=>$cctu,"campanias"=>$campanias,"ubicaciontacho"=>$ubicaciontacho,"idcampania"=>$request->idCa,"idcampania1"=>$request['campanias'],"nombrecampania"=>$nombrecampania[0]->nombre,"idcamara"=>$request->id]);

    }

    public function cambiarCampania(Request $request){
       
        $cctu = DB::table('campaniacamaratratamientoubicacion as c')
                    ->join('camaras as   cam','cam.id','=','c.idcamara')
                    ->join('campanias as ca','ca.id','=','c.idcampania')
                    ->join('tratamientos as t','t.idtratamiento','=','c.idtratamiento')
                    ->where('c.idcampania',$request['campanias'])
                    ->select('idcampania','ca.nombre as campania','c.idcamara','cam.nombre','c.idcamara','c.idtratamiento','t.nombre as tratamiento')
                    ->get();
                    
        $ubicaciontacho = DB::table('ubicaciontachoxcampania as u')
                            ->join('ubicacionestachos as ubi','ubi.id','=','u.idubicacion')
                            ->join('tachos as ta','ta.idtacho','=','u.idtacho')
                            ->join('variedades as v','v.idvariedad','=','ta.idvariedad')
                            ->join('campaniacamaratratamientoubicacion as cc','cc.id','=','u.idcctu')
                            ->whereIn('u.idcctu', DB::table('campaniacamaratratamientoubicacion as c')
                                                    ->Where('c.idcampania',$request['campanias'])
                                                    ->select('c.id'))
                            ->select('u.idubicacion','ubi.nombre as ubicacion','ubi.idzorra','u.idtacho','ta.codigo','ta.subcodigo','v.nombre as variedad','cc.idcamara')
                            ->get();
        
        $campanias = DB::table('campanias')
                        ->select('*')
                        ->where('estado', 1)
                        ->OrderBy('nombre','DESC')
                        ->get();

        $nombrecampania = DB::table('campanias')
                    ->Where('id',$request['campanias'])
                    ->select('nombre')
                    ->get();


                    $tachos=DB::table('ubicaciontachoxcampania as u')
                    ->join('ubicacionestachos as ubi','ubi.id','=','u.idubicacion')
                    ->join('campaniacamaratratamientoubicacion as c','u.idcctu','=','c.id')
                    ->join('tachos as t','t.idtacho','=','u.idtacho')
                    ->join('variedades as v','t.idvariedad','=','v.idvariedad')
                    ->where('c.idcampania',$request['campanias'])
                    ->where('c.idcamara','!=','6')
                    ->select('c.id','c.idcamara', 'c.idcampania','c.idtratamiento','ubi.nombre','ubi.idzorra','t.*','v.nombre as variedad', )
                    ->OrderBy('t.codigo','asc')
                    ->OrderBy('t.subcodigo','asc')
                    ->get();

                    //rint($tachos);
                  // print($request['campanias']);
           
        $tratamientos=DB::table('tratamientos')
            ->select('idtratamiento','nombre')
            ->where('estado','=','1')
            ->get();
        $camaras=DB::table('camaras')
            ->select('id','nombre')
            ->where('estado',"=","1")
            ->get();
        $zorras=DB::table('zorras')
            ->select('id','nombre','idcamara')
            ->where('estado',"=","1")
            ->get();
        $ubicacion=DB::table('ubicacionestachos as u')
            ->join('zorras','u.idzorra','=','zorras.id')
            ->join('camaras','zorras.idcamara','=','camaras.id')
            ->select('u.id','u.nombre','zorras.id as idzorra','zorras.nombre as zorranombre','camaras.id as idcamara')
            ->get();   
            $piletones=DB::table('ubicaciontachoxcampania as u')
            ->join('campaniacamaratratamientoubicacion as c','u.idcctu','=','c.id')
            ->join('tachos as t','t.idtacho','=','u.idtacho')
            ->join('variedades as v','t.idvariedad','=','v.idvariedad')
            ->where('c.idcampania',$request['campanias'])
            ->where('c.idcamara','6')
            ->select('t.*','v.nombre as variedad', 'c.idcamara')
            ->OrderBy('t.codigo','asc')
            ->OrderBy('t.subcodigo','asc')
            ->get();

        return view('admin.camaras.index',["piletones"=>$piletones,"tachos"=>$tachos,"tratamientos"=>$tratamientos,"camaras"=>$camaras,"zorras"=>$zorras,"ubicacion"=>$ubicacion,"cctu"=>$cctu,"campanias"=>$campanias,"ubicaciontacho"=>$ubicaciontacho,"idcampania"=>$request['campanias'],"nombrecampania"=>$nombrecampania[0]->nombre,"idcamara"=>"1"]);
    }
    public function selectTratamiento(Request $request)
    {
    	if($request->ajax()){
             $row = DB::table('campaniacamaratratamientoubicacion')
                ->Where('idcampania',$request->idcampania)
                ->Where('idcamara',$request->idcamara)
                ->update(['idtratamiento'=>$request->idtratamiento]);

            if(! $row){
                DB::table('campaniacamaratratamientoubicacion')
                ->insert(['idcampania'=>$request->idcampania,'idcamara'=>$request->idcamara,'idtratamiento'=>$request->idtratamiento]);
            }
    		return response()->json(['update'=>$row]);
    	}
    }

    public function selectTacho(Request $request)
    {
        if($request->ajax()){

            $idcctu = DB::table('campaniacamaratratamientoubicacion')
            ->Where('idcampania',$request->idcampania)
            ->Where('idcamara',$request->idcamara)
            ->select('id')
            ->get();

            $idubicacion = DB::table('ubicacionestachos')
            ->Where('nombre',$request->ubicacion)
            ->Where('idzorra',$request->idzorra)
            ->select('id')
            ->get();

            // $row = DB::table('ubicaciontachoxcampania')
            // ->where('idubicacion', $idubicacion[0]->id)
            // ->where('idcctu',$idcctu[0]->id)
            // ->update(['idtacho' => $request->idtacho]);


            if($request->idtacho > 0){
                $row = DB::table('ubicaciontachoxcampania')
                ->where('idcctu',$request->idcampania*6)
                ->where('idtacho', $request->idtacho)
                ->update(['idubicacion' =>  $idubicacion[0]->id,'idcctu'=>$idcctu[0]->id]);
            }else{
                $row = DB::table('ubicaciontachoxcampania')
                ->where('idcctu',$idcctu[0]->id)
                ->where('idubicacion', $idubicacion[0]->id)
                ->update(['idubicacion' =>  '531','idcctu'=>$request->idcampania*6]);

            }

            Log::debug("idcctu", ["idcctu" => $idcctu[0]->id]);
            Log::debug("idubicacion", ["idubicacion" =>  $idubicacion[0]->id]);
            Log::debug("idtacho", ["idtacho" =>$request->idtacho]);
            Log::debug("Campania", ["idcampania" =>$request->idcampania]);
            Log::debug("Camara", ["idcamara" =>$request->idcamara]);
            Log::debug("Zorra", ["idzorra" =>$request->idzorra]);




           // $ubi = ubicaciontachoxcampania::findOrFail(1);
            //$ubi->idubicacion=$request->ubicacion;
            //$ubi->idcctu=$idcctu[0]->id;
            //$ubi->idcctu=11;
            //$ubi->update();
            //Log::debug("Se está registrando un usuario", ["nombre" => $ubi->idcctu]);
            //  $row = DB::table('ubicaciontachoxcampania')
            //  ->where('idubicacion', $idubicacion[0]->id)
            //  ->where('idcctu',$idcctu[0]->id)
            //  ->update(['idtacho' => $request->idtacho]);

             $tachos=DB::table('tachos as t')
             ->join('variedades as v','t.idvariedad','=','v.idvariedad')
             ->whereNotIn('t.idtacho', DB::table('tachos as ta')
                                             ->join('ubicaciontachoxcampania as u','ta.idtacho','=','u.idtacho')
                                             ->select('u.idtacho'))
             ->select('t.*','v.nombre as variedad')
             ->where ('t.estado','!=',3)//3=baja
             ->where ('t.destino','=',1)//1=progenitores            
             ->orderBy('t.codigo','asc')
             ->get();

            return response()->json(['tachos'=>$tachos]);           
           
        }
    }


       
}
