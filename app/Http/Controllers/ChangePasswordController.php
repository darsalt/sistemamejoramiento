<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Rules\ChequearPassword;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function index(){
        return view('auth.passwords.change');
    }

    public function update(Request $request){
        $request->validate([
            'oldpassword' => ['required', new ChequearPassword],
            'newpassword' => ['required', 'min:8', 'string', 'confirmed'],
        ], [
            'oldpassword.required' => 'La contraseña actual es requerida',
            'newpassword.required' => 'La nueva contraseña es requerida',
            'newpassword.min' => 'La nueva contraseña debe tener al menos 8 caracteres',
            'newpassword.confirmed' => 'Las nuevas contraseñas no coinciden',
        ]);

        $user = User::find(auth()->user()->id);

        $user->password = Hash::make($request->newpassword);
        $user->save();

        return redirect('/admin')->with('success', 'Contraseña actualizada');
    }
}
