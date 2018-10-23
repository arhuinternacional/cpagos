@extends('layouts.admin')

@section('content')
	<div class="content">

  <section class="content-header">
    
    <h1 class="float-left">
      
      Administrar Proveedor
    
    </h1>

    <div class="float-right">
      <ol class="breadcrumb float-sm-right">
        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Principal</a></li>
        <li class="breadcrumb-item active">Proveedor</li>
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
        <synclose></synclose>
        <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-import">
          Importar Proveedores
        </button>

      </div>

      <div class="box-body">
        
       <table id="tablaDatos" class="table table-bordered table-striped responsive" width="100%">
        {{ Form::open() }}
          <div class="form-inline">
            {{ Form::label('property', 'Buscar por: ', ['style' => 'margin-right: 10px;']) }}
            {{ Form::select('property', ['ci' => 'Company ID', 'cn' => 'Company Name', 'ce' => 'Company Email', 'cp' => 'Company Phone', 'ruc' => 'RUC'], null, ['class' => 'form-control', 'placeholder' => 'Selecione...', 'style' => 'margin-right: 10px;']) }}
            {{ Form::text('search', null, ['class' => 'form-control', 'placeholder' => 'Ingresar...','style' => 'margin-right: 10px;']) }}
            {{ Form::submit('Buscar', ['class' => 'btn btn-primary', 'id' => 'submit']) }}
          </div>
        {{ Form::close() }}
        <hr>
        <thead>
         
         <tr>
           <th></th>
           <th>Company ID</th>
           <th>Company Name</th>
           <th>Company Email</th>
           <th>Company Phone</th>
           <th style="text-align: center;">Ver Mas</th>
           <th>Documento</th>
           <th>Propietario de Cuenta</th>
           <th>Tipo Documento Banco</th>
           <th>Numero Documento de banco</th>
           <th>Numero de Cuenta Bancaria</th>
           <th>Close2u</th>
           <th>Estado</th>
           <th>Operaciones</th>

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
MODAL AGREGAR PROVEEDORES
======================================-->

<div id="modal_add" class="modal fade" role="dialog">
  
  <div class="modal-dialog">

    <div class="modal-content">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header" style="background:#3c8dbc; color:white">

          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>

          <h4 class="modal-title">Agregar Proveedor</h4>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">
          	{{ Form::open() }}
				@include('proveedores.forms.proveedor')
          </div>

        </div>

        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">
          <button type="button" class="btn btn-light pull-left" data-dismiss="modal">Salir</button>
          {{ Form::submit('Guardar', ['class' => 'btn btn-primary ']) }}
        </div>
			{{ Form::close() }}
    </div>
  </div>
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

          <h4 class="modal-title">Importacion de Proveedores</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>


        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">
            <proveedorupload :proveedores="proveedores"></proveedorupload>
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

<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" id="mails_modal">
  <div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Envio de Correo</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
      </div>
      <div class="modal-body">
        <div class="row">
          <div class="col-md-4 center-block">
            <p style="text-align: center">Problemas Clavesol.</p>
            <p style="text-align: center"><span style="font-size: 110px;" class="fa fa-id-card"></span></p>
            <br>
            <p style="text-align: center; padding-top: 40px">
              <button class="btn btn-primary" type="submit">Enviar Correo</button>
            </p>
          </div>
          <div class="col-md-4 center-block">
            <p style="text-align: center;">Problemas Cuenta Bancaria.</p>
            <p style="text-align: center"><span style="font-size: 110px;" class="fa fa-university"></span></p>
            <br>
            <p style="text-align: center; padding-top: 40px">
              
              <button class="btn btn-primary" type="submit">Enviar Correo</button>
            </p>
          </div>
          <div class="col-md-4 center-block">
            <p style="text-align: center;">Ingrese el mensaje personalizado</p>
              {{ Form::open() }}
                {{ Form::textarea('content', null, ['class' => 'form-control', 'rows' => '5']) }}
                <br>
            <p style="text-align: center; padding-top: 30px">
                {{ Form::submit('Enviar Correo', ['class' => 'btn btn-primary']) }}
            </p>
              {{ Form::close() }}
          </div>
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div><!-- /.modal-content -->
  </div>
</div>

@endsection

@section('styles')
  {!!Html::style('css/fileinput.min.css')!!}

    
@endsection

@section('scripts')
  {!!Html::script('js/fileinput.min.js')!!}
  {!!Html::script('js/theme.min.js')!!}
  {!!Html::script('js/proveedores.js')!!}
@endsection