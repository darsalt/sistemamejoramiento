<?php

namespace App\Http\Controllers;

use App\BoxExportacion;
use App\BoxImportacion;
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

    public function corte(){
        $cortes = DB::table('cortes_cuarentena as c')
        ->select('c.*', 'cc.nombre as nombre_campania')
        ->join('campaniacuarentena as cc', 'cc.id', '=', 'c.idcampania')
        ->where('c.estado', 1)->paginate(10);

        return view('admin.cuarentena.generales.corte.index', compact('cortes'));
    }

    public function corteCreate(){
        $campanias = CampaniaCuarentena::where('estado', 1)->get();

        return view('admin.cuarentena.generales.corte.create', compact('campanias'));
    }

    public function corteStore(Request $request){
        DB::table('cortes_cuarentena')->insert([
            'fecha' => $request->fecha,
            'idcampania' => $request->campania,
            'observaciones' => $request->observaciones,
            'estado' => 1
        ]);

        return redirect()->route('cuarentena.generales.corte.index');
    }

    public function corteEdit($id){
        $corte = DB::table('cortes_cuarentena')->where('id', $id)->first();
        $campanias = CampaniaCuarentena::where('estado', 1)->get();

        return view('admin.cuarentena.generales.corte.edit', compact('campanias', 'corte'));

    }

    public function corteUpdate(Request $request, $id){
        DB::table('cortes_cuarentena')->where('id', $id)
        ->update([
            'fecha' => $request->fecha,
            'idcampania' => $request->campania,
            'observaciones' => $request->observaciones
        ]);

        return redirect()->route('cuarentena.generales.corte.index');
    }

    public function corteDestroy($id){
        DB::table('cortes_cuarentena')->where('id', $id)
        ->update([
            'estado' => 0
        ]);

        return redirect()->route('cuarentena.generales.corte.index');
    }

    public function aplicacion(){
        $aplicaciones = DB::table('aplicaciones_cuarentena as a')
        ->select('a.*', 'cc.nombre as nombre_campania', 'bi.nombre as boximpo', 'be.nombre as boxexpo')
        ->join('campaniacuarentena as cc', 'cc.id', '=', 'a.idcampania')
        ->leftjoin('boxesimpo as bi', 'bi.id', '=', 'a.idboximpo')
        ->leftjoin('boxesexpo as be', 'be.id', '=', 'a.idboxexpo')
        ->where('a.estado', 1)->paginate(10);

        return view('admin.cuarentena.generales.aplicaciones.index', compact('aplicaciones'));
    }

    public function aplicacionCreate(){
        $campanias = CampaniaCuarentena::where('estado', 1)->get();
        $boxesImpo = BoxImportacion::where('activo', 1)->get();
        $boxesExpo = BoxExportacion::where('activo', 1)->get();

        return view('admin.cuarentena.generales.aplicaciones.create', compact('campanias', 'boxesImpo', 'boxesExpo'));
    }

    public function aplicacionStore(Request $request){
        foreach($request->boxesimpo as $box){
            DB::table('aplicaciones_cuarentena')->insert([
                'fecha' => $request->fecha,
                'idcampania' => $request->campania,
                'producto' => $request->producto,
                'idboximpo' => $box,
                'observaciones' => $request->observaciones,
                'estado' => 1
            ]);
        }

        foreach($request->boxesexpo as $box){
            DB::table('aplicaciones_cuarentena')->insert([
                'fecha' => $request->fecha,
                'idcampania' => $request->campania,
                'producto' => $request->producto,
                'idboxexpo' => $box,
                'observaciones' => $request->observaciones,
                'estado' => 1
            ]);
        }

        return redirect()->route('cuarentena.generales.aplicacion.index');
    }

    public function aplicacionEdit($id){
        $aplicacion = DB::table('aplicaciones_cuarentena as a')->where('a.id', $id)
        ->select('a.*', 'bi.nombre as boximpo', 'be.nombre as boxexpo')
        ->leftjoin('boxesimpo as bi', 'bi.id', '=', 'a.idboximpo')
        ->leftjoin('boxesexpo as be', 'be.id', '=', 'a.idboxexpo')
        ->first();
        $campanias = CampaniaCuarentena::where('estado', 1)->get();

        return view('admin.cuarentena.generales.aplicaciones.edit', compact('aplicacion', 'campanias'));

    }

    public function aplicacionUpdate(Request $request, $id){
        DB::table('aplicaciones_cuarentena')->where('id', $id)
        ->update([
            'fecha' => $request->fecha,
            'idcampania' => $request->campania,
            'producto' => $request->producto,
            'observaciones' => $request->observaciones
        ]);

        return redirect()->route('cuarentena.generales.aplicacion.index');
    }

    public function aplicacionDestroy($id){
        DB::table('aplicaciones_cuarentena')->where('id', $id)
        ->update([
            'estado' => 0
        ]);

        return redirect()->route('cuarentena.generales.aplicacion.index');
    }
}
