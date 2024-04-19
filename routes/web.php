<?php

use Illuminate\Support\Facades\Route;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/admin/inventario/ingresos/create', 'InventarioController@createIngreso')->name('inventario.ingresos.create');
Route::post('/admin/inventario/ingresos', 'InventarioController@storeIngreso')->name('inventario.ingresos.store');

Route::get('/admin/inventario/egresos/', 'InventarioController@egresos')->name('inventario.egresos.index');
Route::get('/admin/inventario/egresos/create', 'InventarioController@createEgreso')->name('inventario.egresos.create');
Route::post('/admin/inventario/egresos', 'InventarioController@storeEgreso')->name('inventario.egresos.store');
Route::get('/admin/inventario/egresos/edit/{id}', 'InventarioController@editEgreso')->name('inventario.egresos.edit');
Route::put('/admin/inventario/egresos/{id}', 'InventarioController@updateEgreso')->name('inventario.egresos.update');
Route::delete('/admin/inventario/egresos/delete', 'InventarioController@deleteEgreso')->name('inventario.egresos.delete');

//Route::get('/admin/semillados', function () {
//    return view('admin.semillados.index');
//});

Route::get('/admin/semillados/repicadas', function () {
    return view('admin.semillados.repicadas');
});

Route::get('/script', function () {
    return view('poorman');
});

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

// Rutas usuarios
Route::resource('admin/users', 'UserController', ['except' => ['delete']])->names('admin.users');

Route::get('/change-password', 'ChangePasswordController@index')->name('auth.password.change.index');
Route::patch('/change-password', 'ChangePasswordController@update')->name('auth.password.change.update');

Route::get('/home', 'HomeController@index')->name('home');

Route::get('auth/google', 'Auth\GoogleController@redirectToGoogle');
Route::get('auth/google/callback', 'Auth\GoogleController@handleGoogleCallback');

Route::get('admin', function () {
    return view('admin.index');
});

Route::resource("admin/niveles", "NivelesController")->parameters(["niveles"=>"nivel"]);

Route::resource('admin/tachos','TachoController');
Route::resource('admin/variedades','VariedadController')->parameters(["variedades"=>"variedad"]);
Route::resource('admin/tareas','TareaController')->parameters(["tareas"=>"tarea"]);
Route::resource('admin/evaluaciones','EvaluacionController')->parameters(["evaluaciones"=>"evaluacion"]);
Route::resource('admin/salidas','SalidaController')->parameters(["salidas"=>"salida"]);

Route::resource('admin/lotes','LoteController');

Route::resource('admin/tratamientos','TratamientoController');

Route::get('admin/cruzamientos/create/{idCampania?}', 'CruzamientoController@create');
Route::resource('admin/cruzamientos', 'CruzamientoController', ['except' => ['create'], 'names' => 'admin.cruzamientos']);
Route::get('tallosTacho/{id}', 'CruzamientoController@tallosTacho');
Route::get('getTalloById/{idTallo}', 'CruzamientoController@getTalloById');

// Camaras Zorras tachos.
//Route::resource('admin/camaras','CamaraController');
Route::get('admin/camaras/campania', 'CamaraController@cambiarCampania');
Route::get('admin/marcotado/campania/{idcampania}', 'MarcotadoController@cambiarCampania');


Route::get('admin/camaras', 'CamaraController@index');
Route::get('admin/camaras/{id}', 'CamaraController@CambiarCamara');
Route::post('select-tratamiento', ['as'=>'select-tratamiento','uses'=>'CamaraController@selectTratamiento']);
Route::post('select-tacho', ['as'=>'select-tacho','uses'=>'CamaraController@selectTacho']);
Route::post('guardar-fecha', ['as'=>'guardar-fecha','uses'=>'MarcotadoController@guardarfecha']);
Route::post('guardar-cantidad-tallo', ['as'=>'guardar-cantidad-tallo','uses'=>'MarcotadoController@guardarcantidadtallos']);

// Marcotado.
Route::get('admin/marcotado/{id}','MarcotadoController@show');
Route::resource('admin/marcotado','MarcotadoController');

Route::resource('admin/ambientes', 'AmbienteController');
Route::resource('admin/subambientes', 'SubambienteController');
Route::resource('admin/sectores', 'SectorController');
Route::get('buscarSubambientesConIdAmbiente/{id}','SubambienteController@buscarSubambienteConIdAmbiente');




