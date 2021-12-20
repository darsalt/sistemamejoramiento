<?php

namespace App\Http\Controllers;

use App\Campania;
use App\Inventario;
use App\Cruzamiento;
use App\Semilla;
use App\TalloCruzamiento;
use App\Tallo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use Exception;
use Illuminate\Support\Facades\Log;

class InventarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
     //    if($request){
    	// 	$query=trim($request->get('searchText'));
     //        $cruzamientos=DB::table('cruzamientos as c')
     //        ->leftjoin('tachos','idpadre','=','tachos.idtacho')
     //        ->leftjoin('variedades','tachos.idvariedad','=','variedades.idvariedad')
     //        ->select('c.*','tachos.idtacho','tachos.codigo','tachos.subcodigo','tachos.idvariedad','variedades.nombre')
     //        ->where ('tipocruzamiento','like','%'.$query.'%') 
    	// 	->where ('c.estado','=',1)
    	// 	->orderBy('id','asc')
     //        ->paginate('10');
     //        $campanias=DB::table('campanias')->orderBy('nombre', 'desc')->get();
            
    	// 	return view('admin.cruzamientos.index',["cruzamientos"=>$cruzamientos, "campanias"=>$campanias, "searchText"=>$query]);
    	// }

        // if($request){
        //     $query=trim($request->get('searchText'));
        //     $cruzamientos=DB::table('cruzamientos as c')
        //     ->leftjoin('tachos as tp','c.idpadre','=','tp.idtacho')
        //     ->leftjoin('tachos as tm','c.idmadre','=','tm.idtacho') 
        //     ->leftjoin('variedades as vp','vp.idvariedad','=','tp.idvariedad')     
        //     ->leftjoin('variedades as vm','vm.idvariedad','=','tm.idvariedad')        
        //     ->leftjoin('campanias as ca','ca.id','=','c.idcampania')            

        //     ->select('c.*', 'tp.codigo as cp' ,'tp.subcodigo as sp', 'tm.codigo as cm' ,'tm.subcodigo as sm','vp.nombre as vp','vm.nombre as vm', 'ca.nombre as campania')
        //     ->where ('tipocruzamiento','like','%'.$query.'%') 
        //     ->where ('c.estado','=',1)
        //     ->orderBy('id','asc')
        //     ->paginate('10');
        //     return view('admin.inventario.index',["cruzamientos"=>$cruzamientos,"searchText"=>$query]);
        
        $query=trim($request->get('searchText'));
        $semillas=DB::table('semillas as s')
        ->leftjoin('cruzamientos as c','s.idcruzamiento','=','c.id')
        ->leftjoin('tachos as tp','c.idpadre','=','tp.idtacho')
        ->leftjoin('tachos as tm','c.idmadre','=','tm.idtacho') 
        ->leftjoin('variedades as vp','vp.idvariedad','=','tp.idvariedad')     
        ->leftjoin('variedades as vm','vm.idvariedad','=','tm.idvariedad')        
        ->leftjoin('campanias as ca','ca.id','=','c.idcampania')            

        ->select('s.*','c.fechacruzamiento','c.cruza', 'c.cubiculo','c.plantines','c.gramos' ,'tp.codigo as cp' ,'tp.subcodigo as sp', 'tm.codigo as cm' ,'tm.subcodigo as sm','vp.nombre as vp','vm.nombre as vm', 'ca.nombre as campania')
        ->where ('tipocruzamiento','like','%'.$query.'%') 
       // ->where ('s.estado','=',1)
        ->orderBy('idsemilla','asc')
        ->paginate('10');
        return view('admin.inventario.index',["semillas"=>$semillas,"searchText"=>$query]);
        
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $tachos=DB::table('tachos')
            ->join('tallos','tachos.idtacho','=','tallos.idtacho')
            ->select('tachos.idtacho', 'tachos.codigo' , 'tachos.subcodigo','tachos.estado')
        //    ->where ('tachos.estado','=','Ocupado')
            ->where('tallos.fechafloracion', '!=', 'null')
            ->distinct('tachos.codigo')
            ->get();

           // dd($tachos);

        $campanias=DB::table('campanias')->orderBy('nombre', 'desc')->get();

        return view ("admin.cruzamientos.create", ["tachos"=>$tachos, "campanias"=>$campanias]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $arrayMadre = $request->get('arrayMadre');
        $madres = json_decode($arrayMadre);
        $arrayPadre = $request->get('arrayPadre');
        $padres = json_decode($arrayPadre);
        $madresCantidad = count($madres);
        $padresCantidad = count($padres);
        $anio = strval($request->get('campania'));
        $fechainicio = date_create($anio."-01-01");
        $fechafin = date_create($anio."-12-31");
        $campania = DB::table('campanias')->where('nombre', '=', $request->get('campania'))->value('id');
       
        $ultimoCruzamiento=DB::table('cruzamientos')->whereBetween('fechacruzamiento', [$fechainicio, $fechafin])->get()->last();

        if($ultimoCruzamiento != null){
            $ultimoCruza = $ultimoCruzamiento->cruza + 1;  
            $ultimoCubiculo = $ultimoCruzamiento->cubiculo + 1;  
        } else {
            $ultimoCruza = 1; 
            $ultimoCubiculo = 1;   
        }

        $cruza = $ultimoCruza;
        
        if ($request->get('tipocruzamiento') == "Policruzamiento") {
            $j = $ultimoCruza + $padresCantidad;

            $k=0;

            // Cabecera
            $cruzamiento = new Cruzamiento;
            $cruzamiento->tipocruzamiento = $request->get('tipocruzamiento');
            $cruzamiento->cruza = $cruza;
            $cruzamiento->cubiculo = $ultimoCubiculo;
            $cruzamiento->fechacruzamiento = $request->get('fechacruzamiento');
            $cruzamiento->idpadre = null;
            $cruzamiento->idmadre = null;
            $cruzamiento->estado = 1;
            $cruzamiento->idcampania = $campania;

            $cruzamiento->save(); 
            
            $cruza += 1;

            // Detalle
            for($i=$ultimoCruza; $i<$j; $i++) {
                if ($cruzamiento->id != null) {
                    
                    $talloCruzamiento = new TalloCruzamiento;
                    $talloCruzamiento->idtallo = $padres[$k]->id;
                    $talloCruzamiento->idcruzamiento = $cruzamiento->id;
                    $talloCruzamiento->save();
                }    

                $k += 1; 

            } 

        } else {  

            $cruzamiento = new Cruzamiento;
            $cruzamiento->tipocruzamiento = $request->get('tipocruzamiento');
            $cruzamiento->cruza = $ultimoCruza;
            $cruzamiento->cubiculo = $ultimoCubiculo;
            $cruzamiento->fechacruzamiento = $request->get('fechacruzamiento');
            $cruzamiento->idpadre = $padres[0]->idTacho;
            $cruzamiento->idmadre = $padres[0]->idTacho;
            $cruzamiento->estado = 1;
            $cruzamiento->idcampania = $campania;

            $cruzamiento->save();
            $cruza += 1; 

            for ($l=0; $l<$padresCantidad; $l++) {
                $talloCruzamiento = new TalloCruzamiento;
                $talloCruzamiento->idtallo = $padres[$l]->id;
                $talloCruzamiento->idcruzamiento = $cruzamiento->id;
                $talloCruzamiento->save();
            }

        }

        $k=0;
        $tachoId = 0;
        $j = $ultimoCruza + $madresCantidad; 

        for($i=$ultimoCruza; $i<$j; $i++) {

            $tachomadre = $madres[$k]->idTacho;

            if ($tachoId != $tachomadre) {
                
                // Cabecera
                $cruzamiento = new Cruzamiento;
                $cruzamiento->tipocruzamiento = $request->get('tipocruzamiento');
                $cruzamiento->cruza = $cruza;
                $cruzamiento->cubiculo = $ultimoCubiculo;
                $cruzamiento->fechacruzamiento = $request->get('fechacruzamiento');
                if ($request->get('tipocruzamiento') == "Biparental") {
                    $cruzamiento->idpadre = $padres[0]->idTacho;
                } else {
                    $cruzamiento->idpadre = null;
                }    
                $cruzamiento->idmadre = $tachomadre;
                $cruzamiento->estado = 1;
                $cruzamiento->idcampania = $campania;

                $cruzamiento->save(); 
                $tachoId = ($cruzamiento->idmadre);
                $cruza += 1; 

            }
            
            // Detalle
            if ($cruzamiento->id != null) {
            
                $talloCruzamiento = new TalloCruzamiento;
                $talloCruzamiento->idtallomadre = $madres[$k]->id;
                $talloCruzamiento->idcruzamiento = $cruzamiento->id;
                $talloCruzamiento->save();
            }    

            $k += 1;
            
        } 

        // Actualizacion Tallos Madre
        $datosTallosMadre = $request->get('arrayMadreDatos');
        $tallosMadre = json_decode($datosTallosMadre);
        $cantidadTallosMadre = count($tallosMadre);

        for($i=0 ; $i<$cantidadTallosMadre; $i++) {
            $talloUpdate = Tallo::findOrFail($tallosMadre[$i]->talloId)->update([
                'polen' => $tallosMadre[$i]->polen,
                'enmasculado' => $tallosMadre[$i]->enmasculado
            ]);
        }

        // Actualizacion Tallos Padre
        if ($request->get('tipocruzamiento') == "Biparental") {
            $talloUpdate = Tallo::findOrFail($request->get('talloPadre'))->update([
                'polen' => $request->get('polenpadre0')
            ]);
        }else {   
            $datosTallosPadre = $request->get('arrayPadreDatos');
            $tallosPadre = json_decode($datosTallosPadre);
            $cantidadTallosPadre = count($tallosPadre);

            for($i=0 ; $i<$cantidadTallosPadre; $i++) {
                $talloUpdate = Tallo::findOrFail($tallosPadre[$i]->talloId)->update([
                    'polen' => $tallosPadre[$i]->polen,
                ]);
            }
        } 
        return Redirect::to('admin/cruzamientos');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cruzamiento  $cruzamiento
     * @return \Illuminate\Http\Response
     */
    public function show(Cruzamiento $cruzamiento)
    {
        $tallosCruza=DB::table('tallocruzamientos as tc')
            ->leftjoin('tallos as tp','tc.idtallo','=','tp.id')
            ->leftjoin('tallos as tm','tc.idtallomadre','=','tm.id')
            ->leftjoin('tachos as tacp','tp.idtacho','=','tacp.idtacho')
            ->select('tp.numero as tpn' , 'tp.fechafloracion as tpf' , 'tp.polen as tpp', 'tp.enmasculado as tpe', 'tm.numero as tmn', 'tm.fechafloracion as tmf' , 'tm.polen as tmp', 'tm.enmasculado as tme', 'tacp.codigo as codp', 'tacp.subcodigo as subcodp')
            ->where ('tc.idcruzamiento','=',$cruzamiento->id)
            ->get();
        return view('admin.cruzamientos.show', ['tallos' => $tallosCruza]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cruzamiento  $cruzamiento
     * @return \Illuminate\Http\Response
     */
    public function edit(Cruzamiento $cruzamiento)
    {
        //
    }

    public function ingreso()
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cruzamiento  $cruzamiento
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cruzamiento $cruzamiento)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cruzamiento  $cruzamiento
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cruzamiento=Cruzamiento::findOrFail($id);
        $cruzamientos=Cruzamiento::where('cubiculo', $cruzamiento->cubiculo)
                                ->where('idcampania', $cruzamiento->idcampania)->get();
        foreach ($cruzamientos as $cruzamiento) {
            $cruzamiento->estado='0';//baja
            $cruzamiento->update();
        }    
    	return Redirect::to('admin/cruzamientos');
    }

    public function poder(Request $request)
    {
        if($request){
            $query=trim($request->get('searchText'));
            $cruzamientos=DB::table('cruzamientos as c')
            ->leftjoin('tachos as tp','c.idpadre','=','tp.idtacho')
            ->leftjoin('tachos as tm','c.idmadre','=','tm.idtacho') 
            ->leftjoin('variedades as vp','vp.idvariedad','=','tp.idvariedad')     
            ->leftjoin('variedades as vm','vm.idvariedad','=','tm.idvariedad')            
            ->select('c.*', 'tp.codigo as cp' ,'tp.subcodigo as sp', 'tm.codigo as cm' ,'tm.subcodigo as sm','vp.nombre as vp','vm.nombre as vm')
            ->where ('tipocruzamiento','like','%'.$query.'%') 
            ->where ('c.estado','=',1)
            ->orderBy('id','asc')
            ->paginate('10');
           // dd($cruzamientos);
            return view('admin.podergerminativo.index',["cruzamientos"=>$cruzamientos,"searchText"=>$query]);
        }
    }

    public function podergerminativo()
    {


        $podergerminativo=DB::table('cruzamientos as c')
        ->select('c.*')
        ->get();
        //dd($podergerminativo);


        return view("admin.podergerminativo.datos",compact("podergerminativo"),["podergerminativo"=>$podergerminativo]);


    }

    public function tallosTacho($id) {
        return $tallos=DB::table('tallos')
        ->where('idtacho', $id)
        ->get();
    }

     public function ubicacionesasociadas(Request $request,$id)
    {

        $podergerminativo=DB::table('cruzamientos as c')
        ->leftjoin('tachos as tp','c.idpadre','=','tp.idtacho')
        ->leftjoin('tachos as tm','c.idmadre','=','tm.idtacho')
        ->leftjoin('variedades as vp','vp.idvariedad','=','tp.idvariedad')     
        ->leftjoin('variedades as vm','vm.idvariedad','=','tm.idvariedad')
        ->select('c.*', 'tp.codigo as cp' ,'tp.subcodigo as sp', 'tm.codigo as cm' ,'tm.subcodigo as sm','vp.nombre as vp','vm.nombre as vm')
        ->orderBy('c.cruza','asc')
        ->paginate('100');

        $data = '';

       // dd($podergerminativo);


        if ($request->ajax()) {
                $data .= '<div class="table-responsive"><table class="table table-striped table-bordered table-condensed table-hover">';
                $data .= '<thead><th width="5%">Cruza</th> <th width="5%">Cubículo</th><th width="5%">Padre</th><th width="5%">Madre</th><th width="5%">Fecha Cruzamiento</th><th width="10%">Gramos</th><th width="10%">Conteo</th><th width="10%">Poder Germinativo</th><th width="10%">Plantines Potenciales</th></thead>';
            foreach ($podergerminativo as $datos) {

                $data.='<tr>';
                $data.='<td width=6%><label for="tabla">'.$datos->cruza.'</label></td>';
                $data.='<td width=7%><label for="tabla">'.$datos->cubiculo.'</label></td>';
                $data.='<td width=7%><label for="tabla">'.$datos->cp.'-'.$datos->sp.'-'.$datos->vp.'</label></td>';
               $data.='<td width=8%><label for="tabla">'.$datos->cm.'-'.$datos->sm.'-'.$datos->vm.'</label></td>';
                $data.='<td width=9%><label for="tabla">'.$datos->fechacruzamiento.'</label></td>';
                $data.='<td width=10%><input type="text" name="g'.$datos->id.'" id="g'.$datos->id.'"class="form-control" value="'.$datos->gramos.'"></td>';
                $data.='<td width=10%><input type="text" name="c'.$datos->id.'" id="c'.$datos->id.'"class="form-control" value="'.$datos->conteo.'"  onblur="guardapoder(this.name)"></td>';
                $data.='<td width=10%><input type="text" name="poder'.$datos->id.'" id="poder'.$datos->id.'"class="form-control" value="'.$datos->poder.'" disabled></td>';
                $data.='<td width=10%><input type="text" name="plantines'.$datos->id.'" id="plantines'.$datos->id.'"class="form-control" value="'.$datos->plantines.'" disabled></td>';
                $data.='</tr>';
            }
            $data.='</table></div>';
            return $data;
        }
    }

    
    public function updatePoderPost(Request $request)
    {
        $input = $request->all();
        \Log::info($input);

            $cruzamiento=Cruzamiento::findOrFail($request->get('id'));
            $cruzamiento->gramos=$request->get('gramos');
            $cruzamiento->conteo=$request->get('conteo');
            $cruzamiento->poder=$request->get('conteo')*2;
            $cruzamiento->plantines=$request->get('gramos')*$request->get('conteo');

         //   dd($datoagronomico);
            $cruzamiento->update();
        return response()->json();
    }

    // Obtener la semilla segun el id de cruzamiento dado
    public function getSemilla(Request $request){
        $semilla = Semilla::where('idcruzamiento', $request->cruzamiento)->first();

        return response()->json($semilla);
    }

    public function egresos(){
        $egresos = DB::table('egresos_semillas as es')
        ->select('es.id', 'ca.nombre as nombre_campania', 'me.nombre as nombre_motivo', 'v1.nombre as padre', 'v2.nombre as madre', 'es.cantidad', 'es.fecha_egreso', 'es.observaciones')
        ->join('cruzamientos as c', 'es.idcruzamiento', '=', 'c.id')
        ->join('campanias as ca', 'ca.id', '=', 'c.idcampania')
        ->join('motivos_egreso as me', 'es.idmotivo', '=', 'me.id')
        ->join('variedades as v1', 'c.idpadre', '=', 'v1.idvariedad')
        ->join('variedades as v2', 'c.idmadre', '=', 'v2.idvariedad')
        ->where('es.estado', 1)
        ->orderByDesc('es.fecha_egreso')
        ->get();

        return view('admin.inventario.egresos.index', compact('egresos'));
    }

    public function createEgreso(){
        $campanias = Campania::where('estado', 1)->orderByDesc('nombre')->get();
        $motivos = DB::table('motivos_egreso')->where('estado', 1)->get();

        return view('admin.inventario.egresos.create', compact('campanias', 'motivos'));
    }

    public function storeEgreso(Request $request){
        try{
            DB::transaction(function () use($request){
                DB::table('egresos_semillas')->insert([
                    'idcruzamiento' => $request->cruzamiento,
                    'idmotivo' => $request->motivo,
                    'cantidad' => $request->cantidad,
                    'fecha_egreso' => $request->fechaegreso,
                    'observaciones' => $request->observaciones 
                ]);

                $cruzamiento = Cruzamiento::findOrFail($request->cruzamiento);
                $semilla = $cruzamiento->semilla;

                if($request->cantidad <= $semilla->stockactual)
                    $semilla->stockactual -= $request->cantidad;
                else
                    throw new Exception('Cantidad mayor que el stock actual');

                $semilla->save();
            });

            return redirect()->route('inventario.egresos.index')->with('exito', 'exito');
        }
        catch(Exception $e){
            return redirect()->route('inventario.egresos.index')->with('error', 'error');
        }
    }

    public function deleteEgreso(Request $request){
        try{
            DB::transaction(function () use($request){
                DB::table('egresos_semillas')->where('id', $request->id_egreso)->update(['estado' => 0]);

                $egreso = DB::table('egresos_semillas')->where('id', $request->id_egreso)->first();
                $cruzamiento = Cruzamiento::findOrFail($egreso->idcruzamiento);
                $semilla = $cruzamiento->semilla;

                $semilla->stockactual += $egreso->cantidad;
                $semilla->save();
            });

            return redirect()->route('inventario.egresos.index')->with('exito', 'exito');
        }
        catch(Exception $e){
            return redirect()->route('inventario.egresos.index')->with('error', 'error');
        }
    }

    public function editEgreso($id){
        $egreso = DB::table('egresos_semillas as es')->where('es.id', $id)->select('es.*', 'v1.nombre as padre', 'v2.nombre as madre', 'c.idcampania as idcampania')
        ->join('cruzamientos as c', 'es.idcruzamiento', '=', 'c.id')
        ->join('variedades as v1', 'c.idpadre', '=', 'v1.idvariedad')
        ->join('variedades as v2', 'c.idmadre', '=', 'v2.idvariedad')
        ->first();

        $campanias = Campania::where('estado', 1)->get();
        $cruzamientos = Cruzamiento::where('idcampania', $egreso->idcampania)->get();
        $motivos = DB::table('motivos_egreso')->where('estado', 1)->get();

        return view('admin.inventario.egresos.edit', compact('egreso', 'cruzamientos', 'campanias', 'motivos'));
    }

    public function updateEgreso(Request $request, $id){
        try{
            DB::transaction(function () use($request, $id){
                $egresoAnterior = DB::table('egresos_semillas')->where('id', $id)->first();

                $cruzamiento = Cruzamiento::findOrFail($egresoAnterior->idcruzamiento);
                $semilla = $cruzamiento->semilla;

                $semilla->stockactual += $egresoAnterior->cantidad;
                $semilla->save();
                
                DB::table('egresos_semillas')->where('id', $id)->update([
                    'idcruzamiento' => $request->cruzamiento,
                    'idmotivo' => $request->motivo,
                    'cantidad' => $request->cantidad,
                    'fecha_egreso' => $request->fechaegreso,
                    'observaciones' => $request->observaciones
                ]);

                $cruzamiento = Cruzamiento::findOrFail($request->cruzamiento);
                $semilla = $cruzamiento->semilla;

                $semilla->stockactual -= $request->cantidad;
                $semilla->save();
            });

            return redirect()->route('inventario.egresos.index')->with('exito', 'exito');
        }
        catch(Exception $e){
            return redirect()->route('inventario.egresos.index')->with('error', 'error');
        }
    }
}
