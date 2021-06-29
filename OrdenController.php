<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Orden;
use App\Detalle;
use App\Area;
use App\Proyecto;
use App\Autorizante;


use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use App\Http\Requests\OrdenFormRequest;
//use Illuminate\Support\Facades\Auth;
use DB;
//use PDF;
use Barryvdh\DomPDF\Facade as PDF;

use Carbon\Carbon;
use Response;
use Illuminate\Support\Collection;

use storage;
use Auth;
use Socialite;
use Illuminate\Support\Facades\Mail;

use App\Exports\OrdenesExport;
use App\Exports\ProyectosExport;
use App\Exports\ItemsExport;
use Maatwebsite\Excel\Facades\Excel;


class OrdenController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request){
            $areauser= DB::table('users as u')
            ->join('areas as a','u.idarea','=','a.idarea')
            ->select('a.nombrearea')
            ->where('u.id','=',Auth::user()->id)
            ->get()
            ->first();
            try{
                $areauser=$areauser->nombrearea;

            }
            catch(\Exception $e){
            echo "<script type=\"text/  javascript\">window.alert('El usuario NO está asociado a ningún Area!!!. Solicítalo al Administrador.');
            window.location.href = '/ordenes/public/o/public/index.php';</script>"; 
            exit;
            } 

        if($request){
           // dd($request);

            $iddestino=$request->get('iddestino');
            $idproyecto=$request->get('idproyecto');
            $idprioridad=$request->get('idprioridad');
            $idrubro=$request->get('idrubro');
            $idsubrubro=$request->get('idsubrubro');
            $idcuenta=$request->get('idcuenta');
            $idautorizante=$request->get('idautorizante');
            $idestado=$request->get('idestado');
            $idproveedor=$request->get('idproveedor');
            $desde=trim($request->get('fechadesde'));
            $hasta=trim($request->get('fechahasta'));
            $ndesde=trim($request->get('numerodesde'));
            $nhasta=trim($request->get('numerohasta'));
            $text=trim($request->get('searchText'));
            if($request->get('accion')=="ordenes"){
                //dd($request);
                return Excel::download(new OrdenesExport($request), 'ordenes.xlsx');
            }

            if($request->get('accion')=="items"){
                return Excel::download(new ItemsExport($request), 'items.xlsx');
            }

            if($request->get('accion')=="proyectos"){
                return Excel::download(new ProyectosExport($request), 'proyectos.xlsx');
            }


            // DESTINO DEL USUARIO LOGUEADO
            $ordenes1=DB::table('ordenes as o')
            ->join('users as u','o.idusuariocreacion','=','u.id')
            ->join('areas as a','o.iddestino','=','a.idarea')
            //->join('proyectos as a','o.idproyecto','=','a.idproyecto')
            //->join('detalles as d','o.idorden','=','d.idorden')
            ->join('estados_orden as e','o.idestado','=','e.idestado')
            ->join('prioridades as p','o.idprioridad','=','p.idprioridad')
            ->select('o.idorden', 'o.iddestino','o.fechacreacion','u.name','a.nombrearea','o.contenido','e.idestado','e.nombreestado','o.comentarios','p.nombreprioridad','ordenacion')

            ->orderBy('o.idestado','asc')
            ->orderBy('o.idorden','desc')
            ->groupBy('o.idorden','o.iddestino','o.fechacreacion','u.name','a.nombrearea','o.contenido','e.idestado','e.nombreestado','o.comentarios','p.nombreprioridad','ordenacion');

            if ($iddestino<>0) {
                $ordenes1 = $ordenes1->where('o.iddestino','=',$iddestino);
            }
            else{
                $ordenes1->where('o.iddestino','=',auth()->user()->idarea);
            }

            if ($idproyecto<>0) {
                $ordenes1 = $ordenes1->where('o.idproyecto','=',$idproyecto);
            }

            if ($idproveedor<>0) {
                $ordenes1 = $ordenes1->where('o.idproveedor','=',$idproveedor);
            }

            if ($idprioridad<>0) {
                $ordenes1 = $ordenes1->where('o.idprioridad','=',$idprioridad);
            }

            if ($idrubro<>0) {
                $ordenes1 = $ordenes1->where('o.idrubro','=',$idrubro);
            }
            
            if ($idsubrubro<>0) {
                $ordenes1 = $ordenes1->where('o.idsubrubro','=',$idsubrubro);
            }

            if ($idcuenta<>0) {
                $ordenes1 = $ordenes1->where('o.idcuenta','=',$idcuenta);
            }

            if ($idautorizante<>0) {
                $ordenes1 = $ordenes1->where('o.idautorizante','=',$idautorizante);
            }

            if ($idestado<>0) {
                $ordenes1 = $ordenes1->where('o.idestado','=',$idestado);
            }

            if ($desde<>"") 
                $desde = date('Y-m-d H:i:s', strtotime($desde));
            else
                $desde = '2019-01-01 00:00:00';    
            
            if ($hasta<>"") 
                $hasta = date('Y-m-d H:i:s', strtotime($hasta));
            else
                $hasta = Carbon::now('America/Argentina/Salta');
            $ordenes1 = $ordenes1->whereBetween('o.fechacreacion', [$desde, $hasta]);
            if ($ndesde<>"") {
                $ordenes1 = $ordenes1->where('o.idorden','>=',$ndesde);
            }
            if ($nhasta<>"") {
                $ordenes1 = $ordenes1->where('o.idorden','<=',$nhasta);
            }
            if ($text<>"") {
                $ordenes1 = $ordenes1->where('o.contenido','LIKE','%'.$text.'%');
            }


            // SOLICITANTE
            $ordenes2=DB::table('ordenes as o')
            ->join('users as u','o.idusuariocreacion','=','u.id')
            ->join('areas as a','o.iddestino','=','a.idarea')
            //->join('detalles as d','o.idorden','=','d.idorden')
            ->join('estados_orden as e','o.idestado','=','e.idestado')
            ->join('prioridades as p','o.idprioridad','=','p.idprioridad')
            ->select('o.idorden','o.iddestino','o.fechacreacion','u.name','a.nombrearea','o.contenido','e.idestado','e.nombreestado','o.comentarios','p.nombreprioridad','ordenacion') 
            ->orderBy('o.idestado','asc')
            ->orderBy('o.idorden','desc')
            ->groupBy('o.idorden','o.iddestino','o.fechacreacion','u.name','a.nombrearea','o.contenido','e.idestado','e.nombreestado','o.comentarios','p.nombreprioridad','ordenacion');

            $ordenes2->where('o.idusuariocreacion','=',auth()->user()->id);

            //$ordenes2->where('o.iddestino','=',auth()->user()->idarea);

            if ($iddestino<>0) {
                $ordenes2 = $ordenes2->where('o.iddestino','=',$iddestino);
            }

            if ($idproyecto<>0) {
                $ordenes2 = $ordenes2->where('o.idproyecto','=',$idproyecto);
            }

            if ($idprioridad<>0) {
                $ordenes2 = $ordenes2->where('o.idprioridad','=',$idprioridad);
            }

            if ($idrubro<>0) {
                $ordenes2 = $ordenes2->where('o.idrubro','=',$idrubro);
            }
            
            if ($idsubrubro<>0) {
                $ordenes2 = $ordenes2->where('o.idsubrubro','=',$idsubrubro);
            }

            if ($idcuenta<>0) {
                $ordenes2 = $ordenes2->where('o.idcuenta','=',$idcuenta);
            }

            if ($idautorizante<>0) {
                $ordenes2 = $ordenes2->where('o.idautorizante','=',$idautorizante);
            }

            if ($idestado<>0) {
                $ordenes2 = $ordenes2->where('o.idestado','=',$idestado);
            }

            if ($idproveedor<>0) {
                $ordenes2 = $ordenes2->where('o.idproveedor','=',$idproveedor);
            }

            if ($desde<>"") 
                $desde = date('Y-m-d H:i:s', strtotime($desde));
            else
                $desde = '2019-01-01 00:00:00';    
            
            if ($hasta<>"") 
                $hasta = date('Y-m-d H:i:s', strtotime($hasta));
            else
                $hasta = Carbon::now('America/Argentina/Salta');
            $ordenes2 = $ordenes2->whereBetween('o.fechacreacion', [$desde, $hasta]);

            if ($ndesde<>"") {
                $ordenes2 = $ordenes2->where('o.idorden','>=',$ndesde);
            }
            if ($nhasta<>"") {
                $ordenes2 = $ordenes2->where('o.idorden','<=',$nhasta);
            }
            
            if ($text<>"") {
                $ordenes2 = $ordenes2->where('o.contenido','LIKE','%'.$text.'%');
            }
 
            // AUTORIZANTE
            $ordenes3=DB::table('ordenes as o')
            ->join('users as u','o.idusuariocreacion','=','u.id')
            ->join('areas as a','o.iddestino','=','a.idarea')
            //->join('detalles as d','o.idorden','=','d.idorden')
            ->join('estados_orden as e','o.idestado','=','e.idestado')
            ->join('prioridades as p','o.idprioridad','=','p.idprioridad')
            ->select('o.idorden','o.iddestino','o.fechacreacion','u.name','a.nombrearea','o.contenido','e.idestado','e.nombreestado','o.comentarios','p.nombreprioridad','ordenacion') 
            ->orderBy('o.idestado','asc')
            ->orderBy('o.idorden','desc')
            ->groupBy('o.idorden','o.iddestino','o.fechacreacion','u.name','a.nombrearea','o.contenido','e.idestado','e.nombreestado','o.comentarios','p.nombreprioridad','ordenacion');
               
            $ordenes3->where('o.idautorizante','=',auth()->user()->id);

            if ($iddestino<>0) {
                $ordenes3 = $ordenes3->where('o.iddestino','=',$iddestino);
            }

             if ($idproyecto<>0) {
                $ordenes3 = $ordenes3->where('o.idproyecto','=',$idproyecto);
            }

            if ($idprioridad<>0) {
                $ordenes3 = $ordenes3->where('o.idprioridad','=',$idprioridad);
            }

            if ($idrubro<>0) {
                $ordenes3 = $ordenes3->where('o.idrubro','=',$idrubro);
            }
            
            if ($idsubrubro<>0) {
                $ordenes3 = $ordenes3->where('o.idsubrubro','=',$idsubrubro);
            }

            if ($idcuenta<>0) {
                $ordenes3 = $ordenes3->where('o.idcuenta','=',$idcuenta);
            }

            if ($idautorizante<>0) {
                $ordenes3 = $ordenes3->where('o.idautorizante','=',$idautorizante);
            }

            if ($idestado<>0) {
                $ordenes3 = $ordenes3->where('o.idestado','=',$idestado);
            }

            if ($idproveedor<>0) {
                $ordenes3 = $ordenes3->where('o.idproveedor','=',$idproveedor);
            }

            if ($desde<>"") 
                $desde = date('Y-m-d H:i:s', strtotime($desde));
            else
                $desde = '2019-01-01 00:00:00';    
            
            if ($hasta<>"") 
                $hasta = date('Y-m-d H:i:s', strtotime($hasta));
            else
                $hasta = Carbon::now('America/Argentina/Salta');
            $ordenes3 = $ordenes3->whereBetween('o.fechacreacion', [$desde, $hasta]);
            if ($ndesde<>"") {
                $ordenes3 = $ordenes3->where('o.idorden','>=',$ndesde);
            }
            if ($nhasta<>"") {
                $ordenes3 = $ordenes3->where('o.idorden','<=',$nhasta);
            }
            if ($text<>"") {
                $ordenes3 = $ordenes3->where('o.contenido','LIKE','%'.$text.'%');
            }


            // SI EL USUARIO LOGUEADO ES DE ADMINISTRACION, VÉ TODAS 
            $ordenes4=DB::table('ordenes as o')
            ->join('users as u','o.idusuariocreacion','=','u.id')
            ->join('areas as a','o.iddestino','=','a.idarea')
            //->join('detalles as d','o.idorden','=','d.idorden')
            ->join('estados_orden as e','o.idestado','=','e.idestado')
            ->join('prioridades as p','o.idprioridad','=','p.idprioridad')
            ->select('o.idorden','o.iddestino','o.fechacreacion','u.name','a.nombrearea','o.contenido','e.idestado','e.nombreestado','o.comentarios','p.nombreprioridad','ordenacion') 
            ->orderBy('o.idestado','asc')
            ->orderBy('o.idorden','desc')
            ->groupBy('o.idorden','o.iddestino','o.fechacreacion','u.name','a.nombrearea','o.contenido','e.idestado','e.nombreestado','o.comentarios','p.nombreprioridad','ordenacion');

           // $ordenes4->where('o.idestado','!=','1');//Administración -ve todas MENOS LAS QUE ESTÁN
            // EN EL ESTADO "PENDIENTE DE AUTORIZACION"  - ya no es asi

            if ($iddestino<>0) {
                $ordenes4 = $ordenes4->where('o.iddestino','=',$iddestino);
            }

            if ($idproyecto<>0) {
                $ordenes4 = $ordenes4->where('o.idproyecto','=',$idproyecto);
            }

            if ($idprioridad<>0) {
                $ordenes4 = $ordenes4->where('o.idprioridad','=',$idprioridad);
            }

            if ($idrubro<>0) {
                $ordenes4 = $ordenes4->where('o.idrubro','=',$idrubro);
            }
            
            if ($idsubrubro<>0) {
                $ordenes4 = $ordenes4->where('o.idsubrubro','=',$idsubrubro);
            }

            if ($idcuenta<>0) {
                $ordenes4 = $ordenes4->where('o.idcuenta','=',$idcuenta);
            }

            if ($idautorizante<>0) {
                $ordenes4 = $ordenes4->where('o.idautorizante','=',$idautorizante);
            }

            if ($idestado<>0) {
                $ordenes4 = $ordenes4->where('o.idestado','=',$idestado);
            }

            if ($idproveedor<>0) {
                $ordenes4 = $ordenes4->where('o.idproveedor','=',$idproveedor);
            }

            if ($desde<>"") 
                $desde = date('Y-m-d H:i:s', strtotime($desde));
            else
                $desde = '2019-01-01 00:00:00';    
            
            if ($hasta<>"") 
                $hasta = date('Y-m-d H:i:s', strtotime($hasta));
            else
                $hasta = Carbon::now('America/Argentina/Salta');
            $ordenes4 = $ordenes4->whereBetween('o.fechacreacion', [$desde, $hasta]);
            if ($ndesde<>"") {
                $ordenes4 = $ordenes4->where('o.idorden','>=',$ndesde);
            }
            if ($nhasta<>"") {
                $ordenes4 = $ordenes4->where('o.idorden','<=',$nhasta);
            }
            if ($text<>"") {
                $ordenes4 = $ordenes4->where('o.contenido','LIKE','%'.$text.'%');
            }

            if(auth()->user()->idarea == '1') //Admnaliinistracion
                $ordenes = $ordenes1-> union($ordenes2)->union($ordenes3)->union($ordenes4);
            else
                $ordenes = $ordenes1-> union($ordenes2)->union($ordenes3);

            

            //$query = DB::query()->fromSub($ordenes, "some_query_name");
            //$ordenes = $ordenes1-> union($ordenes2)->union($ordenes3);
            $ordenes = $ordenes
            ->orderBy('idorden','desc')
            ->orderBy('ordenacion','asc')
            ->simplePaginate(15);


 //         ->paginate(7);

        
          try{    
            $areas = DB::table('areas as a')
            ->select('a.idarea','a.nombrearea')
            ->where('a.activo','=','1')
            ->get();
            
            }
            catch(\Exception $e){
            echo "<script type=\"text/javascript\">window.alert('El usuario NO está asociado a ningún Area!!!. Solicítalo al Administrador.');
            window.location.href = '/index.php';</script>"; 
            exit;
            }    


        $proyectos = DB::table('proyectos as p')
            ->select('p.idproyecto','p.nombreproyecto')
            ->where('p.activo','=','1')
            ->get();   

        $rubros = DB::table('rubros as r')
            ->select('r.idrubro','r.nombrerubro')
            ->where('r.activo','=','1')
            ->get();

        $cuentas = DB::table('cuentas as c')
            ->select('c.idcuenta','c.nombrecuenta')
            ->where('c.activo','=','1')
            ->get();
        //Autorizantes del area a la que pertenece el usuario logueado
        $autorizantesarea = DB::table('autorizantes as a')
            ->join('users as u','a.iduser','=','u.id')
            ->select('a.idautorizacion','a.montomaximo','u.id','u.name')
            ->where('a.idarea','=',auth()->user()->idarea)
            ->get();

        // Autorizantes de todas las areas
        $autorizantes = DB::table('autorizantes as a')
            ->leftjoin('users as u','a.iduser','=','u.id')
            ->select('u.id','u.name')
            ->distinct('u.id')
            ->where('a.activo','=','1')
            ->get();
            
        $subrubros = DB::table('subrubros as s')
            ->select('s.idsubrubro','s.nombresubrubro')
            ->where('s.activo','=','1')
            ->get();

        $prioridades = DB::table('prioridades as p')
            ->select('p.idprioridad','p.nombreprioridad')
            ->where('p.activo','=','1')
            ->get();

        $estados = DB::table('estados_orden as e')
            ->select('e.idestado','e.nombreestado')
            ->where('e.activo','=','1')
            ->get();
        $proveedores = DB::table('proveedores as pr')
            ->select('pr.idproveedor','pr.nombreproveedor')
            ->where('pr.activo','=','1')
            ->orderBy('pr.nombreproveedor','asc')
            ->get();
        //Ordenes con item no recibidos   
        $date_now = date('Y-m-d');
        $date_past = strtotime('-2 day', strtotime($date_now));
        $date_past = date('Y-m-d', $date_past);
            //dd($date_past);
            $NoRecibidas = DB::table('ordenes')
            ->leftJoin('detalles', 'ordenes.idorden', '=', 'detalles.idorden')
            ->leftJoin('users', 'ordenes.idusuariocreacion', '=', 'users.id')
            ->select('ordenes.idorden','fechaentregado')
            ->where('entregado','=','1')
            ->where('recibido','=','0')
            ->whereDate('fechaentregado', '<=', $date_past) //Where date se encarga de hacer la comparación entre fechas
//            ->where(Carbon::parse('fechaentregado'), '<', $date_past)
            //->where(STR_TO_DATE('fechaentregado','%Y-%m-%d'), '<', $date_past)
           // ->whereRaw('DATEDIFF(CURDATE(),STR_TO_DATE(created_at, '%Y-%m-%d'))'), 2)

            //->whereDate(Carbon::createFromFormat('Y-m-d', '2019-12-28')->diffInDays(Carbon::now()),'>','200')
            ->groupBy('ordenes.idorden','fechaentregado')
            ->get();
            //dd($NoRecibidas);
            return view('ordenes.index',["ordenes"=>$ordenes,"areas"=>$areas,"proyectos"=>$proyectos,"autorizantes"=>$autorizantes,"autorizantesarea"=>$autorizantesarea,"rubros"=>$rubros,"subrubros"=>$subrubros,"cuentas"=>$cuentas,"prioridades"=>$prioridades,"estados"=>$estados,"proveedores"=>$proveedores, "areauser"=>$areauser,"fechadesde"=>$desde,"fechahasta"=>$hasta,"numerodesde"=>$ndesde,"numerohasta"=>$nhasta,"searchText"=>$text,"iddestino"=>$iddestino,"idprioridad"=>$idprioridad,"idrubro"=>$idrubro,"idsubrubro"=>$idsubrubro,"idcuenta"=>$idcuenta,"idautorizante"=>$idautorizante,"idestado"=>$idestado,"idproveedor"=>$idproveedor,"desde"=>$desde,"hasta"=>$hasta,"text"=>$text,"NoRecibidas"=>$NoRecibidas]);
            //return $iddestino;
            //,"areas"=>$areas,"autorizantes"=>$autorizantes,"autorizantesarea"=>$autorizantesarea,"rubros"=>$rubros,"subrubros"=>$subrubros,"prioridades"=>$prioridades,"estados"=>$estados,"proveedores"=>$proveedores, "areauser"=>$areauser,"fechadesde"=>$desde,"fechahasta"=>$hasta,"searchText"=>$text]);
        }
    }
    public function create()
    {
        $areauser= DB::table('users as u')
            ->join('areas as a','u.idarea','=','a.idarea')
            ->select('a.nombrearea')
            ->where('u.id','=',auth()->user()->id)
            ->get()
            ->first();
        $areauser=$areauser->nombrearea;

        $areas = DB::table('areas as a')
            ->select('a.idarea','a.nombrearea')
            ->where('a.activo','=','1')
            ->get();
        $proyectos = DB::table('proyectos as p')
            ->select('p.idproyecto','p.nombreproyecto')
            ->where('p.activo','=','1')
           // ->where('p.idarea','=',$idproyecto)
            ->get();
            
        $rubros = DB::table('rubros as r')
            ->select('r.idrubro','r.nombrerubro')
            ->where('r.activo','=','1')
            ->get();

        $autorizantes = DB::table('autorizantes as a')
            ->join('users as u','a.iduser','=','u.id')
            ->select('a.idautorizacion','a.montomaximo','u.id','u.name')
            ->where('a.idarea','=',auth()->user()->idarea)
            ->get();
            
        $subrubros = DB::table('subrubros as s')
            ->select('s.idsubrubro','s.nombresubrubro')
            ->where('s.activo','=','1')
            ->get();

        $cuentas = DB::table('cuentas as c')
            ->select('c.idcuenta','c.nombrecuenta')
            ->where('c.activo','=','1')
            ->get();

        $prioridades = DB::table('prioridades as p')
            ->select('p.idprioridad','p.nombreprioridad')
            ->where('p.activo','=','1')
            ->get();
        $proveedores = DB::table('proveedores as p')
            ->select('p.idproveedor','p.NombreProveedor')
            ->where('p.activo','=','1')
            ->orderBy('p.NombreProveedor','asc')
            ->get();

        $estados = DB::table('estados_orden as e')
            ->select('e.idestado','e.nombreestado')
            ->where('e.activo','=','1')
            ->get();

         $areass = DB::table('areas as a')
            ->select('a.idarea','a.nombrearea')
            ->where('a.activo','=','1')
            ->get();

        return view("ordenes.create",["areas"=>$areas,"autorizantes"=>$autorizantes,"rubros"=>$rubros,"subrubros"=>$subrubros,"prioridades"=>$prioridades,"proveedores"=>$proveedores,"estados"=>$estados, "areauser"=>$areauser,compact($areass)]);
    }

    public function store(OrdenFormRequest $request)
    {

        $concepto = $request->get('concepto');
        $cantidad = $request->get('cantidad');
        $precioestimado = $request->get('precioestimado');
        if (isset($concepto)) {

            $autorizante = DB::table('autorizantes')
            ->select('montomaximo')
            ->where('iduser','=',$request->get('autorizante'))
            ->where('idarea','=',$request->get('destino'))
            ->get();

            $monto=0;
            $cont=0;
            while($cont<count($concepto)){
                $monto = $monto + $cantidad[$cont] * $precioestimado[$cont];
                $cont = $cont+1;
            }
            $autorizado = $autorizante[0]->montomaximo;
             if( $monto <= $autorizado ){
                if($this->cotizacionalta($request, $monto)){


    //try{
    //    DB::beginTransaction();
        $orden=new Orden;
        //$orden->idarea=$request->get('idarea');
        $orden->iddestino=$request->get('destino');
        //$orden->idproyecto=$request->get('proyecto'); Ahora se juntan con las areas en Destino
        $orden->idautorizante=$request->get('autorizante');
        $orden->idrubro=$request->get('idrubro'); //Rubro
        $orden->idsubrubro=$request->get('idsubrubro'); //Subrubro
        $orden->idcuenta=$request->get('idcuenta'); //Cuenta
        $orden->idprioridad=$request->get('idprioridad'); 
        $orden->idestado=1;//Pendiente de Autorización
        //$orden->idobjetivo=1;//Campo sin usar por el momento
        $orden->idproveedor=$request->get('idproveedor');
        $orden->fechaentrega=$request->get('fechaentrega');
        $orden->comentarios=$request->get('comentarios');
        $orden->idusuariocreacion=(int) auth()->id();; 
        $mytime=Carbon::now('America/Argentina/Salta');
        $orden->fechacreacion=$mytime->toDateTimeString();
        
        $orden->activo=1;
        $orden->save();

        
        $proyectos = $request->get('idproyecto');
        $porcentajes = $request->get('porcentaje');
        $mytime=Carbon::now('America/Argentina/Salta');
        $cont=0;
        while($cont<count($proyectos)){
            $attach_data[$cont] = [
                'idproyecto'    => $proyectos[$cont],
                'idorden'       => $orden->idorden,
                'porcentaje'    => $porcentajes[$cont],
            //    'monto'         => round($monto*$porcentajes[$cont]/100),
                'fecha'         => $mytime->toDateTimeString()
            ];
            $cont = $cont+1;
        }

        $orden->proyectos()->attach($attach_data).




        $id = $orden->idorden;

        $cantidad = $request->get('cantidad');
        $concepto = $request->get('concepto');
        $precioestimado = $request->get('precioestimado');
        
        $contenido = "";

        $cont=0;
        while($cont<count($concepto)){
            $detalle = new Detalle();
            $detalle->idorden = $id;
            $detalle->numero=$cont+1;
            $detalle->cantidad=$cantidad[$cont];
            $detalle->concepto=$concepto[$cont];
            $detalle->precioestimado=$precioestimado[$cont];
            $detalle->idestado=1; //Pendiente
            $detalle->entregado=0;
            $detalle->pagado=0;
            $detalle->recibido=0;
            $detalle->anulado=0;
            $detalle->activo=1;

            $contenido = $contenido ." ". $detalle->concepto;

            $detalle->save();


            $cont = $cont+1;
        }

        $orden->contenido=substr($contenido, 0, 59);
        if ($request->cotizacionunicasolicitante=='on'){
            $orden->proveedorunicosolicitante=1;
        }else{
            $orden->proveedorunicosolicitante=0;
        }


        if($request->cotizacion1){
            $archivo = $request->cotizacion1;
            $nombre = $id.'Cotizacion1'.'.pdf';
            $request->cotizacion1->move(public_path('/cotizaciones'), $nombre);
            $orden->cotizacion1 = $nombre;
            $orden->update();
        }
        if($request->cotizacion2){
             $archivo = $request->cotizacion2;
             $nombre = $id.'Cotizacion2'.'.pdf';
            $request->cotizacion2->move(public_path('/cotizaciones'), $nombre);
            $orden->cotizacion2 = $nombre;
            $orden->update();
        }
        if($request->cotizacion3){
             $archivo = $request->cotizacion3;
             $nombre = $id.'Cotizacion3'.'.pdf';
            $request->cotizacion3->move(public_path('/cotizaciones'), $nombre);
            $orden->cotizacion3 = $nombre;
            $orden->update();
        }




        $orden->update();
        //EnviaMail($id);
        $asunto = 'Nueva Orden de Requerimientos';
        $this->EnviaMail($id,$asunto);


        // $to_name = 'Sistema Ordenes';
        // $to_email = 'darsalta@gmail.com';
        // $data = ["orden"=>$orden,"detalles"=>$det,"autorizante"=>$autorizante];//array('name'=>"Sam Jose", "body" => "Test mail");
        // $template= 'ordenes/mail'; 
        // Mail::send($template, $data, function($message) use ($to_name, $to_email) {
        //     $message->to($to_email, $to_name)
        //         ->subject('Nueva Orden de Requerimientos');
        //     $message->from('lachacraexperimental@gmail.com','Nueva Orden de Requerimientos');
        // });

        DB::commit();
    }else{

        echo "<script type=\"text/javascript\">window.alert('El monto solicitado requiere de 3 cotizaciones o la autorización de Germán Serino para la presentación de una única cotización.');
                history.go(-1);</script>"; 
                exit;
    }
    }else{
        echo "<script type=\"text/javascript\">window.alert('El monto supera el valor máximo para el Autorizante seleccionado.');
            history.go(-1);</script>"; 
            exit;
    }

    }else{
            echo "<script type=\"text/javascript\">window.alert('La orden NO tiene asociada ningún item.');
            history.go(-1);</script>"; 
            exit;
        
    }

    //  }catch(\Exception $e){
    //    DB::rollback();
    //}
       // echo $monto;
       // echo $autorizante[0]->montomaximo;
    return Redirect::to('ordenes');
    }

     public function edit($id)
     {
        $areas = DB::table('areas as a')
            ->select('a.idarea','a.nombrearea')
            ->where('a.activo','=','1')
            ->get();
        $destinos = DB::table('areas as a')
            ->select('a.idarea','a.nombrearea')
            ->where('a.activo','=','1')
            ->get();
/*        $proyectos = DB::table('proyectos as p')
            ->select('p.idproyecto','p.nombreproyecto')
            ->where('p.activo','=','1')
           // ->where('p.idarea','=',$idproyecto)
            ->get();*/
            
        $rubros = DB::table('rubros as r')
            ->select('r.idrubro','r.nombrerubro')
            ->where('r.activo','=','1')
            ->get();

        $autorizantes = DB::table('autorizantes as a')
            ->join('users as u','a.iduser','=','u.id')
            ->select('a.idautorizacion','a.montomaximo','u.id','u.name')
            ->where('a.idarea','=',auth()->user()->idarea)
            ->get();

        $subrubros = DB::table('subrubros as s')
            ->select('s.idsubrubro','s.nombresubrubro')
            ->where('s.activo','=','1')
            ->get();

        $cuentas = DB::table('cuentas as c')
            ->select('c.idcuenta','c.nombrecuenta')
            ->where('c.activo','=','1')
            ->get();

        $prioridades = DB::table('prioridades as p')
            ->select('p.idprioridad','p.nombreprioridad')
            ->where('p.activo','=','1')
            ->get();

        $detalles = DB::table('detalles as d')
            ->select('d.iddetalle','d.cantidad','d.concepto','d.precioestimado','idestado','entregado','pagado','recibido','anulado',DB::raw('DATE_FORMAT(fechaentregado, "%d-%m-%Y") as fechaentregado'),'fechapagado','fecharecibido','fechaanulado',DB::raw('IFNULL(d.preciofinal, 0) AS preciofinal'))
            ->where('d.idorden','=',$id)
            ->where('d.activo','=','1')
            ->get();

//        dd($detalles);

        $estados = DB::table('estados_orden as e')
            ->select('e.idestado','e.nombreestado')
            ->where('e.activo','=','1')
            ->get();
        $estados_item = DB::table('estados_item as e')
            ->select('e.idestado','e.nombreestado')
            ->where('e.activo','=','1')
            ->get();
        $proveedores = DB::table('proveedores as e')
            ->select('e.idproveedor','e.nombreproveedor')
            ->where('e.activo','=','1')
            ->get();
        $solicitante = DB::table('users as u')
            ->join('ordenes as o', 'u.id','=','o.idusuariocreacion') 
            ->select('u.name')
            ->where('o.idorden','=',$id)
            ->first();
        $autorizante = DB::table('users as u')
            ->join('ordenes as o', 'u.id','=','o.idautorizante') 
            ->select('u.name')
            ->where('o.idorden','=',$id)
            ->first();
        $esresponsablecajachica = DB::table('users as u')
            ->select('u.esresponsablecajachica')
            ->where('u.id','=',(int) auth()->id())
            ->first();
        $esresponsabletarjetacredito = DB::table('users as u')
            ->select('u.esresponsabletarjetacredito')
            ->where('u.id','=',(int) auth()->id())
            ->first();
        $destino = DB::table('ordenes as o')
            ->select('iddestino')
            ->where('o.idorden','=',$id)
            ->get();


        $proyectos=DB::table('area_proyecto as ap')
            ->leftjoin('proyectos as p','p.idproyecto','=','ap.idproyecto')
            ->select('p.idproyecto','p.nombreproyecto')
            ->where('ap.idarea','=',$destino[0]->iddestino)
            ->get();
        $proyectosafectados=DB::table('area_proyecto as ap')
            ->leftjoin('proyectos as p','p.idproyecto','=','ap.idproyecto')
            ->leftjoin('orden_proyecto as op','ap.idproyecto','=','op.idproyecto')
            ->select('ap.idproyecto','p.nombreproyecto','op.idorden','op.porcentaje','op.monto')
            ->where('ap.idarea','=',$destino[0]->iddestino)
            ->where('op.idorden','=',$id)
            ->get();

     return view("ordenes.edit",["orden"=>Orden::findOrFail($id),"areas"=>$areas,"autorizantes"=>$autorizantes,"destinos"=>$destinos,"rubros"=>$rubros,"subrubros"=>$subrubros,"cuentas"=>$cuentas,"prioridades"=>$prioridades,"estados"=>$estados,"estados_item"=>$estados_item,"detalles"=>$detalles,"proveedores"=>$proveedores,"solicitante"=>$solicitante,"autorizante"=>$autorizante,"proyectos"=>$proyectos,"proyectosafectados"=>$proyectosafectados,"esresponsablecajachica"=>$esresponsablecajachica,"esresponsabletarjetacredito"=>$esresponsabletarjetacredito]);


     }
    
    public function update(OrdenFormRequest $request,$id)
    {
  //      $concepto = $request->get('concepto');
  //      if (isset($concepto)) {
  //      try{
        //DB::beginTransaction();
        $concepto = $request->get('concepto');
        $cantidad = $request->get('cantidad');
        $precioestimado = $request->get('precioestimado');

        if (isset($concepto)) {


            $orden=Orden::findOrFail($id);
            $montomaximo = DB::table('autorizantes')
            ->select('montomaximo')
            ->where('iduser','=',$orden->idautorizante)
            ->where('idarea','=',$orden->iddestino)
            ->get();


            $monto=0;
            $cont=0;
            while($cont<count($concepto)){
                $monto = $monto + $cantidad[$cont] * $precioestimado[$cont];
                $cont = $cont+1;
            }
 //                       dd($montomaximo);
            if( $monto <= $montomaximo[0]->montomaximo ){
                // ES EL SOLICITANTE Y ESTA PENDIENTE
                if($this->cotizacion($request, $monto, $id)){
                    if($orden->idusuariocreacion == (int) auth()->id()){ //es el solicitante
                        if($orden->idestado == 1){//Pendiente
                        //echo ("Originante");
                        $orden->iddestino=$request->get('destino');
                        //$orden->idproyecto=$request->get('proyecto');
                        $orden->idautorizante=$request->get('autorizante');
                        $orden->idrubro=$request->get('idrubro'); //Rubro
                        $orden->idsubrubro=$request->get('idsubrubro'); //Subrubro
                        $orden->idcuenta=$request->get('idcuenta'); //Cuenta
                        $orden->idprioridad=$request->get('idprioridad');//$request->get('idprioridad'); 
                        $orden->idproveedor=$request->get('idproveedor');
                        $orden->fechaentrega=$request->get('fechaentrega');
                        $orden->comentarios=$request->get('comentarios');
                        $orden->idusuariomodificacion=(int) auth()->id(); 
                        $mytime=Carbon::now('America/Argentina/Salta');
                        $orden->fechamodificacion=$mytime->toDateTimeString();
                        if ($request->cotizacionunicasolicitante=='on'){
                            $orden->proveedorunicosolicitante=1;
                        }else{
                            $orden->proveedorunicosolicitante=0;
                        }
                        $orden->update();

                        DB::table('orden_proyecto')->where('idorden','=',$orden->idorden)->delete();//borro los proyectos de la orden

                        $proyectos = $request->get('idproyecto');
                        $porcentajes = $request->get('porcentaje');
                        $mytime=Carbon::now('America/Argentina/Salta');
                        $cont=0;
                        while($cont<count($proyectos)){
                            $attach_data[$cont] = [
                                'idproyecto'    => $proyectos[$cont],
                                'idorden'       => $orden->idorden,
                                'porcentaje'    => $porcentajes[$cont],
                                'monto'         => round($monto*$porcentajes[$cont]/100),
                                'fecha'         => $mytime->toDateTimeString()
                            ];
                            $cont = $cont+1;
                        }

                        $orden->proyectos()->attach($attach_data).
                    
                    //$usuario=DB::table('detalles')->where('idorden','=',$id)->delete();//borro el detalle existente

                    //Detalle::where('idorden', $orden->idorden)->firstOrFail();
                    DB::table('detalles')
                    ->where('idorden',$orden->idorden)
                    ->update(['activo'=>'0']);

                    $ids = $request->get('iddetalle');
                    $cantidad = $request->get('cantidad');
                    $concepto = $request->get('concepto');
                    $precioestimado = $request->get('precioestimado');

                    $contenido = "";
                    $cont = 0;
                    $contmax=count($ids);
                    //echo $contmax;
                    //dd(count($concepto));
                    while($cont<count($concepto)){
                        if($ids[$cont]==0){
                            //$detalle = Detalle::find($ids[$cont]);
                            //echo $detalle->idorden;
                            $detalle = new Detalle();
                            $detalle->idorden = $orden->idorden;
                            $detalle->numero=$contmax;
                            $detalle->cantidad=$cantidad[$cont];
                            $detalle->concepto=$concepto[$cont];
                            $detalle->precioestimado=$precioestimado[$cont];
                            $detalle->idestado=1;
                            $detalle->activo=1;
                            $detalle->entregado=0;
                            $detalle->pagado=0;
                            $detalle->recibido=0;
                            $detalle->anulado=0;
                            $detalle->save();
                            $contenido = $contenido ." ". $detalle->concepto;
                            $contmax = $contmax+1;

                           //echo $contmax;
                        }else{
                            //echo $detalle->numero;
                            $detalle=Detalle::findOrFail($ids[$cont]);
                            $detalle->cantidad=$cantidad[$cont];
                            $detalle->concepto=$concepto[$cont];
                            $detalle->precioestimado=$precioestimado[$cont];
                            $detalle->activo=1;
                            $detalle->entregado=0;
                            $detalle->pagado=0;
                            $detalle->recibido=0;
                            $detalle->anulado=0;
                            $detalle->update();
                            $contenido = $contenido ." ". $detalle->concepto;
                            }
                        $cont++;

                    }
                    $orden->contenido=substr($contenido, 0, 50);
                    $orden->update();
                    
                }
               // dd($contmax);
        }
        // ES EL AUTORIZANTE
        if($orden->idautorizante == (int) auth()->id()){ // es el autorizante
            //echo ("Autorizante");
            $orden->idestado=$request->get('idestado');
            $orden->comentariosautorizacion=$request->get('comentariosautorizacion');
            $orden->idusuariomodificacion=(int) auth()->id(); 
            $mytime=Carbon::now('America/Argentina/Salta');
            $orden->fechamodificacion=$mytime->toDateTimeString();
            $orden->fechaautorizacion=$mytime->toDateTimeString();
            if ($request->cotizacionunica=='on'){
                $orden->proveedorunicoautorizante=1;
            }else{
                $orden->proveedorunicoautorizante=0;
            }
            $orden->update();

            //Si el estado es anulada tengo que anular todos los items de la orden
            if($request->get('idestado') == 5){//Anulada
                $iddetalle = $request->get('iddetalle');
                $cont=0;
                while($cont<count($iddetalle)){
                    $detalle=Detalle::findOrFail($iddetalle[$cont]);

                    $detalle->anulado=1;
                    $detalle->fechaanulado=date('d-m-Y');
                    $detalle->idanulo=auth()->user()->id;
                    
                    $detalle->update();
                    //echo $detalle;
                    $cont = $cont+1;
                }  
            }   
        }

        if(auth()->user()->idarea==1 && $orden->idestado > 1){//Administracion
            //echo ("Administracion");
            $orden->comentariosadministracion=$request->get('comentariosadministracion');
            $orden->fechaentregaadministracion=$request->get('fechaentregaadministracion');
            $orden->idusuariomodificacion=(int) auth()->id(); 
            $mytime=Carbon::now('America/Argentina/Salta');
            $orden->fechamodificacion=$mytime->toDateTimeString();
            $orden->update();
        }


        // NO ESTA PENDIENTE
        if((auth()->user()->idarea == 1 ||auth()->user()->idarea==$orden->iddestino) && $orden->idestado != 1){//(es de administracion o es DEL AREA) y no está pendiente

            $iddetalle = $request->get('iddetalle');
            $entregado = $request->get('entregado');
            $recibido = $request->get('recibido');
            $anulado = $request->get('anulado');
            $fechaentregado = $request->get('autfechaentregado');
            $fecharecibido = $request->get('autfecharecibido');
            $fechaanulado = $request->get('autfechaanulado');
            $cont=0;
            while($cont<count($recibido)){
                $detalle=Detalle::findOrFail($iddetalle[$cont]);
                if($entregado[$cont]!="0" && $detalle->entregado==0){
                    $detalle->entregado=$entregado[$cont];
                    $detalle->fechaentregado=date("Y-m-d",strtotime($fechaentregado[$cont]));
                    $detalle->identrego=auth()->user()->id;
                }
                if($recibido[$cont]!="0" && $detalle->recibido==0){
                    $detalle->recibido=$recibido[$cont];
                    $detalle->fecharecibido=date("Y-m-d",strtotime($fecharecibido[$cont]));
                    $detalle->idrecibio=auth()->user()->id;
                }
                if($anulado[$cont]!="0" && $detalle->anulado==0){
                    $detalle->anulado=$anulado[$cont];
                    $detalle->fechaanulado=date("Y-m-d",strtotime($fechaanulado[$cont]));
                    $detalle->idanulo=auth()->user()->id;
                }
                $detalle->update();

                $cont = $cont+1;
            }
            
        }
           
        //si el usuario es responsable de caja chica o tarjeta de credito, entonces paga (si el destino es su area)
        // dd(auth()->user()->esresponsablecajachica +100+ auth()->user()->esresponsabletarjetacredito +10+ auth()->user()->idarea);
        // && (auth()->user()->idarea==$orden->iddestino || auth()->user()->idarea==1)
        if((auth()->user()->esresponsablecajachica==1 || auth()->user()->esresponsabletarjetacredito == 1)) {

            $iddetalle = $request->get('iddetalle');
            $pagado = $request->get('pagado');
            $fechapagado = $request->get('autfechapagado');
            $cantidad = $request->get('cantidad');
            $precioestimado = $request->get('precioestimado');
            $preciofinal = $request->get('preciofinal');
            $preciofinalaux = $request->get('preciofinalaux');
            $monto=0;
            $cont=0;
            while($cont<count($pagado)){
                if($preciofinalaux[$cont]>0){
                    $monto= $monto + ($preciofinalaux[$cont]*$cantidad[$cont]);
                }else{
                    $monto= $monto + ($precioestimado[$cont]*$cantidad[$cont]);
                }
                if($iddetalle[$cont]>0){
                    $detalle=Detalle::findOrFail($iddetalle[$cont]);
                    //Sdd($detalle);
                    if($pagado[$cont]!="0" && $detalle->pagado==0 ){
                        $detalle->pagado=$pagado[$cont];
                        $detalle->fechapagado=$fechapagado[$cont];
                        $detalle->idpago=auth()->user()->id;
                        $detalle->preciofinal=$preciofinalaux[$cont];
                    }
                }

                $detalle->update();
                $cont = $cont+1;
            }

            $proyectos = DB::table('orden_proyecto')
                     ->select(DB::raw('*'))
                     ->where('idorden', '=', $orden->idorden)
                     ->get();
            DB::table('orden_proyecto')->where('idorden','=',$orden->idorden)->delete();//borro los proyectos de la orden
             $mytime=Carbon::now('America/Argentina/Salta');
             $cont=0;
             foreach ($proyectos as $proyecto){

                $attach_data[$cont] = [
                'idproyecto'    => $proyecto->idproyecto,
                'idorden'       => $proyecto->idorden,
                'porcentaje'    => $proyecto->porcentaje,
                'monto'         => round($monto*$proyecto->porcentaje/100,2),
                'fecha'         => $mytime->toDateTimeString()
                ];
                $cont = $cont+1;
            }

            $orden->proyectos()->attach($attach_data);


        }

        if($request->get('accion')=="finalizar"){
            $orden=Orden::findOrFail($id);
            $orden->idestado = "10"; //finalizada
            $orden->update();
        }

        //Recibimos el archivo y lo guardamos en la carpeta storage/app/public
        //$request->file('presupuesto1')->store('public');
        //dd($request->cotizacionunica);
        if($request->cotizacion1){
             $archivo = $request->cotizacion1;
             $nombre = $id.'Cotizacion1'.'.pdf';
            $request->cotizacion1->move(public_path('/cotizaciones'), $nombre);
            $orden->cotizacion1 = $nombre;
            $orden->update();
        }
        if($request->cotizacion2){
             $archivo = $request->cotizacion2;
             $nombre = $id.'Cotizacion2'.'.pdf';
            $request->cotizacion2->move(public_path('/cotizaciones'), $nombre);
            $orden->cotizacion2 = $nombre;
            $orden->update();
        }
        if($request->cotizacion3){
             $archivo = $request->cotizacion3;
             $nombre = $id.'Cotizacion3'.'.pdf';
            $request->cotizacion3->move(public_path('/cotizaciones'), $nombre);
            $orden->cotizacion3 = $nombre;
            $orden->update();
        }


        $autorizante = DB::table('users as u')
            ->join('ordenes as o', 'u.id','=','o.idautorizante') 
            ->select('u.name','u.email')
            ->where('o.idorden','=',$id)
            ->first();
        $solicitante = DB::table('users as u')
            ->join('ordenes as o', 'u.id','=','o.idusuariocreacion') 
            ->select('u.name','u.email')
            ->where('o.idorden','=',$id)
            ->first();

        if($request->get('idestado') == 4){//Observada
            $asunto = 'Orden de Requerimientos OBSERVADA';
            $this->EnviaMailNotificacion($orden->idorden,$solicitante, $asunto);
        } 
        if($request->get('idestado') == 5){//Anulada
            $asunto = 'Orden de Requerimientos ANULADA';
            $this->EnviaMailNotificacion($orden->idorden,$solicitante, $asunto);
        }


        DB::commit();
    }else{
        //dd($request);
        echo "<script type=\"text/javascript\">window.alert('El monto solicitado requiere de 3 cotizaciones o la autorización de Germán Serino para la presentación de una única cotización.');
                history.go(-1);</script>"; 
                exit;
    }
        }else{
             echo "<script type=\"text/javascript\">window.alert('El monto supera el valor máximo para el Autorizante seleccionado.');
                 history.go(-1);</script>"; 
                 exit;
         }

 

    }else{
        echo "<script type=\"text/javascript\">window.alert('La orden NO tiene asociada ningún item.');
             history.go(-1);</script>";

        exit;
    }

        // }else{
        //     echo "<script type=\"text/javascript\">window.alert('La orden NO tiene asociada ningún item.');
        //     history.go(-1);</script>";

        //     exit;
        // }

  //    }catch(\Exception $e){
  //      DB::rollback();
  //  }
        //echo (count($concepto));
   //     echo $request->get('cboxentregado');
       //         echo $request->get('idestado');
//return $archivo;
    return Redirect::to('ordenes');
        
    }

    public function show($id) //video 25
    {

        $orden=DB::table('ordenes as o')
        ->join('areas as a','o.idarea','=','a.idarea')
        ->select('o.idorden','o.contenido','a.nombrearea')
        ->where('o.idorden','=',$id)
        ->first();

        $det=DB::table('detalles as d')
            ->join('estados_item as ei','d.idestado','=','ei.idestado')
            ->select('d.cantidad','d.concepto','d.precioestimado')
            ->where('d.idorden','=',$id)
            ->get();

        return view("ordenes.show",["orden"=>$orden,"detalles"=>$det]);
    }

    public function destroy($id)
    {
        $orden=Orden::findOrFail($id);
        $orden->idestado=5;//Anulada
        $orden->update();
        return Redirect::to('ordenes');

    }

    // public function index()
    // {
    //     $products = Product::all();

    //     return view('products', compact('products'));
    // }

    public function print()
    {        

        $pdf = PDF::loadView('ordenes/pdf');

        return $pdf->download('orden.pdf');
    }

    public function imprimir($id)
    {        
        $orden=DB::table('ordenes as o')
        ->join('areas as a','o.iddestino','=','a.idarea')
        ->join('users as u','o.idusuariocreacion','=','u.id')
        ->join('estados_orden as e','o.idestado','=','e.idestado')
        //->join('proyectos as p','o.idproyecto','=','p.idproyecto')
        ->join('rubros as r','o.idrubro','=','r.idrubro')
        ->join('subrubros as s','o.idsubrubro','=','s.idsubrubro')
        ->join('cuentas as c','o.idcuenta','=','c.idcuenta')
        ->join('prioridades as i','o.idprioridad','=','i.idprioridad')
        ->join('proveedores as v','o.idproveedor','=','v.idproveedor')


        ->select('o.idorden','o.idestado','nombreestado','o.contenido','o.iddestino','a.nombrearea','nombrerubro','nombresubrubro','nombrecuenta','nombreprioridad','nombreproveedor','fechaentrega','fechacreacion','fechaautorizacion','u.name','u.firma','o.comentarios','o.comentariosautorizacion','o.comentariosadministracion','o.fechaentregaadministracion')
        ->where('o.idorden','=',$id)
        ->first();

        $det=DB::table('detalles as d')
            ->leftjoin('users as e','d.identrego','=','e.id')
            ->leftjoin('users as p','d.idpago','=','p.id')
            ->leftjoin('users as r','d.idrecibio','=','r.id')
            ->leftjoin('users as a','d.idanulo','=','a.id')

           // ->join('estados_item as ei','d.idestado','=','ei.idestado')
            ->select('d.cantidad','d.concepto',DB::raw('DATE_FORMAT(fechaentregado, "%d-%m-%Y") as fechaentregado'),'fechapagado','fecharecibido','fechaanulado','anulado','d.precioestimado','preciofinal','e.iniciales as inie','p.iniciales as inip','r.iniciales as inir','a.iniciales as inia')
            ->where('d.idorden','=',$id)
            ->where('d.activo','=',1)
            ->get();

        $autorizante = DB::table('users as u')
            ->join('ordenes as o', 'u.id','=','o.idautorizante') 
            ->select('u.name','u.firma')
            ->where('o.idorden','=',$id)
            ->first();
        $proyectosafectados=DB::table('area_proyecto as ap')
            ->leftjoin('proyectos as p','p.idproyecto','=','ap.idproyecto')
            ->leftjoin('orden_proyecto as op','ap.idproyecto','=','op.idproyecto')
            ->select('ap.idproyecto','p.nombreproyecto','op.idorden','op.porcentaje','op.monto')
            ->where('ap.idarea','=',$orden->iddestino)
            ->where('op.idorden','=',$id)
            ->get();

    
        $pdf = PDF::loadView('ordenes/pdf',["orden"=>$orden,"detalles"=>$det,"autorizante"=>$autorizante,"proyectosafectados"=>$proyectosafectados]);
        //$pdf->set_paper ('a4','landscape'); 

        //return $pdf->setPaper('a4', 'landscape')->download('orden'.$id.'.pdf');
        return $pdf->setPaper('a4', 'landscape')->stream('orden'.$id.'.pdf',array('Attachment'=>false));

        //            return view("ordenes.show",["orden"=>$orden,"detalles"=>$det]);

    }

     public function EnviaMail($id, $asunto)
    {        
        $orden=DB::table('ordenes as o')
        ->join('areas as a','o.iddestino','=','a.idarea')
        ->join('users as u','o.idusuariocreacion','=','u.id')
        ->join('estados_orden as e','o.idestado','=','e.idestado')
       // ->join('proyectos as p','o.idproyecto','=','p.idproyecto')
        ->join('rubros as r','o.idrubro','=','r.idrubro')
        ->join('subrubros as s','o.idsubrubro','=','s.idsubrubro')
        ->join('cuentas as c','o.idcuenta','=','c.idcuenta')
        ->join('prioridades as i','o.idprioridad','=','i.idprioridad')
        ->join('proveedores as v','o.idproveedor','=','v.idproveedor')


        ->select('o.idorden','nombreestado','o.contenido','a.nombrearea','nombrerubro','nombresubrubro','nombrecuenta','nombreprioridad','nombreproveedor','fechaentrega','u.name','u.email')
        ->where('o.idorden','=',$id)
        ->first();

        $det=DB::table('detalles as d')
            ->join('estados_item as ei','d.idestado','=','ei.idestado')
            ->select('d.cantidad','d.concepto','d.precioestimado','precioestimado')
            ->where('d.idorden','=',$id)
            ->get();

        $autorizante = DB::table('users as u')
            ->join('ordenes as o', 'u.id','=','o.idautorizante') 
            ->select('u.name','u.email')
            ->where('o.idorden','=',$id)
            ->first();

        $destinatario = $autorizante;


        $data = ["orden"=>$orden,"detalles"=>$det,"autorizante"=>$autorizante,"destinatario"=>$destinatario,"titulo"=>'SE GENERÓ UNA ORDEN QUE TIENE A USTED COMO AUTORIZANTE'];
        $template= 'ordenes/mail'; 
        //Envío al autorizante
        Mail::send($template, $data, function($message) use ($data,$orden,$autorizante,$destinatario) {
            $message->to($autorizante->email, $autorizante->name)
            ->subject('Autorizar Nueva Orden');
            $message->from('admin@chacraexperimental.org','Chacra Experimental');
        });
        //dd($data);

    }

     public function EnviaMailNotificacion($idOrden, $destinatario, $asunto)
    {        
        $orden=DB::table('ordenes as o')
        ->join('areas as a','o.iddestino','=','a.idarea')
        ->join('users as u','o.idusuariocreacion','=','u.id')
        ->join('estados_orden as e','o.idestado','=','e.idestado')
       // ->join('proyectos as p','o.idproyecto','=','p.idproyecto')
        ->join('rubros as r','o.idrubro','=','r.idrubro')
        ->join('subrubros as s','o.idsubrubro','=','s.idsubrubro')
        ->join('cuentas as c','o.idcuenta','=','c.idcuenta')
        ->join('prioridades as i','o.idprioridad','=','i.idprioridad')
        ->join('proveedores as v','o.idproveedor','=','v.idproveedor')


        ->select('o.idorden','nombreestado','o.contenido','a.nombrearea','nombrerubro','nombresubrubro','nombrecuenta','nombreprioridad','nombreproveedor','fechaentrega','u.name','u.email')
        ->where('o.idorden','=',$idOrden)
        ->first();

        $det=DB::table('detalles as d')
            ->join('estados_item as ei','d.idestado','=','ei.idestado')
            ->select('d.cantidad','d.concepto','d.precioestimado','precioestimado')
            ->where('d.idorden','=',$idOrden)
            ->get();

        $autorizante = DB::table('users as u')
            ->join('ordenes as o', 'u.id','=','o.idautorizante') 
            ->select('u.name','u.email')
            ->where('o.idorden','=',$idOrden)
            ->first();
      
        $data = ["orden"=>$orden,"detalles"=>$det,"autorizante"=>$autorizante,"destinatario"=>$destinatario,"titulo"=>$asunto];
        $template= 'ordenes/mail'; 
        //Envío al autorizante
        Mail::send($template, $data, function($message) use ($data,$orden,$autorizante,$destinatario) {
            $message->to($destinatario->email, $destinatario->name)
            ->subject('Cambio de estado');
            $message->from('admin@chacraexperimental.org','Chacra Experimental');
        });
        //dd($data);

    }
    public function cotizacion(OrdenFormRequest $request, $monto, $id) {
       $orden=Orden::findOrFail($id);
       if(($orden->cotizacion1!="" || $request->cotizacion1) && ($orden->cotizacion2!="" || $request->cotizacion2) && ($orden->cotizacion3!="" || $request->cotizacion3)){
        return true;
        }else{   
           if ($monto >= 60000) {
                if($request->get('idestado') == 1 || $request->get('idestado')==null){

                   if (($orden->cotizacion1!="" || $request->cotizacion1) && $request->cotizacionunicasolicitante=='on'){
                    return true;
                    }else{

                        return false;
                    } 
                }else{
                    if (($orden->cotizacion1!="" || $request->cotizacion1) && ($orden->proveedorunicoautorizante=="" || $request->cotizacionunica=='on')){
                    return true;
                    }else{

                        return false;
                    }                   
                }

            }else{
                return true;
           }
        }
    }
    public function cotizacionalta(OrdenFormRequest $request, $monto) {
        //dd($request->cotizacion1);
        if ($monto >= 60000) {
                if ($request->cotizacion1 && $request->cotizacionunicasolicitante=='on'){
                    return true;
                }else{
                    if ($request->cotizacion1 && $request->cotizacion2 && $request->cotizacion3){
                        return true;
                    }else{
                        return false;
                    }
                }
        }else{
            return true;
           }
    }

    public function excel()
    {        
        /**
         * toma en cuenta que para ver los mismos 
         * datos debemos hacer la misma consulta
        **/
        Excel::create('Laravel Excel', function($excel) {
            $excel->sheet('Excel sheet', function($sheet) {
                //otra opción -> $products = Product::select('name')->get();
                $ordenes = Orden::all();                
                $sheet->fromArray($ordenes);
                $sheet->setOrientation('landscape');
            });
        })->export('xls');
    }    

     public function search() { 
     $category = request('category', 'default'); 
     $term = request('term'); // no default defined ... 
     } 

}