//Route::get('admin/ubicacionesexpo', 'UbicacionController@index');
//Route::get('admin/ubicacionesimpo', 'UbicacionController@index');
Route::get('admin/ubicacionesexpo/create', 'UbicacionexpoController@create');
Route::get('admin/ubicacionesimpo/create', 'UbicacionimpoController@create');


Route::resource('admin/ubicacionesexpo','UbicacionexpoController');
Route::resource('admin/ubicacionesimpo','UbicacionimpoController');

//Route::resource('admin/inspecciones','InspeccionController');


//Rutas exportaciones - Ingresos
Route::get('admin/exportaciones/ingresos', 'ExportacionController@index')->name('exportaciones.ingresos.index');
Route::get('admin/exportaciones/ingresos/create', 'ExportacionController@create')->name('exportaciones.ingresos.create');
Route::post('admin/exportaciones/ingresos', 'ExportacionController@store')->name('exportaciones.ingresos.store');
Route::delete('admin/exportaciones/ingresos/{idexportacion}', 'ExportacionController@destroy');
Route::patch('admin/exportaciones/ingresos/bajaTacho/{idexportacion}', 'ExportacionController@bajaTacho')->name('exportaciones.ingresos.bajaTacho');

//Rutas exportaciones - Envios
Route::get('admin/exportaciones/envios', 'ExportacionController@envios')->name('exportaciones.envios.index');
Route::get('admin/exportaciones/envios/create', 'ExportacionController@enviosCreate')->name('exportaciones.envios.create');
Route::post('admin/exportaciones/envios', 'ExportacionController@enviosStore')->name('exportaciones.envios.store');
Route::delete('admin/exportaciones/envios/{id}', 'ExportacionController@destroyEnvio')->name('exportaciones.envios.destroy');

// Rutas importaciones - Ingresos
Route::get('admin/importaciones/ingresos', 'ImportacionController@index')->name('importaciones.ingresos.index');
Route::get('admin/importaciones/ingresos/create', 'ImportacionController@create')->name('importaciones.ingresos.create');
Route::post('admin/importaciones/ingresos', 'ImportacionController@store')->name('importaciones.ingresos.store');
Route::delete('admin/importaciones/ingresos/delete/{idimportacion}', 'ImportacionController@destroy');
Route::patch('admin/importaciones/ingresos/bajaTacho/{idimportacion}', 'ImportacionController@bajaTacho')->name('importaciones.ingresos.bajaTacho');

// Rutas importaciones - Inspecciones
Route::get('admin/importaciones/inspecciones', 'InspeccionController@index')->name('importaciones.inspecciones.index');
Route::get('admin/importaciones/inspecciones/create', 'InspeccionController@create')->name('importaciones.inspecciones.create');
Route::post('admin/importaciones/inspecciones', 'InspeccionController@store')->name('importaciones.inspecciones.store');
Route::delete('admin/importaciones/inspecciones/{id}', 'InspeccionController@destroy')->name('importaciones.inspecciones.destroy');

// Rutas importaciones - Levantamientos cuarentena
Route::get('admin/importaciones/levantamientos', 'ImportacionController@levantamientoIndex')->name('importaciones.levantamientos.index');
Route::get('admin/importaciones/levantamientos/create', 'ImportacionController@levantamientoCreate')->name('importaciones.levantamientos.create');
Route::post('admin/importaciones/levantamientos', 'ImportacionController@levantamientoStore')->name('importaciones.levantamientos.store');
Route::delete('admin/importaciones/levantamientos/{id}', 'ImportacionController@levantamientoDestroy')->name('importaciones.levantamientos.destroy');

