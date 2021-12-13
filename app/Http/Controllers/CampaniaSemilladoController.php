<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\CampaniaSemillado;
use App\Semillado;
use Carbon\Carbon;

use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\CampaniaSemilladoFormRequest;
use DB;
use App\Exports\CampaniasSemilladoExport;
use Maatwebsite\Excel\Facades\Excel;

class CampaniaSemilladoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
    	if($request){
    		$query=trim($request->get('searchText'));
    		$campaniasemillado=DB::table('campaniasemillado as t')
            ->select('t.*')
            ->where ('nombre','like','%'.$query.'%') 
    		->where ('t.estado','=',1)
    		->orderBy('id','asc')
    		->paginate('10');
    		return view('admin.campaniasemillado.index',["campaniasemillado"=>$campaniasemillado,"searchText"=>$query]);
    	}
    }

    public function create()
    {           
    	return view ("admin.campaniasemillado.create");
    }

    public function store(CampaniaSemilladoFormRequest $request)
    {
            $campaniasemillado=new CampaniaSemillado;
            $campaniasemillado->nombre=$request->get('nombre');
            $campaniasemillado->fechainicio=$request->get('fechainicio');
            $campaniasemillado->fechafin=$request->get('fechafin');
            $campaniasemillado->comentarios=$request->get('comentarios');


            $campaniasemillado->vigente=1;
            $campaniasemillado->estado=1;

            $campaniasemillado->save();

    	
    	return Redirect::to('admin/campaniasemillado');
    }

    public function show($id)
    {
    	return view("admin.campaniasemillado.show",["campaniasemillado"=>CampaniaSemillado::findOrFail($id)]);
    }

     public function edit(CampaniaSemillado $campaniasemillado)
    {
            return view('admin.campaniasemillado.edit',compact('campaniasemillado'));
    }

    public function update(CampaniaSemilladoFormRequest $request,$id)
    {
        $campaniasemillado=CampaniaSemillado::findOrFail($id);
        $campaniasemillado->nombre=$request->get('nombre');
        $campaniasemillado->comentarios=$request->get('comentarios');
        $campaniasemillado->fechainicio=$request->get('fechainicio');
        $campaniasemillado->fechafin=$request->get('fechafin');
        //$campania->vigente=$request->get('estado');

       // $campania->estado=$request->get('estado');

        $campaniasemillado->update();
        return Redirect::to('admin/campaniasemillado');
    }

    public function destroy($id)
    {
    	$campaniasemillado=CampaniaSemillado::findOrFail($id);
    	$campaniasemillado->estado='0';//baja
      	$campaniasemillado->update();
    	return Redirect::to('admin/campaniasemillado');
    }


     public function export() 
     {
         return Excel::download(new CampaniasSemilladoExport, 'campaniasemillado.xlsx');
     }

     public function incluirpg()
     {
         $campaniasemillado=DB::table('campaniasemillado as c')
         ->select('c.id as idcampaniasemillado', 'c.nombre as nombrecampaniasemillado')
         ->orderBy('c.id','desc')
         ->get();
 
         $campaniacruzamiento=DB::table('campanias as c')
         ->select('c.id as idcampaniacruzamiento', 'c.nombre as nombrecampaniacruzamiento')
         ->orderBy('c.id','desc')
         ->get();
 
         return view("admin.campaniasemillado.pg",compact("campaniasemillado"),["campaniasemillado"=>$campaniasemillado, "campaniacruzamiento"=>$campaniacruzamiento]);
     }

     private function getUltimaOrden($campaniaSemillado){
        $ultimoSemillado = Semillado::where('idcampaniasemillado', $campaniaSemillado)->orderByDesc('numero')->first();

        return $ultimoSemillado ? $ultimoSemillado->numero : 0;
    }

     public function guardarpg(Request $request)
     {

        $cruzamientos=DB::table('cruzamientos as c')
            ->select('c.id')
    		->where ('c.idcampania','=',$request->get('idcampaniacruzamiento'))
    		->orderBy('c.id','asc')
            ->get();
            $numero = $this->getUltimaOrden($request->idcampaniasemillado);
            $date = Carbon::now();
        //   dd($request->get('idcampaniasemillado'));
           // $date = $date->format('d-m-Y');

            foreach ($cruzamientos as $datas) {
                $numero++;
                $semillado = new Semillado();
    
                $semillado->numero = $numero;

                $semillado->fechasemillado = $date;
                $semillado->idcampaniacruzamiento = $request->idcampaniacruzamiento;
                $semillado->idcampaniasemillado = $request->idcampaniasemillado;
                $semillado->idcruzamiento = $datas->id;
                $semillado->gramos = 0.5;
                $semillado->cajones = 0.2;
    
                $semillado->save();
            }
            $inventario=DB::table('semillados as s') 
            ->leftjoin('campanias as c','c.id','=','s.idcampaniacruzamiento')
            ->leftjoin('cruzamientos as cru','cru.id','=','s.idcruzamiento')
            ->select(DB::raw('s.idcampaniacruzamiento,c.nombre,COUNT(s.idcampaniacruzamiento) as cantidad,SUM(s.gramos) as gramos,round(SUM(s.gramos*cru.conteo),0) as plantas,SUM(2*cru.conteo) as poder,SUM(s.cajones) as cajones,SUM(s.repicadas) as repicadas'))
            ->groupBy('s.idcampaniacruzamiento')
            ->groupBy('c.nombre')
                //->orderBy('nombre','asc')
            ->paginate('10');
            return view('admin.semillados.index',["inventario"=>$inventario]);
     }

}
