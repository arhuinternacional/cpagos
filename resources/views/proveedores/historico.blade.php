@extends('layouts.admin')

@section('content')
	<div class="content">

  <section class="content-header">
    
    <h1 class="float-left">
      
      Historico Proveedores
    
    </h1>

    <div class="float-right">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Principal</a></li>
        <li class="breadcrumb-item active">Historico</li>
      </ol>
    </div><!-- /.col -->

  </section>

  <section class="content">

  	<div>
  		
    <!-- <button type="button" class="btn btn-primary pull-right" data-toggle="modal" data-target="#modal-import">
      Descargar Historico
    </button> -->
  	</div>
    <br>
	   <hr>
    <div class="box">

      <div class="box-header with-border">
  
       <!-- <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarProducto">
          
          Agregar Proveedor

        </button>-->

      </div>

      <div class="box-body">
        
       <table id="tablaDatos" class="table table-bordered table-striped dt-responsive tablas" width="100%">
         
        <thead>
         
         <tr>
           <th></th>
           <th>Proveedor / Company ID</th>
           <th>Atributos</th>
           <th>Original</th>
           <th>Cambio</th>
           <th>Fecha de Cambio</th>

         </tr> 

        </thead>

        <tbody>
          
          


        </tbody>

       </table>

      </div>

    </div>

  </section>

</div>

@endsection

@section('styles')
  {!!Html::style('css/fileinput.min.css')!!}

    
@endsection

@section('scripts')
  {!!Html::script('js/fileinput.min.js')!!}
  {!!Html::script('js/theme.min.js')!!}
  {!!Html::script('js/historicprov.js')!!}
@endsection