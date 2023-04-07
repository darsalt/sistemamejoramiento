<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Campania;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\CampaniaFormRequest;
use DB;
use App\Exports\CampaniasExport;
use Maatwebsite\Excel\Facades\Excel;

class CampaniaController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
    	if($request){
    		$query=trim($request->get('searchText'));
    		$campanias=DB::table('campanias as t')
            ->select('t.*')
            ->where ('nombre','like','%'.$query.'%') 
    		->where ('t.estado','=',1)
    		->orderBy('nombre','desc')
    		->paginate('10');
    		return view('admin.campanias.index',["campanias"=>$campanias,"searchText"=>$query]);
    	}
    }

    public function create()
    {           
    	return view ("admin.campanias.create");
    }

    public function store(CampaniaFormRequest $request)
    {
            $campania=new Campania;
            $campania->nombre=$request->get('nombre');
            $campania->fechainicio=$request->get('fechainicio');
            $campania->fechafin=$request->get('fechafin');
            $campania->comentarios=$request->get('comentarios');
            $campania->cruza=0;
            $campania->cubiculo=0;

            $campania->vigente=1;
            $campania->estado=1;

            $campania->save();

            // Asociar un tratamiento (ninguno) a las cámaras para esa campaña
            DB::table('campaniacamaratratamientoubicacion')->insert(['idcamara' => '1','idtratamiento' => '1', 'idcampania' => $campania->id]);
            DB::table('campaniacamaratratamientoubicacion')->insert(['idcamara' => '2','idtratamiento' => '1', 'idcampania' => $campania->id]);
            DB::table('campaniacamaratratamientoubicacion')->insert(['idcamara' => '3','idtratamiento' => '1', 'idcampania' => $campania->id]);
            DB::table('campaniacamaratratamientoubicacion')->insert(['idcamara' => '4','idtratamiento' => '1', 'idcampania' => $campania->id]);
            DB::table('campaniacamaratratamientoubicacion')->insert(['idcamara' => '5','idtratamiento' => '1', 'idcampania' => $campania->id]);
            DB::table('campaniacamaratratamientoubicacion')->insert(['idcamara' => '6','idtratamiento' => '1', 'idcampania' => $campania->id]);
            // //Camara 1
            // for($i=3; $i < 99; $i++) {
            //     DB::table('ubicaciontachoxcampania')->insert(['idubicacion' => $i,'idtacho' => null, 'idcctu' => '1']);
            // }
            // //Camara 2
            // for($i=99; $i < 195; $i++) {
            //     DB::table('ubicaciontachoxcampania')->insert(['idubicacion' => $i,'idtacho' => null, 'idcctu' => '2']);
            // }
            // //Camara 3
            // for($i=195; $i < 291; $i++) {
            //     DB::table('ubicaciontachoxcampania')->insert(['idubicacion' => $i,'idtacho' => null, 'idcctu' => '3']);
            // }
            // for($i=291; $i < 386; $i++) {
            //     DB::table('ubicaciontachoxcampania')->insert(['idubicacion' => $i,'idtacho' => null, 'idcctu' => '5']);
            // }
            // for($i=387; $i < 530; $i++) {
            //     DB::table('ubicaciontachoxcampania')->insert(['idubicacion' => $i,'idtacho' => null, 'idcctu' => '5']);
            // }

            $tachos = DB::table('tachos')->where('inactivo', 0)->where('destino', 1)->get();
            foreach($tachos as $tacho){
                // Asociar a los tachos activos y con destino 'tachos de progenitores' la campaña recien creada
                DB::table('tachos_campanias')->insert(['idtacho' => $tacho->idtacho, 'idcampania' => $campania->id]);
                // Asociar los tachos de la campaña a la ubicacion piletones (despues pasan a las zorras)
                DB::table('ubicaciontachoxcampania')->insert(['idubicacion' => '531','idtacho' => $tacho->idtacho, 'idcctu' => $campania->id*6]);
            }


    	return Redirect::to('admin/campanias');
    }

    public function show($id)
    {
    	return view("admin.campanias.show",["campania"=>Campania::findOrFail($id)]);
    }

     public function edit(Campania $campania)
    {
            return view('admin.campanias.edit',compact('campania'));
    }

    public function update(CampaniaFormRequest $request,$id)
    {
        $campania=Campania::findOrFail($id);
        $campania->nombre=$request->get('nombre');
        $campania->comentarios=$request->get('comentarios');
        $campania->fechainicio=$request->get('fechainicio');
        $campania->fechafin=$request->get('fechafin');
        //$campania->vigente=$request->get('estado');

       // $campania->estado=$request->get('estado');

        $campania->update();
        return Redirect::to('admin/campanias');
    }

    public function destroy($id)
    {
    	$campania=Campania::findOrFail($id);
    	$campania->estado='0';//baja
      	$campania->update();
    	return Redirect::to('admin/campanias');
    }


     public function export() 
     {
         return Excel::download(new CampaniasExport, 'campanias.xlsx');
     }


}
