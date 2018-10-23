@extends('layouts.admin')

@section('content')

  <input type="hidden" id="file">

  <div class="content">

    <section class="content-header">
      
      <h1 class="float-left">
        
        Administrar Facturas
      
      </h1>

      <div class="float-right">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Principal</a></li>
          <li class="breadcrumb-item active">Facturas</li>
        </ol>
      </div><!-- /.col -->

    </section>
    <br>
    <hr>
    <section class="content">

      <div class="box">

        <div class="float-right">
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#generateModal">
                  Generar Facturas de Costos
          </button>
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#uploadFact">
                  Importar Factura Manual
          </button>

        </div>
        
        <div class="box-body">     
          <facturas-listado></facturas-listado>
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
              <Facturas :facturas="facturas"></Facturas>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary salir" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="uploadFact" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title" id="exampleModalLabel">Importacion de facturas Manuales</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="col-md-12">
                <Facturasmanual :facturas="facturas"></Facturasmanual>
            </div>
        </div>
        <div class="modal-footer">
          <button id="close" type="button" class="btn btn-secondary salir" data-dismiss="modal">Cerrar</button>
          
        </div>
      </div>
    </div>
  </div>

  

@endsection


@section('scripts')
  
@endsection
