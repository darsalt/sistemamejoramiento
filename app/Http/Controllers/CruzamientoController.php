<?php

namespace App\Http\Controllers;

use App\Cruzamiento;
use App\TalloCruzamiento;
use App\Tallo;
use App\Semilla;
use App\Imports\CruzamientosImport;
use Maatwebsite\Excel\Facades\Excel;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use DB;
use Illuminate\Support\Facades\Log;

class CruzamientoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request){
            $campanias=DB::table('campanias')
            ->Where('estado',1)
            ->orderBy('nombre', 'desc')
            ->get();
            if($request->has('campania'))
                $idCampania = $request->campania;
            else
                $idCampania = $campanias[0]->id;
               
            $query=trim($request->get('searchText'));
            $cruzamientos=DB::table('cruzamientos as c')
            ->leftjoin('tachos','idpadre','=','tachos.idtacho')
            ->leftjoin('variedades','tachos.idvariedad','=','variedades.idvariedad')
            ->select('c.*','tachos.idtacho','tachos.codigo','tachos.subcodigo','tachos.idvariedad','variedades.nombre')
            ->where ('tipocruzamiento','like','%'.$query.'%') 
            ->where('c.idcampania', $idCampania)
            ->where ('c.estado','=',1)
            ->orderBy('fechacruzamiento','asc')->orderBy('cubiculo', 'asc')->orderBy('cruza', 'asc')
            ->paginate('10')
            ->appends(request()->query());

