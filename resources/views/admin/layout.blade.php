<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  @yield('metadatos')

  <title>Mejoramiento</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="{{asset('adminlte/plugins/fontawesome-free/css/all.min.css')}}">

  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('adminlte/css/adminlte.min.css')}}">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

  <!-- Select2 -->
  <link rel="stylesheet" href="{{asset('adminlte/plugins/select2/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">

  <!-- Bootstrap4 Duallistbox -->
  <link rel="stylesheet" href="{{asset('adminlte/plugins/bootstrap4-duallistbox/bootstrap-duallistbox.min.css')}}">
  
  <link rel="stylesheet" href="{{asset('adminlte/css/adminlte.min.css')}}">
  
  <!--Css Grid-->
  <link rel="stylesheet" href="{{asset('css/camaras.css')}}">
  <link rel="stylesheet" href="{{asset('css/styles.css')}}">

  <!--Sweetalert-->
  <link rel="stylesheet" href="{{asset('sweetalert/sweetalert2.min.css')}}">

  @yield('otros-estilos')

<style>
   .wrapper > ul#results li {
     margin-bottom: 2px;
     background: #e2e2e2;
     padding: 20px;
     width: 97%;
     list-style: none;
   }
   .ajax-loading{
     text-align: center;
   }
.sizep{
  width: 40px;
  word-wrap: break-word;
  border-collapse: collapse;
  border-spacing: 0;
}
.sizem{
  width: 60px;
  word-wrap: break-word;
  border-collapse: collapse;
  border-spacing: 0;
}
.sizeg{
  width: 80px;
  word-wrap: break-word;
  border-collapse: collapse;
  border-spacing: 0;
}


</style>
 </head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">

  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
      </li>
      <li class="nav-item d-none d-sm-inline-block">
        <a href="#" class="nav-link">@yield('titulo')</a>
      </li>

    </ul>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                            </li>
<!--                             @if (Route::has('register'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                                </li>
                            @endif -->
                        @else
                        
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('auth.password.change.index') }}">Cambiar contraseña</a>

                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
    
  </nav>
  <!-- /.navbar -->
  <!--  -->
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src="{{asset('adminlte/img/chacra.png')}}" alt="Chacra Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Mejoramiento</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
<!--         <div class="image">
          <img src="adminlte/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
        </div> -->
        <div class="info">
          <a href="#" class="d-block">{{ auth()->user()->name }}</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
        <?php if (auth()->user()->esAdmin){ ?>
          <li class="nav-item">
            <a href="{{route('admin.users.index')}}" class="nav-link">
              <i class="nav-icon fa fa-user"></i>
              <p>Usuarios</p>
            </a>
          </li>

          <li class="nav-item">
            <a href="{{url('admin/variedades')}}" class="nav-link">
              <i class="nav-icon fab fa-pagelines"></i>
              <p>
              Clones
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('admin/tachos')}}" class="nav-link">
              <i class="nav-icon fas fa-shopping-basket"></i>
              <p>
              Tachos
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="{{url('admin/ambientes')}}" class="nav-link">
              <i class="nav-icon fas fa-map-marker"></i>
              <p>
              Ubicaciones
              <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="{{url('admin/ambientes')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Ambientes
                  </p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="{{url('admin/subambientes')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Subambientes
                  </p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="{{url('admin/sectores')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Sectores
                  </p>
                </a>
              </li>
            </ul>
          </li>

          <!--
             <a href="{{url('admin/lotes')}}" class="nav-link">
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
              <i class="far fa-circle nav-icon"></i>
              <p>Lotes</p>
            </a>
             <a href="{{url('admin/inspecciones')}}" class="nav-link">
              &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <i class="nav-icon fas fa-glasses"></i>
                <p>Inspecciones</p>
            </a> -->
        <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-table"></i>
              <p>
                Bancos Germoplasma
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="{{url('admin/campaniabanco')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Campañas
                  </p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="{{url('admin/bancos')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Bancos
                  </p>
                </a>
              </li>
            </ul>

            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="{{url('admin/agronomicas')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Ev. Agronómicas
                  </p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="{{url('admin/laboratorios')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Ev. Laboratorio
                  </p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="{{url('admin/sanitarias')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Ev. Sanitarias
                  </p>
                </a>
              </li>
            </ul>
           </li>

           <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-exchange-alt"></i>
            <p>
                Cuarentena
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="{{url('admin/campaniacuarentena')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Campañas
                  </p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Exportación
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{route('exportaciones.ingresos.index')}}" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Ingresos</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('exportaciones.envios.index')}}" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Envios</p>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
<!--             <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="{{url('admin/ubicacionesexpo')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Boxes-Expo
                  </p>
                </a>
              </li>
            </ul> -->
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Importación
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{url('admin/importaciones/ingresos')}}" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Ingresos</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('importaciones.inspecciones.index')}}" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Inspecciones</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('importaciones.levantamientos.index')}}" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Levantamiento cuarentena</p>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
            
