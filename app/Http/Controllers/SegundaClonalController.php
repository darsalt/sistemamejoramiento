<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Ambiente;
use App\Edad;
use App\EvaluacionDetalleCampoSanidadSC;
use App\EvaluacionDetalleLaboratorioSC;
use App\EvaluacionSegundaClonal;
use App\Sector;
use App\Serie;
use App\PrimeraClonalDetalle;
use App\SegundaClonal;
use App\SegundaClonalDetalle;
use App\Variedad;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SegundaClonalController extends Controller
{
    public function index($anio = 0, $idSerie = 0, $idSector = 0){
        if($anio == 0)
            $anio = date('Y');
        
        $series = Serie::where('estado', 1)->get();
        $ambientes = Ambiente::where('estado', 1)->get();
        //$seedlings = SegundaClonal::where('idserie', $idSerie)->where('idsector', $idSector)->paginate(10);

        if($idSector > 0){
            $idSubambiente = Sector::find($idSector)->subambiente->id;
            $idAmbiente = Sector::find($idSector)->subambiente->ambiente->id;
        }
        else{
            $idSubambiente = $idAmbiente = 0;
        }

        $parcelasPC = PrimeraClonalDetalle::whereHas('primera', function($query) use($idSerie){
            $query->where('idserie', $idSerie);
        });
        
        $parcelasPC = $parcelasPC->orderBy('parcela')->get();
        $variedades = Variedad::where('estado', 1)->get();
        $testigos = SegundaClonalDetalle::whereHas('segunda', function($q) use($anio, $idSector){
            $q->where('anio', $anio)->where('idsector', $idSector);
        })->where('testigo', 1)->get();

        return view('admin.segundaclonal.seleccion.index')->with(compact('series', 'ambientes', 'idSerie', 'idSector', 'idSubambiente', 'idAmbiente', 'parcelasPC', 'variedades', 'testigos', 'anio'));
    }

    public function saveSegundaClonal(Request $request){
        try{
            DB::transaction(function () use($request){
                $segunda = SegundaClonal::where('anio', $request->anio)->where('idsector', $request->sector)->first();

                /*if($segunda){
                    $parcelasCargadas = $segunda->parcelas()->where('idsector', $request->sector);

                    foreach($parcelasCargadas->get() as $parcela){
                        // Eliminamos del detalle las parcelas que antes fueron seleccionadas y se deseleccionaron
                        if(!in_array($parcela->idprimeraclonal_detalle, $request->seedlingsPC ?? [])){
                            $parcela->delete();
                        }
                    }

                    //$this->regenerarNrosParcelas($request->serie);
                    //$i = $this->getUltimaParcela($request->serie) + 1;
                    for($i = 0; $i < count($request->seedlingsPC); $i++){
                        // Cargamos las parcelas nuevas que nunca fueron agregadas
                        if(!in_array($request->seedlingsPC[$i], $parcelasCargadas->pluck('idprimeraclonal_detalle')->toArray())){
                            $seedling = new SegundaClonalDetalle();
                            $seedling->idsegundaclonal = $segunda->id;
                            $seedling->idprimeraclonal_detalle = $request->seedlingsPC[$i];
                            $seedling->idsector = $request->sector;
                            $seedling->parcela = $request->parcelas[$i];
                            $seedling->save();
                        }
                        else{
                            //Se actualiza el numero de parcela en el caso que se haya cambiado
                            $seedling = SegundaClonalDetalle::where('idprimeraclonal_detalle', $request->seedlingsPC[$i])->first();
                            $seedling->parcela = $request->parcelas[$i];
                            $seedling->save();
                        }
                    }
                }
                else{
                    if($request->seedlingsPC){
                        $segunda = new SegundaClonal();
                        $segunda->anio = $request->anio;
                        $segunda->idserie = $request->serie;
                        $segunda->fecha = now();
                        $segunda->save();

                        //$this->regenerarNrosParcelas($request->serie);
                        //$i = $this->getUltimaParcela($request->serie) + 1;
                        for($i = 0; $i < count($request->seedlingsPC); $i++){
                            $seedling = new SegundaClonalDetalle();
                            $seedling->idsegundaclonal = $segunda->id;
                            $seedling->idprimeraclonal_detalle = $request->seedlingsPC[$i];
                            $seedling->idsector = $request->sector;
                            $seedling->parcela = $request->parcelas[$i];
                            $seedling->save();  
                        }
                    }
                }*/
                if(!$segunda){
                    $segunda = new SegundaClonal();
                    $segunda->anio = $request->anio;
                    $segunda->idsector = $request->sector;
                    $segunda->fecha = now();
                    $segunda->save();
                }

                $parcelasCargadas = $segunda->parcelas()->where('idserie', $request->serie)->get();
                foreach($parcelasCargadas as $parcela){
                    $parcela->delete();
                }

                for($i = 0; $i < count($request->seedlingsPC); $i++){
                    $parcela = new SegundaClonalDetalle();
                    $parcela->idsegundaclonal = $segunda->id;
                    $parcela->idprimeraclonal_detalle = $request->seedlingsPC[$i];
                    $parcela->idserie = $request->serie;
                    $parcela->parcela = $request->parcelas[$i];
                    $parcela->save();  
                }
            });
            session(['exito' => 'exito']);
            return response()->json(true);
        }
        catch(Exception $e){
            session(['error' => 'error']);
            return response()->json(false);
        }
    }

    public function getSegundaClonal(Request $request){
        $seedling = SegundaClonal::with('sector.subambiente.ambiente')->find($request->id);

        return $seedling;
    }

    public function getSegundaClonales(Request $request){
        $seedlings = SegundaClonalDetalle::whereHas('segunda', function($query) use($request){
            $query->where('idserie', $request->serie);
        })->with(['parcelaPC.primera.variedad', 'variedad'])->get();

        return $seedlings;
    }

    public function editSegundaClonal(Request $request){
        try{
            DB::transaction(function () use($request){
                $segunda = SegundaClonal::find($request->idSeedling);

                $segunda->idserie = $request->serie;
                $segunda->idsector = $request->sector;
                $segunda->save();

                foreach($segunda->parcelas as $parcela){
                    $parcela->delete();
                }

                $i = $this->getUltimaParcela($request->serie) + 1;
                foreach($request->seedlingsPC as $parcela){
                    $seedling = new SegundaClonalDetalle();
                    $seedling->idsegundaclonal = $segunda->id;
                    $seedling->idprimeraclonal_detalle = $parcela;
                    $seedling->parcela = $i;
                    $seedling->save();
                    $i += 1;
                }
            });
            session(['exito' => 'exito']);
            return response()->json(true);
        }
        catch(Exception $e){
            session(['error' => 'error']);
            return response()->json(false);
        }
    }
    
    public function delete(Request $request, $id = 0){
        try{
            $seedling = SegundaClonal::find($id);

            foreach($seedling->parcelas as $parcela){
                $parcela->delete();
            }
    
            $seedling->delete();

            return redirect()->back()->with('exito', 'exito');
        }
        catch(Exception $e){
            return redirect()->back()->with('error', 'error');
        }
    }

    private function getUltimaParcela($anio, $idSector){
        $ultimoSeedling = SegundaClonalDetalle::whereHas('segunda', function($q) use($anio, $idSector){
            $q->where('anio', $anio)->where('idsector', $idSector);
        })->orderByDesc('parcela')->first();

        return $ultimoSeedling ? $ultimoSeedling->parcela : 0;
    }

    public function getUltimaParcelaAjax(Request $request){
        return $this->getUltimaParcela($request->anio, $request->sector);
    }

    private function regenerarNrosParcelas($idSerie){
        $seedlings = SegundaClonalDetalle::whereHas('segunda', function($q) use($idSerie){
            $q->where('idserie', $idSerie);
        })->orderBy('parcela')->get();

        $i = 1;
        foreach($seedlings as $seedling){
            $seedling->parcela = $i;
            $seedling->save();
            $i++;
        }
    }

    public function saveTestigo(Request $request){
        try{
            $segunda_detalle = DB::transaction(function () use($request){
                $segunda = SegundaClonal::where('anio', $request->anio)->where('idsector', $request->sector)->first();

                $segunda_detalle = new SegundaClonalDetalle();
                $segunda_detalle->segunda()->associate($segunda);
                //$segunda_detalle->idserie = $request->serie;
                $segunda_detalle->parcela = $request->parcelaTestigo;
                $segunda_detalle->testigo = 1;
                $segunda_detalle->idvariedad = $request->variedad;
                $segunda_detalle->save();

                return $segunda_detalle;
            });

            return SegundaClonalDetalle::with('variedad')->find($segunda_detalle->id);
        }
        catch(Exception $e){
            session(['error' => 'error']);
            return response()->json(false);
        }
    }

    public function deleteTestigo($idTestigo = 0){
        SegundaClonalDetalle::find($idTestigo)->delete();

        return redirect()->back()->with('exito', 'exito');
    }

    function evCampoSanidad($anio = 0, $idSerie = 0, $idSector = 0, $mes = 0, $edad2 = 0){
        if($anio == 0)
            $anio = date('Y');
        
        $ambientes = Ambiente::where('estado', 1)->get();
        $edades = Edad::all();
        $series = Serie::where('estado', 1)->get();
        $sector = Sector::find($idSector);
        $origen = 'sc';

        if($sector){
            $idSubambiente = $sector->subambiente->id;
            $idAmbiente = $sector->subambiente->ambiente->id;
        }
        else{
            $idSubambiente = $idAmbiente = 0;    
        }

        $seedlings = SegundaClonalDetalle::whereHas('segunda', function($q) use($anio, $idSerie, $idSector){
            $q->where('idsector', $idSector)->where('anio', $anio);
        })->whereHas('parcelaPC', function($q){
            $q->where('laboratorio', 0);
        })->where('idserie', $idSerie)->get();

        $evaluacion = EvaluacionSegundaClonal::where('anio', $anio)->where('idserie', $idSerie)->where('idsector', $idSector)
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
                $evaluacion = EvaluacionSegundaClonal::where('anio', $request->anio)->where('idserie', $request->serie)->where('idsector', $request->sector)
                ->where('mes', $request->mes)->where('idedad', $request->edad)->where('tipo', 'C')->first();

                if(!$evaluacion){
                    $evaluacion = new EvaluacionSegundaClonal();
                    $evaluacion->idserie = $request->serie;
                    $evaluacion->idsector = $request->sector;
                    $evaluacion->anio = $request->anio;
                    $evaluacion->mes = $request->mes;
                    $evaluacion->idedad = $request->edad;
                    $evaluacion->tipo = 'C';
                    $evaluacion->fecha = $request->fecha;
                    $evaluacion->save();
                }

                $evaluacionDetalle = EvaluacionDetalleCampoSanidadSC::where('idevaluacion', $evaluacion->id)->where('idseedling', $request->idSeedling)->first();
                if(!$evaluacionDetalle){
                    $evaluacionDetalle = new EvaluacionDetalleCampoSanidadSC();
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
        $origen = 'sc';

        if($sector){
            $idSubambiente = $sector->subambiente->id;
            $idAmbiente = $sector->subambiente->ambiente->id;
        }
        else{
            $idSubambiente = $idAmbiente = 0;    
        }

        $seedlings = SegundaClonalDetalle::whereHas('segunda', function($q) use($anio, $idSerie, $idSector){
            $q->where('idsector', $idSector)->where('anio', $anio);
        })->whereHas('parcelaPC', function($q){
            $q->where('laboratorio', 1);
        })->where('idserie', $idSerie)->get();

        $evaluacion = EvaluacionSegundaClonal::where('anio', $anio)->where('idserie', $idSerie)->where('idsector', $idSector)
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
                $evaluacion = EvaluacionSegundaClonal::where('anio', $request->anio)->where('idserie', $request->serie)->where('idsector', $request->sector)
                ->where('mes', $request->mes)->where('idedad', $request->edad)->where('tipo', 'L')->first();

                if(!$evaluacion){
                    $evaluacion = new EvaluacionSegundaClonal();
                    $evaluacion->idserie = $request->serie;
                    $evaluacion->idsector = $request->sector;
                    $evaluacion->anio = $request->anio;
                    $evaluacion->mes = $request->mes;
                    $evaluacion->idedad = $request->edad;
                    $evaluacion->tipo = 'L';
                    $evaluacion->fecha = $request->fecha;
                    $evaluacion->save();
                }

                $evaluacionDetalle = EvaluacionDetalleLaboratorioSC::where('idevaluacion', $evaluacion->id)->where('idseedling', $request->idSeedling)->first();
                if(!$evaluacionDetalle){
                    $evaluacionDetalle = new EvaluacionDetalleLaboratorioSC();
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
        $inventario = DB::select("SELECT sc.anio, scd.idserie, s.nombre as nombre_serie, sc.idsector, sec.nombre AS nombre_sector, sa.nombre AS nombre_subambiente, a.nombre AS nombre_ambiente, COUNT(*) as cant_seedlings FROM segundasclonal_detalle as scd INNER JOIN segundasclonal as sc ON scd.idsegundaclonal = sc.id INNER JOIN series AS s ON s.id = scd.idserie INNER JOIN sectores AS sec ON sec.id = sc.idsector INNER JOIN subambientes AS sa ON sa.id = sec.idsubambiente INNER JOIN ambientes AS a ON a.id = sa.idambiente GROUP BY sc.anio, nombre_serie, sc.idsector, scd.idserie, nombre_sector, nombre_subambiente, nombre_ambiente");
        $origen = 'sc';
        
        foreach($inventario as $linea){
            $cantidadPorEdadYMesCS = DB::select("select esc.mes, COUNT(case e.nombre when 'Planta' then 1 else null end) as planta, COUNT(case e.nombre when 'Soca 1' then 1 else null end) as soca1, COUNT(case e.nombre when 'Soca 2' then 1 else null end) as soca2 from evaluacionesdetalle_camposanidad_sc edcssc inner join evaluaciones_segundaclonal as esc on edcssc.idevaluacion = esc.id inner join edades as e on esc.idedad = e.id where esc.anio = ? and esc.idserie = ? and esc.idsector = ? group by esc.mes ", [$linea->anio, $linea->idserie, $linea->idsector]);
            $cantidadPorEdadYMesLab = DB::select("select esc.mes, COUNT(case e.nombre when 'Planta' then 1 else null end) as planta, COUNT(case e.nombre when 'Soca 1' then 1 else null end) as soca1, COUNT(case e.nombre when 'Soca 2' then 1 else null end) as soca2 from evaluacionesdetalle_laboratorio_sc edlabsc inner join evaluaciones_segundaclonal as esc on edlabsc.idevaluacion = esc.id inner join edades as e on esc.idedad = e.id where esc.anio = ? and esc.idserie = ? and esc.idsector = ? group by esc.mes ", [$linea->anio, $linea->idserie, $linea->idsector]);
            $linea->evaluacionesCS = $cantidadPorEdadYMesCS;
            $linea->evaluacionesLab = $cantidadPorEdadYMesLab;
            array_push($inventarioFinal, $linea);
        }

        return view('admin.primera.inventario2.index', compact('inventarioFinal', 'origen'));
    }
}
