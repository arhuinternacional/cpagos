<!DOCTYPE html>
<html>
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta id="token" name="csrf-token" content="{{ csrf_token() }}">

  <title>Cabify - Disfruta del viaje</title>

  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <link rel="icon" href="{{asset('img/plantilla/favicon.ico')}}">
  @include('layouts.css')
  @section('styles')
  @show
</head>

<body class="hold-transition skin-blue sidebar-collapse sidebar-mini login-page">
  <header class="main-header">
  
  <!--=====================================
  LOGOTIPO
  ======================================-->
  <a href="{{ url('/admin') }}" class="logo">
    
    <!-- logo mini -->
    <span class="logo-mini">
      
      <img src="{{asset('img/plantilla/logoblanco.png')}}" class="img-responsive" style="padding:10px">

    </span>

    <!-- logo normal -->

    <span class="logo-lg">
      
      <img src="{{asset('img/plantilla/logocabify2.png')}}" class="img-responsive" style="padding:10px 0px" width="110">

    </span>

  </a>

  <!--=====================================
  BARRA DE NAVEGACIÓN
  ======================================-->
  <nav class="navbar navbar-static-top" role="navigation">
    
    <!-- Botón de navegación -->

    <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button" align="left">
          
          <span class="sr-only">Toggle navigation</span>
        
        </a>

    <!-- perfil de usuario -->

    <div class="navbar-custom-menu">
        
      <ul class="nav navbar-nav">
        
        <li class="dropdown user user-menu">
          
          <a href="#" class="dropdown-toggle" data-toggle="dropdown">

            <span class="hidden-xs"><span class="hidden-xs">{!! Auth::user()->name !!}</span></span>

          </a>

          <!-- Dropdown-toggle -->

          <ul class="dropdown-menu">
            
            <li class="user-body">
              
              <div class="pull-right">
                
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">
                    {{ __('Salir') }}
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
                               
              </div>

            </li>

          </ul>

        </li>

      </ul>

    </div>

  </nav>

 </header>



<aside class="main-sidebar">

   <section class="sidebar">

    <ul class="sidebar-menu">

    <li class="active">

        <a href="{{ url('/admin') }}">

          <i class="fa fa-home"></i>
          <span>Inicio</span>

        </a>

      </li>

      <li>

        <a href="{{ url('admin/usuario') }}">

          <i class="fa fa-user"></i>
          <span>Usuarios</span>

        </a>

      </li>

     <li class="treeview">

        <a href="#">

          <i class="fa fa-car"></i>
          
          <span>Conductores</span>
          
          <span class="pull-right-container">
          
            <i class="fa fa-angle-left pull-right"></i>

          </span>

        </a>
        <ul class="treeview-menu">
          <li>

            <a href="{{ url('admin/proveedor') }}">

              <i class="fa fa-car"></i>
              <span>Proveedores</span>

            </a>

          </li>


          <li>

            <a href="{{ url('admin/historico') }}">
              
              <i class="fa fa-history"></i>
              <span>Histórico</span>

            </a>

            </li>
          </ul>
        </li>

         <li class="treeview">

        <a href="#">

          <i class="fa fa-list-ul"></i>
          
          <span>Costos</span>
          
          <span class="pull-right-container">
          
            <i class="fa fa-angle-left pull-right"></i>

          </span>

        </a>
        <ul class="treeview-menu">
          <li>

            <a href="{{ url('admin/costos') }}">

              <i class="fa fa-list-ul"></i>
              <span>Costos</span>

            </a>

          </li>


          <li>

            <a href="{{ url('admin/incidentescosto') }}">
              
              <i class="fa fa-info"></i>
              <span>Incidencias</span>

            </a>

            </li>
          </ul>
        </li>
      

     <li>

        <a href="{{ url('admin/facturas') }}">

          <i class="fa fa-file"></i>
          <span>Factura</span>

        </a>

      </li>

      <li>

        <a href="{{ url('admin/pagos') }}">

          <i class="fa fa-dollar"></i>
          <span>Pagos</span>

        </a>

      </li>

      
    </ul>

    

   </section>

</aside>


  @yield('contenido')
  @include('layouts.js') 
  @section('scripts')
  @show
  @include('layouts.footer')
</body>
 
</html>