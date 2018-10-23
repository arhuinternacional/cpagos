@extends('layouts.admin')

@section('content')
	<div class="content">

  <section class="content-header">
    
    <h1 class="float-left">
      
      Administrar Pagos
    
    </h1>

    <div class="float-right">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Principal</a></li>
        <li class="breadcrumb-item active">Pagos</li>
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

        <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-import">
          Generar Pagos
        </button>

      </div>

      <div class="box-body">
        
       <pagos></pagos>

      </div>

    </div>

  </section>

</div>

<!--=====================================
MODAL IMPORTAR PROVEEDORES
======================================-->

<div id="modal-import" class="modal fade" role="dialog">
  
  <div class="modal-dialog modal-lg">

    <div class="modal-content">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <h4 class="modal-title">Generador de Pagos</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>


        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">
              <pagogenerate :pagos="pagos"></pagogenerate>
          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->       
        <div class="modal-footer">
          <button type="button" class="btn btn-light pull-left salir" data-dismiss="modal">Salir</button>
        </div>
    </div>
  </div>
</div>

@endsection

@section('styles')
  

    
@endsection

@section('scripts')
   {!!Html::script('js/pagos.js')!!}
@endsection