// Cuarentena - Evaluaciones Sanitarias
Route::get('admin/cuarentena/sanitarias', 'SanitariasCuarentenaController@index')->name('cuarentena.sanitarias.index');
Route::get('admin/cuarentena/sanitarias/create', 'SanitariasCuarentenaController@create')->name('cuarentena.sanitarias.create');
Route::post('admin/cuarentena/sanitarias', 'SanitariasCuarentenaController@store')->name('cuarentena.sanitarias.store');
Route::get('admin/cuarentena/sanitarias/datos/{idevaluacion}', 'SanitariasCuarentenaController@datosasociados')->name('cuarentena.sanitarias.datosasociados');
Route::get('admin/cuarentena/sanitarias/datosasociados/{idevaluacion}', 'SanitariasCuarentenaController@getDatosAsociados');
Route::post('admin/cuarentena/sanitarias/datosasociados/store', 'SanitariasCuarentenaController@updateDatosEvaluacion')->name('cuarentena.sanitarias.storeDatosAsociados');
Route::delete('admin/cuarentena/sanitarias/{id}', 'SanitariasCuarentenaController@destroy');

// Cuarentena - Tareas generales
// Fertilizacion
Route::get('admin/cuarentena/generales/fertilizacion', 'TareasGeneralesController@fertilizacion')->name('cuarentena.generales.fertilizacion.index');
Route::get('admin/cuarentena/generales/fertilizacion/create', 'TareasGeneralesController@fertilizacionCreate')->name('cuarentena.generales.fertilizacion.create');
Route::post('admin/cuarentena/generales/fertilizacion', 'TareasGeneralesController@fertilizacionStore')->name('cuarentena.generales.fertilizacion.store');
Route::get('admin/cuarentena/generales/fertilizacion/{id}/edit', 'TareasGeneralesController@fertilizacionEdit')->name('cuarentena.generales.fertilizacion.edit');
Route::put('admin/cuarentena/generales/fertilizacion/{id}', 'TareasGeneralesController@fertilizacionUpdate')->name('cuarentena.generales.fertilizacion.update');
Route::delete('admin/cuarentena/generales/fertilizacion/{id}', 'TareasGeneralesController@fertilizacionDestroy')->name('cuarentena.generales.fertilizacion.destroy');

// Limpieza
Route::get('admin/cuarentena/generales/limpieza', 'TareasGeneralesController@limpieza')->name('cuarentena.generales.limpieza.index');
Route::get('admin/cuarentena/generales/limpieza/create', 'TareasGeneralesController@limpiezaCreate')->name('cuarentena.generales.limpieza.create');
Route::post('admin/cuarentena/generales/limpieza', 'TareasGeneralesController@limpiezaStore')->name('cuarentena.generales.limpieza.store');
Route::get('admin/cuarentena/generales/limpieza/{id}/edit', 'TareasGeneralesController@limpiezaEdit')->name('cuarentena.generales.limpieza.edit');
Route::put('admin/cuarentena/generales/limpieza/{id}', 'TareasGeneralesController@limpiezaUpdate')->name('cuarentena.generales.limpieza.update');
Route::delete('admin/cuarentena/generales/limpieza/{id}', 'TareasGeneralesController@limpiezaDestroy')->name('cuarentena.generales.limpieza.destroy');

// Corte
Route::get('admin/cuarentena/generales/corte', 'TareasGeneralesController@corte')->name('cuarentena.generales.corte.index');
Route::get('admin/cuarentena/generales/corte/create', 'TareasGeneralesController@corteCreate')->name('cuarentena.generales.corte.create');
Route::post('admin/cuarentena/generales/corte', 'TareasGeneralesController@corteStore')->name('cuarentena.generales.corte.store');
Route::get('admin/cuarentena/generales/corte/{id}/edit', 'TareasGeneralesController@corteEdit')->name('cuarentena.generales.corte.edit');
Route::put('admin/cuarentena/generales/corte/{id}', 'TareasGeneralesController@corteUpdate')->name('cuarentena.generales.corte.update');
Route::delete('admin/cuarentena/generales/corte/{id}', 'TareasGeneralesController@corteDestroy')->name('cuarentena.generales.corte.destroy');

// Aplicación
Route::get('admin/cuarentena/generales/aplicacion', 'TareasGeneralesController@aplicacion')->name('cuarentena.generales.aplicacion.index');
Route::get('admin/cuarentena/generales/aplicacion/create', 'TareasGeneralesController@aplicacionCreate')->name('cuarentena.generales.aplicacion.create');
Route::post('admin/cuarentena/generales/aplicacion', 'TareasGeneralesController@aplicacionStore')->name('cuarentena.generales.aplicacion.store');
Route::get('admin/cuarentena/generales/aplicacion/{id}/edit', 'TareasGeneralesController@aplicacionEdit')->name('cuarentena.generales.aplicacion.edit');
Route::put('admin/cuarentena/generales/aplicacion/{id}', 'TareasGeneralesController@aplicacionUpdate')->name('cuarentena.generales.aplicacion.update');
Route::delete('admin/cuarentena/generales/aplicacion/{id}', 'TareasGeneralesController@aplicacionDestroy')->name('cuarentena.generales.aplicacion.destroy');

