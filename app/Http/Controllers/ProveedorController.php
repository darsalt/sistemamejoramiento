<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Proveedor;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProveedorFormRequest;
use DB;

class ProveedorController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
    	if($request){
    		$query=trim($request->get('searchText'));
    		$proveedores=DB::table('proveedores')->where ('nombreproveedor','like','%'.$query.'%') 
    		->where ('activo','=',1)
    		->orderBy('idproveedor','asc')
    		->paginate('10');
    		return view('almacen.proveedor.index',["proveedores"=>$proveedores,"searchText"=>$query]);
    	}
    }

    public function create()
    {
    	return view ("almacen.proveedor.create");
    }

    public function store(ProveedorFormRequest $request)
    {
    	$proveedor=new Proveedor;
    	$proveedor->codigo=$request->get('codigo');
        $proveedor->nombreproveedor=$request->get('nombre');
        $proveedor->CUIT=$request->get('cuit');
        $proveedor->domicilio=$request->get('domicilio');
        $proveedor->telefono=$request->get('telefono');
        $proveedor->correoelectronico=$request->get('correoelectronico');
    	$proveedor->activo='1';
    	$proveedor->save();
    	return Redirect::to('almacen/proveedor');
    }

    public function show($id)
    {
    	return view("almacen.proveedor.show",["proveedor"=>Proveedor::findOrFail($id)]);
    }

     public function edit(Proveedor $proveedor)
    {
        return view('almacen.proveedor.edit',compact('proveedor'));
    }

    public function update(ProveedorFormRequest $request,$id)
    {
        $proveedor=Proveedor::findOrFail($id);
        $proveedor->Codigo=$request->get('codigo');
        $proveedor->NombreProveedor=$request->get('nombre');
        $proveedor->CUIT=$request->get('cuit');
        $proveedor->Domicilio=$request->get('domicilio');
        $proveedor->Telefono=$request->get('telefono');
        $proveedor->CorreoElectronico=$request->get('correoelectronico');

        $proveedor->update();
        return Redirect::to('almacen/proveedor');
    }

    public function destroy($id)
    {
    	$proveedor=Proveedor::findOrFail($id);
    	$proveedor->activo='0';
      	$proveedor->update();
    	return Redirect::to('almacen/proveedor');
    }
}
