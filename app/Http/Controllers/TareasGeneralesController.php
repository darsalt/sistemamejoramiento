<?php

namespace App\Http\Controllers;

use App\CampaniaCuarentena;
use App\FertilizacionCuarentena;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TareasGeneralesController extends Controller
{
    public function fertilizacion(){
        $fertilizaciones = FertilizacionCuarentena::where('estado', 1)->paginate(10);

        return view('admin.cuarentena.generales.fertilizacion.index', compact('fertilizaciones'));
    }

    public function fertilizacionCreate(){
        $campanias = CampaniaCuarentena::where('estado', 1)->get();

        return view('admin.cuarentena.generales.fertilizacion.create', compact('campanias'));
    }

    public function fertilizacionStore(Request $request){
        $fertilizacion = new FertilizacionCuarentena();

        $fertilizacion->fecha = $request->fecha;
        $fertilizacion->idcampania = $request->campania;
        $fertilizacion->producto = $request->producto;
        $fertilizacion->dosis = $request->dosis;
        $fertilizacion->observaciones = $request->observaciones;
        $fertilizacion->estado = 1;
        $fertilizacion->save();

        return redirect()->route('cuarentena.generales.fertilizacion.index');
    }

    public function fertilizacionEdit($id){
        $fertilizacion = FertilizacionCuarentena::findOrFail($id);
        $campanias = CampaniaCuarentena::where('estado', 1)->get();

        return view('admin.cuarentena.generales.fertilizacion.edit', compact('campanias', 'fertilizacion'));

    }

    public function fertilizacionUpdate(Request $request, $id){
        $fertilizacion = FertilizacionCuarentena::findOrFail($id);

        $fertilizacion->fecha = $request->fecha;
        $fertilizacion->idcampania = $request->campania;
        $fertilizacion->producto = $request->producto;
        $fertilizacion->dosis = $request->dosis;
        $fertilizacion->observaciones = $request->observaciones;
        $fertilizacion->estado = 1;
        $fertilizacion->save();

        return redirect()->route('cuarentena.generales.fertilizacion.index');
    }

    public function fertilizacionDestroy($id){
        $fertilizacion = FertilizacionCuarentena::findOrFail($id);
        $fertilizacion->estado = 0;
        $fertilizacion->save();

        return redirect()->route('cuarentena.generales.fertilizacion.index');
    }
}
