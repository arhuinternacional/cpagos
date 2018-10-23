@extends('layouts.admin')

@section('content')
	<div class="content">

  <section class="content-header">
    
    <h1 class="float-left">
      
      Verificacion de Pagos
    
    </h1>

    <div class="float-right">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Principal</a></li>
        <li class="breadcrumb-item active">Verificación Pagos</li>
      </ol>
    </div><!-- /.col -->

  </section>
  <br>
  <hr>
  <section class="content col-12">
    <div class="box">

      <div class="box-header with-border">
  
       <!-- <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarProducto">
          
          Agregar Proveedor

        </button>-->

        <!-- <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-import">
          Generar Pagos
        </button> -->

      </div>

      <div class="box-body">
        
       <verificacionpago></verificacionpago>

      </div>

    </div>

  </section>

</div>



@endsection

@section('styles')
  

    
@endsection