<!--             <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="{{url('admin/ubicacionesimpo')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Boxes-Impo
                  </p>
                </a>
              </li>
            </ul> -->

            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="{{route('cuarentena.sanitarias.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Ev. Sanitarias
                  </p>
                </a>
              </li>
            </ul>

            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Tareas generales
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{route('cuarentena.generales.fertilizacion.index')}}" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Fertilización</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('cuarentena.generales.limpieza.index')}}" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Limpieza</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('cuarentena.generales.corte.index')}}" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Corte</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{route('cuarentena.generales.aplicacion.index')}}" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Aplicaciones</p>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
           </li>


           <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fab fa-mixer"></i>
              <p>
                Cruzamientos
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="{{url('admin/campanias')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Campañas
                  </p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Tachos de Progenitores
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{url('admin/sanitariasp')}}" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Ev. Sanitarias</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{url('admin/cortes')}}" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Tareas de Corte</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{url('admin/fertilizaciones')}}" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Tareas de Fertilización</p>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="#" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Tratamientos
                    <i class="right fas fa-angle-left"></i>
                  </p>
                </a>
                <ul class="nav nav-treeview">
                  <li class="nav-item">
                    <a href="{{url('admin/tratamientos')}}" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Tipos</p>
                    </a>
                  </li>
                  <li class="nav-item">
                    <a href="{{url('admin/camaras')}}" class="nav-link">
                      <i class="far fa-dot-circle nav-icon"></i>
                      <p>Cámaras</p>
                    </a>
                  </li>
                </ul>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="{{url('admin/marcotado')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Marcotado
                  </p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="{{url('admin/cruzamientos')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Cruzamiento
                  </p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="{{url('admin/podergerminativo')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Poder Germinativo
                  </p>
                </a>
              </li>
            </ul>            
          </li>


          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-layer-group"></i>
              <p>
                  Stock de Semillas
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>

            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="{{url('admin/inventario')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Inventario
                  </p>
                </a>
              </li>
            </ul>

            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="{{url('admin/inventario/ingresos/create')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Ingresos
                  </p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="{{url('admin/inventario/egresos')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Egresos
                  </p>
                </a>
              </li>
            </ul>
          </li>
          
          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-seedling"></i>
              <p>
                  Semillado
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="{{url('admin/campaniasemillado')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Campañas Semillados
                  </p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="{{url('admin/incluirpg')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Incluir PG
                  </p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="{{url('admin/semillados')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Inventario semillados
                  </p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="{{url('admin/semillados/ordenes')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Nuevo Semillado
                  </p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="{{url('admin/semillados/repicadas')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Repicadas
                  </p>
                </a>
              </li>
            </ul>
          </li>          

          <!-- <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-arrow-up"></i>
              <p>
                Exportaciones
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="{{url('admin/exportaciones')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Exportación
                  </p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="{{url('admin/ubicacionesexpo')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Boxes
                  </p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-arrow-down"></i>
              <p>
                Importaciones
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="{{url('admin/importaciones')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Importación
                  </p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="{{url('admin/ubicacionesimpo')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Boxes
                  </p>
                </a>
              </li>
            </ul>
          </li>   -->
          <li class="nav-item">
            <a href="{{url('admin/individual')}}" class="nav-link">
              <i class="nav-icon fas fa-map-marker"></i>
              <p>
              Etapa Individual
              <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="{{url('admin/individual/campaniaseedling')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Campañas de Seedling
                  </p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="{{url('admin/individual/inventario')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Inventario
                  </p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="{{url('admin/individual/seleccion')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Selección
                  </p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item">
            <a href="{{url('admin/primera')}}" class="nav-link">
            <i class="nav-icon fas fa-check"></i>
            <p>
              Primera Clonal
              <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="{{url('admin/primera/serie')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Series
                  </p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="{{route('primeraclonal.inventario.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Inventario
                  </p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="{{url('admin/primera/seleccion')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Selección
                  </p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="{{route('primeraclonal.laboratorio.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Laboratorio
                  </p>
                </a>
              </li>
            </ul>    
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="{{route('primeraclonal.evaluaciones.camposanidad')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Ev. Campo-Sanidad
                  </p>
                </a>
              </li>
            </ul> 
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="{{route('primeraclonal.evaluaciones.laboratorio')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Ev. Laboratorio
                  </p>
                </a>
              </li>
            </ul>         
          </li>
          <?php } ?>

          <!--Segunda Clonal-->
          <li class="nav-item">
            <a href="{{url('admin/segunda')}}" class="nav-link">
            <i class="nav-icon fas fa-check-double"></i>
            <p>
              Segunda Clonal
              <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="{{route('segundaclonal.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Selección
                  </p>
                </a>
              </li>
            </ul>
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="{{route('segundaclonal.inventario.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Inventario
                  </p>
                </a>
              </li>
            </ul>     
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="{{route('segundaclonal.evaluaciones.camposanidad')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Ev. Campo-Sanidad
                  </p>
                </a>
              </li>
            </ul> 
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="{{route('segundaclonal.evaluaciones.laboratorio')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Ev. Laboratorio
                  </p>
                </a>
              </li>
            </ul>         
          </li>

          <!--MET-->
          <li class="nav-item">
            <a href="{{url('admin/met')}}" class="nav-link">
              <i class="nav-icon fas fa-tasks"></i>
            <p>
              MET
              <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="{{route('met.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Selección
                  </p>
                </a>
              </li>
            </ul>    
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="{{route('met.inventario.index')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Inventario
                  </p>
                </a>
              </li>
            </ul>     
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="{{route('met.evaluaciones.camposanidad')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Ev. Campo-Sanidad
                  </p>
                </a>
              </li>
            </ul> 
            <ul class="nav nav-treeview">
              <li class="nav-item has-treeview">
                <a href="{{route('met.evaluaciones.laboratorio')}}" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>
                    Ev. Laboratorio
                  </p>
                </a>
              </li>
            </ul>        
          </li>


          <!-- <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-arrow-up"></i>
              <p>
                Exportación
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{url('admin/exportaciones')}}" class="nav-link">
                <i class="nav-icon fas fa-arrow-up"></i>
                  <p>Exportación</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('admin/tareas')}}" class="nav-link">
                  <i class="nav-icon fas fa-tasks"></i>
                  <p>
                  Tareas
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('admin/evaluaciones')}}" class="nav-link">
                  <i class="nav-icon fas fa-calculator"></i>
                  <p>
                    Evaluaciones
                  </p>
                </a>
              </li>
            </ul>
          </li>

          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-arrow-down"></i>
              <p>
                Importación
                <i class="fas fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="pages/tables/simple.html" class="nav-link">
                <i class="nav-icon fas fa-table"></i>
                  <p>Importación</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('admin/tareas')}}" class="nav-link">
                  <i class="nav-icon fas fa-tasks"></i>
                  <p>
                  Tareas
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{url('admin/evaluaciones')}}" class="nav-link">
                  <i class="nav-icon fas fa-calculator"></i>
                  <p>
                    Evaluaciones
                  </p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/tables/data.html" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Lotes</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="pages/tables/jsgrid.html" class="nav-link">
                  <i class="nav-icon fas fa-glasses"></i>
                  <p>Inspecciones</p>
                </a>
              </li>
            </ul>
          </li>
 -->
          
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <!-- /.content-header -->

    <!-- Main content -->
    <div class="content">
      <br>
    @yield('content')
    </div>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="p-3">
      <h5>Title</h5>
      <p>Sidebar content</p>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-none d-sm-inline">
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2020 <a href="https://chacraexperimental.org">Chacra Experimental Agrícola Santa Rosa </a>.</strong> Todos los derechos reservados.
  </footer>
