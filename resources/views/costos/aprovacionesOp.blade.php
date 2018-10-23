@extends('layouts.admin')

@section('content')

  <div class="content">

    <section class="content-header">
      
      <h1 class="float-left">
        
        Aprobacion de Costos
      
      </h1>

      <div class="float-right">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Principal</a></li>
          <li class="breadcrumb-item active">Costos</li>
        </ol>
      </div><!-- /.col -->

    </section>
    <br>
    <hr>

    <section class="content">

      <div class="box">

        <div class="box-header with-border">
          <button id="enviar" class="btn btn-primary float-right">Solicitar Aprobacion</button>
        </div>
        
        <div class="box-body">     
        {{ Form::open() }}
          <div class="form-inline">
            {{ Form::label('property', 'Buscar Por: ', ['style' => 'margin-right: 10px;']) }}
            {{ Form::select('property', ['y' => 'Año', 'w' => 'Semana', 'f' => 'Fecha'],null, ['class' => 'form-control', 'placeholder' => 'Seleccione...', 'style' => 'margin-right: 10px;', 'id' => 'property']) }}
            {{ Form::text('search', null, ['class' => 'form-control', 'style' => 'margin-right: 10px;', 'placeholder' => 'Ingresar....', 'id' => 'searchs']) }}
            {{ Form::submit('Buscar', ['class' => 'btn btn-primary', 'id' => 'submit']) }}
          </div>
        {{ Form::close() }}
        <br>     
         <table id="tablaDatos" class="table table-bordered table-striped dt-responsive" width="100%">
          
        <hr>
          <thead>           
           <tr>
             <th></th>
             <th>Company ID</th>
             <th>Driver ID</th>
             <th>Cost</th>
             <th>Monto Total a Facturar (calculado)</th>
             <th>Monto Total a Pagar (calculado)</th>    
             <th>Semana</th>     
             <th>Año</th>     
             <th>Estado</th>     
             <th>Fecha</th>  
           </tr> 
          </thead>
          <tbody>
          </tbody>
         </table>
        </div>
      </div>
    </section>
  </div>


  <!--=====================================
  MODAL IMPORTAR COSTOS
  ======================================-->

  <div id="modal-import" class="modal fade" role="dialog">
    
    <div class="modal-dialog modal-lg">

      <div class="modal-content">

          <!--=====================================
          CABEZA DEL MODAL
          ======================================-->

          <div class="modal-header" style="background:#3c8dbc; color:white">

            <h4 class="modal-title">Importacion de Costos</h4>

            <button type="button" class="close" data-dismiss="modal">&times;</button>

          </div>

          <!--=====================================
          CUERPO DEL MODAL
          ======================================-->

          <div class="modal-body">
            <div class="box-body">
                  
            </div>

          </div>

          <!--=====================================
          PIE DEL MODAL
          ======================================-->       
          <div class="modal-footer">
            <button id="salir" type="button" class="btn btn-default float-left" data-dismiss="modal">Salir</button>
          </div>
      </div>
    </div>
  </div>
@endsection


@section('scripts')
  {!!Html::script('js/costosAproindex.js')!!}
@endsection
