<?php

namespace App\Http\Controllers;

use App\Ambiente;
use App\CampaniaSeedling;
use App\Http\Controllers\Controller;
use App\PrimeraClonal;
use App\Seedling;
use App\Serie;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PrimeraClonalController extends Controller
{
    public function index($idSerie = 0){
        $series = Serie::where('estado', 1)->get();
        $ambientes = Ambiente::where('estado', 1)->get();
        $seedlings = PrimeraClonal::where('idserie', $idSerie)->paginate(10);
        $campSeedling = CampaniaSeedling::where('estado', 1)->get();

        return view('admin.primera.seleccion.index')->with(compact('series', 'seedlings', 'ambientes', 'campSeedling', 'idSerie'));
    }

    public function getUltimaParcela($serie){
        $ultimoSeedling = PrimeraClonal::where('idserie', $serie)->orderByDesc('parceladesde')->first();

        return $ultimoSeedling ? $ultimoSeedling->parceladesde + $ultimoSeedling->cantidad - 1 : 0;
    }

    // Obtener el numero de la ultima parcela cargada
    public function getUltimaParcelaAjax(Request $request){
        Log::debug($request->serie);
        return response()->json($this->getUltimaParcela($request->serie));
    }

    public function savePrimeraClonal(Request $request){
        try{
            $primeraClonal = new PrimeraClonal();
    
            $primeraClonal->idserie = $request->serie;
            $primeraClonal->idsector = $request->sector;
            $seedling = Seedling::find($request->parcela);
            $primeraClonal->seedling()->associate($seedling);
            $primeraClonal->fecha = $request->fecha;
            $primeraClonal->cantidad = $request->cantidad;
            $primeraClonal->parceladesde = $this->getUltimaParcela($request->serie) + 1;
            
            $primeraClonal->save();

            return PrimeraClonal::where('id', $primeraClonal->id)->with(['serie', 'seedling.campania', 'sector.subambiente.ambiente'])->first();
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
    
            $primeraClonal->idserie = $request->serie;
            $primeraClonal->idsector = $request->sector;
            $seedling = Seedling::find($request->parcela);
            $primeraClonal->seedling()->associate($seedling);
            $primeraClonal->fecha = $request->fecha;
            $primeraClonal->cantidad = $request->cantidad;
            
            $primeraClonal->save();

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
}