           // dd($cruzamientos);
    		return view('admin.cruzamientos.index',["cruzamientos"=>$cruzamientos, "campanias"=>$campanias, "searchText"=>$query, "idCampania" => $idCampania]);
    	}
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($idCampania = 0)
    {
        $campanias=DB::table('campanias')->where('estado', 1)->orderBy('nombre', 'desc')->get();

        if($idCampania == 0)
            $idCampania = $campanias[0]->id;
        //$idCampania=7;
       // dd($idCampania);
        $tachos=DB::table('tachos_campanias')
        ->leftjoin('tachos','tachos.idtacho','=','tachos_campanias.idtacho')
        ->leftjoin('variedades','tachos.idvariedad','=','variedades.idvariedad')
        ->join('tallos','tachos.idtacho','=','tallos.idtacho')
        ->select('tachos.idtacho', 'tachos.codigo' , 'tachos.subcodigo','tachos.idvariedad','variedades.nombre')
         //   ->select('tachos_campanias.idtacho',)

            //    ->where ('tachos.estado','=','Ocupado')
        //    ->leftjoin('variedades','tachos.idvariedad','=','variedades.idvariedad')
            //->where('tachos_campanias.idcampania', '=', '10')
            //->where('tallos.idcampania', '=', '10')
            ->where('tachos_campanias.idcampania', '=', $idCampania)
            ->where('tallos.idcampania', '=', $idCampania)
            ->where('tallos.fechafloracion', '!=', $idCampania)
          //  ->whereIn('tachos.idtacho', DB::table('tachos_campanias as tc')->where('tc.idcampania', $idCampania)->pluck('tc.idtacho'))
          // ->whereIn('tachos.idtacho',function($query){
          //  $query->select('idtacho')->from('tachos_campanias')->where('idcampania','=',$idCampania);
          //  })
           ->distinct('tachos.codigo')
            ->get();
            //dd($tachos);


        return view ("admin.cruzamientos.create", ["tachos"=>$tachos, "campanias"=>$campanias, "idCampania" => $idCampania]);
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
        $campania = $request->get('campania');

        $ultimoCruzamiento=DB::table('cruzamientos')->where('idcampania', $campania)->orderByDesc('cruza')->first();


        if($ultimoCruzamiento != null){
            $ultimoCruza = $ultimoCruzamiento->cruza + 1;  
            $ultimoCubiculo = $ultimoCruzamiento->cubiculo + 1;  
        } else {
            $ultimoCruza = 1; 
            $ultimoCubiculo = 1;   
        }

        $cruza = $ultimoCruza;

        $this->crearEncabezadoYDetalleCruzamiento($request->get('tipocruzamiento'), $cruza, $ultimoCubiculo, $request->get('fechacruzamiento'), $campania, $padres, $madres);
        $this->actualizarTallosMadreYPadre($request->get('tipocruzamiento'), $request->get('arrayMadreDatos'), $request->get('arrayPadreDatos'), $request->get('polenpadre0'), $request->get('talloPadre'));
 
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
        $tachos=DB::table('tachos_campanias')
                ->leftjoin('tachos','tachos.idtacho','=','tachos_campanias.idtacho')
                ->leftjoin('variedades','tachos.idvariedad','=','variedades.idvariedad')
                ->join('tallos','tachos.idtacho','=','tallos.idtacho')
                ->select('tachos.idtacho', 'tachos.codigo' , 'tachos.subcodigo','tachos.idvariedad','variedades.nombre')
                ->where('tachos_campanias.idcampania', '=', $cruzamiento->campaniaCruzamiento->id)
                ->where('tallos.idcampania', '=', $cruzamiento->campaniaCruzamiento->id)
                ->where('tallos.fechafloracion', '!=', $cruzamiento->campaniaCruzamiento->id)
                ->distinct('tachos.codigo')
                ->get();

        $tallosPadre = DB::table('tallocruzamientos')
                        ->where('idcruzamiento', $cruzamiento->id)
                        ->get();

        $cubiculo = $cruzamiento->cubiculo;
        $cruzamientosRelacionados = DB::table('cruzamientos as c')->where('c.idcampania', $cruzamiento->idcampania)
                                    ->where('c.cubiculo', $cubiculo)
                                    ->join('tallocruzamientos as tc', 'tc.idcruzamiento', '=', 'c.id')
                                    ->join('tallos as t', function($join) {
                                        $join->on('tc.idtallo', '=', 't.id')
                                             ->orOn('tc.idtallomadre', '=', 't.id');
                                    })
                                    ->join('tachos', 't.idtacho', '=', 'tachos.idtacho')
                                    ->select('c.*', 'tc.idtallo as idtallopadre', 'tc.idtallomadre', 't.polen', 'tachos.idtacho as idtacho_poli', 't.enmasculado')
                                    ->orderBy('c.cruza', 'asc')->get();
        
        //dd($cruzamientosRelacionados);
        return view('admin.cruzamientos.edit', compact('cruzamiento', 'tachos', 'tallosPadre', 'cruzamientosRelacionados'), ['prueba' => json_encode($cruzamientosRelacionados)]);
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
        $arrayMadre = $request->get('arrayMadre');
        $madres = json_decode($arrayMadre);
        $arrayPadre = $request->get('arrayPadre');
        $padres = json_decode($arrayPadre);

        $menorCruza = DB::table('cruzamientos')->where('idcampania', $cruzamiento->idcampania)
                        ->where('cubiculo', $cruzamiento->cubiculo)->orderBy('cruza', 'asc')->value('cruza');

        $cubiculo = $cruzamiento->cubiculo;
        $cruzamientosRelacionados = DB::table('cruzamientos')->where('idcampania', $cruzamiento->idcampania)
                                    ->where('cubiculo', $cruzamiento->cubiculo)->orderBy('cruza', 'asc')->get();

        foreach($cruzamientosRelacionados as $auxCruzamiento){
            // Borrar los datos de talloscruzamiento
            TalloCruzamiento::where('idcruzamiento', $auxCruzamiento->id)->delete();
            // Borrar encabezado de cruzamiento
            Cruzamiento::where('id', $auxCruzamiento->id)->delete();
        }

        $this->crearEncabezadoYDetalleCruzamiento($request->get('tipocruzamiento'), $menorCruza, $cubiculo, $request->get('fechacruzamiento'), $cruzamiento->idcampania, $padres, $madres, true, $cruzamiento->created_at);
        $this->actualizarTallosMadreYPadre($request->get('tipocruzamiento'), $request->get('arrayMadreDatos'), $request->get('arrayPadreDatos'), $request->get('polenpadre0'), $request->get('talloPadre'));

        session()->flash('mensajeSuccess', 'Cruzamiento actualizado con éxito.');
        return Redirect::to('admin/cruzamientos');
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

            $campanias=DB::table('campanias')
            ->Where('estado',1)
            ->orderBy('id', 'desc')
            ->get();

            if($request->has('campania'))
                $idCampania = $request->campania;
            else
                $idCampania = $campanias[0]->id;
//dd($idCampania);
            $cruzamientos=DB::table('cruzamientos as c')
            ->leftjoin('tachos as tp','c.idpadre','=','tp.idtacho')
            ->leftjoin('tachos as tm','c.idmadre','=','tm.idtacho') 
            ->leftjoin('variedades as vp','vp.idvariedad','=','tp.idvariedad')     
            ->leftjoin('variedades  as vm','vm.idvariedad','=','tm.idvariedad')            
            ->select('c.*', 'tp.codigo as cp' ,'tp.subcodigo as sp', 'tm.codigo as cm' ,'tm.subcodigo as sm','vp.nombre as vp','vm.nombre as vm')
            ->where ('tipocruzamiento','like','%'.$query.'%') 
            ->where('c.idcampania', $idCampania)
            ->where ('c.estado','=',1)
            ->orderBy('id','asc')
            ->paginate('10')
            ->appends(request()->query());

          //  if ($campania<>0) {
          //      $cruzamientos = $cruzamientos->where('c.idcampania','=',$request->get('campania'));
          //  }

           // dd($cruzamientos);

            return view('admin.podergerminativo.index',["cruzamientos"=>$cruzamientos, "campanias"=>$campanias, "searchText"=>$query, "idCampania" => $idCampania]);
        }
    }

    public function podergerminativo($id)
    {
        if($id){

            $podergerminativo=DB::table('cruzamientos as c')
            ->select('c.*')
            ->where('c.idcampania', $id)
            ->where ('c.estado','=',1)
            ->orderBy('fechacruzamiento','asc')->orderBy('cubiculo', 'asc')->orderBy('cruza', 'asc')
           ->get();
            // ->paginate('10')
            //->appends(request()->query());
           // dd($podergerminativo);


            return view("admin.podergerminativo.datos",compact("podergerminativo"),["podergerminativo"=>$podergerminativo]);
        }

    }

    public function tallosTacho($id) {
        $tallos=DB::table('tallos as t')
                ->where('idtacho', $id)
                ->whereNotIn('id',function($query){
                    $query->select('idtallo')
                        ->from('tallocruzamientos as tc')
                        ->leftjoin('cruzamientos as c','tc.idcruzamiento','=','c.id')    
                        ->where('idtallo','>', '0');
                })
                ->whereNotIn('id',function($query){
                    $query->select('idtallomadre')
                        ->from('tallocruzamientos as tc')
                        ->leftjoin('cruzamientos as c','tc.idcruzamiento','=','c.id')    
                        ->where('idtallomadre','>', '0');
                })
                ->get();

        return $tallos;
    }

    public function getTalloById($idTallo){
        $tallo = DB::table('tallos')->where('id', $idTallo)->get();

        return $tallo;
    }

     public function ubicacionesasociadas(Request $request,$id)
    {

        $podergerminativo=DB::table('cruzamientos as c')
        ->leftjoin('tachos as tp','c.idpadre','=','tp.idtacho')
        ->leftjoin('tachos as tm','c.idmadre','=','tm.idtacho')
        ->leftjoin('variedades as vp','vp.idvariedad','=','tp.idvariedad')     
        ->leftjoin('variedades as vm','vm.idvariedad','=','tm.idvariedad')
        ->select('c.*', 'tp.codigo as cp' ,'tp.subcodigo as sp', 'tm.codigo as cm' ,'tm.subcodigo as sm','vp.nombre as vp','vm.nombre as vm')
        ->where('c.idcampania', $id)
        ->where ('c.estado','=',1)
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
            if($cruzamiento != null){
                $cruzamiento->gramos=$request->get('gramos');
                $cruzamiento->conteo=$request->get('conteo');
                $cruzamiento->poder=$request->get('conteo')*2;
                $cruzamiento->plantines=$request->get('gramos')*$request->get('conteo');
                $cruzamiento->stock=$request->get('gramos');
                $cruzamiento->update(); 

            } else {
                $cruzamiento = new Cruzamiento;
                $cruzamiento->tipocruzamiento = $request->get('tipocruzamiento');
                $cruzamiento->cruza = $cruza;
                $cruzamiento->cubiculo = $ultimoCubiculo;
                $cruzamiento->fechacruzamiento = $request->get('fechacruzamiento');
                $cruzamiento->idpadre = null;
                $cruzamiento->idmadre = null;
                $cruzamiento->estado = 1;
                $cruzamiento->idcampania = $campania;  
            }

          //  $semilla = Semilla::where('idcruzamiento', $request->get('id'))->get();
         //   $semilla = Semilla::where('idcruzamiento', '=', $request->get('id'))->firstOrFail();
         //   $semilla = Semilla::where('idcruzamiento', $request->get('id'))->first();
             $semilla=DB::table('semillas as s')
            ->leftjoin('cruzamientos as c','c.id','=','s.idcruzamiento')
            ->leftjoin('tachos as tp','c.idpadre','=','tp.idtacho')
            ->leftjoin('tachos as tm','c.idmadre','=','tm.idtacho') 
            ->leftjoin('variedades as vp','vp.idvariedad','=','tp.idvariedad')     
            ->leftjoin('variedades as vm','vm.idvariedad','=','tm.idvariedad') 
            ->where('idcruzamiento', $request->get('id'))
            ->first();
            \Log::info($semilla);

            if (Semilla::where('idcruzamiento', $request->get('id'))->exists()){

            }else{
                $semilla = new Semilla;
              //  $semilla->idcruzamiento = $request->get('id');
                
             //   $semilla->save();

            }

/*
            if($semilla){
                $semilla->idcruzamiento = $request->get('id');
                $semilla->stockinicial = $request->get('gramos');;
                $semilla->stockactual = $request->get('gramos');
                $semilla->fechaingreso = $request->get('fechacruzamiento');
                $semilla->madre = $cruzamiento->idmadre;
                $semilla->padre = $cruzamiento->idpadre;
                $semilla->podergerminativo = $request->get('conteo')*2;
                $semilla->procedencia = 'Cruzamiento';
                $semilla->observaciones = 'Origen de un cruzamiento - Fecha de ingreso = fecha de cruzamiento';
                $semilla->update();
            } else {
                $semilla = new Semilla;
                $semilla->idcruzamiento = $request->get('id');
                $semilla->stockinicial = $request->get('gramos');;
                $semilla->stockactual = $request->get('gramos');
                $semilla->fechaingreso = $request->get('fechacruzamiento');
                $semilla->madre = $cruzamiento->idmadre;
                $semilla->padre = $cruzamiento->idpadre;
                $semilla->podergerminativo = $request->get('conteo')*2;
                $semilla->procedencia = 'Cruzamiento';
                $semilla->observaciones = 'Origen de un cruzamiento - Fecha de ingreso = fecha de cruzamiento';
                $semilla->save();

                
            }
*/            
         return response()->json();
    }

    public function importForm(){
        return view('admin.cruzamientos.import');
    }
 
    public function import(Request $request)
    {
        $import = new CruzamientosImport();
        Excel::import($import, request()->file('cruzamientos'));
        return view('admin.cruzamientos.import', ['numRows'=>$import->getRowCount()]);
    }

    // Obtener cruzamientos segun la campania elegida
    public function getCruzamientos(Request $request){
        $cruzamientos = Cruzamiento::has('semilla')->where('idcampania', $request->campania)->whereNotNull('idmadre')->where('idpadre', '<>', 'idmadre')
        ->with('madre')->with('padre')->get();

        return response()->json($cruzamientos);
    }

    private function getUltimoCruzamiento($campania){
        $ultimoCruzamiento = Cruzamiento::where('idcampania', $campania)->orderByDesc('cruza')->first();
        return $ultimoCruzamiento ? $ultimoCruzamiento->cruza : 0;
    }

    private function crearEncabezadoYDetalleCruzamiento($tipoCruzamiento, $cruza, $cubiculo, $fechaCruzamiento, $campania, $padres, $madres, $edicion = false, $created_at = null){
        $madresCantidad = count($madres);
        $padresCantidad = count($padres);

        ///// Creacion de la cabecera del cruzamiento y detalle - PADRE /////
        // Cabecera
        $cruzamiento = new Cruzamiento;
        $cruzamiento->tipocruzamiento = $tipoCruzamiento;
        $cruzamiento->cruza = $cruza;
        $cruzamiento->cubiculo = $cubiculo;
        $cruzamiento->fechacruzamiento = $fechaCruzamiento;
        if ($tipoCruzamiento == "Policruzamiento") {
            $cruzamiento->idpadre = null;
            $cruzamiento->idmadre = null;
        }
        else {
            $cruzamiento->idpadre = $padres[0]->idTacho;
            $cruzamiento->idmadre = $padres[0]->idTacho;
        }
        $cruzamiento->estado = 1;
        $cruzamiento->idcampania = $campania;
        if($edicion)
            $cruzamiento->created_at = $created_at;
        $cruzamiento->save(); 
        
        $cruza += 1;

        // Chequear si el numero de cruza ya existe. Se debe hacer este chequeo ya que cuando se edita puede ser que se agreguen
        // mas registros de los que originalmente tenia el cruzamiento, por lo tanto si me quede sin lugar en el "hueco" que se elimino
        // del cruzamiento original, entonces continuo con el proximo nro de cruza disponible
        if (Cruzamiento::where('cruza', $cruza)->where('idcampania', $campania)->exists())
            $cruza = DB::table('cruzamientos')->where('idcampania', $campania)->orderByDesc('cruza')->value('cruza');

        // Detalle
        for ($i=0; $i<$padresCantidad; $i++) {
            $talloCruzamiento = new TalloCruzamiento;
            $talloCruzamiento->idtallo = $padres[$i]->id;
            $talloCruzamiento->idcruzamiento = $cruzamiento->id;
            $talloCruzamiento->save();
        }
        ////////////////////////////////////////////////////////////////////


        ///// Creacion de la cabecera del cruzamiento y detalle - MADRE /////
        $tachoId = 0;

        for($i=0; $i<$madresCantidad; $i++) {
            $tachomadre = $madres[$i]->idTacho;

            if ($tachoId != $tachomadre) { 
                // Cabecera
                $cruzamiento = new Cruzamiento;
                $cruzamiento->tipocruzamiento = $tipoCruzamiento;
                $cruzamiento->cruza = $cruza;
                $cruzamiento->cubiculo = $cubiculo;
                $cruzamiento->fechacruzamiento = $fechaCruzamiento;

                if ($tipoCruzamiento == "Biparental")
                    $cruzamiento->idpadre = $padres[0]->idTacho;
                else
                    $cruzamiento->idpadre = null;

                $cruzamiento->idmadre = $tachomadre;
                $cruzamiento->estado = 1;
                $cruzamiento->idcampania = $campania;
                if($edicion)
                    $cruzamiento->created_at = $created_at;
                $cruzamiento->save(); 
                $tachoId = ($cruzamiento->idmadre);
                $cruza += 1; 

                // Se hace el mismo control sobre cruza que en el padre. La explicacion del por que esta arriba
                if (Cruzamiento::where('cruza', $cruza)->where('idcampania', $campania)->exists())
                    $cruza = DB::table('cruzamientos')->where('idcampania', $campania)->orderByDesc('cruza')->value('cruza');
            }
            
            // Detalle
            if ($cruzamiento->id != null) {
                $talloCruzamiento = new TalloCruzamiento;
                $talloCruzamiento->idtallomadre = $madres[$i]->id;
                $talloCruzamiento->idcruzamiento = $cruzamiento->id;
                $talloCruzamiento->save();
            }          
        } 
        ////////////////////////////////////////////////////////////////////
    }

    private function actualizarTallosMadreYPadre($tipoCruzamiento, $datosTallosMadre, $datosTallosPadre, $polenpadre0, $talloPadre){
        // Actualizacion Tallos Madre
        $tallosMadre = json_decode($datosTallosMadre);
        $cantidadTallosMadre = $tallosMadre ? count($tallosMadre) : 0;

        for($i=0 ; $i<$cantidadTallosMadre; $i++) {
            if ($tallosMadre[$i]->polen == "") {
                $polen = null;
            } else {
                $polen = $tallosMadre[$i]->polen;
            }
            $talloUpdate = Tallo::findOrFail($tallosMadre[$i]->talloId)->update([
                'polen' => $polen,
                'enmasculado' => $tallosMadre[$i]->enmasculado
            ]);
        }

         // Actualizacion Tallos Padre
        if ($tipoCruzamiento == "Biparental") {
            if ($polenpadre0 == "") {
                $polen = null;
            } else {
                $polen = $polenpadre0;
            }
            $talloUpdate = Tallo::findOrFail($talloPadre)->update([
                'polen' => $polen
            ]);
        }else {   
            $tallosPadre = json_decode($datosTallosPadre);
            $cantidadTallosPadre = $tallosPadre ? count($tallosPadre) : 0;

            for($i=0 ; $i<$cantidadTallosPadre; $i++) {
                if ($tallosPadre[$i]->polen == "") {
                    $polen = null;
                } else {
                    $polen = $tallosPadre[$i]->polen;
                }
                $talloUpdate = Tallo::findOrFail($tallosPadre[$i]->talloId)->update([
                    'polen' => $polen,
                ]);
            }
        }  
    }
}
