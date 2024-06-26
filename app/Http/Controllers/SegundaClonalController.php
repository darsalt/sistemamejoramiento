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
    public function index($idSerie = 0, $idSector = 0){        
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

        $parcelasPC = DB::table('primerasclonal_detalle as pcd')
                        ->join('primerasclonal as p', 'pcd.idprimeraclonal', '=', 'p.id')
                        ->leftJoin('segundasclonal_detalle as scd', 'scd.idprimeraclonal_detalle', '=', 'pcd.id')
                        ->where('p.idserie', $idSerie)
                        ->where('p.idsector', $idSector)
                        ->select('pcd.id', 'scd.parcela')
                        ->orderBy('scd.parcela')
                        ->distinct('pcd.id')
                        ->get();

        $variedades = Variedad::where('estado', 1)->get();
        $testigos = SegundaClonalDetalle::whereHas('segunda', function($q) use($idSerie, $idSector){
            $q->where('idserie', $idSerie)->where('idsector', $idSector);
        })->where('testigo', 1)->get();

        return view('admin.segundaclonal.seleccion.index')->with(compact('series', 'ambientes', 'idSerie', 'idSector', 'idSubambiente', 'idAmbiente', 'parcelasPC', 'variedades', 'testigos'));
    }

    public function saveSegundaClonal(Request $request){
        try{
            DB::transaction(function () use($request){
                $segunda = SegundaClonal::where('idserie', $request->serie)->where('idsector', $request->sector)->first();

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
                    $segunda->idserie = $request->serie;
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
                    $parcela->bloque = $request->bloques[$i];
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

                $i = $this->getUltimaParcela($request->serie, $request->sector) + 1;
                foreach($request->seedlingsPC as $parcela){
                    $seedling = new SegundaClonalDetalle();
                    $seedling->idsegundaclonal = $segunda->id;
                    $parcela->idserie = $request->serie;
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

    private function getUltimaParcela($idSerie, $idSector){
        $ultimoSeedling = SegundaClonalDetalle::whereHas('segunda', function($q) use($idSerie, $idSector){
            $q->where('idserie', $idSerie)->where('idsector', $idSector);
        })->orderByDesc('parcela')->first();

        return $ultimoSeedling ? $ultimoSeedling->parcela : 0;
    }

    public function getUltimaParcelaAjax(Request $request){
        return $this->getUltimaParcela($request->serie, $request->sector);
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
                $segunda = SegundaClonal::where('idserie', $request->serie)->where('idsector', $request->sector)->first();

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

    function viewEvCampoSanidad(Request $request, EvaluacionSegundaClonal $evaluacion){
        $origen = 'sc';
        $cantRegistros = $request->input('cant_registros', 30);

        $seedlings = SegundaClonalDetalle::whereHas('segunda', function($q) use($evaluacion){
            $q->where('idsector', $evaluacion->sector->id)->where('idserie', $evaluacion->serie->id);
        })->where('idserie', $evaluacion->serie->id)->paginate($cantRegistros);

        $user = auth()->user();

        foreach($seedlings as $seedling){
            $seedling->tallos = $seedling->getEvaluacionCampoSanidadAttribute($evaluacion, 'tallos');
            $seedling->altura = $seedling->getEvaluacionCampoSanidadAttribute($evaluacion, 'altura');
            $seedling->grosor = $seedling->getEvaluacionCampoSanidadAttribute($evaluacion, 'grosor');
            $seedling->vuelco = $seedling->getEvaluacionCampoSanidadAttribute($evaluacion, 'vuelco');
            $seedling->flor = $seedling->getEvaluacionCampoSanidadAttribute($evaluacion, 'flor');
            $seedling->brix = $seedling->getEvaluacionCampoSanidadAttribute($evaluacion, 'brix', 1);
            $seedling->escaldad = $seedling->getEvaluacionCampoSanidadAttribute($evaluacion, 'escaldad');
            $seedling->carbon = $seedling->getEvaluacionCampoSanidadAttribute($evaluacion, 'carbon');
            $seedling->roya = $seedling->getEvaluacionCampoSanidadAttribute($evaluacion, 'roya');
            $seedling->mosaico = $seedling->getEvaluacionCampoSanidadAttribute($evaluacion, 'mosaico');
            $seedling->estaria = $seedling->getEvaluacionCampoSanidadAttribute($evaluacion, 'estaria');
            $seedling->amarilla = $seedling->getEvaluacionCampoSanidadAttribute($evaluacion, 'amarilla');
            $seedling->readonly = $seedling->isReadonly($evaluacion, $user);
        }

        return view('admin.primera.evaluaciones.campo_sanidad', compact('evaluacion', 'cantRegistros', 'seedlings', 'origen'));
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
                
                $campos = [
                    'tallos' => $request->tallos,
                    'altura' => $request->altura,
                    'grosor' => $request->grosor,
                    'vuelco' => $request->vuelco,
                    'flor' => $request->flor,
                    'brix' => $request->brix,
                    'escaldad' => $request->escaldad,
                    'carbon' => $request->carbon,
                    'roya' => $request->roya,
                    'mosaico' => $request->mosaico,
                    'estaria' => $request->estaria,
                    'amarilla' => $request->amarilla,
                ];
                
                foreach ($campos as $campo => $valor) {
                    if ($valor !== 'NaN') {
                        $evaluacionDetalle->$campo = $valor;
                    }
                }
                
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

    function viewEvLaboratorio(Request $request, EvaluacionSegundaClonal $evaluacion){
        $origen = 'sc';
        $cantRegistros = $request->input('cant_registros', 30);

        $seedlings = SegundaClonalDetalle::whereHas('segunda', function($q) use($evaluacion){
            $q->where('idsector', $evaluacion->sector->id)->where('idserie', $evaluacion->serie->id);
        })->where('idserie', $evaluacion->serie->id)->paginate($cantRegistros);

        $user = auth()->user();

        foreach($seedlings as $seedling){
            $seedling->peso_muestra = $seedling->getEvaluacionLaboratorioAttribute($evaluacion, 'peso_muestra');
            $seedling->peso_jugo = $seedling->getEvaluacionLaboratorioAttribute($evaluacion, 'peso_jugo');
            $seedling->brix = $seedling->getEvaluacionLaboratorioAttribute($evaluacion, 'brix', 1);
            $seedling->polarizacion = $seedling->getEvaluacionLaboratorioAttribute($evaluacion, 'polarizacion');
            $seedling->temperatura = $seedling->getEvaluacionLaboratorioAttribute($evaluacion, 'temperatura', 1);
            $seedling->fibra = $seedling->getEvaluacionLaboratorioAttribute($evaluacion, 'fibra', 1);
            $seedling->brix_corregido = $seedling->getEvaluacionLaboratorioAttribute($evaluacion, 'brix_corregido', 2);
            $seedling->pol_jugo = $seedling->getEvaluacionLaboratorioAttribute($evaluacion, 'pol_jugo', 2);
            $seedling->pureza = $seedling->getEvaluacionLaboratorioAttribute($evaluacion, 'pureza', 2);
            $seedling->rend_prob = $seedling->getEvaluacionLaboratorioAttribute($evaluacion, 'rend_prob', 2);
            $seedling->pol_cania = $seedling->getEvaluacionLaboratorioAttribute($evaluacion, 'pol_cania', 2);
            $seedling->readonly = $seedling->isReadonly($evaluacion, $user);
        }

        return view('admin.primera.evaluaciones.laboratorio', compact('evaluacion', 'cantRegistros', 'seedlings', 'origen'));
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
                
                $campos = [
                    'peso_muestra' => $request->pesomuestra,
                    'peso_jugo' => $request->pesojugo,
                    'brix' => $request->brix,
                    'polarizacion' => $request->polarizacion,
                    'temperatura' => $request->temperatura,
                    'fibra' => $request->fibra
                ];
                
                foreach ($campos as $campo => $valor) {
                    if ($valor !== 'NaN') {
                        $evaluacionDetalle->$campo = $valor;
                    }
                }
                
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
        $inventario = DB::select("SELECT s.anio, scd.idserie, s.nombre as nombre_serie, sc.idsector, sec.nombre AS nombre_sector, sa.nombre AS nombre_subambiente, a.nombre AS nombre_ambiente, COUNT(*) as cant_seedlings FROM segundasclonal_detalle as scd INNER JOIN segundasclonal as sc ON scd.idsegundaclonal = sc.id INNER JOIN series AS s ON s.id = scd.idserie INNER JOIN sectores AS sec ON sec.id = sc.idsector INNER JOIN subambientes AS sa ON sa.id = sec.idsubambiente INNER JOIN ambientes AS a ON a.id = sa.idambiente GROUP BY s.anio, nombre_serie, sc.idsector, scd.idserie, nombre_sector, nombre_subambiente, nombre_ambiente");
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
