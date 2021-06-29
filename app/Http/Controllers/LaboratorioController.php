<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Laboratorio;
use App\DatoLaboratorio;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\LaboratorioFormRequest;
use DB;
//use App\Exports\laboratorioExport;
use Maatwebsite\Excel\Facades\Excel;

class LaboratorioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
    	if($request){
    		$query=trim($request->get('searchText'));

    		$laboratorios=DB::table('laboratorios as a')->where ('t.nombre','like','%'.$query.'%') 
            ->select('a.id','b.nombre as banco','a.idnombre','t.nombre','a.fechageneracion','a.observaciones')
            ->leftjoin('bancos as b','b.idbanco','=','a.idbanco')
            ->leftjoin('tiposlaboratorios as t','t.id','=','a.idnombre')
    		->where ('a.estado','=',1)
    		->orderBy('id','desc')
    		->paginate('10');

    		return view('admin.bancos.laboratorios.index',["laboratorios"=>$laboratorios,"searchText"=>$query]);
    	}
    }

    public function create()
    {

        $variedades=DB::table('variedades')
        ->where ('estado','=',1)
        ->count();
        //dd($variedades);

        $tipos=DB::table('tiposlaboratorios')
        ->where ('estado','=',1)
        ->get();

        $bancos=DB::table('bancos')
        ->select('idbanco','nombre')
        ->where ('estado','=',1)
        ->orderBy('idbanco','desc')
        ->first();

    	return view ("admin.bancos.laboratorios.create",["variedades"=>$variedades,"bancos"=>$bancos,"tipos"=>$tipos]);
    }

    public function store(LaboratorioFormRequest $request)
    {

    	$laboratorio=new Laboratorio;
    	$laboratorio->idbanco=$request->get('idbanco');
        $laboratorio->idnombre=$request->get('idnombre');
        $laboratorio->fechageneracion=$request->get('fechageneracion');
        $laboratorio->observaciones=$request->get('observaciones');
    	$laboratorio->estado='1';
    	$laboratorio->save();

        $key = $laboratorio->id;

        $variedadesbanco=DB::table('variedadesbanco as v')
        ->select('id','idbanco','tabla','tablita','surco','parcela','va.nombre as nombrevariedad','testigo')
        ->leftjoin('variedades as va','va.idvariedad','=','v.idvariedad')
        ->where ('v.idbanco','=',$request->get('idbanco'))
        ->where ('v.estado','=',1)
        ->get();
        $array = [];

             foreach ($variedadesbanco as $vb){
                        // $datoslaboratorio=new DatoLaboratorio;
                        // $datoslaboratorio->idevaluacion=$laboratorio->id;
                        // $datoslaboratorio->idbanco=$vb->idbanco;
                        // $datoslaboratorio->idubicacion=$vb->id;
                        // $datoslaboratorio->pesomuestra=0;
                        // $datoslaboratorio->pesojugo=0;
                        // $datoslaboratorio->brix=0;
                        // $datoslaboratorio->polarizacion=0;
                        // $datoslaboratorio->temperatura=0;
                        // $datoslaboratorio->brixcorregido=0;
                        // $datoslaboratorio->polenjugo=0;
                        // $datoslaboratorio->pureza=0;
                        // $datoslaboratorio->rendimientoprobable=0;
                        // $datoslaboratorio->polencana=0;

                        // $datoslaboratorio->save();
            $array []= array("idevaluacion" => $key, "idbanco" => $vb->idbanco,"idubicacion"=> $vb->id);

                    }

       DB::table('datoslaboratorios')->insert($array);


    	return Redirect::to('bancos/laboratorios');



    }

    public function show($id)
    {
    	return view("admin.bancos.laboratorios.show",["Laboratorio"=>Laboratorio::findOrFail($id)]);
    }

     public function edit(Laboratorio $laboratorio)
    {
        $tipos=DB::table('tiposlaboratorios')
        ->where ('estado','=',1)
        ->get();

        $laboratorio=DB::table('laboratorios as a')
        ->select('a.id as idlaboratorio','a.idnombre','t.nombre','a.fechageneracion','a.observaciones','b.idbanco','b.nombre as nombrebanco')
        ->leftjoin('bancos as b','b.idbanco','=','a.idbanco')
        ->leftjoin('tiposlaboratorios as t','t.id','=','a.idnombre')
        ->where ('a.id','=',$laboratorio->id)
        ->where ('a.estado','=',1)
        ->first();
        //dd($laboratorio);
        return view('admin.bancos.laboratorios.edit',compact('laboratorio'),["laboratorio"=>$laboratorio,"tipos"=>$tipos]);

    }

    public function view(Laboratorio $laboratorio)
    {
        return view('admin.banco.laboratorios.view',compact('laboratorio'));
    }

    public function update(LaboratorioFormRequest $request,$id)
    {
        $laboratorio=Laboratorio::findOrFail($id);
        $laboratorio->idnombre=$request->get('idnombre');
        $laboratorio->fechageneracion=$request->get('fechageneracion');
        $laboratorio->observaciones=$request->get('observaciones');
        $laboratorio->estado=1;//$request->get('estado');

        $laboratorio->update();
        return Redirect::to('admin/laboratorios');
    }

    public function destroy($id)
    {
    	$laboratorio=Laboratorio::findOrFail($id);
    	$laboratorio->estado='0';//baja
      	$laboratorio->update();
    	return Redirect::to('admin/laboratorios');
    }


    public function export() 
    {

        return Excel::download(new bancosExport, 'bancos.xlsx');
    }

    public function ubicacionesasociadas(Request $request,$id)
    {
        // $banco=Banco::findOrFail($id);


        // $ubicacionesasociadas=DB::table('variedadesbanco as e')
        // ->select('e.id','e.idbanco','e.tabla','e.tablita','e.surco','e.parcela','v.nombre')
        // ->leftjoin('variedades as v','v.idvariedad','=','e.idvariedad')
        // ->where ('e.idbanco','=',$id)
        // ->orderBy('e.id','asc')
        // ->get();

        $datosasociados=DB::table('datoslaboratorios as d')
        ->select('vb.*','d.*','v.idvariedad','v.nombre as nombrevariedad')
 //       ->select('d.*')
        ->join('bancos as b','b.idbanco','=','d.idbanco')
        ->join('laboratorios as a','a.id','=','d.idevaluacion')
        ->join('variedadesbanco as vb','vb.id','=','d.idubicacion')
        ->leftjoin('variedades as v','v.idvariedad','=','vb.idvariedad')
        ->where ('d.idevaluacion','=',$id)
        ->orderBy('d.id','asc')
        ->paginate('100');


        $data = '';


        if ($request->ajax()) {
            $data .= '<div class="table-responsive"><table id="datoslaboratorios" class="table table-striped table-bordered table-condensed table-hover">';
            $data .= '<thead><th>T.</th><th><div class="sizem">Tabla Tablita Surco Parcela</div></th><th><div class="sizep">Variedad</div></th><th><div class="sizem">Peso muestra</div></th><th><div class="sizem">Peso jugo</div></th><th><div class="sizem">Brix</div></th><th><div class="sizem">Polarización</div></th><th><div class="sizem">Temperatura</div></th><th><div class="sizem">Conductividad eléctrica</div></th><th><div class="sizep">Brix corregido</div></th><th><div class="sizep">Pol en jugo</div></th><th><div class="sizep">Pureza</div></th><th><div class="sizep">Rendimiento probable</div></th><th><div class="sizep">Pol en caña</div></th></thead>';

            foreach ($datosasociados as $datos) {
                if ($datos->testigo==1) 
                    $t='value = 1 checked';
                else
                    $t='value = 0';
                $data.='<tr>';
                $data.='<td><input type="checkbox" name="t" id="t" '.$t.'  disabled> </td>';
                $data.='<td><label for="tabla">'.$datos->tabla.'-'.$datos->tablita.'-'.$datos->surco.'-'.$datos->parcela.'</label></td>';
                $data.='<td width=9%><label for="tabla">'.$datos->nombrevariedad.'</label></td>';

                $data.='<td><input type="text" name="pm'.$datos->id.'" id="pm'.$datos->id.'"class="form-control" value="'.$datos->pesomuestra.'"></td>';
                $data.='<td><input type="text" name="pj'.$datos->id.'" id="pj'.$datos->id.'"class="form-control" value="'.$datos->pesojugo.'"></td>';
                $data.='<td><input type="text" name="b'.$datos->id.'" id="b'.$datos->id.'"class="form-control" value="'.$datos->brix.'"></td>';
                $data.='<td><input type="text" name="p'.$datos->id.'" id="p'.$datos->id.'"class="form-control" value="'.$datos->polarizacion.'"></td>';
                $data.='<td width=10%><input type="text" name="t'.$datos->id.'" id="t'.$datos->id.'"class="form-control" value="'.$datos->temperatura.'"></td>';
                $data.='<td width=10%><input type="text" name="c'.$datos->id.'" id="c'.$datos->id.'"class="form-control" value="'.$datos->conductividad.'" onblur="guardavariedad(this.name)"></td>';
                $data.='<td><label for="tabla">'.$datos->brixcorregido.'</label></td>';
                $data.='<td><label for="tabla">'.$datos->polenjugo.'</label></td>';
                $data.='<td><label for="tabla">'.$datos->pureza.'</label></td>';
                $data.='<td><label for="tabla">'.$datos->rendimientoprobable.'</label></td>';
                $data.='<td><label for="tabla">'.$datos->polencana.'</label></td>';
                $data.='</tr>';

            }
            $data.='</table></div>';

            return $data;
        }



        //dd($bancos1);

        return view("admin.bancos.ubicaciones.ubicaciones",compact("banco"),["banco"=>$banco,"ubicacionesasociadas"=>$ubicacionesasociadas]);

        //return Redirect::to('admin/importaciones/inspecciones/'.$request->get('idimportacion').'/');


    }

    public function datosasociados($id)
    {
        $laboratorio=Laboratorio::findOrFail($id);



        $datosasociados=DB::table('datoslaboratorios as d')
        ->select('vb.*','d.*','v.idvariedad','v.nombre as nombrevariedad')
 //       ->select('d.*')
        ->join('bancos as b','b.idbanco','=','d.idbanco')
        ->join('laboratorios as a','a.id','=','d.idevaluacion')
        ->join('variedadesbanco as vb','vb.id','=','d.idubicacion')
        ->leftjoin('variedades as v','v.idvariedad','=','vb.idvariedad')
        ->where ('d.idevaluacion','=',$id)
        ->orderBy('d.id','asc')
        ->get();


    //dd($datosasociados);


        return view("admin.bancos.laboratorios.datos.datos",compact("laboratorio"),["laboratorio"=>$laboratorio,"datosasociados"=>$datosasociados]);
        //return Redirect::to('admin/importaciones/inspecciones/'.$request->get('idimportacion').'/');


    }

    public function editardatos(LaboratorioFormRequest $request,$id)
    {
        $datoslaboratorio=DB::table('datoslaboratorios')
        ->select('id')
        ->where ('idevaluacion','=',$request->get('idevaluacion'))
        ->get();

        foreach ($datoslaboratorio as $d){
            $pm=$request->get('pm'.$d->id);
            $pj=$request->get('pj'.$d->id);
            $b=$request->get('b'.$d->id);
            $p=$request->get('p'.$d->id);
            $t=$request->get('t'.$d->id);
            $c=$request->get('c'.$d->id);
            if($t<20)
                $bc=+$b-(((20-$p)*((0.00082*$t)+0.042))-(((20-$t)/50)*(20-$t)/50));
             // +AK5-(((20-AL5)*((0,00082*AM5)+0,042))-(((20-AM5)/50)*(20-AM5)/50));
            else
                $bc=((($t-20)*0.06))+((($t-20)*($t-20)*($b/15)*0.000615)+$b);
             //(((AM5-20)*0,06))+(((AM5-20)*(AM5-20))*(AK5/15)*0,000615)+AK5)
            $pol=($p*0.26)/((((1.00037)+(0.0038*$b))+(((0.00001625*($b*$b)))))*0.99823);
            //=(AL5*0,26)/((((1,00037)+(0,0038*AK5))+(((0,00001625*(AK5*AK5)))))*0,99823)

            $datolaboratorio=DatoLaboratorio::findOrFail($d->id);
            $datolaboratorio->pesomuestra=$pm;
            $datolaboratorio->pesojugo=$pj;
            $datolaboratorio->brix=$b;
            $datolaboratorio->polarizacion=$p;
            $datolaboratorio->temperatura=$t;
            $datolaboratorio->conductividad=$c;
            $datolaboratorio->brixcorregido=$bc;
            $datolaboratorio->polenjugo=$pol;
            if($bc>0){
            $datolaboratorio->pureza=$pol/$bc*100;//=+AO5/AN5*100
            $datolaboratorio->rendimientoprobable=+$pol*((1.4-(40/($pol/$bc*100)))*0.65);//=+AO5*((1,4-(40/AP5))*0,65)
            }
            $datolaboratorio->polencana=$pol*0.82;//=AO5*0,82
            
         //   dd($datolaboratorio);
            $datolaboratorio->update();
        }



        return Redirect::to('bancos/laboratorios');

    }

    public function updateEvaluacionPost(Request $request)
    {
                $input = $request->all();
        \Log::info($input);
            $pm=$request->get('pesomuestra');
            $pj=$request->get('pesojugo');
            $b=$request->get('brix');
            $p=$request->get('polarizacion');
            $t=$request->get('temperatura');
            $c=$request->get('conductividad');
            if($t<20)
                $bc=+$b-(((20-$p)*((0.00082*$t)+0.042))-(((20-$t)/50)*(20-$t)/50));
             // +AK5-(((20-AL5)*((0,00082*AM5)+0,042))-(((20-AM5)/50)*(20-AM5)/50));
            else
                $bc=((($t-20)*0.06))+((($t-20)*($t-20)*($b/15)*0.000615)+$b);
             //(((AM5-20)*0,06))+(((AM5-20)*(AM5-20))*(AK5/15)*0,000615)+AK5)
            $pol=($p*0.26)/((((1.00037)+(0.0038*$b))+(((0.00001625*($b*$b)))))*0.99823);
            //=(AL5*0,26)/((((1,00037)+(0,0038*AK5))+(((0,00001625*(AK5*AK5)))))*0,99823)

            $datolaboratorio=DatoLaboratorio::findOrFail($request->get('id'));
            $datolaboratorio->pesomuestra=$pm;
            $datolaboratorio->pesojugo=$pj;
            $datolaboratorio->brix=$b;
            $datolaboratorio->polarizacion=$p;
            $datolaboratorio->temperatura=$t;
            $datolaboratorio->conductividad=$c;
            $datolaboratorio->brixcorregido=$bc;
            $datolaboratorio->polenjugo=$pol;
            if($bc>0){
            $datolaboratorio->pureza=$pol/$bc*100;//=+AO5/AN5*100
            $datolaboratorio->rendimientoprobable=+$pol*((1.4-(40/($pol/$bc*100)))*0.65);//=+AO5*((1,4-(40/AP5))*0,65)
            }
            $datolaboratorio->polencana=$pol*0.82;//=AO5*0,82
            
         //   dd($datolaboratorio);
            $datolaboratorio->update();
        return response()->json();
    }

}
