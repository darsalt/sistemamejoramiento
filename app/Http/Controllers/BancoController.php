<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Banco;
use App\VariedadesBanco;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\BancoFormRequest;
use App\Http\Requests\UbicacionFormRequest; 
use App\Http\Controllers\Arr;
use DB;
use App\Exports\bancoExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Log;


class BancoController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
    	if($request){
    		$query=trim($request->get('searchText'));

    		$bancos=DB::table('bancos')->where ('nombre','like','%'.$query.'%') 
    		->where ('estado','=',1)
    		->orderBy('nombre','desc')
    		->paginate('10');




    		return view('admin.bancos.index',["bancos"=>$bancos,"searchText"=>$query]);
    	}
    }

    public function create()
    {

        $variedades=DB::table('variedades')
        ->where ('estado','=',1)
        ->count();
        //dd($variedades);

    	return view ("admin.bancos.create",["variedades"=>$variedades]);
    }

    public function store(BancoFormRequest $request)
    {

        $cant=$request->get('tablas') * $request->get('tablitas') * $request->get('surcos');
    	$banco=new Banco;
    	$banco->nombre=$request->get('nombre');
        $banco->anio=$request->get('anio');
        $banco->fechageneracion=$request->get('fechageneracion');
        $banco->tablas=$request->get('tablas');
        $banco->tablitas=$request->get('tablitas');
        $banco->surcos=$request->get('surcos');
        $banco->parcelas=$cant;
        $banco->observaciones=$request->get('observaciones');
    	$banco->estado='1';
    	$banco->save();

       // $variedades=DB::table('variedades as v')
       // ->select('v.idvariedad')
       // ->where ('estado','=',1)
       // ->get();
        $tablas=$request->get('tablas');
        $tablitas=$request->get('tablitas');
        $surcos=$request->get('surcos');

        $p=0;
        $banco=$banco->idbanco;


//Model::insert($data); // Eloquent approach
//DB::table('table')->insert($data); // Query Builder approach


$array = [];

        //for ($i = 1; $i <=$cant; $i++){
            for ($t = 1; $t <=$tablas; $t++){
                for ($ta = 1; $ta <=$tablitas; $ta++){
                    for ($s = 1; $s <=$surcos; $s++){
                        //$variedadesbanco=new VariedadesBanco;
                        //$variedadesbanco->idbanco=$banco;
                        //$variedadesbanco->tabla=$t;
                        //$variedadesbanco->tablita=$ta;
                        //$variedadesbanco->parcela=$p+1;
                        //$variedadesbanco->surco=$s;
                        //$variedadesbanco->estado='1';
                        //$variedadesbanco->save();
                        //$myArray[$p]  = $banco,$t,$ta,$p+1,$s,1;  
$array []= array("idbanco" => $banco,"tabla"=> $t,"tablita"=> $ta,"parcela"=> $p+1,"surco"=> $s,"estado"=> '1');

                        $p=$p+1;
                    }
                    $s=1;
                }
                $ta=1;
            }
            $t=1;
        //}
            DB::table('variedadesbanco')->insert($array);

    	return Redirect::to('admin/bancos');



    }

    public function show($id)
    {
    	return view("admin.bancos.show",["banco"=>Banco::findOrFail($id)]);
    }

     public function edit(Banco $banco)
    {

        return view('admin.bancos.edit',compact('banco'));
    }

    public function view(Banco $banco)
    {
        return view('admin.banco.view',compact('banco'));
    }

    public function update(BancoFormRequest $request,$id)
    {
        $banco=Banco::findOrFail($id);
        $banco->nombre=$request->get('nombre');
        $banco->anio=$request->get('anio');
        $banco->fechageneracion=$request->get('fechageneracion');
        $banco->tablas=$request->get('tablas');
        $banco->tablitas=$request->get('tablitas');
        $banco->surcos=$request->get('surcos');
        $banco->parcelas=$request->get('tablas') * $request->get('tablitas') * $request->get('surcos');
        $banco->observaciones=$request->get('observaciones');
        $banco->estado=1;
        //$request->get('estado');
        $banco->update();

        if($request->get('tablas')>$request->get('tablasant')){
            $p=$request->get('tablasant')*$request->get('tablitasant')*$request->get('surcos');
            for ($t = $request->get('tablasant')+1; $t <=$request->get('tablas'); $t++){
                for ($ta = 1; $ta <=$request->get('tablitas'); $ta++){
                    for ($s = 1; $s <=$request->get('surcos'); $s++){
                        $variedadesbanco=new VariedadesBanco;
                        $variedadesbanco->idbanco=$banco->idbanco;
                        $variedadesbanco->tabla=$t;
                        $variedadesbanco->tablita=$ta;
                        $variedadesbanco->parcela=$p+1;
                        $variedadesbanco->surco=$s;
                        if(isset($variedades[$p]->idvariedad) ){
                            $variedadesbanco->idvariedad=$variedades[$p]->idvariedad;
                        }
                        $variedadesbanco->estado='1';
                        $variedadesbanco->save();
                        $p=$p+1;
                    }
                    $s=1;
                }
                $ta=1;
            }
            $t=1;
        }
        
        if($request->get('tablitas')>$request->get('tablitasant')){
            $p=$request->get('tablas')*$request->get('tablitasant')*$request->get('surcos');
            for ($t = 1; $t <=$request->get('tablas'); $t++){
                for ($ta = $request->get('tablitasant')+1; $ta <=$request->get('tablitas'); $ta++){
                    for ($s = 1; $s <=$request->get('surcos'); $s++){
                        $variedadesbanco=new VariedadesBanco;
                        $variedadesbanco->idbanco=$banco->idbanco;
                        $variedadesbanco->tabla=$t;
                        $variedadesbanco->tablita=$ta;
                        $variedadesbanco->parcela=$p+1;
                        $variedadesbanco->surco=$s;
                        if(isset($variedades[$p]->idvariedad) ){
                            $variedadesbanco->idvariedad=$variedades[$p]->idvariedad;
                        }
                        $variedadesbanco->estado='1';
                        $variedadesbanco->save();
                        $p=$p+1;
                    }
                    $s=1;
                }
                $ta=1;
            }
            $t=1;
        }

        return Redirect::to('admin/bancos');
    }

    public function destroy($id)
    {
    	$banco=Banco::findOrFail($id);
    	$banco->estado='0';//baja
      	$banco->update();
    	return Redirect::to('admin/bancos');
    }


    public function export() 
    {

        return Excel::download(new bancosExport, 'bancos.xlsx');
    }

    public function ubicacionesasociadas(Request $request,$id)
    {
        $banco=Banco::findOrFail($id);
        $variedades = DB::table('variedades as v')
        ->select('v.idvariedad','v.nombre')
        ->where('v.estado','=','1')
  //      ->take(5)
        ->get();
     //   dd($banco);
        $ubicaciones=DB::table('variedadesbanco as e')
        ->select('e.id','e.idbanco','e.tabla','e.tablita','e.surco','e.parcela','e.testigo','v.idvariedad','v.nombre')
        ->leftjoin('variedades as v','v.idvariedad','=','e.idvariedad')
        ->where ('e.idbanco','=',$id)
        ->orderBy('e.id','asc')
        ->paginate($banco->surcos);

      return view("admin.bancos.ubicaciones.ubicaciones",compact("banco"),["banco"=>$banco,"ubicaciones"=>$ubicaciones,"variedades"=>$variedades]);

    }

    public function ubicacionesasociadasOK(Request $request,$id)
    {
       // $id = $request->input('idbanco');
        $banco=Banco::findOrFail($id);

        $variedades = DB::table('variedades as v')
        ->select('v.idvariedad','v.nombre')
        ->where('v.estado','=','1')
        ->get();

        $ubicaciones=DB::table('variedadesbanco as e')
        ->select('e.id','e.idbanco','e.tabla','e.tablita','e.surco','e.parcela','e.testigo','v.idvariedad','v.nombre')
        ->leftjoin('variedades as v','v.idvariedad','=','e.idvariedad')
        ->where ('e.idbanco','=',$id)
        ->orderBy('e.id','asc')
        ->paginate('100');


        $data = '';

        if ($request->ajax()) {
            $data .= '<div class="table-responsive"><table class="table table-striped table-bordered table-condensed table-hover">';
            $data .= '<thead><th width="15%">Testigo</th><th width="15%">Tabla</th><th width="15%">Tablita</th>
                      <th width="15%">Surco</th><th width="15%">Parcela</th><th width="25%">Variedad</th></thead>';
            foreach ($ubicaciones as $ubicacion) {
                if ($ubicacion->testigo==1) 
                    $t='value = 1 checked';
                else
                    $t='value = 0';
                $data.='<tr>';

                $data.='<td width=15%><input type="checkbox" name="t'.$ubicacion->id.'" id="t'.$ubicacion->id.'" onchange="guardatestigo(this.name,this.value)" '.$t.'> </td>';
                $data.='<td width=15%><label for="tabla">'.$ubicacion->tabla.'</label></td>';
                $data.='<td width=15%><label for="tabla">'.$ubicacion->tablita.'</label></td>';
                $data.='<td width=15%><label for="tabla">'.$ubicacion->surco.'</label></td>';
                $data.='<td width=15%><label for="tabla">'.$ubicacion->parcela.'</label></td>';
                $data.='<td width=25%><div class="form-group">';
                $data.='<select class="select2 form-control" name="'.$ubicacion->id.'" id="'.$ubicacion->id.'" style="width: 100%;"class="form-control" onchange="guardavariedad(this.name,this.value)">';
                

                $data.='<option value="0">Ninguna</option>';
                foreach ($variedades as $variedad){
                    if ($variedad->idvariedad==$ubicacion->idvariedad) 
                        $s='selected="selected"';
                    else
                        $s='';
                        $data.='<option value="'.$variedad->idvariedad.'" '.$s. '>'.$variedad->nombre.'</option>';
                }
                $data.='</select>';
                $data.='</div></td>';
                $data.='</tr>';
            }
            $data.='</table></div>';
            return $data;
        }
     //   return view('admin.bancos.ubicaciones.ubi');
        return view("admin.bancos.ubicaciones.data",compact("banco"),["banco"=>$banco,"ubicaciones"=>$ubicaciones,"variedades"=>$variedades]);




    }

    public function ubicacionesasociadasDIN(Request $request,$id)
    {
       // $id = $request->input('idbanco');
        $banco=Banco::findOrFail($id);

        $variedades = DB::table('variedades as v')
        ->select('v.idvariedad','v.nombre')
        ->where('v.estado','=','1')
        ->get();

        $ubicaciones=DB::table('variedadesbanco as e')
        ->select('e.id','e.idbanco','e.tabla','e.tablita','e.surco','e.parcela','e.testigo','v.idvariedad','v.nombre')
        ->leftjoin('variedades as v','v.idvariedad','=','e.idvariedad')
        ->where ('e.idbanco','=',$id)
        ->orderBy('e.id','asc')
        ->paginate('100');


        $data = '';

        if ($request->ajax()) {
            $data .= '<div class="table-responsive"><table class="table table-striped table-bordered table-condensed table-hover">';
            $data .= '<thead><th width="15%">Testigo</th><th width="15%">Tabla</th><th width="15%">Tablita</th>
                      <th width="15%">Surco</th><th width="15%">Parcela</th><th width="25%">Variedad</th></thead>';
            foreach ($ubicaciones as $ubicacion) {
                if ($ubicacion->testigo==1) 
                    $t='value = 1 checked';
                else
                    $t='value = 0';
                $data.='<tr>';

                $data.='<td width=15%><input type="checkbox" name="t'.$ubicacion->id.'" id="t'.$ubicacion->id.'" onchange="guardatestigo(this.name,this.value)" '.$t.'> </td>';
                $data.='<td width=15%><label for="tabla">'.$ubicacion->id.'</label></td>';
                $data.='<td width=15%><label for="tabla">'.$ubicacion->tablita.'</label></td>';
                $data.='<td width=15%><label for="tabla">'.$ubicacion->surco.'</label></td>';
                $data.='<td width=15%><label for="tabla">'.$ubicacion->parcela.'</label></td>';
                $data.='<td width=25%><div class="form-group">';
                $data.='<select class="select2 form-control" name="'.$ubicacion->id.'" id="'.$ubicacion->id.'" style="width: 100%;"class="form-control" onchange="guardavariedad(this.name,this.value)">';
                

                $data.='<option value="0">Ninguna</option>';
                foreach ($variedades as $variedad){
                    if ($variedad->idvariedad==$ubicacion->idvariedad) 
                        $s='selected="selected"';
                    else
                        $s='';
                        $data.='<option value="'.$variedad->idvariedad.'" '.$s. '>'.$variedad->nombre.'</option>';
                }
                $data.='</select>';
                $data.='</div></td>';
                $data.='</tr>';
            }
            $data.='</table></div>';
            return $data;
        }
     //   return view('admin.bancos.ubicaciones.ubi');
        return view("admin.bancos.ubicaciones.data",compact("banco"),["banco"=>$banco,"ubicaciones"=>$ubicaciones,"variedades"=>$variedades]);




    }


    public function ubicaciones(Request $request)
    {
       // $banco=Banco::findOrFail($id);


    //    $ubicaciones=DB::table('variedadesbanco as e')
    //    ->select('e.id','e.idbanco','e.tabla','e.tablita','e.surco','e.parcela','e.testigo','v.idvariedad','v.nombre')
    //    ->leftjoin('variedades as v','v.idvariedad','=','e.idvariedad')
    //    ->where ('e.idbanco','=','2')
    //    ->orderBy('e.id','asc')
    //    ->paginate('10');

        $ubicaciones = VariedadesBanco::paginate(8);
        $data = '';
        if ($request->ajax()) {
            foreach ($ubicaciones as $ubicacion) {
                $data.='<li>'.$ubicacion->id.' <strong>'.$ubicacion->idbanco.'</strong> : '.$ubicacion->idvariedad.'</li>';
            }
            return $data;
        }
        return view('admin.bancos.ubicaciones.data');
        //return view("admin.bancos.ubicaciones.ubicaciones",compact("banco"),["banco"=>$banco,"ubicacionesasociadas"=>$ubicacionesasociadas,"variedades"=>$variedades]);

       // $variedades = DB::table('variedades as v')
        //->select('v.idvariedad','v.nombre')
        //->where('v.estado','=','1')
        //->get();
        //dd($bancos1);

       // return view("admin.bancos.ubicaciones.ubicaciones",compact("banco"),["banco"=>$banco,"ubicacionesasociadas"=>$ubicacionesasociadas,"variedades"=>$variedades]);
        //return Redirect::to('admin/importaciones/inspecciones/'.$request->get('idimportacion').'/');


    }

    public function editarubicaciones(UbicacionFormRequest $request)
    {
        $id = $request->input('idbanco');
        $banco=Banco::findOrFail($id);

        dd($banco);
        $ubicacionesasociadas=DB::table('variedadesbanco as e')
        ->select('e.id','e.idbanco','e.tabla','e.tablita','e.surco','e.parcela','e.testigo','v.idvariedad','v.nombre')
        ->leftjoin('variedades as v','v.idvariedad','=','e.idvariedad')
        ->where ('e.idbanco','=',$id)
        ->orderBy('e.id','asc')
        ->get();

       // dd($ubicacionesasociadas);

        $variedades = DB::table('variedades as v')
        ->select('v.idvariedad','v.nombre')
        ->where('v.estado','=','1')
        ->get();
        foreach ($ubicacionesasociadas as $d){

            $variedadesbanco=VariedadesBanco::findOrFail($d->id);
            $checkboxValue = $request->input('t'.$d->id);
            if(isset($checkboxValue)){
                $variedadesbanco->testigo=1;
            }else{
                $variedadesbanco->testigo=0;
            }
            $variedadesbanco->idvariedad=$request->get('v'.$d->id);

            echo($request->get('t'.$d->id));
          //  dd($request);

            $variedadesbanco->update();
        }

        //return view("admin.bancos",compact("banco"));
        return Redirect::to('admin/bancos');


    }

    public function editarvariaciones()
    {

        return Redirect::to('admin/bancos');


    }


    // public function updateVariedad(Request $request,$id)
    // {
    //     return view('admin/bancos/ubicaciones/data');
    // }
   
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function updateVariedadPost(Request $request)
    {
        $input = $request->all();
            $variedadesbanco=VariedadesBanco::findOrFail($request->get('id'));
            // $checkboxValue = $request->input('t'.$d->id);
            // if(isset($checkboxValue)){
            //     $variedadesbanco->testigo=1;
            // }else{
            //     $variedadesbanco->testigo=0;
            // }
            $variedadesbanco->idvariedad=$request->get('variedad');

          //  dd($request);
          \Log::info($variedadesbanco->idvariedad);

            $variedadesbanco->update();


   
        return response()->json(['success'=>'Got Simple Ajax Request.']);
    }

    public function updateTestigoPost(Request $request)
    {

        $input = $request->all();
            $variedadesbanco=VariedadesBanco::findOrFail($request->get('id'));
             $checkboxValue = $request->input('testigo');
             \Log::info($checkboxValue);

             if($checkboxValue==0){
                 $variedadesbanco->testigo=1;
             }else{
                 $variedadesbanco->testigo=0;
            }
          //  dd($request);
            $variedadesbanco->update();
  
        return response()->json(['success'=>'Got Simple Ajax Request.']);
    }
}