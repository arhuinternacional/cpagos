<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
 	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- CSRF Token -->
	<meta name="csrf-token" content="{{ csrf_token() }}" id="token">
  <link rel="icon" href="{{asset('img/favicon.ico')}}">


	<title>Cabify - Disfruta del viaje</title>

  

  {!!Html::style('css/app.css')!!}
  {!!Html::style('css/all.css')!!}
  <!-- Theme style -->
  {!!Html::style('css/adminlte.min.css')!!}
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
  {!!Html::style('https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css')!!}
  {!!Html::style('plugins/css/datatables.min.css')!!}
  {!!Html::style('plugins/css/rowGroup.bootstrap4.min.css')!!}
  {!!Html::style('https://cdn.datatables.net/select/1.2.7/css/select.bootstrap4.min.css')!!}
  {!!Html::style('https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css')!!}

  @section('styles')
  @show
  <style>
    body{
      font-size: 0.8rem;
    }
    .btn{
      font-size: 0.8rem !important;
    }
    
  </style>
</head>
<body class="hold-transition sidebar-mini sidebar-collapse">
<div class="wrapper">
  <!-- Navbar -->
  <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
      </li>
    </ul>

    <!-- SEARCH FORM -->
    <!-- {{ Form::open() }}
    <div class="form-inline ml-3">
        {{ Form::label('search', 'Buscar por: ', ['style' => 'margin-right: 10px;']) }}
        {{ Form::select('property', ['ci' => 'Company ID', 'cn' => 'Company Name', 'ce' => 'Company Email', 'cp' => 'Company Phone', 'ruc' => 'RUC'], null, ['class' => 'form-control form-control-sm', 'placeholder' => 'Selecione...', 'style' => 'margin-right: 10px;']) }}
      <div class="input-group input-group-sm">
        {{ Form::text('search', null, ['class' => 'form-control form-control-navbar', 'placeholder' => 'Buscar', 'aria-label' => 'Buscar', 'autocomplete' => 'off']) }}
        {{ Form::submit('Buscar', ['class' => 'btn btn-primary', 'id' => 'btnSearch']) }}
      </div>
    </div>
        
    {{ Form::close() }} -->

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      
      <li class="nav-item">
        <a class="nav-link" data-widget="control-sidebar" data-slide="true" href="#"><i
            class="fa fa-th-large"></i></a>
      </li>
    </ul>
  </nav>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ url('/admin') }}" class="brand-link">
      <img src="{{ url('img/logoblanco.png') }}" alt="Cabify Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">Cabify</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ url('dist/img/avatr.png') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          @if(auth::check())
            <span style="color: #fff;">{{ auth::user()->name }}</span>
          @endif
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="{{ url('/admin/usuario') }}" class="nav-link">
              <i class="nav-icon fa fa-users"></i>
              <p>
                Usuarios
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-car"></i>
              <p>
                Proveedores
                <i class="right fa fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('/admin/proveedor') }}" class="nav-link">
                  <i class="fa fa-bars nav-icon"></i>
                  <p>Listado</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/admin/historico') }}" class="nav-link">
                  <i class="fa fa-tasks nav-icon"></i>
                  <p>Historico</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-columns"></i>
              <p>
                Costos
                <i class="fa fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('admin/costos') }}" class="nav-link">
                  <i class="fa fa-bars nav-icon"></i>
                  <p>Listado</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('admin/costos/historial') }}" class="nav-link">
                  <i class="fa fa-tasks nav-icon"></i>
                  <p>Historial</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('admin/costos/aprovacion') }}" class="nav-link">
                  <i class="fa fa-calendar-times nav-icon"></i>
                  <p>Aprobaciones</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('admin/incidentescosto') }}" class="nav-link">
                  <i class="fa fa-calendar-times nav-icon"></i>
                  <p>Incidentes</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-file"></i>
              <p>
                Facturas
                <i class="fa fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('admin/facturas') }}" class="nav-link">
                  <i class="fa fa-bars nav-icon"></i>
                  <p>Listado</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/admin/facturas/factclose') }}" class="nav-link">
                  <i class="fa fa-check-square nav-icon"></i>
                  <p>Verificar Close2U</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('/admin/facturaincidentes') }}" class="nav-link">
                  <i class="fa fa-calendar-times nav-icon"></i>
                  <p>Incidentes</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-money-bill-wave"></i>
              <p>
                Pagos
                <i class="fa fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('admin/pagos') }}" class="nav-link">
                  <i class="fa fa-bars nav-icon"></i>
                  <p>Listado</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('admin/pagos/verificacion') }}" class="nav-link">
                  <i class="fa fa-tasks nav-icon"></i>
                  <p>Verificacion</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ url('admin/pagos/incidentes') }}" class="nav-link">
                  <i class="fa fa-calendar-times nav-icon"></i>
                  <p>Incidentes</p>
                </a>
              </li>
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link">
              <i class="nav-icon fa fa-columns"></i>
              <p>
                Admministracion
                <i class="fa fa-angle-left right"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="{{ url('/admin/administracion') }}" class="nav-link">
                  <i class="fa fa-bars nav-icon"></i>
                  <p>Formatos</p>
                </a>
                <a href="{{ url('/admin/filemanager') }}" class="nav-link">
                  <i class="fa fa-bars nav-icon"></i>
                  <p>Archivo</p>
                </a>
              </li>
            </ul>
          </li>
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>

  <!-- Content Wrapper. Contains page content -->
  <div id="app" class="content-wrapper">
    
    @yield('content')
  </div>
  <!-- /.content-wrapper -->

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
    <div class="row">
      <div class="mx-auto col-10 pt-5">
        <a class="btn btn-primary" style="width: 100%;" href="{{ route('logout') }}"
           onclick="event.preventDefault();
                         document.getElementById('logout-form').submit();">
            {{ ('Salir') }}
        </a>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
      </div>
    </div>
  </aside>
  <!-- /.control-sidebar -->

  <!-- Main Footer -->
  <footer class="main-footer">
    <!-- To the right -->
    <div class="float-right d-sm-none d-md-block">
      <b class="text-right">Version Beta</b> 4.21.4
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; 2018 <a href="#" target="_blank">ARHU INTERNACIONAL</a>.</strong>

    Todos los derechos reservados.

     
  </footer>
</div>
<!-- ./wrapper -->
{!!Html::script('js/app.js')!!}
<!-- AdminLTE App -->
{!!Html::script('plugins/js/datatables.min.js')!!}
{!!Html::script('https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js')!!}
{!!Html::script('https://cdn.datatables.net/select/1.2.7/js/dataTables.select.min.js')!!}
{!!Html::script('https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js')!!}

{!!Html::script('plugins/js/rowGroup.bootstrap4.min.js')!!}
{!!Html::script('js/adminlte.min.js')!!}
{!!Html::script('js/principal.js') !!}

@section('scripts')
@show

</body>
</html>