Route::get('export', 'TachoController@export');
Route::get('exportvariedades', 'VariedadController@export');
Route::get('exportexportaciones', 'ExportacionController@export');
Route::get('exportimportaciones', 'ImportacionController@export');
Route::get('exporttareas', 'TareaController@export');
Route::get('exportevaluaciones', 'EvaluacionController@export');
Route::get('exportlotes', 'LoteController@export');
//Route::get('exportubicaciones', 'UbicacionController@export');

Route::get('/admin/variedades/view', function () {
    return view('admin.variedades.view');
});
Route::get('/admin/tachos/view', function () {
    return view('admin.tachos.view');
});
Route::get('/admin/importaciones/view', function () {
    return view('admin.importaciones.view');
});

Route::get('/admin/tratamientos/view', function () {
    return view('admin.tratamientos.view');
});

Route::get('/admin/campanias/view', function () {
    return view('admin.campanias.view');
});

Route::get('/admin/cruzamientos/view', function () {
    return view('admin.cruzamientos.view');
});

Route::get('/admin/tachos/cortes/view', function () {
    return view('admin.tachos.cortes.view');
});
Route::get('/admin/tachos/fertilizaciones/view', function () {
    return view('admin.tachos.fertilizaciones.view');
});

Route::get('/admin/exportaciones/tareas/{id}','ExportacionController@tareasasociadas');
Route::get('/admin/importaciones/tareas/{id}','ImportacionController@tareasasociadas');

Route::get('/admin/exportaciones/evaluaciones/{id}','ExportacionController@evaluacionesasociadas');
Route::get('/admin/importaciones/evaluaciones/{id}','ImportacionController@evaluacionesasociadas');

Route::get('/admin/exportaciones/salidas/{id}','ExportacionController@salidasasociadas');
Route::get('/admin/importaciones/salidas/{id}','ImportacionController@salidasasociadas');



//Route::get('/admin/exportaciones/salidamasiva','ExportacionController@salidamasiva');



//Route::get('/admin/importaciones/inspecciones/{id}','ImportacionController@inspeccionesasociadas');


//Route::get('/admin/lotes/tareas/{id}','LoteController@tareasasociadas');
Route::get('/admin/lotes/evaluaciones/{id}','LoteController@evaluacionesasociadas');

Route::get('/admin/ubicacionesexpo/tareas/{id}','UbicacionexpoController@tareasasociadas');
Route::get('/admin/ubicacionesimpo/tareas/{id}','UbicacionimpoController@tareasasociadas');

Route::get('/admin/ubicacionesexpo/evaluaciones/{id}','UbicacionexpoController@evaluacionesasociadas');
Route::get('/admin/ubicacionesimpo/evaluaciones/{id}','UbicacionimpoController@evaluacionesasociadas');
Route::get('/admin/ubicacionesimpo/inspecciones/{id}','UbicacionimpoController@inspeccionesasociadas');


Route::get('/BuscarTachosConIdvariedad/{id}','VariedadController@BuscarTachosConIdVariedad');
Route::get('/BuscarVariedadConIdTacho/{id}','TachoController@BuscarVariedadConIdTacho');
Route::get('/BuscarExportacionConIdTacho/{id}','ExportacionController@BuscarExportacionConIdTacho');

//


Route::post('bancos/ubicaciones','BancoController@editarubicaciones');
Route::get('exportbancos', 'BancoController@export');
Route::resource('admin/bancos','BancoController')->parameters(["bancos"=>"banco"]);

Route::resource('admin/agronomicas','AgronomicaController')->parameters(["bancos"=>"banco"]);
Route::resource('bancos/agronomicas','AgronomicaController')->parameters(["bancos"=>"banco"]);
Route::get('/admin/bancos/agronomicas/datos/{id}','AgronomicaController@datosasociados');
Route::post('agronomicas/datos/{idevaluacion}','AgronomicaController@editardatos');

