<?php

namespace App\Http\Controllers;

use App\BoxExportacion;
use App\BoxImportacion;
use App\CampaniaCuarentena;
use App\DatoSanitariaCuarentena;
use App\Exportacion;
use App\Http\Controllers\Controller;
use App\Importacion;
use App\SanitariaCuarentena;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class SanitariasCuarentenaController extends Controller
{
    public function index(){
        $sanitarias = SanitariaCuarentena::where('estado', 1)->paginate(10);

        return view('admin.cuarentena.sanitarias.index', compact('sanitarias'));
    }

    public function create(){
        $campanias = CampaniaCuarentena::where('estado', 1)->get();

        return view('admin.cuarentena.sanitarias.create', compact('campanias'));
    }

    public function store(Request $request){
        $sanitaria = new SanitariaCuarentena();
        $sanitaria->idcampania = $request->get('campania');
        $sanitaria->fecha = $request->get('fecha');
        $sanitaria->observaciones = $request->get('observaciones');
        $sanitaria->estado = 1;
        $sanitaria->save();

        $id = $sanitaria->id;
        $boxesImpo = BoxImportacion::where('activo', 1)->get();

        foreach($boxesImpo as $box){
            $importaciones = Importacion::where('idcampania', $request->campania)->where('idbox', $box->id)->where('estado', 1)->get();

            foreach($importaciones as $importacion){
                DB::table('datos_sanitarias_cuarentena')->insert(['idevaluacion' => $id, 'origen' => 'I', 'idbox' => $box->id, 'idtacho' => $importacion->idtacho]);
            }
        }

        $boxesExpo = BoxExportacion::where('activo', 1)->get();

        foreach($boxesExpo as $box){
            $exportaciones = Exportacion::where('idcampania', $request->campania)->where('idbox', $box->id)->where('estado', 1)->get();

            foreach($exportaciones as $exportacion){
                DB::table('datos_sanitarias_cuarentena')->insert(['idevaluacion' => $id, 'origen' => 'E', 'idbox' => $box->id, 'idtacho' => $exportacion->idtacho]);
            }
        }

        return redirect()->route('cuarentena.sanitarias.index');
    }

    public function destroy($id)
    {
        $sanitaria=SanitariaCuarentena::findOrFail($id);
        $sanitaria->estado='0';//baja
        $sanitaria->update();

        return redirect()->route('cuarentena.sanitarias.index');
    }

    public function datosasociados($id){
        $sanitaria = SanitariaCuarentena::findOrFail($id);

        $datosasociados=DB::table('datos_sanitarias_cuarentena as d')
        ->select('d.*')
        ->join('sanitarias_cuarentena as s','s.id','=','d.idevaluacion')
        ->where ('d.idevaluacion','=',$id)
        ->orderBy('d.id','asc')
        ->get();

        return view("admin.cuarentena.sanitarias.datos", ["sanitaria"=>$sanitaria,"datosasociados"=>$datosasociados]);
    }

    public function getDatosAsociados(Request $request, $idEvaluacion){
        $sanitaria = SanitariaCuarentena::findOrFail($idEvaluacion);

        $datosasociados=DB::table('datos_sanitarias_cuarentena as d')
        ->select('d.*','t.codigo','t.subcodigo', 'be.nombre as boxexpo', 'bi.nombre as boximpo')
        ->join('sanitarias_cuarentena as s','s.id','=','d.idevaluacion')
        ->join('tachos as t','t.idtacho','=','d.idtacho')
        ->leftjoin('boxesexpo as be', 'be.id', '=', 'd.idbox')        
        ->leftjoin('boxesimpo as bi', 'bi.id', '=', 'd.idbox')       
        ->where ('d.idevaluacion','=',$idEvaluacion)
        ->orderBy('d.id','asc')
        ->paginate('100');

        Log::debug($datosasociados);

        $data = '';

        if ($request->ajax()) {
            $data .= '<div class="table-responsive"><table class="table table-striped table-bordered table-condensed table-hover">';
            $data.='<thead><th><div class="sizem">Tipo</div></th><th><div class="sizem">Box</div></th><th><div class="sizem">Tacho</div></th><th><div class="sizem">Carbón</div></th><th><div class="sizem">Escaldadura</div></th><th><div class="sizem">Estría roja</div></th><th><div class="sizem">Mosaico</div></th><th><div class="sizem">Roya marrón</div></th><th><div class="sizem">Roya anaranjada</div></th><th><div class="sizem">Pokka boeng</div></th><th><div class="sizem">Amarillamiento</div></th><th><div class="sizem">Mancha parda</div></th><th><div class="sizem">Otra</div></th></thead>';
            foreach ($datosasociados as $datos) {
                $data.='<tr>';
                if($datos->origen == 'I'){
                    $data.='<td>Importación</td>';    
                    $data.='<td>'.$datos->boximpo.'</td>';    
                }
                else{
                    $data.='<td>Exportación</td>';    
                    $data.='<td>'.$datos->boxexpo.'</td>';    
                }
                $data.='<td>'.$datos->codigo.'-'.$datos->subcodigo.'</td>';
                $data.='<td><input type="text" name="c'.$datos->id.'" id="c'.$datos->id.'"class="form-control" value="'.$datos->carbon.'"></td>';
                $data.='<td><input type="text" name="e'.$datos->id.'" id="e'.$datos->id.'"class="form-control" value="'.$datos->escaladura.'"></td>';
                $data.='<td><input type="text" name="er'.$datos->id.'" id="er'.$datos->id.'"class="form-control" value="'.$datos->estriaroja.'"></td>';
                $data.='<td><input type="text" name="m'.$datos->id.'" id="m'.$datos->id.'"class="form-control" value="'.$datos->mosaico.'"></td>';
                $data.='<td><input type="text" name="rm'.$datos->id.'" id="rm'.$datos->id.'"class="form-control" value="'.$datos->royamarron.'"></td>';
                $data.='<td><input type="text" name="ra'.$datos->id.'" id="ra'.$datos->id.'"class="form-control" value="'.$datos->royaanaranjada.'"></td>';
                $data.='<td><input type="text" name="pb'.$datos->id.'" id="pb'.$datos->id.'"class="form-control" value="'.$datos->pokkaboeng.'"></td>';
                $data.='<td><input type="text" name="a'.$datos->id.'" id="a'.$datos->id.'"class="form-control" value="'.$datos->amarillamiento.'"></td>';
                $data.='<td><input type="text" name="mp'.$datos->id.'" id="mp'.$datos->id.'"class="form-control" value="'.$datos->manchaparda.'"></td>';
                $data.='<td><input type="text" name="o'.$datos->id.'" id="o'.$datos->id.'"class="form-control" value="'.$datos->otra.'" onblur="guardaevaluacion(this.name)"></td>';

                $data.='</tr>';
            }
            $data.='</table></div>';
            return $data;
        }
    }

    public function updateDatosEvaluacion(Request $request){
        $input = $request->all();

        $datosanitario=DatoSanitariaCuarentena::findOrFail($request->get('id'));

        $datosanitario->carbon=$request->get('carbon');
        $datosanitario->escaladura=$request->get('escaladura');
        $datosanitario->estriaroja=$request->get('estriaroja');
        $datosanitario->mosaico=$request->get('mosaico');
        $datosanitario->royamarron=$request->get('royamarron');
        $datosanitario->royaanaranjada=$request->get('royaanaranjada');
        $datosanitario->pokkaboeng=$request->get('pokkaboeng');
        $datosanitario->amarillamiento=$request->get('amarillamiento');
        $datosanitario->manchaparda=$request->get('manchaparda');
        $datosanitario->otra=$request->get('otra');
        $datosanitario->update();

        return response()->json();
    }
}