</div>
<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{asset('adminlte/plugins/jquery/jquery.min.js')}}"></script>
<!-- Bootstrap 4 -->
<script src="{{asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('adminlte/js/adminlte.min.js')}}"></script>

<!-- InputMask -->
<script src="{{asset('adminlte/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('adminlte/plugins/inputmask/min/jquery.inputmask.bundle.min.js')}}"></script>

<!-- Select2 -->
<script src="{{asset('adminlte/plugins/select2/js/select2.full.min.js')}}"></script>
<!-- Bootstrap4 Duallistbox -->
<script src="{{asset('adminlte/plugins/bootstrap4-duallistbox/jquery.bootstrap-duallistbox.min.js')}}"></script>

<!--jQuery Validate-->
<script src="{{asset('js/jquery.validate.min.js')}}"></script>
<script src="{{asset('js/validaciones/idiomas/es_AR.js')}}"></script>

<script src="{{asset('dist/handsontable.full.js')}}"></script>

<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
<script src="{{asset('js/paging.js')}}"></script>

<script src="{{asset('sweetalert/sweetalert2.all.min.js')}}"></script>

<!--Scripts propios-->
<script src="{{asset('js/scripts.js')}}"></script>

<!-- Page script -->
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Bootstrap Duallistbox
    $('.duallistbox').bootstrapDualListbox()
  });
</script>

@yield('script')
</body>
</html>
