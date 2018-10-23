@extends('layouts.admin')

@section('content')

  <div class="content">

    <section class="content-header">
      
      <h1 class="float-left">
        
        Administrar Incidentes de Costos
      
      </h1>

      <div class="float-right">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Principal</a></li>
          <li class="breadcrumb-item active">Incidentes de Costos</li>
        </ol>
      </div><!-- /.col -->

    </section>
    <br>
    <section class="content">

      <div class="box">

        <div class="box-header with-border">
    
         <!-- <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarProducto">
            
            Agregar Proveedor

          </button>-->

        </div>
        <hr>
        <div class="box-body">          
         <costo-incident-principal></costo-incident-principal>
        </div>
      </div>
    </section>
  </div>

@endsection


@section('scripts')
   {!!Html::script('js/costosincident.js')!!}
@endsection