Route::resource('admin/sanitarias','SanitariaController')->parameters(["bancos"=>"banco"]);
Route::resource('bancos/sanitarias','SanitariaController')->parameters(["bancos"=>"banco"]);
Route::get('/admin/bancos/sanitarias/datos/{id}','SanitariaController@datosasociados');
Route::post('sanitarias/datos/{idevaluacion}','SanitariaController@editardatos');

Route::resource('admin/laboratorios','LaboratorioController')->parameters(["bancos"=>"banco"]);
Route::resource('bancos/laboratorios','LaboratorioController')->parameters(["bancos"=>"banco"]);
Route::get('/admin/bancos/laboratorios/datos/{id}','LaboratorioController@datosasociados');
Route::post('laboratorios/datos/{idevaluacion}','LaboratorioController@editardatos');

Route::get('/admin/bancos/ubicacionesasociadas/{id}', 'BancoController@ubicacionesasociadas');

Route::post('ubicaciones/{idevaluacion}','BancoController@updatevariedad');
Route::post('sanitarias/datos/{idevaluacion}','SanitariaController@editardatos');

Route::post('ubicaciones/datos','BancoController@updatevariedad');


Route::post ('/updateUser', 'BancoController@updatevariedad');
Route::get ('/updateUser', 'BancoController@updatevariedad');

Route::get ('ubicaciones/{idbanco}' , 'BancoController@ubicacionesasociadas'); 


Route::get('/admin/bancos/ubicaciones/{idbanco}','BancoController@ubicacionesasociadas');
Route::get('/admin/bancos/agronomicas/{idevaluacion}','AgronomicaController@ubicacionesasociadas');
Route::get('/admin/bancos/laboratorios/{idevaluacion}','LaboratorioController@ubicacionesasociadas');
Route::get('/admin/bancos/sanitarias/{idevaluacion}','SanitariaController@ubicacionesasociadas');

Route::get('/admin/progenitores/sanitarias/{idevaluacion}','ProgenitoresSanitariaController@ubicacionesasociadas');


Route::post ('ubicaciones' , 'BancoController@updateVariedadPost')->name('ubicaciones.post');
Route::post ('ubicaciones1' , 'BancoController@updateTestigoPost')->name('testigo.post');

Route::post ('agronomicas' , 'AgronomicaController@updateEvaluacionPost')->name('agronomicas.post');
Route::post ('laboratorios' , 'LaboratorioController@updateEvaluacionPost')->name('laboratorios.post');
Route::post ('sanitarias' , 'SanitariaController@updateEvaluacionPost')->name('sanitarias.post');

Route::get('/admin/progenitores/sanitarias/datos/{id}','ProgenitoresSanitariaController@datosasociados');
Route::post('progenitores/sanitarias/datos/{idevaluacion}','ProgenitoresSanitariaController@editardatos');
Route::post ('sanitariasp' , 'ProgenitoresSanitariaController@updateEvaluacionPost')->name('sanitariasp.post');


//Route::resource('admin/progenitores/fertilizaciones','FertilizacionController');
//Route::resource('admin/progenitores/cortes','CorteController');
//Route::resource('admin/progenitores/sanitarias','ProgenitoresSanitariaController');


Route::resource('admin/cortes','CorteController');
Route::resource('admin/fertilizaciones','FertilizacionController');
Route::resource('admin/sanitariasp','ProgenitoresSanitariaController');


Route::get('admin/podergerminativo','CruzamientoController@poder');
Route::get('/admin/podergerminativo/datos/{campania}','CruzamientoController@podergerminativo');
Route::post('podergerminativo/datos','CruzamientoController@editarpodergerminativo');


Route::get('/admin/podergerminativo/edit/{campania}','CruzamientoController@ubicacionesasociadas');
//Route::get('/admin/bancos/agronomicas/{idevaluacion}','AgronomicaController@ubicacionesasociadas');


Route::get('/admin/podergerminativo/editar','CruzamientoController@editardatos');

Route::post ('podergerminativo', 'CruzamientoController@updatePoderPost')->name('podergerminativo.post');

