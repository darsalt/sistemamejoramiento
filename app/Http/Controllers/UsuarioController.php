<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\UsuarioFormRequest;
use DB;

class UsuarioController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
    	$query=trim($request->get('searchText'));
    		$usuarios=DB::table('users')->where ('name','like','%'.$query.'%') 
    		->orderBy('id','asc')
    		->paginate('10');
    		return view('seguridad.usuario.index',["usuarios"=>$usuarios,"searchText"=>$query]);
    }

    public function create()
    {
        $areas = DB::table('areas as a')
            ->select('a.idarea','a.nombrearea')
            ->where('a.activo','=','1')
            ->get();
    	return view ("seguridad.usuario.create",["areas"=>$areas]);
    }

    public function store(UsuarioFormRequest $request)
    {
    	$usuario=new User;
    	$usuario->name=$request->get('name');
    	$usuario->email=$request->get('email');
    	$usuario->password=bcrypt($request->get('name'));
        $usuario->idarea=$request->get('idarea');
    	$usuario->save();
    	return Redirect::to('seguridad/usuario');
    }

    public function show($id)
    {
    	return view("seguridad.usuario.show",["usuario"=>User::findOrFail($id)]);
    }



    public function edit($id)
    {
        $areas = DB::table('areas as a')
            ->select('a.idarea','a.nombrearea')
            ->where('a.activo','=','1')
            ->get();
        return view('seguridad.usuario.edit',["areas"=>$areas,"usuario"=>User::findOrFail($id)]);
    }


    
    public function update(UsuarioFormRequest $request,$id)
    {
        $usuario=User::findOrFail($id);
        $usuario->name=$request->get('name');
        $usuario->email=$request->get('email');
        $usuario->idarea=$request->get('idarea');
        if ($request->get('eslider'))
            $usuario->eslider=1;
        else
            $usuario->eslider=0;
        if ($request->get('esresponsablecajachica'))
            $usuario->esresponsablecajachica=1;
        else
            $usuario->esresponsablecajachica=0;
        if ($request->get('esresponsabletarjetacredito'))
            $usuario->esresponsabletarjetacredito=1;
        else
            $usuario->esresponsabletarjetacredito=0;
       // dd($usuario);
    	//$usuario->password=bcrypt($request->get('password'));
        $usuario->update();
        return Redirect::to('seguridad/usuario');
    }

    public function destroy($id)
    {
    	$usuario=DB::table('users')->where('id','=',$id)->delete();
    	return Redirect::to('seguridad/usuario');
    }
}
