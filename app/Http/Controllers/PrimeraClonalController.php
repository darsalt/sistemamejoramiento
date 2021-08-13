<?php

namespace App\Http\Controllers;

use App\Ambiente;
use App\CampaniaSeedling;
use App\Http\Controllers\Controller;
use App\PrimeraClonal;
use App\PrimeraClonalDetalle;
use App\Sector;
use App\Seedling;
use App\Serie;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PrimeraClonalController extends Controller
{
    public function index($idSerie = 0, $idSector = 0){
        $series = Serie::where('estado', 1)->get();
        $ambientes = Ambiente::where('estado', 1)->get();
        $seedlings = PrimeraClonal::where('idserie', $idSerie)->where('idsector', $idSector)->paginate(10);
        $campSeedling = CampaniaSeedling::where('estado', 1)->get();

        if($idSector > 0){
            $idSubambiente = Sector::find($idSector)->subambiente->id;
            $idAmbiente = Sector::find($idSector)->subambiente->ambiente->id;
        }
        else{
            $idSubambiente = $idAmbiente = 0;
        }

        return view('admin.primera.seleccion.index')->with(compact('series', 'seedlings', 'ambientes', 'campSeedling', 'idSerie', 'idSector', 'idSubambiente', 'idAmbiente'));
    }

    public function getUltimaParcela($serie){
        $ultimoSeedling = PrimeraClonal::where('idserie', $serie)->orderByDesc('parceladesde')->first();

        return $ultimoSeedling ? $ultimoSeedling->parceladesde + $ultimoSeedling->cantidad - 1 : 0;
    }

    // Obtener el numero de la ultima parcela cargada
    public function getUltimaParcelaAjax(Request $request){
        return response()->json($this->getUltimaParcela($request->serie));
    }

    private static function insertarDetalle($primeraClonal){
        for($i = $primeraClonal->parceladesde; $i<$primeraClonal->parceladesde + $primeraClonal->cantidad; $i++){
            $planta = new PrimeraClonalDetalle();
            $planta->primera()->associate($primeraClonal);
            $planta->parcela = $i;
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
            $primeraClonal->parceladesde = $this->getUltimaParcela($request->serie) + 1;
            $primeraClonal->cantidad = $request->parcelaHasta - $primeraClonal->parceladesde + 1;
            
            $primeraClonal->save();

            $this::insertarDetalle($primeraClonal);

            return PrimeraClonal::where('id', $primeraClonal->id)->with(['serie', 'seedling.campania', 'seedling.semillado.cruzamiento.madre', 'seedling.semillado.cruzamiento.padre'])->first();
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
}