Route::resource('admin/campaniabanco','CampaniaBancoController');
Route::resource('admin/campaniacuarentena','CampaniaCuarentenaController');

Route::resource('admin/campanias','CampaniaController');
Route::resource('admin/campaniasemillado','CampaniaSemilladoController');


Route::get('admin/camaras/{id}/{idCa}', 'CamaraController@CambiarCamara');

Route::resource('admin/inventario', 'InventarioController');
Route::get('admin/individual/inventario', 'EtapaIndividualController@inventario')->name('individual.inventario.index');


//Route::get('/admin/podergerminativo/edit/{campania}','CruzamientoController@ubicacionesasociadas');
Route::get('/admin/semillados/ordenes/{campania?}','SemilladoController@ordenes')->name('semillados.ordenes');
Route::get('/admin/semillados/repicadas/{campania}','SemilladoController@repicadas');
Route::get('/admin/semillados','SemilladoController@index');
Route::delete('/admin/semillados/{semillado?}', 'SemilladoController@delete')->name('semillados.delete');
//Route::get('/admin/semillados', function () {
//    return view('admin.semillados.index');
//});



Route::get('/rconphp', function () {
    return view('rconphp');
});

 
//Route::get('admin/cruzamientos/import','CruzamientoController@importForm')->name('cruzamientos.import');
//Route::post('admin/cruzamientos/import','CruzamientoController@import')->name('cruzamientos.import');
//Route::get('admin/podergerminativo','CruzamientoController@importForm');
//Route::post('podergerminativo/datos','CruzamientoController@import')->name('cruzamientos.import');

// Rutas Ajax - (Darfe Facundo)
Route::get('ajax/cruzamientos/getCruzamientos', 'CruzamientoController@getCruzamientos')->name('ajax.cruzamientos.getCruzamientos');
Route::get('ajax/semillados/getUltimaOrden', 'SemilladoController@getUltimaOrdenAjax')->name('ajax.semillados.getUltimaOrden');
Route::get('ajax/semillas/getSemilla', 'InventarioController@getSemilla')->name('ajax.semillas.getSemilla');
Route::post('ajax/semillados/saveSemillado', 'SemilladoController@saveSemillado')->name('ajax.semillados.saveSemillado');
Route::get('ajax/semillados/getSemillados', 'SemilladoController@getSemillados')->name('ajax.semillados.getSemillados');
Route::get('ajax/semillados/getSemillado', 'SemilladoController@getSemillado')->name('ajax.semillados.getSemillado');
Route::put('ajax/semillados/editSemillado', 'SemilladoController@editSemillado')->name('ajax.semillados.editSemillado');
Route::get('ajax/semillados/getProgenitores', 'SemilladoController@getProgenitores')->name('ajax.semillados.getProgenitores');

Route::resource('admin/individual/campaniaseedling','CampaniaSeedlingController');
Route::get('admin/individual/seleccion/{campania?}/{sector?}', 'EtapaIndividualController@index')->name('individual.index');
Route::delete('admin/individual/{seedling?}', 'EtapaIndividualController@delete')->name('individual.delete');

// Rutas Ajax para seedling
Route::get('ajax/individual/getUltimaParcela', 'EtapaIndividualController@getUltimaParcelaAjax')->name('ajax.individual.getUltimaParcela');
Route::get('ajax/subambientes/getSubambientesDadoAmbiente', 'SubambienteController@getSubambientesDadoAmbiente')->name('ajax.subambientes.getSubambientesDadoAmbiente');
Route::get('ajax/sectores/getSectoresDadoSubambiente', 'SectorController@getSectoresDadoSubambiente')->name('ajax.sectores.getSectoresDadoSubambiente');
//Route::get('ajax/lotes/getLotesDadoSubambiente', 'LoteController@getLotesDadoSubambiente')->name('ajax.lotes.getLotesDadoSubambiente');

Route::post('ajax/individual/saveSeedling', 'EtapaIndividualController@saveSeedling')->name('ajax.individual.saveSeedling');
Route::get('ajax/individual/getSeedling', 'EtapaIndividualController@getSeedling')->name('ajax.individual.getSeedling');
Route::get('ajax/individual/getSeedlings', 'EtapaIndividualController@getSeedlings')->name('ajax.individual.getSeedlings');
Route::put('ajax/individual/editSeedling', 'EtapaIndividualController@editSeedling')->name('ajax.individual.editSeedling');
Route::get('ajax/individual/getProgenitoresSeedling', 'EtapaIndividualController@getProgenitoresSeedling')->name('ajax.individual.getProgenitoresSeedling');

