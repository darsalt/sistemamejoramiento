<?php

namespace App\Http\Controllers;

use App\Ambiente;
use App\CampaniaSeedling;
use App\CampaniaSemillado;
use App\Http\Controllers\Controller;
use App\Sector;
use App\Seedling;
use App\Semillado;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class EtapaIndividualController extends Controller
{
    public function index($idCampania = 0){
        $seedlings = Seedling::where('idcampania', $idCampania)->paginate(10);
        $campaniasSeedling = CampaniaSeedling::where('estado', 1)->get();
        $campaniasSemillado = CampaniaSemillado::where('estado', 1)->get();
        $ambientes = Ambiente::where('estado', 1)->get();

        return view('admin.individual.seleccion.index', compact('seedlings', 'campaniasSeedling', 'campaniasSemillado', 'ambientes', 'idCampania'));
    }

    public function getUltimaParcela($campaniaSeedling){
        $ultimoSeedling = Seedling::where('idcampania', $campaniaSeedling)->orderByDesc('parcela')->first();

        return $ultimoSeedling ? $ultimoSeedling->parcela : 0;
    }

    // Obtener el numero de la ultima parcela cargada
    public function getUltimaParcelaAjax(Request $request){
        return response()->json($this->getUltimaParcela($request->campania));
    }

    public function saveSeedling(Request $request){
        try{
            $seedling = new Seedling();
    
            $seedling->idcampania = $request->campSeedling;
            $semillado = Semillado::find($request->ordenSemillado);
            $seedling->semillado()->associate($semillado);
            $seedling->idsector = $request->sector;
            $seedling->origen = $request->origen;
            $seedling->parcela = $this->getUltimaParcela($request->campSeedling) + 1;
            $seedling->fecha_plantacion = $request->fecha;
            $seedling->tabla = $request->tabla;
            $seedling->tablita = $request->tablita;
            $seedling->surcos = $request->surcos;
            $seedling->plantasxsurco = $request->plantasxsurco;
            
            $seedling->save();

            return Seedling::where('id', $seedling->id)->with(['campania', 'semillado.campania', 'sector.subambiente.ambiente'])->first();
        }
        catch(Exception $e){
            return response()->json($e->getMessage());
        }
    }

    public function getSeedling(Request $request){
        return Seedling::where('id', $request->id)->with(['campania', 'semillado.campania', 'sector.subambiente.ambiente'])->first();
    }

    public function editSeedling(Request $request){
        try{
            $seedling = Seedling::where('id', $request->idSeedling)->first();
    
            $seedling->idcampania = $request->campSeedling;
            $seedling->idsector = $request->sector;
            $seedling->fecha_plantacion = $request->fecha;
            $seedling->origen = $request->origen;
            $semillado = Semillado::where('idsemillado', $request->ordenSemillado)->first();
            $seedling->semillado()->associate($semillado);
            $seedling->tabla = $request->tabla;
            $seedling->tablita = $request->tablita;
            $seedling->surcos = $request->surcos;
            $seedling->plantasxsurco = $request->plantasxsurco;
            
            $seedling->save();

            session(['exito' => 'exito']);

            return Seedling::with(['campania', 'semillado.campania', 'sector.subambiente.ambiente'])->get();
        }
        catch(Exception $e){
            return response()->json($e->getMessage());
        }
    }

    public function delete(Request $request, $id = 0){
        try{
            $seedling = Seedling::find($id);
    
            $seedling->delete();

            return redirect()->back()->with('exito', 'exito');
        }
        catch(Exception $e){
            return redirect()->back()->with('error', 'error');
        }
    }

    public function getSeedlings(Request $request){
        return Seedling::where('idcampania', $request->campania)->get();
    }

    public function getProgenitoresSeedling(Request $request){
        $idSemillado = Seedling::find($request->id)->idsemillado;
        $semillado = Semillado::find($idSemillado);
        $cruzamiento = $semillado->cruzamiento;
        $progenitores = ['madre' => $cruzamiento->madre, 'padre' => $cruzamiento->padre];
        
        return $progenitores;
    }
}
