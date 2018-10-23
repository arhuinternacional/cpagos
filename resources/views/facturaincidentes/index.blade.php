@extends('layouts.admin')

@section('content')

  <input type="hidden" id="file">

  <div class="content">

    <section class="content-header">
      
      <h1 class="float-left">
        
        Facturas con Incidencias
      
      </h1>

      <div class="float-right">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Principal</a></li>
          <li class="breadcrumb-item active">Incidentes Facturas</li>
        </ol>
      </div><!-- /.col -->

      <!-- <div class="float-right">
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#generateModal">
                Generar Facturas de Costos
        </button>
        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#uploadFact">
                Importar Factura Manual
        </button>
      
      </div> -->

    </section>
    <br>
    <hr>
    <section class="content">

      <div class="box">

        <div class="box-header with-border">
    
         {{ Form::open() }}
          <div class="form-inline">
            {{ Form::label('property', 'Buscar Por: ', ['style' => 'margin-right: 10px;']) }}
            {{ Form::select('property', ['y' => 'Año', 'w' => 'Semana', 'f' => 'Fecha Facturacion'],null, ['class' => 'form-control', 'placeholder' => 'Seleccione...', 'style' => 'margin-right: 10px;']) }}
            {{ Form::text('search', null, ['class' => 'form-control', 'style' => 'margin-right: 10px;', 'placeholder' => 'Ingresar....']) }}
            {{ Form::label('type', 'Tipo de Factura: ', ['style' => 'margin-right: 10px;']) }}
            {{ Form::select('type', ['gt' => 'Generada', 'mn' => 'Manual'], null, ['class' => 'form-control', 'style' => 'margin-right: 10px;', 'placeholder' => 'Seleccione...']) }}
            {{ Form::submit('Buscar', ['class' => 'btn btn-primary', 'id' => 'submit']) }}
          </div>
        {{ Form::close() }}

        </div>
        <hr>
        <div class="box-body">          
         <table id="tablaDatos" class="table table-bordered table-striped dt-responsive" width="100%">
          <thead>           
           <tr>
             <th></th>
             <th>Año</th>
             <th>Semana</th>
             <th>Fecha Facturacion</th>
             <th>Company ID</th>
             <th>Company Nombre</th>
             <th>Company Tax Code</th>
             <th>Company Email</th>
             <th>Total Factura</th>
             <th>Tipo de Factura</th>
             <th>Estado</th>
             <th>Observaciones</th>
           </tr> 
          </thead>
          <tbody>
          </tbody>
         </table>
        </div>
      </div>
    </section>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="generateModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title" id="exampleModalLabel">Generador de facturas</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="col-md-12">
              <div class="form-group col-md-6">
                {{ Form::label('costo', 'Costos:', []) }}
                
              </div>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          {!! Form::submit('Generar', ['class' => 'btn btn-primary', 'id' => 'generate']) !!}
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="uploadFact" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title" id="exampleModalLabel">Importacion de facturas</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="col-md-12">
              <div class="form-group col-md-6">
                {{ Form::open(['url' => '/admin/facturas/import', 'files' => true]) }}
                {{ Form::file('excel', ['class' => 'form-control']) }}
              </div>
            </div>
        </div>
        <div class="modal-footer">
          <button id="close" type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
          {{ Form::submit('Importar', ['class' => 'btn btn-primary', 'id' => 'import']) }}
          {{ Form::close() }}
        </div>
      </div>
    </div>
  </div>


@endsection


@section('scripts')
  {!!Html::script('js/facturainci.js')!!}
@endsection
