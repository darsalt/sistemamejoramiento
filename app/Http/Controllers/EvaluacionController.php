<?php

namespace App\Http\Controllers;

use App\Ambiente;
use App\Edad;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Evaluacion;
use App\EvaluacionMET;
use App\EvaluacionPrimeraClonal;
use App\EvaluacionSegundaClonal;
use App\Tacho;

use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\EvaluacionFormRequest;
use DB;
use App\Exports\EvaluacionsExport;
use App\Rules\EvaluacionUnica;
use App\Serie;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class EvaluacionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
    	if($request){
    		$query=trim($request->get('searchText'));
    		$evaluaciones=DB::table('evaluaciones as e')
            ->leftjoin('tachos as t','e.idtacho','=','t.idtacho')
            ->leftjoin('variedades as v','e.idvariedad','=','v.idvariedad')
            ->select('e.idevaluacion','e.idvariedad','t.idtacho','t.codigo','t.subcodigo','v.nombre as nombrevariedad','e.idtipoevaluacion','e.fechaevaluacion','e.idestado','e.observaciones')
            ->where ('v.nombre','like','%'.$query.'%') 
    		//->where ('activo','=',1)
    		->orderBy('e.idtacho','desc')
    		->paginate('3');

            return view('admin.evaluaciones.index',["evaluaciones"=>$evaluaciones,"searchText"=>$query]);
    	}
    }

    public function create()
    {
            $variedades = DB::table('variedades as v')
            ->select('v.idvariedad','v.nombre')
            //->where('v.estado','=','1')
            ->get();

            $tachos = DB::table('tachos as t')
            ->select('t.idtacho','t.codigo','t.subcodigo')
            //->where('t.estado','=','1')
            ->get();

    	return view ("admin.evaluaciones.create",["variedades"=>$variedades,"tachos"=>$tachos]);
    }

    public function store(EvaluacionFormRequest $request)
    {
         //           dd($request);

        if($request->get('portacho')==1){
        	$evaluacion=new Evaluacion;
            $evaluacion->idtacho=$request->get('idtacho');
            $evaluacion->idexportacion=$request->get('idexportacion');
            $evaluacion->idimportacion=$request->get('idimportacion');
            $evaluacion->idvariedad=$request->get('idvariedad');
            $evaluacion->idtipoevaluacion=$request->get('idtipoevaluacion');
            $evaluacion->fechaevaluacion=$request->get('fechaevaluacion');
            $evaluacion->observaciones=$request->get('observaciones');
        	$evaluacion->carbon=$request->get('carbon');
            $evaluacion->escaladura=$request->get('escaladura');
            $evaluacion->estriaroja=$request->get('estriaroja');
            $evaluacion->mosaico=$request->get('mosaico');
            $evaluacion->royamarron=$request->get('royamarron');
            $evaluacion->amarillamiento=$request->get('amarillamiento');
            $evaluacion->altura=$request->get('altura');
            $evaluacion->floracion=$request->get('floracion');
            $evaluacion->grosor=$request->get('grosor');
            $evaluacion->macollaje=$request->get('macollaje');
            //$evaluacion->idestado=$request->get('idestado');
          //  dd($evaluacion);

        	$evaluacion->save();
        	//return Redirect::to('admin/evaluaciones');
            if($evaluacion->idexportacion!=null)
                return Redirect::to('admin/exportaciones/evaluaciones/'.$request->get('idexportacion').'/');
            else
                return Redirect::to('admin/importaciones/evaluaciones/'.$request->get('idimportacion').'/');
        }else{
            $tachos = DB::table('tachos as t')
            ->leftjoin('exportaciones as e','t.idtacho','=','e.idtacho')
            ->leftjoin('importaciones as i','t.idtacho','=','i.idtacho')
            ->select('t.idtacho',DB::raw('CONCAT(codigo,"-",subcodigo) as nombretacho'),'t.idubicacion','expo','impo','idexportacion','idimportacion')
            ->where('t.idubicacion','=',$request->get('idubicacion'))
            ->get();

            $cont=0;
            while($cont<count($tachos)){

                $tacho=Tacho::findOrFail($tachos[$cont]->idtacho);

                $evaluacion=new Evaluacion;
                $evaluacion->idexportacion=$tachos[$cont]->idexportacion;
                $evaluacion->idimportacion=$tachos[$cont]->idimportacion;
                $evaluacion->idtacho=$tacho->idtacho;
                $evaluacion->idvariedad=$tacho->idvariedad;
                $evaluacion->idtipoevaluacion=$request->get('idtipoevaluacion');
                //$evaluacion->producto=$request->get('producto');
                //$evaluacion->dosis=$request->get('dosis');
                $evaluacion->fechaevaluacion=$request->get('fechaevaluacion');
                $evaluacion->observaciones=$request->get('observaciones');
                // $tarea->idestado=$request->get('idestado');
                $evaluacion->save();

                $cont = $cont+1;
            } 
            if($tacho->expo==1)
                return Redirect::to('admin/ubicacionesexpo/evaluaciones/'.$request->get('idubicacion').'/');
            else
                return Redirect::to('admin/ubicacionesimpo/evaluaciones/'.$request->get('idubicacion').'/'); 

        }


    }

    public function show($id)
    {
    	return view("admin.evaluaciones.show",["evaluacion"=>Evaluacion::findOrFail($id)]);
    }

     public function edit(Evaluacion $evaluacion)
    {
            $variedades = DB::table('variedades as v')
            ->select('v.idvariedad','v.nombre')
            //->where('v.estado','=','1')
            ->get();

            $tachos = DB::table('tachos as t')
            ->select('t.idtacho','t.codigo','t.subcodigo')
            //->where('t.estado','=','1')
            ->get();
        return view('admin.evaluaciones.edit',compact('evaluacion'),["variedades"=>$variedades,"tachos"=>$tachos]);
    }

    public function update(EvaluacionFormRequest $request,$id)
    {
        $evaluacion=Evaluacion::findOrFail($id);
        $evaluacion->idtacho=$request->get('idtacho');
        $evaluacion->idvariedad=$request->get('idvariedad');
        $evaluacion->idtipoevaluacion=$request->get('idtipoevaluacion');
        $evaluacion->fechaevaluacion=$request->get('fechaevaluacion');
        $evaluacion->observaciones=$request->get('observaciones');
        $evaluacion->idestado=$request->get('idestado');

        $evaluacion->update();
        return Redirect::to('admin/evaluaciones');
    }

    public function destroy($id)
    {
    	$evaluacion=Evaluacion::findOrFail($id);
    	$evaluacion->idestado='0';//baja
      	$evaluacion->update();
    	return Redirect::to('admin/evaluaciones');
    }


    public function export() 
    {
        return Excel::download(new evaluacionesExport, 'evaluaciones.xlsx');
    }

    /******************* FUNCIONES NUEVAS PARA LAS EVALUACIONES DE CAMPO-SANIDAD Y LABORATORIO *****************/
    public function new_index(Request $request, $tipo, $origen){    
        $ambientes = Ambiente::where('estado', 1)->get();
        $edades = Edad::all();
        $series = Serie::where('estado', 1)->get();

        switch ($origen) {
            case 'pc':
                $evaluaciones = EvaluacionPrimeraClonal::query();
                break;
            case 'sc':
                $evaluaciones = EvaluacionSegundaClonal::query();
                break;
            case 'met':
                $evaluaciones = EvaluacionMET::query();
                break;
        }

        $filtros = array_filter($request->all(), function($valor){
            return $valor != 0 && $valor != null;
        });

        if(array_key_exists('anio', $filtros))
            $evaluaciones->where('anio', $filtros['anio']);

        if(array_key_exists('serie', $filtros))
            $evaluaciones->where('idserie', $filtros['serie']);

        if(array_key_exists('sector', $filtros))
            $evaluaciones->where('idsector', $filtros['sector']);

        if(array_key_exists('subambiente', $filtros))
            $evaluaciones->whereHas('sector', function ($query) use ($filtros) {
                $query->where('idsubambiente', $filtros['subambiente']);
            });

        if(array_key_exists('ambiente', $filtros))
            $evaluaciones->whereHas('sector.subambiente', function ($query) use ($filtros) {
                $query->where('idambiente', $filtros['ambiente']);
            });

        if(array_key_exists('fecha', $filtros))
            $evaluaciones->where('fecha', $filtros['fecha']);

        if(array_key_exists('mes', $filtros))
            $evaluaciones->where('mes', $filtros['mes']);

        if(array_key_exists('edad', $filtros))
            $evaluaciones->where('idedad', $filtros['edad']);

        $evaluaciones = $evaluaciones->where('tipo', $tipo)->get();

        // Obtener la cantidad de clones registrados para cada evaluacion
        if($origen == 'pc')
            if($tipo == 'C')
                $tablaDetalle = 'evaluacionesdetalle_camposanidad_pc';
            else
                $tablaDetalle = 'evaluacionesdetalle_laboratorio_pc';

        if($origen == 'sc')
            if($tipo == 'C')
                $tablaDetalle = 'evaluacionesdetalle_camposanidad_sc';
            else
                $tablaDetalle = 'evaluacionesdetalle_laboratorio_sc';

        if($origen == 'met')
            if($tipo == 'C')
                $tablaDetalle = 'evaluacionesdetalle_camposanidad_met';
            else
                $tablaDetalle = 'evaluacionesdetalle_laboratorio_met';

        $evaluaciones->map(function ($evaluacion) use ($tablaDetalle) {
            $conteo = DB::table($tablaDetalle)
                ->where('idevaluacion', $evaluacion->id)
                ->count();
        
            $evaluacion->cant_clones_evaluados = $conteo;
            return $evaluacion;
        });

        return view('admin.evaluaciones2.index', compact('tipo',  'origen', 'evaluaciones', 'ambientes', 'edades', 'series'));
    }

    public function new_create($tipo, $origen){
        $ambientes = Ambiente::where('estado', 1)->get();
        $edades = Edad::all();
        $series = Serie::where('estado', 1)->orderBy('nombre')->get();

        return view('admin.evaluaciones2.create', compact('ambientes', 'edades', 'series', 'tipo', 'origen'));
    }

    public function new_store(Request $request, $tipo, $origen){
        switch($origen){
            case 'pc':
                $modelo = EvaluacionPrimeraClonal::class;
                break;
            case 'sc':
                $modelo = EvaluacionSegundaClonal::class;
                break;
            case 'met':
                $modelo = EvaluacionMET::class;
                break;
        }

        $rules = [
            'anio' => ['required', new EvaluacionUnica($modelo, $tipo, $request->all())],
            'serie' => 'required',
            'ambiente' => 'required',
            'subambiente' => 'required',
            'sector' => 'required',
            'fecha' => 'required',
            'mes' => 'required',
            'edad' => 'required',
        ];

        $messages = [
            'required' => 'El campo :attribute es obligatorio.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        // Comprobar si la validación falla
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Pase las validaciones
        switch ($origen) {
            case 'pc':
                $evaluacion = new EvaluacionPrimeraClonal();
                break;
            case 'sc':
                $evaluacion = new EvaluacionSegundaClonal();
                break;
            case 'met':
                $evaluacion = new EvaluacionMET();
                break;
        }

        $evaluacion->idserie = $request->serie;
        $evaluacion->idsector = $request->sector;
        $evaluacion->anio = $request->anio;
        $evaluacion->mes = $request->mes;
        $evaluacion->idedad = $request->edad;
        $evaluacion->fecha = $request->fecha;
        $evaluacion->tipo = $tipo;
        $evaluacion->save();

        return redirect()->route('admin.evaluaciones.index', [$tipo, $origen])->with('success', 'Se creó la evaluación exitosamente.');
    }
}