// Serie
Route::resource('admin/primera/serie','SerieController');
Route::get('ajax/primera/serie/getAnioSerie', 'SerieController@getAnioSerie')->name('ajax.primera.serie.getAnioSerie');

// Primera clonal
Route::get('admin/primera/seleccion/{serie?}/{sector?}', 'PrimeraClonalController@index')->name('primeraclonal.index');
Route::delete('admin/primera/{serie?}', 'PrimeraClonalController@delete')->name('primeraclonal.delete');
Route::get('admin/primera/inventario', 'PrimeraClonalController@inventario')->name('primeraclonal.inventario.index');
//Route::get('/admin/primera/evaluaciones/camposanidad', 'PrimeraClonalController@evCampoSanidad')->name('primeraclonal.evaluaciones.camposanidad');
Route::get('/admin/primera/evaluaciones/camposanidad/view/{evaluacion}', 'PrimeraClonalController@viewEvCampoSanidad')->name('primeraclonal.evaluaciones.camposanidad.view');
//Route::get('/admin/primera/evaluaciones/laboratorio/{anio?}/{serie?}/{sector?}/{mes?}/{edad?}', 'PrimeraClonalController@evLaboratorio')->name('primeraclonal.evaluaciones.laboratorio');
Route::get('/admin/primera/evaluaciones/laboratorio/view/{evaluacion}', 'PrimeraClonalController@viewEvLaboratorio')->name('primeraclonal.evaluaciones.laboratorio.view');

// Laboratorio
Route::get('/admin/primera/laboratorio/{serie?}/{sector?}', 'PrimeraClonalController@laboratorio')->name('primeraclonal.laboratorio.index');
Route::patch('admin/primera/laboratorio/{serie}/{sector}', 'PrimeraClonalController@saveLaboratorio')->name('primeraclonal.laboratorio.save');

// Rutas Ajax para primera clonal
Route::get('ajax/primera/getUltimaParcela', 'PrimeraClonalController@getUltimaParcelaAjax')->name('ajax.primeraclonal.getUltimaParcela');
Route::post('ajax/primera/savePrimeraClonal', 'PrimeraClonalController@savePrimeraClonal')->name('ajax.primeraclonal.savePrimeraClonal');
Route::get('ajax/primera/getPrimeraClonal', 'PrimeraClonalController@getPrimeraClonal')->name('ajax.primeraclonal.getPrimeraClonal');
Route::put('ajax/primera/editPrimeraClonal', 'PrimeraClonalController@editPrimeraClonal')->name('ajax.primeraclonal.editPrimeraClonal');
Route::get('ajax/primera/getSeedlings', 'PrimeraClonalController@getSeedlings')->name('ajax.primeraclonal.getSeedlings');
Route::post('ajax/primera/saveTestigos', 'PrimeraClonalController@saveTestigos')->name('ajax.primeraclonal.saveTestigos');
Route::post('ajax/primera/evaluaciones/saveEvCampoSanidad', 'PrimeraClonalController@saveEvCampoSanidad')->name('ajax.primeraclonal.evaluaciones.saveEvCampoSanidad');
Route::post('ajax/primera/evaluaciones/saveEvLaboratorio', 'PrimeraClonalController@saveEvLaboratorio')->name('ajax.primeraclonal.evaluaciones.saveEvLaboratorio');

Route::get('/admin/incluirpg','CampaniaSemilladoController@incluirpg');
Route::post('campaniasemillado/pg','CampaniaSemilladoController@guardarpg');


// Segunda Clonal
Route::group(['prefix' => '/admin/segunda', 'as' => 'segundaclonal.'], function () {
    Route::get('/seleccion/{anio?}/{serie?}/{sector?}', 'SegundaClonalController@index')->name('index');
    Route::delete('/{segunda?}', 'SegundaClonalController@delete')->name('delete');
    Route::delete('/testigo/{testigo?}', 'SegundaClonalController@deleteTestigo')->name('deleteTestigo');
    Route::get('/inventario', 'SegundaClonalController@inventario')->name('inventario.index');
    Route::get('/evaluaciones/camposanidad/view/{evaluacion}', 'SegundaClonalController@viewEvCampoSanidad')->name('evaluaciones.camposanidad.view');
    Route::get('/evaluaciones/laboratorio/view/{evaluacion}', 'SegundaClonalController@viewEvLaboratorio')->name('evaluaciones.laboratorio.view');
});

