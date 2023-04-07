<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Agronomica;
use App\DatoAgronomico;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\AgronomicaFormRequest;
use DB;
//use App\Exports\agronomicaExport;
use Maatwebsite\Excel\Facades\Excel;

class DatoAgronomicoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        dd("ss");

    }

    public function create()
    {


    }

    public function store(AgronomicaFormRequest $request)
    {
        $datosagronomica=DB::table('datosagronomicos')
        ->select('id')
        ->where ('idevaluacion','=',$request->get('idevaluacion'))
        ->get();

        foreach ($datosagronomica as $d){

            $datoagronomico=DatoAgronomico::findOrFail($d->id);
            $datoagronomico->tallos=$request->get('t'.$d->id);
            $datoagronomico->altura=$request->get('a'.$d->id);
            $datoagronomico->grosor=$request->get('g'.$d->id);
            $datoagronomico->vuelco=$request->get('v'.$d->id);
            $datoagronomico->floracion=$request->get('f'.$d->id);
            $datoagronomico->otra=$request->get('o'.$d->id);


         //   dd($datoagronomico);
            $datoagronomico->update();
        }



        return Redirect::to('bancos/agronomicas');


    }

    public function show($id)
    {

    }

     public function edit(Agronomica $agronomica)
    {
        dd("svvs");


    }

    public function view(Agronomica $agronomica)
    {
    }

    public function update(AgronomicaFormRequest $request,$id)
    {
        dd("ss");
        $agronomica=Agronomica::findOrFail($id);
        $agronomica->nombre=$request->get('nombre');
        $agronomica->fechageneracion=$request->get('fechageneracion');
        $agronomica->observaciones=$request->get('observaciones');
        $agronomica->estado=1;//$request->get('estado');

        $agronomica->update();
        return Redirect::to('admin/agronomicas');
    }

    public function destroy($id)
    {
 
    }


    public function export() 
    {

        return Excel::download(new bancosExport, 'bancos.xlsx');
    }

    public function ubicacionesasociadas(Request $request,$id)
    {
        $banco=Banco::findOrFail($id);


        $ubicacionesasociadas=DB::table('variedadesbanco as e')
        ->select('e.id','e.idbanco','e.tabla','e.tablita','e.surco','e.parcela','v.nombre')
        ->leftjoin('variedades as v','v.idvariedad','=','e.idvariedad')
        ->where ('e.idbanco','=',$id)
        ->orderBy('e.id','asc')
        ->get();




        //dd($bancos1);

        return view("admin.bancos.ubicaciones.ubicaciones",compact("banco"),["banco"=>$banco,"ubicacionesasociadas"=>$ubicacionesasociadas]);
        //return Redirect::to('admin/importaciones/inspecciones/'.$request->get('idimportacion').'/');


    }

    public function datosasociados($id)
    {
        $agronomica=Agronomica::findOrFail($id);



        $datosasociados=DB::table('datosagronomicos as d')
        ->select('vb.*','d.*','v.idvariedad','v.nombre as nombrevariedad')
        ->join('bancos as b','b.idbanco','=','d.idbanco')
        ->join('agronomicas as a','a.id','=','d.idevaluacion')
        ->leftjoin('variedadesbanco as vb','vb.id','=','d.idubicacion')
        ->join('variedades as v','v.idvariedad','=','v.idvariedad')
        ->where ('d.idevaluacion','=',$id)
        ->orderBy('d.id','asc')
        ->get();


    //dd($datosasociados);


        return view("admin.bancos.agronomicas.datos.datos",compact("agronomica"),["agronomica"=>$agronomica,"datosasociados"=>$datosasociados]);
        //return Redirect::to('admin/importaciones/inspecciones/'.$request->get('idimportacion').'/');


    }

}
