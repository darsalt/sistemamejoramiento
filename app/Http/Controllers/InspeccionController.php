<?php

namespace App\Http\Controllers;

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
    	if($request){
    		$query=trim($request->get('searchText'));
    		$inspecciones=DB::table('inspecciones as t')
            ->leftjoin('variedades as v','t.idvariedad','=','v.idvariedad')
            ->select('t.*', 'v.nombre as nombrevariedad')
            ->where ('codigo','like','%'.$query.'%') 
    		//->where ('activo','=',1)
    		->orderBy('idinspeccion','asc')
    		->paginate('3');
    		return view('admin.inspecciones.index',["inspecciones"=>$inspecciones,"searchText"=>$query]);
    	}
    }

    public function create()
    {   //mando todas las variedades
        $variedades = DB::table('variedades as v')
            ->select('v.idvariedad','v.nombre')
            //->where('v.estado','=','0')
            ->get();
        
    	return view ("admin.inspecciones.create",["variedades"=>$variedades]);
    }

    public function store(InspeccionFormRequest $request)
    {
       // dd($request);
    if($request->get('portacho')==1){
        $inspeccion=new Inspeccion;
        $inspeccion->fechainspeccion=$request->get('fechainspeccion');
        $inspeccion->certificado=$request->get('certificado');
        $inspeccion->idimportacion=$request->get('idimportacion');
        $inspeccion->observaciones=$request->get('observaciones');
        // $exportacion->estado='1'; // continua en la cuarentena
        $inspeccion->save();
        $id = $inspeccion->idinspeccion;



        if($request->certificado){
            $archivo = $request->certificado;
            $nombre = 'Certificado'.$id.'.pdf';
            $request->certificado->move(public_path('/certificados'), $nombre);
            $inspeccion->certificado = $nombre;
            $inspeccion->update();
        }
        //return Redirect::to('admin/inspeccion');
        return Redirect::to('admin/importaciones/inspecciones/'.$request->get('idimportacion').'/');
    }else{
            $tachos = DB::table('tachos as t')
            ->join('importaciones as i','t.idtacho','=','i.idtacho')
            ->select('t.idtacho',DB::raw('CONCAT(codigo,"-",subcodigo) as nombretacho'),'t.idubicacion','impo','idimportacion')
            ->where('i.idubicacion','=',$request->get('idubicacion'))
            ->get();
          //  dd(count($tachos));
            $cont=0;
            while($cont<count($tachos)){

                $tacho=Tacho::findOrFail($tachos[$cont]->idtacho);

                $inspeccion=new Inspeccion;
               // $inspeccion->idexportacion=$tachos[$cont]->idexportacion;
                $inspeccion->idimportacion=$tachos[$cont]->idimportacion;
               // $inspeccion->idtacho=$tacho->idtacho;
               // $inspeccion->idvariedad=$tacho->idvariedad;
               
                $inspeccion->fechainspeccion=$request->get('fechainspeccion');
                $inspeccion->observaciones=$request->get('observaciones');
                $inspeccion->save();
                $id = $inspeccion->idinspeccion;



                if($request->certificado){
                    $archivo = $request->certificado;
                    $name = $archivo->getClientOriginalName();;
                    $inspeccion->certificado = $name;
                    $inspeccion->update();



                } 
                $cont = $cont+1;


            }

                if($request->certificado){
                    $archivo = $request->certificado;
                    $name = $archivo->getClientOriginalName();;
                    $archivo->move(public_path('/certificados'), $name);
                }
            return Redirect::to('admin/ubicacionesimpo/inspecciones/'.$request->get('idubicacion').'/'); 

        }


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
    	$inspeccion->estado='3';//baja
      	$inspeccion->update();
    	return Redirect::to('admin/inspecciones');
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
