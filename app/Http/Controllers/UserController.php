<?php

namespace App\Http\Controllers;

use App\Ambiente;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index(Request $request){
        $searchText = trim($request->get('searchText'));
        $usuarios = User::where('name','like','%'.$searchText.'%');
        $usuarios = $usuarios->OrWhere('email','like','%'.$searchText.'%');
        $usuarios = $usuarios->paginate(10);

        return view('admin.users.index', compact('usuarios', 'searchText'));
    }

    public function create(){
        $ambientes = Ambiente::all();

        return view('admin.users.create', ['ambientes' => $ambientes]);
    }

    public function store(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'ambiente' => ['required'],
        ]);

        if($validator->fails()){
            return redirect()->route('admin.users.create')
                ->withErrors($validator)
                ->withInput();
        }

        $esAdmin = $request->has('administrador') ? 1 : 0;

        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'idambiente' => $request['ambiente'],
            'esAdmin' => $esAdmin
        ]);

        return redirect()->route('admin.users.index')->withSuccess('Usuario creado con éxito.');
    }

    public function edit(User $user){
        $ambientes = Ambiente::all();
        return view('admin.users.edit', compact('user', 'ambientes'));
    }

    public function update(Request $request, User $user){
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'ambiente' => ['required'],
        ]);

        if($validator->fails()){
            return redirect()->route('admin.users.edit', $user)
                ->withErrors($validator)
                ->withInput();
        }

        $esAdmin = $request->has('administrador') ? 1 : 0;

        $user->update([
            'name' => $request['name'],
            'email' => $request['email'],
            'idambiente' => $request['ambiente'],
            'esAdmin' => $esAdmin
        ]);

        return redirect()->route('admin.users.index')->withSuccess('Usuario actualizado con éxito.');
    }
}
