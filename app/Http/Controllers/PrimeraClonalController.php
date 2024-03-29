<?php

namespace App\Http\Controllers;

use App\Ambiente;
use App\CampaniaSeedling;
use App\Edad;
use App\EvaluacionDetalleCampoSanidadPC;
use App\EvaluacionDetalleLaboratorioPC;
use App\EvaluacionPrimeraClonal;
use App\Http\Controllers\Controller;
use App\PrimeraClonal;
use App\PrimeraClonalDetalle;
use App\Sector;
use App\Seedling;
use App\Serie;
use App\Variedad;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PrimeraClonalController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index($idSerie = 0, $idSector = 0){
        $series = Serie::where('estado', 1)->get();
        $ambientes = Ambiente::where('estado', 1)->get();
        $seedlings = PrimeraClonal::where('idserie', $idSerie)->where('idsector', $idSector)
        ->orderBy('parcelaDesde')->paginate(10);
        $parcelas = PrimeraClonalDetalle::whereHas('primera', function($q) use($idSerie, $idSector){
            $q->where('idserie', $idSerie)->where('idsector', $idSector);
        })->orderBy('parcela')->get();
        $campSeedling = CampaniaSeedling::where('estado', 1)->get();
        $variedades = Variedad::where('estado', 1)->get();

        if($idSector > 0){
            $idSubambiente = Sector::find($idSector)->subambiente->id;
            $idAmbiente = Sector::find($idSector)->subambiente->ambiente->id;
        }
        else{
            $idSubambiente = $idAmbiente = 0;
        }

        return view('admin.primera.seleccion.index')->with(compact('series', 'seedlings', 'ambientes', 'campSeedling', 'idSerie', 'idSector', 'idSubambiente', 'idAmbiente', 'variedades', 'parcelas'));
    }

    public function getUltimaParcela($serie, $sector){
        $ultimoSeedling = PrimeraClonalDetalle::whereHas('primera', function($q) use($serie, $sector){
            $q->where('idserie', $serie)->where('idsector', $sector);
        })->orderByDesc('parcela')->first();

        return $ultimoSeedling ? (int)$ultimoSeedling->parcela : 0;
    }

    // Obtener el numero de la ultima parcela cargada
    public function getUltimaParcelaAjax(Request $request){
        return response()->json($this->getUltimaParcela($request->serie, $request->sector));
    }

    private static function insertarDetalle($primeraClonal){
        for($i = $primeraClonal->parceladesde; $i<$primeraClonal->parceladesde + $primeraClonal->cantidad; $i++){
            $planta = new PrimeraClonalDetalle();
            $planta->primera()->associate($primeraClonal);
            $planta->parcela = $i;
            $planta->nombre_clon = 'NA ' . substr(trim($primeraClonal->serie->nombre), strlen(trim($primeraClonal->serie->nombre))-2, 2) . ' ' . strval($i);
            $planta->laboratorio = 0;
            $planta->save();
        }
    }

    public function savePrimeraClonal(Request $request){
        try{
            $primeraClonal = new PrimeraClonal();
            
            $primeraClonal->idserie = $request->serie;
            $primeraClonal->idsector = $request->sector;
            $seedling = Seedling::find($request->parcela);
            $primeraClonal->seedling()->associate($seedling);
            $primeraClonal->fecha = now();
            $primeraClonal->parceladesde = $request->parcelaDesde;
            $primeraClonal->cantidad = $request->parcelaHasta - $primeraClonal->parceladesde + 1;
            
            $primeraClonal->save();

            $this::insertarDetalle($primeraClonal);

            return PrimeraClonal::where('id', $primeraClonal->id)->with(['serie', 'seedling.campania', 'seedling.semillado.cruzamiento.madre', 'seedling.semillado.cruzamiento.padre', 'seedling.variedad', 'parcelas'])->first();
        }
        catch(Exception $e){
            return response()->json($e->getMessage());
        }
    }

    public function getPrimeraClonal(Request $request){
        return PrimeraClonal::with(['serie', 'seedling.campania', 'sector.subambiente.ambiente'])->find($request->id);
    }

    public function editPrimeraClonal(Request $request){
        try{
            $primeraClonal = PrimeraClonal::find($request->idSeedling);
    
            PrimeraClonalDetalle::where('idprimeraclonal', $request->idSeedling)->delete();
            $primeraClonal->idserie = $request->serie;
            $primeraClonal->idsector = $request->sector;
            $seedling = Seedling::find($request->parcela);
            $primeraClonal->seedling()->associate($seedling);
            $primeraClonal->cantidad = $request->parcelaHasta - $primeraClonal->parceladesde + 1;
            
            $primeraClonal->save();

            $this::insertarDetalle($primeraClonal);

            session(['exito' => 'exito']);

            return response()->json(true);
        }
        catch(Exception $e){
            return response()->json($e->getMessage());
        }
    }

    public function delete(Request $request, $id = 0){
        try{
            PrimeraClonalDetalle::where('idprimeraclonal', $id)->delete();

            $seedling = PrimeraClonal::find($id);
    
            $seedling->delete();

            return redirect()->back()->with('exito', 'exito');
        }
        catch(Exception $e){
            return redirect()->back()->with('error', 'error');
        }
    }

    public function laboratorio($idSerie = 0, $idSector = 0){
        $series = Serie::where('estado', 1)->get();
        $ambientes = Ambiente::where('estado', 1)->get();
        $seedlings = PrimeraClonal::where('idserie', $idSerie)->where('idsector', $idSector)->paginate(20);
        $sector = Sector::find($idSector);

        if($sector){
            $idSubambiente = $sector->subambiente->id;
            $idAmbiente = $sector->subambiente->ambiente->id;
        }
        else{
            $idSubambiente = $idAmbiente = 0;    
        }

        return view('admin.primera.laboratorio.index', compact('idSerie', 'series', 'seedlings', 'ambientes', 'idSector', 'idSubambiente', 'idAmbiente'));
    }

    public function saveLaboratorio(Request $request, $idSerie, $idSector){
        try{
            DB::transaction(function () use($request, $idSerie, $idSector){
                $primera = PrimeraClonal::where('idserie', $idSerie)->where('idsector', $idSector)->get();

                foreach($primera as $seedling){
                    $seedling->parcelas()->update(['laboratorio' => 0]);

                    if(isset($request->ids)){
                        foreach($request->ids as $id){
                            $parcela = PrimeraClonalDetalle::find($id);
                            $parcela->laboratorio = 1;
                            $parcela->save();
                        }
                    }
                }
            });

            return response()->json(true);
        }
        catch(Exception $e){
            return response()->json(false);
        }
    }

    public function getSeedlings(Request $request){
        if($request->procedencia == 'L'){
            $seedlings = PrimeraClonalDetalle::where('laboratorio', 1)->whereHas('primera', function($query) use($request){
                $query->where('idserie', $request->idSerie)->where('idSector', $request->idSector);
            })->get();
        }
        else{
            $seedlings = PrimeraClonalDetalle::whereHas('primera', function($query) use($request){
                $query->where('idserie', $request->idSerie)->where('idSector', $request->idSector);
            })->get();
        }

        return response()->json($seedlings);
    }

    public function saveTestigos(Request $request){
        try{
            DB::transaction(function() use ($request){
                if(count($request->testigoVariedad) == count($request->testigoParcela)){
                    // Borrar todos los testigos previos
                    PrimeraClonalDetalle::whereHas('primera', function($q) use($request){
                        $q->where('testigo', 1)->where('idserie', $request->serie)->where('idsector', $request->sector);
                    })->delete();
                    PrimeraClonal::where('testigo', 1)->where('idserie', $request->serie)->where('idsector', $request->sector)->delete();

                    for($i = 0; $i < count($request->testigoVariedad); $i++){
                        $variedad = $request->testigoVariedad[$i];
                        $parcela = $request->testigoParcela[$i];
                        $digits = strlen((string)$parcela);

                        $detalles = PrimeraClonalDetalle::whereHas('primera', function($q) use($request){
                            $q->where('idserie', $request->serie)->where('idsector', $request->sector);
                        })->get();

                        foreach($detalles as $detalle){
                            if(str_ends_with((string)((int)$detalle->parcela), (string)$parcela)){
                                $primeraRelacionado = $detalle->primera;
                                $primeraClonal = new PrimeraClonal();
    
                                $primeraClonal->idserie = $primeraRelacionado->serie->id;
                                $primeraClonal->idsector = $primeraRelacionado->sector->id;
                                $primeraClonal->fecha = now();
                                $primeraClonal->parceladesde = $detalle->parcela + 0.5;
                                $primeraClonal->cantidad = 1;
                                $primeraClonal->idvariedad = $variedad;
                                $primeraClonal->testigo = 1;
                                $primeraClonal->save();

                                $primeraClonalDetalle = new PrimeraClonalDetalle();
                                $primeraClonalDetalle->idprimeraclonal = $primeraClonal->id;
                                $primeraClonalDetalle->parcela = $detalle->parcela + 0.5;
                                $primeraClonalDetalle->save();
                            }
                        }
                        /*while($detalle){
                            $primeraRelacionado = $detalle->primera;
                            $primeraClonal = new PrimeraClonal();

                            $primeraClonal->anio = $primeraRelacionado->anio;
                            $primeraClonal->idserie = $primeraRelacionado->serie->id;
                            $primeraClonal->idsector = $primeraRelacionado->sector->id;
                            $primeraClonal->fecha = now();
                            $primeraClonal->parceladesde = $parcela + 0.5;
                            $primeraClonal->cantidad = 1;
                            $primeraClonal->idvariedad = $variedad;
                            $primeraClonal->testigo = 1;

                            $primeraClonal->save();
                            
                            $parcela += pow(10, $digits);
                            $detalle = PrimeraClonalDetalle::where('parcela', $parcela)->whereHas('primera', function($q) use($request){
                                $q->where('idserie', $request->serie)->where('idsector', $request->sector);
                            })->first();
                        }*/
                    }
                }
                else
                    throw new Exception("Los campos de parcela son requeridos.");
            });

            session(['exito' => 'exito']);
            return response()->json(true);
        }
        catch(Exception $e){
            session(['error' => 'error']);
            return response()->json(false);
        }
    }

    function evCampoSanidad(Request $request, $anio = 0, $idSerie = 0, $idSector = 0, $mes = 0, $edad2 = 0){
        if($anio == 0)
            $anio = date('Y');
        
        $ambientes = Ambiente::where('estado', 1)->get();
        $edades = Edad::all();
        $series = Serie::where('estado', 1)->get();
        $sector = Sector::find($idSector);
        $origen = 'pc';

        if($sector){
            $idSubambiente = $sector->subambiente->id;
            $idAmbiente = $sector->subambiente->ambiente->id;
        }
        else{
            $idSubambiente = $idAmbiente = 0;    
        }

        $cantRegistros = $request->input('cant_registros', 30);

        $seedlings = PrimeraClonalDetalle::whereHas('primera', function($q) use($idSerie, $idSector){
            $q->where('idserie', $idSerie)->where('idsector', $idSector);
        })->where('laboratorio', 0)->paginate($cantRegistros);

        $evaluacion = EvaluacionPrimeraClonal::where('anio', $anio)->where('idserie', $idSerie)->where('idsector', $idSector)
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
                                                                        'idAmbiente', 'mes', 'edad2', 'seedlings', 'fecha_calendario', 'idEvaluacion', 'origen',
                                                                        'cantRegistros'));
    }

    function saveEvCampoSanidad(Request $request){
        try{
            DB::transaction(function () use($request){
                $evaluacion = EvaluacionPrimeraClonal::where('anio', $request->anio)->where('idserie', $request->serie)->where('idsector', $request->sector)
                ->where('mes', $request->mes)->where('idedad', $request->edad)->where('tipo', 'C')->first();

                if(!$evaluacion){
                    $evaluacion = new EvaluacionPrimeraClonal();
                    $evaluacion->idserie = $request->serie;
                    $evaluacion->idsector = $request->sector;
                    $evaluacion->anio = $request->anio;
                    $evaluacion->mes = $request->mes;
                    $evaluacion->idedad = $request->edad;
                    $evaluacion->tipo = 'C';
                    $evaluacion->fecha = $request->fecha;
                    $evaluacion->save();
                }

                $evaluacionDetalle = EvaluacionDetalleCampoSanidadPC::where('idevaluacion', $evaluacion->id)->where('idseedling', $request->idSeedling)->first();
                if(!$evaluacionDetalle){
                    $evaluacionDetalle = new EvaluacionDetalleCampoSanidadPC();
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

    function evLaboratorio(Request $request, $anio = 0, $idSerie = 0, $idSector = 0, $mes = 0, $edad2 = 0){
        if($anio == 0)
            $anio = date('Y');
        
        $ambientes = Ambiente::where('estado', 1)->get();
        $edades = Edad::all();
        $series = Serie::where('estado', 1)->get();
        $sector = Sector::find($idSector);
        $origen = 'pc';

        if($sector){
            $idSubambiente = $sector->subambiente->id;
            $idAmbiente = $sector->subambiente->ambiente->id;
        }
        else{
            $idSubambiente = $idAmbiente = 0;    
        }

        $cantRegistros = $request->input('cant_registros', 30);

        $seedlings = PrimeraClonalDetalle::whereHas('primera', function($q) use($idSerie, $idSector){
            $q->where('idserie', $idSerie)->where('idsector', $idSector);
        })->where('laboratorio', 1)->paginate($cantRegistros);

        $evaluacion = EvaluacionPrimeraClonal::where('anio', $anio)->where('idserie', $idSerie)->where('idsector', $idSector)
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
                                                                        'idAmbiente', 'mes', 'edad2', 'seedlings', 'fecha_calendario', 'idEvaluacion', 'origen',
                                                                        'cantRegistros'));
    }

    function saveEvLaboratorio(Request $request){
        try{
            return DB::transaction(function () use($request){
                $evaluacion = EvaluacionPrimeraClonal::where('anio', $request->anio)->where('idserie', $request->serie)->where('idsector', $request->sector)
                ->where('mes', $request->mes)->where('idedad', $request->edad)->where('tipo', 'L')->first();

                if(!$evaluacion){
                    $evaluacion = new EvaluacionPrimeraClonal();
                    $evaluacion->idserie = $request->serie;
                    $evaluacion->idsector = $request->sector;
                    $evaluacion->anio = $request->anio;
                    $evaluacion->mes = $request->mes;
                    $evaluacion->idedad = $request->edad;
                    $evaluacion->tipo = 'L';
                    $evaluacion->fecha = $request->fecha;
                    $evaluacion->save();
                }

                $evaluacionDetalle = EvaluacionDetalleLaboratorioPC::where('idevaluacion', $evaluacion->id)->where('idseedling', $request->idSeedling)->first();
                if(!$evaluacionDetalle){
                    $evaluacionDetalle = new EvaluacionDetalleLaboratorioPC();
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
        $inventario = DB::select("SELECT s.anio, pc.idserie, s.nombre as nombre_serie, pc.idsector, sec.nombre AS nombre_sector, sa.nombre AS nombre_subambiente, a.nombre AS nombre_ambiente, COUNT(*) as cant_seedlings FROM primerasclonal_detalle as pcd INNER JOIN primerasclonal as pc ON pcd.idprimeraclonal = pc.id INNER JOIN series AS s ON s.id = pc.idserie INNER JOIN sectores AS sec ON sec.id = pc.idsector INNER JOIN subambientes AS sa ON sa.id = sec.idsubambiente INNER JOIN ambientes AS a ON a.id = sa.idambiente GROUP BY s.anio, nombre_serie, pc.idsector, pc.idserie, nombre_sector, nombre_subambiente, nombre_ambiente");
        $origen = 'pc';
        
        foreach($inventario as $linea){

            $cantidadPorEdadYMesCS = DB::select("select epc.mes, COUNT(case e.nombre when 'Planta' then 1 else null end) as planta, COUNT(case e.nombre when 'Soca 1' then 1 else null end) as soca1, COUNT(case e.nombre when 'Soca 2' then 1 else null end) as soca2 from evaluacionesdetalle_camposanidad_pc edcspc inner join evaluaciones_primeraclonal as epc on edcspc.idevaluacion = epc.id inner join edades as e on epc.idedad = e.id where epc.anio = ? and epc.idserie = ? and epc.idsector = ? group by epc.mes ", [$linea->anio, $linea->idserie, $linea->idsector]);
            $cantidadPorEdadYMesLab = DB::select("select epc.mes, COUNT(case e.nombre when 'Planta' then 1 else null end) as planta, COUNT(case e.nombre when 'Soca 1' then 1 else null end) as soca1, COUNT(case e.nombre when 'Soca 2' then 1 else null end) as soca2 from evaluacionesdetalle_laboratorio_pc edlabpc inner join evaluaciones_primeraclonal as epc on edlabpc.idevaluacion = epc.id inner join edades as e on epc.idedad = e.id where epc.anio = ? and epc.idserie = ? and epc.idsector = ? group by epc.mes ", [$linea->anio, $linea->idserie, $linea->idsector]);
            $linea->evaluacionesCS = $cantidadPorEdadYMesCS;
            $linea->evaluacionesLab = $cantidadPorEdadYMesLab;
            array_push($inventarioFinal, $linea);
        }

        return view('admin.primera.inventario2.index', compact('inventarioFinal', 'origen'));
    }
}
