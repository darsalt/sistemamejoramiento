<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Ubicacion;
use App\Tacho;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\UbicacionFormRequest;
use DB;
use App\Exports\UbicacionesExport;
use Maatwebsite\Excel\Facades\Excel;

class UbicacionimpoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {

        if($request->getPathInfo()=="/admin/ubicacionesexpo"){
        	if($request){
        		$query=trim($request->get('searchText'));
        		$ubicaciones=DB::table('ubicaciones as l')
                //->leftjoin('tachos as t','l.idubicacion','=','t.idubicacion')
                ->select('l.idubicacion','l.nombreubicacion','l.observaciones')
                ->where ('l.estado','=','1') 
                ->where ('l.nombreubicacion','like','%'.$query.'%') 
        		->where ('expo','=',1)
        		->orderBy('l.idubicacion','desc')
        		->paginate('10');
                //dd($ubicaciones);
            }
            return view('admin.ubicacionesexpo.index',["ubicaciones"=>$ubicaciones,"searchText"=>$query,"sector"=>"expo"]);
    	}

        if($request->getPathInfo()=="/admin/ubicacionesimpo"){
            if($request){
                $query=trim($request->get('searchText'));
                $ubicaciones=DB::table('ubicaciones as l')
                //->leftjoin('tachos as t','l.idubicacion','=','t.idubicacion')
                ->select('l.idubicacion','l.nombreubicacion','l.observaciones')
                ->where ('l.estado','=','1') 
                ->where ('l.nombreubicacion','like','%'.$query.'%') 
                ->where ('impo','=',1)
                ->orderBy('l.idubicacion','desc')
                ->paginate('10');
                //dd($ubicaciones);
            }
            return view('admin.ubicacionesimpo.index',["ubicaciones"=>$ubicaciones,"searchText"=>$query,"sector"=>"impo"]);
        }

    }

    public function create()
    {
            $variedades = DB::table('variedades as v')
            ->select('v.idvariedad','v.nombre')
            //->where('v.estado','=','1')
            ->get();


            if($_GET["area"]=="expo")
                $tachos = DB::table('tachos as t')
                ->select('t.idtacho',DB::raw('CONCAT(codigo,"-",subcodigo) as nombretacho'))
                ->where('t.estado','=','ocupado')
                ->where('t.idubicacion','=','0')
                ->where('t.expo','=','1')
                ->get();
            else
                $tachos = DB::table('tachos as t')
                ->select('t.idtacho',DB::raw('CONCAT(codigo,"-",subcodigo) as nombretacho'))
                ->where('t.estado','=','ocupado')
                ->where('t.idubicacion','=','0')
                ->where('t.impo','=','1')
                ->get();

        if($_GET["area"]=="expo")
    	   return view ("admin.ubicacionesexpo.create",["variedades"=>$variedades,"tachos"=>$tachos]);
        else
            return view ("admin.ubicacionesimpo.create",["variedades"=>$variedades,"tachos"=>$tachos]);

    }

    // public function store(TareaFormRequest $request)
    // {
    // 	$tarea=new Tarea;
    //     $tarea->idtacho=$request->get('idtacho');
    //     $tarea->idvariedad=$request->get('idvariedad');
    //     $tarea->idtipotarea=$request->get('idtipotarea');
    //     $tarea->fecharealizacion=$request->get('fecharealizacion');
    //     $tarea->observaciones=$request->get('observaciones');
    // 	$tarea->idestado=$request->get('idestado');
    // 	$tarea->save();
    // 	return Redirect::to('admin/tareas');
    // }
    public function store(UbicacionFormRequest $request)
    {   //dd($request);
        $ubicacion=new Ubicacion;
        $ubicacion->nombreubicacion=$request->get('nombreubicacion');
        $ubicacion->observaciones=$request->get('observaciones');
        $ubicacion->estado=1;
        if($request->get('area')=="expo"){
            $ubicacion->expo=1;
            $ubicacion->impo=0;
        }else{
            $ubicacion->impo=1;
            $ubicacion->expo=0;
        }
        $ubicacion->save();
        $idubicacion = $ubicacion->idubicacion;


        if($request->get('tachos')>0){
            $tachos = $request->get('tachos');
            $cont=0;
            while($cont<count($tachos)){

                $tacho=Tacho::findOrFail($tachos[$cont]);
                $tacho->idubicacion = $idubicacion;

                $tacho->update();
                $cont = $cont+1;
            }
        }
        
        if($request->get('area')=="expo")
            return Redirect::to('admin/ubicacionesexpo');
        else
            return Redirect::to('admin/ubicacionesimpo');


       

    }

    public function show($id)
    {
    	return view("admin.ubicaciones.show",["ubicacion"=>Ubicacion::findOrFail($id)]);
    }

     public function edit($idubicacion)
    {
                  //dd($idubicacion);
        $ubicacion = Ubicacion::find($idubicacion);

            $variedades = DB::table('variedades as v')
            ->select('v.idvariedad','v.nombre')
            //->where('v.estado','=','1')
            ->get();

            $tachos = DB::table('tachos as t')
            ->select('t.idtacho',DB::raw('CONCAT(codigo,"-",subcodigo) as nombretacho'),'idubicacion')
            ->where('t.impo','=','1')
            ->where(function($query) use ($idubicacion) {
                $query->where('t.idubicacion','=',$idubicacion)
                  ->orwhere('t.idubicacion','=','0');
            })
            ->get();

            return view('admin.ubicacionesimpo.edit',compact('ubicacion'),["variedades"=>$variedades,"tachos"=>$tachos]);
    }
    
    public function update(UbicacionFormRequest $request,$id)
    {

        $ubicacion=Ubicacion::findOrFail($id);
        $ubicacion->nombreubicacion=$request->get('nombreubicacion');
        $ubicacion->observaciones=$request->get('observaciones');

        $ubicacion->update();

        DB::table('tachos')
        ->where('idubicacion',$id)
        ->update(['idubicacion'=>'0']);

        $tachos = $request->get('tachos');
        $cont=0;
        //dd($tachos);
        if(!empty($tachos)){
            while($cont<count($tachos)){
                $tacho=Tacho::findOrFail($tachos[$cont]);
                $tacho->idubicacion = $id;

                $tacho->update();
                $cont = $cont+1;
            }
        }
        if($ubicacion->expo==1){return Redirect::to('admin/ubicacionesexpo');}
        if($ubicacion->impo==1){return Redirect::to('admin/ubicacionesimpo');}

    }

    public function destroy($id)
    {
    	$ubicacion=Ubicacion::findOrFail($id);
    	$ubicacion->estado='0';//baja
      	$ubicacion->update();
        if($ubicacion->expo==1){return Redirect::to('admin/ubicacionesexpo');}
        if($ubicacion->impo==1){return Redirect::to('admin/ubicacionesimpo');} 
   }


    public function export() 
    {
        return Excel::download(new UbicacionesExport, 'ubicaciones.xlsx');
    }

    public function tareasasociadas($id)
    {
        //$exportacion=Exportacion::findOrFail($id);

        $ubicacion=DB::table('ubicaciones as l')
        //->leftjoin('tachos as t','e.idtacho','=','t.idtacho')
        //->leftjoin('variedades as v','e.idvariedad','=','v.idvariedad')
        ->select('l.idubicacion','l.nombreubicacion','l.observaciones','expo','impo')
        ->where ('idubicacion','=',$id)
        ->get();

        $tachos = DB::table('tachos as t')
        ->select('t.idtacho',DB::raw('CONCAT(codigo,"-",subcodigo) as nombretacho'),'nombre as nombrevariedad')
        ->leftjoin('variedades as v','t.idvariedad','=','v.idvariedad')
        ->where('t.idubicacion','=',$id)
        ->get();

        $tareasasociadas=DB::table('tareas as t')
        ->select('t.idtarea','tt.nombre','t.fecharealizacion','observaciones')
        ->leftjoin('tipostareas as tt','t.idtipotarea','=','tt.idtipotarea')
        ->where ('idimportacion','=',$id)
        ->orderBy('t.fecharealizacion','desc')
        ->paginate('3');

        return view("admin.ubicacionesimpo.tareas",compact("ubicacion"),["ubicacion"=>$ubicacion,"tareasasociadas"=>$tareasasociadas,"tachos"=>$tachos]);

    }

    public function evaluacionesasociadas($id)
    {
         $ubicacion=DB::table('ubicaciones as l')
        //->leftjoin('tachos as t','e.idtacho','=','t.idtacho')
        //->leftjoin('variedades as v','e.idvariedad','=','v.idvariedad')
        ->select('l.idubicacion','l.nombreubicacion','l.observaciones','expo','impo')
        ->where ('idubicacion','=',$id)
        ->get();

        $tachos = DB::table('tachos as t')
        ->select('t.idtacho',DB::raw('CONCAT(codigo,"-",subcodigo) as nombretacho'),'nombre as nombrevariedad')
        ->leftjoin('variedades as v','t.idvariedad','=','v.idvariedad')
        ->where('t.idubicacion','=',$id)
        ->get();

         $evaluacionesasociadas=DB::table('evaluaciones as e')
        ->select('e.idevaluacion','t.nombre','e.fechaevaluacion','observaciones')
        ->leftjoin('tiposevaluaciones as t','e.idtipoevaluacion','=','t.idtipoevaluacion')
        ->where ('idimportacion','=',$id)
        ->orderBy('e.fechaevaluacion','desc')
        ->paginate('3');


        return view("admin.ubicacionesimpo.evaluaciones",compact("ubicacion"),["ubicacion"=>$ubicacion,"evaluacionesasociadas"=>$evaluacionesasociadas,"tachos"=>$tachos]);

    }

    public function inspeccionesasociadas($id)
    {
         $ubicacion=DB::table('ubicaciones as l')
        //->leftjoin('tachos as t','e.idtacho','=','t.idtacho')
        //->leftjoin('variedades as v','e.idvariedad','=','v.idvariedad')
        ->select('l.idubicacion','l.nombreubicacion','l.observaciones','expo','impo')
        ->where ('idubicacion','=',$id)
        ->get();

        $tachos = DB::table('tachos as t')
        ->select('t.idtacho',DB::raw('CONCAT(codigo,"-",subcodigo) as nombretacho'),'nombre as nombrevariedad')
        ->leftjoin('variedades as v','t.idvariedad','=','v.idvariedad')
        ->where('t.idubicacion','=',$id)
        ->get();

         $inspeccionesasociadas=DB::table('inspecciones as e')
        ->select('e.idinspeccion','e.certificado','e.fechainspeccion','observaciones')
       // ->leftjoin('tiposevaluaciones as t','e.idtipoevaluacion','=','t.idtipoevaluacion')
        ->where ('idimportacion','=',$id)
        ->orderBy('e.fechaevaluacion','desc')
        ->paginate('3');


        return view("admin.ubicacionesimpo.inspecciones",compact("ubicacion"),["ubicacion"=>$ubicacion,"inspeccionesasociadas"=>$inspeccionesasociadas,"tachos"=>$tachos]);

    }

}
