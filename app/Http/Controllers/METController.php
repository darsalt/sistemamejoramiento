<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Serie;
use App\Ambiente;
use App\Edad;
use App\EvaluacionDetalleCampoSanidadMET;
use App\EvaluacionDetalleLaboratorioMET;
use App\EvaluacionMET;
use App\MET;
use App\METDetalle;
use App\Sector;
use App\SegundaClonalDetalle;
use App\Variedad;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class METController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index($idSerie = 0, $idSector = 0){        
        $series = Serie::where('estado', 1)->get();
        $ambientes = Ambiente::where('estado', 1)->get();

        if($idSector > 0){
            $idSubambiente = Sector::find($idSector)->subambiente->id;
            $idAmbiente = Sector::find($idSector)->subambiente->ambiente->id;
        }
        else{
            $idSubambiente = $idAmbiente = 0;
        }

        /*$parcelasSC = SegundaClonalDetalle::whereHas('segunda', function($query) use($idSerie){
            $query->where('idserie', $idSerie);
        })->orderBy('parcela')->get();*/
        $variedades = Variedad::where('estado', 1)->get();

        $met = MET::where('idserie', $idSerie)->where('idsector', $idSector)->first();

        $parcelasCargadas = METDetalle::whereHas('met', function($query) use($idSerie, $idSector){
            $query->where('idserie', $idSerie)->where('idsector', $idSector);
        })->orderBy('parcela')->get();

        return view('admin.met.seleccion.index2')->with(compact('series', 'ambientes', 'idSector', 'idSerie', 'idSubambiente', 'idAmbiente', 'parcelasCargadas', 'variedades', 'met'));
    }

    public function saveMET(Request $request){
        try{
            DB::transaction(function () use($request){
                /*$met = MET::where('anio', $request->anio)->first();

                if($met){
                    $parcelasCargadas = $met->parcelas()->where('idsector', $request->sector);

                    foreach($parcelasCargadas->get() as $parcela){
                        // Eliminamos del detalle las parcelas que antes fueron seleccionadas y se deseleccionaron
                        if(!in_array($parcela->idsegundaclonal_detalle, $request->seedlingsSC ?? [])){
                            $parcela->delete();
                        }
                    }

                    $this->regenerarNrosParcelas($request->anio);
                    $i = $this->getUltimaParcela($request->anio) + 1;
                    foreach($request->seedlingsSC ?? [] as $nroParcela){
                        // Cargamos las parcelas nuevas que nunca fueron agregadas
                        if(!in_array($nroParcela, $parcelasCargadas->pluck('idsegundaclonal_detalle')->toArray())){
                            $seedling = new METDetalle();
                            $seedling->idmet = $met->id;
                            $seedling->idsegundaclonal_detalle = $nroParcela;
                            $seedling->idsector = $request->sector;
                            $seedling->parcela = $i;
                            $seedling->save();
                            $i += 1;
                        }
                    }
                }
                else{
                    if($request->seedlingsSC){
                        $met = new MET();
                        $met->anio = $request->anio;
                        $met->save();

                        $this->regenerarNrosParcelas($request->anio);
                        $i = $this->getUltimaParcela($request->anio) + 1;
                        foreach($request->seedlingsSC as $parcela){
                            $seedling = new METDetalle();
                            $seedling->idmet = $met->id;
                            $seedling->idsegundaclonal_detalle = $parcela;
                            $seedling->idsector = $request->sector;
                            $seedling->parcela = $i;
                            $seedling->save();
                            $i += 1;
                        }
                    }
                }*/
                $met = new MET();
                $met->idserie = $request->serie;
                $met->idsector = $request->sector;
                $met->cant_variedades = $request->cantVariedades;
                $met->repeticiones = $request->repeticiones;
                $met->bloques = $request->cantBloques;
                $met->save();
            });
            
            session(['exito' => 'exito']);
            return response()->json(true);  
        }
        catch(Exception $e){
            session(['error' => 'error']);
            return response()->json(false);
        }
    }

    /*private function getUltimaParcela($anio){
        $ultimoSeedling = METDetalle::whereHas('met', function($q) use($anio){
            $q->where('anio', $anio);
        })->orderByDesc('parcela')->first();

        return $ultimoSeedling ? $ultimoSeedling->parcela : 0;
    }*/

    private function regenerarNrosParcelas($anio){
        $seedlings = METDetalle::whereHas('met', function($q) use($anio){
            $q->where('anio', $anio);
        })->orderBy('parcela')->get();

        $i = 1;
        foreach($seedlings as $seedling){
            $seedling->parcela = $i;
            $seedling->save();
            $i++;
        }
    }

    public function getMETAsociado(Request $request){
        $met = MET::where('idserie', $request->serie)->where('idsector', $request->sector)->first() ?? null;

        return response()->json($met);
    }

    public function getUltimaParcela(Request $request){
        $met = MET::where('idserie', $request->serie)->where('idsector', $request->sector)->first();
        
        if(count($met->parcelas) > 0){
            $ultimo_met_detalle = $met->parcelas()->orderByDesc('parcela')->first();
            return $ultimo_met_detalle->parcela;
        }
        else
            return 0;
    }

    public function saveDetalleMET(Request $request){
        try{
            return DB::transaction(function () use($request){
                $met = MET::where('idserie', $request->serie)->where('idsector', $request->sector)->first();

                if($met){
                    $met_detalle = new METDetalle();

                    $met_detalle->idmet = $met->id;
                    if($request->origenSeedling == 'sc')
                        $met_detalle->idsegundaclonal_detalle = $request->seedlingsSC;
                    else{
                        if($request->origenSeedling == 'testigo')
                            $met_detalle->idvariedad = $request->variedad;
                        else
                            $met_detalle->observaciones = $request->observaciones;
                    }
                    $met_detalle->parcela = $request->nroParcela;
                    $met_detalle->bloque = $request->nroBloque;
                    $met_detalle->repeticion = $request->nro_repeticion;
                    $met_detalle->save();

                    return METDetalle::with(['parcelaSC.parcelaPC', 'variedad', 'parcelaSC.variedad', 'parcelaSC.segunda.serie'])->find($met_detalle->id);
                }
                else
                    throw new Exception("No se encontro el MET correspondiente");
                    return null;
            });
        }
        catch(Exception $e){
            return response()->json(false);
        } 
    } 

    function evCampoSanidad($anio = 0, $idSerie = 0, $idSector = 0, $mes = 0, $edad2 = 0){
        if($anio == 0)
            $anio = date('Y');
        
        $ambientes = Ambiente::where('estado', 1)->get();
        $edades = Edad::all();
        $series = Serie::where('estado', 1)->get();
        $sector = Sector::find($idSector);
        $origen = 'met';

        if($sector){
            $idSubambiente = $sector->subambiente->id;
            $idAmbiente = $sector->subambiente->ambiente->id;
        }
        else{
            $idSubambiente = $idAmbiente = 0;    
        }

        $seedlings = METDetalle::whereHas('met', function($q) use($idSerie, $idSector){
            $q->where('idserie', $idSerie)->where('idsector', $idSector);
        })->get();

        $evaluacion = EvaluacionMET::where('anio', $anio)->where('idserie', $idSerie)->where('idsector', $idSector)
        ->where('mes', $mes)->where('idedad', $edad2)->where('tipo', 'C')->first();
        if($evaluacion){
            $fecha_calendario = $evaluacion->fecha;
            $idEvaluacion = $evaluacion->id;
        }
        else{
            $fecha_calendario = now();
            $idEvaluacion = 0;
        }

        return view('admin.primera.evaluaciones.campo_sanidad', compact('ambientes', 'edades', 'series', 'anio', 'idSerie', 'idSector', 'idSubambiente', 
                                                                        'idAmbiente', 'mes', 'edad2', 'seedlings', 'fecha_calendario', 'idEvaluacion', 'origen'));
    }

    function saveEvCampoSanidad(Request $request){
        try{
            DB::transaction(function () use($request){
                $evaluacion = EvaluacionMET::where('anio', $request->anio)->where('idserie', $request->serie)->where('idsector', $request->sector)
                ->where('mes', $request->mes)->where('idedad', $request->edad)->where('tipo', 'C')->first();

                if(!$evaluacion){
                    $evaluacion = new EvaluacionMET();
                    $evaluacion->idserie = $request->serie;
                    $evaluacion->idsector = $request->sector;
                    $evaluacion->anio = $request->anio;
                    $evaluacion->mes = $request->mes;
                    $evaluacion->idedad = $request->edad;
                    $evaluacion->tipo = 'C';
                    $evaluacion->fecha = $request->fecha;
                    $evaluacion->save();
                }

                $evaluacionDetalle = EvaluacionDetalleCampoSanidadMET::where('idevaluacion', $evaluacion->id)->where('idseedling', $request->idSeedling)->first();
                if(!$evaluacionDetalle){
                    $evaluacionDetalle = new EvaluacionDetalleCampoSanidadMET();
                    $evaluacionDetalle->idevaluacion = $evaluacion->id;
                    $evaluacionDetalle->idseedling = $request->idSeedling;
                }
                $evaluacionDetalle->tipo = $request->tipo;
                $evaluacionDetalle->tallos = $request->tallos;
                $evaluacionDetalle->altura = $request->altura;
                $evaluacionDetalle->grosor = $request->grosor;
                $evaluacionDetalle->vuelco = $request->vuelco;
                $evaluacionDetalle->flor = $request->flor;
                $evaluacionDetalle->brix = $request->brix;
                $evaluacionDetalle->escaldad = $request->escaldad;
                $evaluacionDetalle->carbon = $request->carbon;
                $evaluacionDetalle->roya = $request->roya;
                $evaluacionDetalle->mosaico = $request->mosaico;
                $evaluacionDetalle->estaria = $request->estaria;
                $evaluacionDetalle->amarilla = $request->amarilla;
                $evaluacionDetalle->save();
            });

            session(['exito' => 'exito']);
            return response()->json(true);
        }
        catch(Exception $e){
            session(['error' => 'error']);
            return response()->json(false);
        }
    }

    function evLaboratorio($anio = 0, $idSerie = 0, $idSector = 0, $mes = 0, $edad2 = 0){
        if($anio == 0)
            $anio = date('Y');
        
        $ambientes = Ambiente::where('estado', 1)->get();
        $edades = Edad::all();
        $series = Serie::where('estado', 1)->get();
        $sector = Sector::find($idSector);
        $origen = 'met';

        if($sector){
            $idSubambiente = $sector->subambiente->id;
            $idAmbiente = $sector->subambiente->ambiente->id;
        }
        else{
            $idSubambiente = $idAmbiente = 0;    
        }

        $seedlings = METDetalle::whereHas('met', function($q) use($idSerie, $idSector){
            $q->where('idserie', $idSerie)->where('idsector', $idSector);
        })->whereHas('parcelaSC', function($q){
            $q->whereHas('parcelaPC', function($q2){
                $q2->where('laboratorio', 1);
            });
        })->get();

        $evaluacion = EvaluacionMET::where('anio', $anio)->where('idserie', $idSerie)->where('idsector', $idSector)
        ->where('mes', $mes)->where('idedad', $edad2)->where('tipo', 'L')->first();
        if($evaluacion){
            $fecha_calendario = $evaluacion->fecha;
            $idEvaluacion = $evaluacion->id;
        }
        else{
            $fecha_calendario = now();
            $idEvaluacion = 0;
        }

        return view('admin.primera.evaluaciones.laboratorio', compact('ambientes', 'edades', 'series', 'anio', 'idSerie', 'idSector', 'idSubambiente', 
                                                                        'idAmbiente', 'mes', 'edad2', 'seedlings', 'fecha_calendario', 'idEvaluacion', 'origen'));
    }

    function saveEvLaboratorio(Request $request){
        try{
            return DB::transaction(function () use($request){
                $evaluacion = EvaluacionMET::where('anio', $request->anio)->where('idserie', $request->serie)->where('idsector', $request->sector)
                ->where('mes', $request->mes)->where('idedad', $request->edad)->where('tipo', 'L')->first();

                if(!$evaluacion){
                    $evaluacion = new EvaluacionMET();
                    $evaluacion->idserie = $request->serie;
                    $evaluacion->idsector = $request->sector;
                    $evaluacion->anio = $request->anio;
                    $evaluacion->mes = $request->mes;
                    $evaluacion->idedad = $request->edad;
                    $evaluacion->tipo = 'L';
                    $evaluacion->fecha = $request->fecha;
                    $evaluacion->save();
                }

                $evaluacionDetalle = EvaluacionDetalleLaboratorioMET::where('idevaluacion', $evaluacion->id)->where('idseedling', $request->idSeedling)->first();
                if(!$evaluacionDetalle){
                    $evaluacionDetalle = new EvaluacionDetalleLaboratorioMET();
                    $evaluacionDetalle->idevaluacion = $evaluacion->id;
                    $evaluacionDetalle->idseedling = $request->idSeedling;
                }
                $evaluacionDetalle->peso_muestra = $request->pesomuestra;
                $evaluacionDetalle->peso_jugo = $request->pesojugo;
                $evaluacionDetalle->brix = $request->brix;
                $evaluacionDetalle->polarizacion = $request->polarizacion;
                $evaluacionDetalle->temperatura = $request->temperatura;
                $evaluacionDetalle->conductividad = $request->conductividad;
                
                if($request->temperatura < 20)
                    $brix_corregido = +$request->brix-(((20-$request->polarizacion)*((0.00082*$request->temperatura)+0.042))-(((20-$request->temperatura)/50)*(20-$request->temperatura)/50));
                else
                    $brix_corregido = ((($request->temperatura-20)*0.06))+((($request->temperatura-20)*($request->temperatura-20)*($request->brix/15)*0.000615)+$request->brix);
                
                $evaluacionDetalle->brix_corregido = $brix_corregido;
                $pol_jugo = ($request->polarizacion*0.26)/((((1.00037)+(0.0038*$request->brix))+(((0.00001625*($request->brix*$request->brix)))))*0.99823);
                $evaluacionDetalle->pol_jugo = $pol_jugo;
                $evaluacionDetalle->pureza = $pol_jugo/$brix_corregido*100;
                $evaluacionDetalle->rend_prob = +$pol_jugo*((1.4-(40/($pol_jugo/$brix_corregido*100)))*0.65);
                $evaluacionDetalle->pol_cania = $pol_jugo*0.82;
                $evaluacionDetalle->save();

                return $evaluacionDetalle;
            });
        }
        catch(Exception $e){
            session(['error' => 'error']);
            return response()->json(false);
        }
    }

    public function inventario(){
        $inventarioFinal = [];
        $inventario = DB::select("SELECT s.id as idserie, s.nombre as nombre_serie, met.anio as anio, met.idsector, sec.nombre AS nombre_sector, sa.nombre AS nombre_subambiente, a.nombre AS nombre_ambiente, COUNT(*) as cant_seedlings FROM met_detalle as metd INNER JOIN met as met ON metd.idmet = met.id INNER JOIN sectores AS sec ON sec.id = met.idsector INNER JOIN series AS s ON met.idserie = s.id INNER JOIN subambientes AS sa ON sa.id = sec.idsubambiente INNER JOIN ambientes AS a ON a.id = sa.idambiente GROUP BY s.id, s.nombre, met.anio, met.idsector, nombre_sector, nombre_subambiente, nombre_ambiente");
        $origen = 'met';
        
        foreach($inventario as $linea){
            $cantidadPorEdadYMesCS = DB::select("select emet.mes, COUNT(case e.nombre when 'Planta' then 1 else null end) as planta, COUNT(case e.nombre when 'Soca 1' then 1 else null end) as soca1, COUNT(case e.nombre when 'Soca 2' then 1 else null end) as soca2 from evaluacionesdetalle_camposanidad_met edcsmet inner join evaluaciones_met as emet on edcsmet.idevaluacion = emet.id inner join edades as e on emet.idedad = e.id where emet.anio = ? and emet.idsector = ? group by emet.mes ", [$linea->anio, $linea->idsector]);
            $cantidadPorEdadYMesLab = DB::select("select emet.mes, COUNT(case e.nombre when 'Planta' then 1 else null end) as planta, COUNT(case e.nombre when 'Soca 1' then 1 else null end) as soca1, COUNT(case e.nombre when 'Soca 2' then 1 else null end) as soca2 from evaluacionesdetalle_laboratorio_met edlabmet inner join evaluaciones_met as emet on edlabmet.idevaluacion = emet.id inner join edades as e on emet.idedad = e.id where emet.anio = ? and emet.idsector = ? group by emet.mes ", [$linea->anio, $linea->idsector]);
            $linea->evaluacionesCS = $cantidadPorEdadYMesCS;
            $linea->evaluacionesLab = $cantidadPorEdadYMesLab;
            array_push($inventarioFinal, $linea);
        }

        return view('admin.primera.inventario2.index', compact('inventarioFinal', 'origen'));
    }
}
