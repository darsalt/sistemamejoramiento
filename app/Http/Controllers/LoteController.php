<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Lote;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\LoteFormRequest;
use DB;
use App\Exports\LotesExport;
use Maatwebsite\Excel\Facades\Excel;

class LoteController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
    	if($request){
    		$query=trim($request->get('searchText'));
    		$lotes=DB::table('lotes as l')
            ->leftjoin('tachos as t','l.idlote','=','t.idlote')
            ->select('l.idlote','l.nombrelote','l.observaciones')
            ->where ('l.estado','=','1') 
            ->where ('l.nombrelote','like','%'.$query.'%') 
    		//->where ('activo','=',1)
    		->orderBy('l.nombrelote','desc')
    		->paginate('3');

            return view('admin.lotes.index',["lotes"=>$lotes,"searchText"=>$query]);
    	}
    }

    public function create()
    {
            $variedades = DB::table('variedades as v')
            ->select('v.idvariedad','v.nombre')
            //->where('v.estado','=','1')
            ->get();

    	return view ("admin.lotes.create",["variedades"=>$variedades]);
    }

    // public function store(TareaFormRequest $request)
    // {
    // 	$tarea=new Tarea;
    //     $tarea->idtacho=$request->get('idtacho');
    //     $tarea->idvariedad=$request->get('idvariedad');
    //     $tarea->idtipotarea=$request->get('idtipotarea');
    //     $tarea->fecharealizacion=$request->get('fecharealizacion');
    //     $tarea->observaciones=$request->get('observaciones');
    // 	$tarea->idestado=$request->get('idestado');
    // 	$tarea->save();
    // 	return Redirect::to('admin/tareas');
    // }
    public function store(LoteFormRequest $request)
    {   //dd($request);
        $lote=new Lote;
        $lote->nombrelote=$request->get('nombrelote');
        $lote->observaciones=$request->get('observaciones');
        $lote->estado=1;

        $lote->save();
        return Redirect::to('admin/lotes');
    }

    public function show($id)
    {
    	return view("admin.lotes.show",["lote"=>Lote::findOrFail($id)]);
    }

     public function edit(Lote $lote)
    {
                                    dd($lote);

            $variedades = DB::table('variedades as v')
            ->select('v.idvariedad','v.nombre')
            //->where('v.estado','=','1')
            ->get();
        return view('admin.lotes.edit',compact('lote'),["variedades"=>$variedades]);
    }

    public function update(LoteFormRequest $request,$id)
    {
        $lote=Lote::findOrFail($id);
        $lote->nombrelote=$request->get('nombrelote');
        $lote->observaciones=$request->get('observaciones');

        $lote->update();
        return Redirect::to('admin/lotes');
    }

    public function destroy($id)
    {
    	$lote=Lote::findOrFail($id);
    	$lote->estado='0';//baja
      	$lote->update();
    	return Redirect::to('admin/lotes');
    }


    public function export() 
    {
        return Excel::download(new lotesExport, 'lotes.xlsx');
    }

    public function tareasasociadas($id)
    {
        //$exportacion=Exportacion::findOrFail($id);

        $lote=DB::table('lotes as l')
        //->leftjoin('tachos as t','e.idtacho','=','t.idtacho')
        //->leftjoin('variedades as v','e.idvariedad','=','v.idvariedad')
        ->select('l.idlote','l.nombrelote','l.observaciones')
        ->where ('idlote','=',$id)
        ->get();

        $tareasasociadas=DB::table('tareas as t')
        ->select('t.idtarea','tt.nombre','t.fecharealizacion','observaciones')
        ->leftjoin('tipostareas as tt','t.idtipotarea','=','tt.idtipotarea')
        ->where ('idimportacion','=',$id)
        ->orderBy('t.fecharealizacion','desc')
        ->paginate('3');


        return view("admin.lotes.tareas",compact("lote"),["lote"=>$lote,"tareasasociadas"=>$tareasasociadas]);

    }

    public function evaluacionesasociadas($id)
    {
        //$exportacion=Exportacion::findOrFail($id);

        $importacion=DB::table('importaciones as e')
        ->leftjoin('tachos as t','e.idtacho','=','t.idtacho')
        ->leftjoin('variedades as v','e.idvariedad','=','v.idvariedad')
        ->select('e.idimportacion','t.idtacho','e.idvariedad','t.codigo','t.subcodigo','v.nombre as nombrevariedad','e.idubicacion')
        ->where ('idimportacion','=',$id)
        ->get();

        $evaluacionesasociadas=DB::table('evaluaciones as e')
        ->select('e.idevaluacion','t.nombre','e.fechaevaluacion','observaciones')
        ->leftjoin('tiposevaluaciones as t','e.idtipoevaluacion','=','t.idtipoevaluacion')
        ->where ('idimportacion','=',$id)
        ->orderBy('e.fechaevaluacion','desc')
        ->paginate('3');


        return view("admin.importaciones.evaluaciones",compact("importacion"),["importacion"=>$importacion,"evaluacionesasociadas"=>$evaluacionesasociadas]);

    }
}
