<?php

namespace App\Http\Controllers;

use App\CampaniaCuarentena;
use App\FertilizacionCuarentena;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    public function limpieza(){
        $limpiezas = DB::table('limpiezas_cuarentena as l')
        ->select('l.*', 'c.nombre as nombre_campania')
        ->join('campaniacuarentena as c', 'c.id', '=', 'l.idcampania')
        ->where('l.estado', 1)->paginate(10);

        return view('admin.cuarentena.generales.limpieza.index', compact('limpiezas'));
    }

    public function limpiezaCreate(){
        $campanias = CampaniaCuarentena::where('estado', 1)->get();

        return view('admin.cuarentena.generales.limpieza.create', compact('campanias'));
    }

    public function limpiezaStore(Request $request){
        DB::table('limpiezas_cuarentena')->insert([
            'fecha' => $request->fecha,
            'idcampania' => $request->campania,
            'observaciones' => $request->observaciones,
            'estado' => 1
        ]);

        return redirect()->route('cuarentena.generales.limpieza.index');
    }

    public function limpiezaEdit($id){
        $limpieza = DB::table('limpiezas_cuarentena')->where('id', $id)->first();
        $campanias = CampaniaCuarentena::where('estado', 1)->get();

        return view('admin.cuarentena.generales.limpieza.edit', compact('campanias', 'limpieza'));

    }

    public function limpiezaUpdate(Request $request, $id){
        DB::table('limpiezas_cuarentena')->where('id', $id)
        ->update([
            'fecha' => $request->fecha,
            'idcampania' => $request->campania,
            'observaciones' => $request->observaciones
        ]);

        return redirect()->route('cuarentena.generales.limpieza.index');
    }

    public function limpiezaDestroy($id){
        DB::table('limpiezas_cuarentena')->where('id', $id)
        ->update([
            'estado' => 0
        ]);

        return redirect()->route('cuarentena.generales.limpieza.index');
    }
}
