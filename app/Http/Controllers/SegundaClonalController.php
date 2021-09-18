<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Ambiente;
use App\Sector;
use App\Serie;
use App\PrimeraClonalDetalle;
use App\SegundaClonal;
use App\SegundaClonalDetalle;
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

        $parcelasPC = PrimeraClonalDetalle::whereHas('primera', function($query) use($idSerie, $idSector){
            $query->where('idserie', $idSerie);
        });
        
        $parcelasPC = $parcelasPC->orderBy('parcela')->get();

        return view('admin.segundaclonal.seleccion.index')->with(compact('series', 'ambientes', 'idSerie', 'idSector', 'idSubambiente', 'idAmbiente', 'parcelasPC'));
    }

    public function saveSegundaClonal(Request $request){
        try{
            DB::transaction(function () use($request){
                $segunda = SegundaClonal::where('idserie', $request->serie)->first();

                if($segunda){
                    $parcelasCargadas = $segunda->parcelas()->where('idsector', $request->sector);

                    foreach($parcelasCargadas->get() as $parcela){
                        // Eliminamos del detalle las parcelas que antes fueron seleccionadas y se deseleccionaron
                        if(!in_array($parcela->idprimeraclonal_detalle, $request->seedlingsPC ?? [])){
                            $parcela->delete();
                        }
                    }

                    $this->regenerarNrosParcelas($request->serie);
                    $i = $this->getUltimaParcela($request->serie) + 1;
                    foreach($request->seedlingsPC ?? [] as $nroParcela){
                        // Cargamos las parcelas nuevas que nunca fueron agregadas
                        if(!in_array($nroParcela, $parcelasCargadas->pluck('idprimeraclonal_detalle')->toArray())){
                            $seedling = new SegundaClonalDetalle();
                            $seedling->idsegundaclonal = $segunda->id;
                            $seedling->idprimeraclonal_detalle = $nroParcela;
                            $seedling->idsector = $request->sector;
                            $seedling->parcela = $i;
                            $seedling->save();
                            $i += 1;
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

                        $this->regenerarNrosParcelas($request->serie);
                        $i = $this->getUltimaParcela($request->serie) + 1;
                        foreach($request->seedlingsPC as $parcela){
                            $seedling = new SegundaClonalDetalle();
                            $seedling->idsegundaclonal = $segunda->id;
                            $seedling->idprimeraclonal_detalle = $parcela;
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

    public function getSegundaClonal(Request $request){
        $seedling = SegundaClonal::with('sector.subambiente.ambiente')->find($request->id);

        return $seedling;
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

    private function getUltimaParcela($idSerie){
        $ultimoSeedling = SegundaClonalDetalle::whereHas('segunda', function($q) use($idSerie){
            $q->where('idserie', $idSerie);
        })->orderByDesc('parcela')->first();

        return $ultimoSeedling ? $ultimoSeedling->parcela : 0;
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
}
