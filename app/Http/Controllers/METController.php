<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Serie;
use App\Ambiente;
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
    public function index($anio = 0, $idSector = 0){
        if($anio == 0)
            $anio = (int)date('Y');
        
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

        $parcelasCargadas = METDetalle::whereHas('met', function($query) use($anio, $idSector){
            $query->where('anio', $anio)->where('idsector', $idSector);
        })->orderBy('parcela')->get();

        return view('admin.met.seleccion.index2')->with(compact('series', 'ambientes', 'anio', 'idSector', 'idSubambiente', 'idAmbiente', 'parcelasCargadas', 'variedades'));
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
                $met->anio = $request->anio;
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
        $met = MET::where('anio', $request->anio)->where('idsector', $request->sector)->first() ?? null;

        return response()->json($met);
    }

    public function getUltimaParcela(Request $request){
        $met = MET::where('anio', $request->anio)->where('idsector', $request->sector)->first();
        
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
                Log::debug($request);
                $met = MET::where('anio', $request->anio)->where('idsector', $request->sector)->first();

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
                    $met_detalle->save();

                    return METDetalle::with(['parcelaSC.parcelaPC', 'variedad', 'parcelaSC.variedad'])->find($met_detalle->id);
                }
                else
                    throw new Exception("No se encontro el MET correspondiente");
                    return null;
            });
        }
        catch(Exception $e){
            Log::debug($e->getMessage());
            return response()->json(false);
        }
    } 
}
