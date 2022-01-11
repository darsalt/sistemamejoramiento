<?php

namespace App\Http\Controllers;

use App\BoxImportacion;
use App\CampaniaCuarentena;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Inspeccion;
use App\Tacho;

use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\InspeccionFormRequest;
use DB;
use App\Exports\InspeccionsExport;
use Maatwebsite\Excel\Facades\Excel;
use storage;


class InspeccionController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $inspecciones = Inspeccion::where('estado', 1)->paginate(10);

        return view('admin.inspecciones.index', compact('inspecciones'));        
    }

    public function create(){   
        $campanias = CampaniaCuarentena::where('estado', 1)->get();
        $boxes = BoxImportacion::where('activo', 1)->get();
        
    	return view('admin.inspecciones.create', compact('campanias', 'boxes'));
    }

    public function store(InspeccionFormRequest $request)
    {
        $inspeccion = new Inspeccion();

        $inspeccion->fechainspeccion = $request->fecha;
        $inspeccion->idbox = $request->box;
        $inspeccion->idcampania = $request->campania;
        $inspeccion->observaciones = $request->observaciones;
        $inspeccion->save();

        $archivo = $request->certificado;
        $nombre = 'Certificado_' . $inspeccion->idinspeccion . '.' . $archivo->extension();
        $request->certificado->move(public_path('/certificados'), $nombre);
        $inspeccion->certificado = $nombre;
        $inspeccion->update();

        return redirect()->route('importaciones.inspecciones.index');
    }

    public function show($id)
    {
    	return view("admin.inspecciones.show",["inspeccion"=>Inspeccion::findOrFail($id)]);
    }

     public function edit(Inspeccion $inspeccion)
    {
        $variedades = DB::table('variedades as v')
        ->select('v.idvariedad','v.nombre')
            //->where('v.estado','=','0')
        ->get();
        $estados = array(
            1 => 'Libre',
            2 => 'Ocupado',
            3 => 'Baja',
        );
        return view('admin.inspecciones.edit',compact('inspeccion'),["variedades"=>$variedades,"estados"=>$estados]);
    }

    public function update(InspeccionFormRequest $request,$id)
    {
        $inspeccion=Inspeccion::findOrFail($id);
        $inspeccion->codigo=$request->get('codigo');
        $inspeccion->subcodigo=$request->get('subcodigo');
        $inspeccion->fechaalta=$request->get('fechaalta');
        $inspeccion->idvariedad=$request->get('idvariedad');
        $inspeccion->observaciones=$request->get('observaciones');
        if($request->get('idvariedad')==0){
           $inspeccion->estado='libre';
        }
        else{
            $inspeccion->estado='ocupado';
        }
        //$inspeccion->estado=$request->get('estado');

        $inspeccion->update();
        return Redirect::to('admin/inspecciones');
    }

    public function destroy($id)
    {
    	$inspeccion=Inspeccion::findOrFail($id);
    	$inspeccion->estado = 0;
      	$inspeccion->update();
        
          return redirect()->route('importaciones.inspecciones.index');
    }


    public function export() 
    {
        return Excel::download(new InspeccionsExport, 'inspecciones.xlsx');
    }

    public function BuscarVariedadConIdInspeccion($id)
    {
        $variedad=DB::table('inspecciones as t')
        ->leftjoin('variedades as v','t.idvariedad','=','v.idvariedad')
            ->select('v.idvariedad','v.nombre')
            ->where('t.idinspeccion','=',$id)
            ->get();

        return response()->json($variedad);
    }
}
