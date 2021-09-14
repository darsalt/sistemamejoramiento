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
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class METController extends Controller
{
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

        $parcelasSC = SegundaClonalDetalle::whereHas('segunda', function($query) use($idSerie){
            $query->where('idserie', $idSerie);
        })->orderBy('idprimeraclonal_detalle')->get();

        return view('admin.met.seleccion.index')->with(compact('series', 'ambientes', 'idSerie', 'idSector', 'idSubambiente', 'idAmbiente', 'parcelasSC'));
    }

    public function saveMET(Request $request){
        try{
            DB::transaction(function () use($request){
                $met = MET::where('anio', $request->anio)->first();

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

    private function getUltimaParcela($anio){
        $ultimoSeedling = METDetalle::whereHas('met', function($q) use($anio){
            $q->where('anio', $anio);
        })->orderByDesc('parcela')->first();

        return $ultimoSeedling ? $ultimoSeedling->parcela : 0;
    }

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
}