// Rutas Ajax Segunda Clonal
Route::group(['prefix' => '/ajax/segunda', 'as' => 'ajax.segundaclonal.'], function () {
    Route::get('/getSegundaClonal', 'SegundaClonalController@getSegundaClonal')->name('getSegundaClonal');
    Route::put('/editSegundaClonal', 'SegundaClonalController@editSegundaClonal')->name('editSegundaClonal');
    Route::post('/saveSegundaClonal', 'SegundaClonalController@saveSegundaClonal')->name('saveSegundaClonal');
    Route::post('/saveTestigo', 'SegundaClonalController@saveTestigo')->name('saveTestigo');
    Route::get('/getSegundaClonales', 'SegundaClonalController@getSegundaClonales')->name('getSegundaClonales');
    Route::get('/getUltimaParcela', 'SegundaClonalController@getUltimaParcelaAjax')->name('getUltimaParcela');
    Route::post('/evaluaciones/saveEvCampoSanidad', 'SegundaClonalController@saveEvCampoSanidad')->name('evaluaciones.saveEvCampoSanidad');
    Route::post('/evaluaciones/saveEvLaboratorio', 'SegundaClonalController@saveEvLaboratorio')->name('evaluaciones.saveEvLaboratorio');
});

// MET
Route::group(['prefix' => '/admin/met', 'as' => 'met.'], function () {
    Route::get('/seleccion/{anio?}/{sector?}', 'METController@index')->name('index');
    Route::get('/inventario', 'METController@inventario')->name('inventario.index');
    Route::get('/evaluaciones/camposanidad/view/{evaluacion}', 'METController@viewEvCampoSanidad')->name('evaluaciones.camposanidad.view');
    Route::get('/evaluaciones/laboratorio/view/{evaluacion}', 'METController@viewEvLaboratorio')->name('evaluaciones.laboratorio.view');
});

// Rutas Ajax MET
Route::group(['prefix' => '/ajax/met', 'as' => 'ajax.met.'], function () {
    Route::post('/saveMET', 'METController@saveMET')->name('saveMET');
    Route::get('/METAsociado', 'METController@getMETAsociado')->name('METAsociado');
    Route::get('/getUltimaParcela', 'METController@getUltimaParcela')->name('getUltimaParcela');
    Route::post('/saveDetalleMET', 'METController@saveDetalleMET')->name('saveDetalleMET');
    Route::post('/evaluaciones/saveEvCampoSanidad', 'METController@saveEvCampoSanidad')->name('evaluaciones.saveEvCampoSanidad');
    Route::post('/evaluaciones/saveEvLaboratorio', 'METController@saveEvLaboratorio')->name('evaluaciones.saveEvLaboratorio');
});

// Rutas ajax Tachos
Route::get('/ajax/tachos/getSubtachosDeTacho', 'TachoController@getSubtachosDeTacho')->name('ajax.tachos.getSubtachosDeTacho');
Route::get('/ajax/tachos/getTachosBoxExportacion', 'TachoController@getTachosBoxExportacion')->name('ajax.tachos.getTachosBoxExportacion');

Route::get('/clear-cache', function () {
    Artisan::call('cache:clear');
    Artisan::call('route:clear');
 
    return "Cache cleared successfully";
 });

 // Evaluaciones campo-sanidad y laboratorio
 Route::middleware('auth')->group(function () {
    Route::group(['prefix' => '/admin/evaluaciones'], function () {
        Route::get('/index/{tipo}/{origen}', 'EvaluacionController@new_index')->name('admin.evaluaciones.index');
        Route::get('/create/{tipo}/{origen}', 'EvaluacionController@new_create')->name('admin.evaluaciones.create');
        Route::post('/store/{tipo}/{origen}', 'EvaluacionController@new_store')->name('admin.evaluaciones.store');
    });  
 });