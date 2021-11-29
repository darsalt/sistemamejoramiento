<?php

namespace App\Http\Controllers;

use App\Campania;
use App\CampaniaSemillado;
use App\Semillado;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SemilladoController extends Controller
{
    public function index(Request $request)
    {
        if($request){
            $inventario=DB::table('semillados as s') 
            ->leftjoin('campanias as c','c.id','=','s.idcampania')
            ->leftjoin('cruzamientos as cru','cru.id','=','s.idcruzamiento')
            ->select(DB::raw('s.idcampania,c.nombre,COUNT(s.idcampania) as cantidad,SUM(s.gramos) as gramos,round(SUM(s.gramos*cru.conteo),0) as plantas,SUM(2*cru.conteo) as poder,SUM(s.cajones) as cajones,SUM(s.repicadas) as repicadas'))
            ->groupBy('s.idcampania')
            ->groupBy('c.nombre')
                //->orderBy('nombre','asc')
            ->paginate('10');
            //dd($inventario);
            return view('admin.semillados.index',["inventario"=>$inventario]);
        }
    }

    public function inventario(Request $request,$id)
    {

        $inventario=DB::table('semillados as s')
        ->leftjoin('campanias as c','c.id','=','s.idcampania')
        ->select('c.idcampania')
        ->paginate('100');

        //dd($inventario);

        $data = '';


        if ($request->ajax()) {
                $data .= '<div class="table-responsive"><table class="table table-striped table-bordered table-condensed table-hover">';
                $data .= '<thead><th width="5%">Orden</th><th width="5%">Fecha</th><th width="5%">Cruza</th><th width="5%">Cruzamiento</th><th width="5%">Gramos</th><th width="5%">Poder Germinativo</th><th width="10%">Plantas</th><th width="10%">Cajones</th></thead>';
            foreach ($semillados as $datos) {

                $data.='<tr>';
                $data.='<td width=6%><label for="tabla">'.$datos->numero.'</label></td>';
                $data.='<td width=9%><label for="tabla">'.$datos->fechasemillado.'</label></td>';
                $data.='<td width=6%><label for="tabla">'.$datos->cruza.'</label></td>';
                $data.='<td width=6%><label for="tabla">'.$datos->cruza.'</label></td>';
                $data.='<td width=10%><input type="text" name="g'.$datos->idsemillado.'" id="g'.$datos->idsemillado.'"class="form-control" value="'.$datos->gramos.'"></td>';
                $data.='<td width=6%><label for="tabla">'.$datos->poder.'</label></td>';
                $data.='<td width=6%><label for="tabla">'.$datos->poder*$datos->gramos.'</label></td>';
                //$data.='<td width=10%><input type="text" name="g'.$datos->idsemillado.'" id="g'.$datos->idsemillado.'"class="form-control" value="'.$datos->plantas.'"></td>';
                $data.='<td width=10%><input type="text" name="g'.$datos->idsemillado.'" id="g'.$datos->idsemillado.'"class="form-control" value="'.$datos->cajones.'"></td>';
                $data.='</tr>';
            }
            $data.='</table></div>';
            return $data;
        }
    }

    public function semillados(Request $request,$id)
    {

        $semillados=DB::table('semillados as s')
        ->leftjoin('campanias as c','c.id','=','s.idcampania')
        ->leftjoin('cruzamientos as cr','cr.id','=','s.idcruzamiento')
        ->select('s.idsemillado','s.numero', 's.fechasemillado', 'c.nombre' ,'cr.id','cr.cruza','cr.poder','s.idcruzamiento', 's.gramos' ,'s.cajones')
        ->orderBy('s.numero','asc')
        ->paginate('100');

        $data = '';

      //  dd($semillados);

        if ($request->ajax()) {
                $data .= '<div class="table-responsive"><table class="table table-striped table-bordered table-condensed table-hover">';
                $data .= '<thead><th width="5%">Orden</th><th width="5%">Fecha</th><th width="5%">Cruza</th><th width="5%">Cruzamiento</th><th width="5%">Gramos</th><th width="5%">Poder Germinativo</th><th width="10%">Plantas</th><th width="10%">Cajones</th></thead>';
            foreach ($semillados as $datos) {

                $data.='<tr>';
                $data.='<td width=6%><label for="tabla">'.$datos->numero.'</label></td>';
                $data.='<td width=9%><label for="tabla">'.$datos->fechasemillado.'</label></td>';
                $data.='<td width=6%><label for="tabla">'.$datos->id.'</label></td>';
                $data.='<td width=6%><label for="tabla">'.$datos->cruza.'</label></td>';
                $data.='<td width=10%><input type="text" name="g'.$datos->idsemillado.'" id="g'.$datos->idsemillado.'"class="form-control" value="'.$datos->gramos.'"></td>';
                $data.='<td width=6%><label for="tabla">'.$datos->poder.'</label></td>';
                $data.='<td width=6%><label for="tabla">'.$datos->poder*$datos->gramos.'</label></td>';
				//$data.='<td width=10%><input type="text" name="g'.$datos->idsemillado.'" id="g'.$datos->idsemillado.'"class="form-control" value="'.$datos->plantas.'"></td>';
				$data.='<td width=10%><input type="text" name="g'.$datos->idsemillado.'" id="g'.$datos->idsemillado.'"class="form-control" value="'.$datos->cajones.'"></td>';
                $data.='</tr>';
            }
            $data.='</table></div>';
            return $data;
        }
    }

public function repicadas(Request $request,$id)
    {

        $semillados=DB::table('semillados as s')
        ->leftjoin('campanias as c','c.id','=','s.idcampania')
        ->leftjoin('cruzamientos as cr','cr.cruza','=','s.idcruzamiento')
        ->select('s.idsemillado','s.numero', 's.fechasemillado', 'c.nombre' ,'cr.cruza','cr.poder','s.idcruzamiento', 's.gramos' ,'s.cajones','s.repicadas')
        ->orderBy('s.numero','asc')
        ->paginate('100');

        $data = '';

      //  dd($semillados);

        if ($request->ajax()) {
                $data .= '<div class="table-responsive"><table class="table table-striped table-bordered table-condensed table-hover">';
                $data .= '<thead><th width="5%">Orden</th><th width="5%">Fecha</th><th width="5%">Cruza</th><th width="5%">Cruzamiento</th><th width="5%">Gramos</th><th width="5%">Poder Germinativo</th><th width="10%">Plantas</th><th width="10%">Cajones</th><th width="10%">Repicadas</th></thead>';
            foreach ($semillados as $datos) {

                $data.='<tr>';
                $data.='<td width=6%><label for="tabla">'.$datos->numero.'</label></td>';
                $data.='<td width=9%><label for="tabla">'.$datos->fechasemillado.'</label></td>';
                $data.='<td width=6%><label for="tabla">'.$datos->cruza.'</label></td>';
                $data.='<td width=6%><label for="tabla">'.$datos->cruza.'</label></td>';
                $data.='<td width=6%><label for="tabla">'.$datos->gramos.'</label></td>';

                $data.='<td width=6%><label for="tabla">'.$datos->poder.'</label></td>';
                $data.='<td width=6%><label for="tabla">'.$datos->poder*$datos->gramos.'</label></td>';
                $data.='<td width=6%><label for="tabla">'.$datos->cajones.'</label></td>';

				$data.='<td width=10%><input type="text" name="g'.$datos->idsemillado.'" id="g'.$datos->idsemillado.'"class="form-control" value="'.$datos->repicadas.'"></td>';
                $data.='</tr>';
            }
            $data.='</table></div>';
            return $data;
        }
    }

    public function ordenes($campActiva = 0){
        $semillados = Semillado::where('idcampania', $campActiva)->with(['campania', 'cruzamiento.semilla', 'cruzamiento.campaniaCruzamiento'])->paginate(10);
        dd($semillados);
        $campaniasSemillado = CampaniaSemillado::where('estado', 1)->get();
        $campaniasCruzamiento = Campania::where('estado', 1)->get();

        return view('admin.semillados.ordenes', compact('semillados', 'campaniasSemillado', 'campaniasCruzamiento', 'campActiva'));
    }

    private function getUltimaOrden($campaniaSemillado){
        $ultimoSemillado = Semillado::where('idcampania', $campaniaSemillado)->orderByDesc('numero')->first();

        return $ultimoSemillado ? $ultimoSemillado->numero : 0;
    }

    // Obtener el numero de la ultima orden de semillado
    public function getUltimaOrdenAjax(Request $request){
        return response()->json($this->getUltimaOrden($request->campania));
    }

    // Almacenar una nueva orden de semillado
    public function saveSemillado(Request $request){
        try{
            $semillado = new Semillado();
    
            $semillado->numero = $this->getUltimaOrden($request->campSemillado) + 1;
            $semillado->fechasemillado = $request->fechaSemillado;
            $semillado->idcampania = $request->campSemillado;
            $semillado->idcruzamiento = $request->nroCruza;
            $semillado->gramos = $request->cantGramos;
            $semillado->cajones = $request->cantCajones;

            $semilla = $semillado->cruzamiento->semilla;
            $semilla->stockactual = $semilla->stockactual - $semillado->gramos;
            $semilla->save();
            
            $semillado->save();

            return Semillado::where('idsemillado', $semillado->idsemillado)
            ->with(['campania', 'cruzamiento.semilla', 'cruzamiento.campaniaCruzamiento', 'cruzamiento.madre', 'cruzamiento.padre'])->first();
        }
        catch(Exception $e){
            return response()->json($e->getMessage());
        }
        
    }

    // Editar un semillado
    public function editSemillado(Request $request){
        try{
            $semillado = Semillado::where('idsemillado', $request->idSemillado)->first();
    
            $semillado->fechasemillado = $request->fechaSemillado;
            $semillado->idcampania = $request->campSemillado;
            $semillado->idcruzamiento = $request->nroCruza;
            $semillado->cajones = $request->cantCajones;

            $semilla = $semillado->cruzamiento->semilla;
            $semilla->stockactual += $semillado->gramos;
            $semilla->stockactual -= $request->cantGramos;
            $semillado->gramos = $request->cantGramos;
            $semilla->save();
            
            $semillado->save();

            session(['exito' => 'exito']);

            return Semillado::with(['campania', 'cruzamiento.semilla', 'cruzamiento.campaniaCruzamiento'])->get();
        }
        catch(Exception $e){
            return response()->json($e->getMessage());
        }
        
    }

    public function getSemillados(Request $request){
        return response()->json(Semillado::where('idcampania', $request->campania)->with(['campania', 'cruzamiento.semilla', 'cruzamiento.campaniaCruzamiento'])->get());
    }

    public function getSemillado(Request $request){
        return Semillado::with(['campania', 'cruzamiento.campaniaCruzamiento', 'cruzamiento.semilla'])->find($request->id);
    }

    public function delete(Request $request, $id = 0){
        try{
            $semillado = Semillado::where('idsemillado', $id)->first();

            $semilla = $semillado->cruzamiento->semilla;
            $semilla->stockactual += $semillado->gramos;
            $semilla->save();
    
            $semillado->delete();

            return redirect()->back()->with('exito', 'exito');
        }
        catch(Exception $e){
            return redirect()->back()->with('error', 'error');
        }
    }

    public function getProgenitores(Request $request){
        $semillado = Semillado::find($request->id);
        $cruzamiento = $semillado->cruzamiento;
        $progenitores = ['madre' => $cruzamiento->madre, 'padre' => $cruzamiento->padre];
        
        return $progenitores;
    }
}
