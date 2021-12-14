<?php

namespace App\Http\Controllers;

use App\Ambiente;
use App\CampaniaSeedling;
use App\CampaniaSemillado;
use App\Http\Controllers\Controller;
use App\Sector;
use App\Seedling;
use App\Semillado;
use App\Subambiente;
use App\Variedad;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class EtapaIndividualController extends Controller
{
    public function index($idCampania = 0, $idSector = 0){
        $seedlings = Seedling::where('idcampania', $idCampania)->where('idsector', $idSector)->paginate(10);
        $campaniasSeedling = CampaniaSeedling::where('estado', 1)->get();
        $campaniasSemillado = CampaniaSemillado::where('estado', 1)->get();
        $ambientes = Ambiente::where('estado', 1)->get();
        $variedades = Variedad::all();

        if($idSector > 0){
            $idSubambiente = Sector::find($idSector)->subambiente->id;
            $idAmbiente = Sector::find($idSector)->subambiente->ambiente->id;
        }
        else{
            $idSubambiente = $idAmbiente = 0;
        }

        return view('admin.individual.seleccion.index', compact('seedlings', 'campaniasSeedling', 'campaniasSemillado', 'ambientes', 'idCampania', 'variedades', 'idSector', 'idSubambiente', 'idAmbiente'));
    }

    public function inventario(){
        $inventario = DB::select("SELECT s.idcampania, c.nombre AS nombre_campania, s.idsector, sec.nombre AS nombre_sector, sa.nombre AS nombre_subambiente, a.nombre AS nombre_ambiente, COUNT(*) as cant_parcelas, SUM(surcos) as cant_surcos, SUM(s.surcos * s.plantasxsurco) as cant_seedlings, COUNT(case s.origen when 'cruzamiento' then 1 else null end) as cant_cruzas FROM seedlings AS s INNER JOIN campaniaseedling AS c ON c.id = s.idcampania INNER JOIN sectores AS sec ON sec.id = s.idsector INNER JOIN subambientes AS sa ON sa.id = sec.idsubambiente INNER JOIN ambientes AS a ON a.id = sa.idambiente GROUP BY s.idcampania, nombre_campania, s.idsector, nombre_sector, nombre_subambiente, nombre_ambiente");

        return view('admin.individual.inventario2.index', compact('inventario'));
    }

    public function getUltimaParcela($campaniaSeedling, $idSector){
        $ultimoSeedling = Seedling::where('idcampania', $campaniaSeedling)->where('idsector', $idSector)->orderByDesc('parcela')->first();

        return $ultimoSeedling ? $ultimoSeedling->parcela : 0;
    }

    // Obtener el numero de la ultima parcela cargada
    public function getUltimaParcelaAjax(Request $request){
        return response()->json($this->getUltimaParcela($request->campania, $request->sector));
    }

    public function saveSeedling(Request $request){
        try{
            $seedling = new Seedling();
    
            $seedling->idcampania = $request->campSeedling;
            $seedling->idsector = $request->sector;
            $seedling->origen = $request->origen;
            
            $seedling->parcela = $this->getUltimaParcela($request->campSeedling, $request->sector) + 1;
            if($request->origen == 'cruzamiento'){
                $semillado = Semillado::find($request->ordenSemillado);
                $seedling->semillado()->associate($semillado); 
            }
            else{ 
                if($request->origen == 'n/i')
                    $seedling->observaciones = $request->observacion;
                else
                    $seedling->idvariedad = $request->variedad;
            }  

            $seedling->fecha_plantacion = $request->fecha;
            $seedling->tabla = $request->tabla;
            $seedling->tablita = $request->tablita;
            $seedling->surcos = $request->surcos;
            $seedling->plantasxsurco = $request->plantasxsurco;
            
            $seedling->save();

            return Seedling::where('id', $seedling->id)->with(['campania', 'semillado.campaniasemillado', 'sector.subambiente.ambiente', 'variedad', 'semillado.cruzamiento.madre',
            'semillado.cruzamiento.padre'])->first();
        }
        catch(Exception $e){
            return response()->json($e->getMessage());
        }
    }

    public function getSeedling(Request $request){
        return Seedling::where('id', $request->id)->with(['campania', 'semillado.campaniasemillado', 'sector.subambiente.ambiente'])->first();
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

            return Seedling::with(['campania', 'semillado.campaniasemillado', 'sector.subambiente.ambiente'])->get();
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
        return Seedling::where('idcampania', $request->campania)->where('idsector', $request->sector)->get();
    }

    public function getProgenitoresSeedling(Request $request){
        $seedling = Seedling::find($request->id);
        $idSemillado = $seedling->idsemillado;
        if($idSemillado){
            $semillado = Semillado::find($idSemillado);
            $cruzamiento = $semillado->cruzamiento;
            $progenitores = ['madre' => $cruzamiento->madre, 'padre' => $cruzamiento->padre, 'origen' => $seedling->origen];
        }
        else{
            $progenitores = ['variedad' => $seedling->variedad->nombre, 'observaciones' => $seedling->observaciones, 'origen' => $seedling->origen];
        }
        
        return $progenitores;
    }
}
