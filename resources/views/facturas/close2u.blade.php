@extends('layouts.admin')

@section('content')

  <input type="hidden" id="file">

  <div class="content">

    <section class="content-header">
      
      <h1 class="float-left">
        
        Close2U Checker
      
      </h1>

      <div class="float-right">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Principal</a></li>
          <li class="breadcrumb-item active">Close2U Checker</li>
        </ol>
      </div><!-- /.col -->

    </section>
    <br>
    <hr>
    <section class="content">

      <div class="box">

      <div class="float-right">
          <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#uploadFact">
                    Verificar Facturas Close2U / Checker
            </button>

            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#downloadFacts">
                    Descargar Facturas generadas
            </button>

        </div>
        <div class="box-body">     
          <facturas-close></facturas-close>
        </div>
      </div>
    </section>
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
                <Facturasupload :facturas="facturas"></Facturasupload>
            </div>
        </div>
        <div class="modal-footer">
          <button id="close" type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="downloadFacts" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title" id="exampleModalLabel">Descargar Excel de Facturas Pendientes</h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <div class="col-md-12">
              <FacturaGenerate :facturas="facturas"></FacturaGenerate>
            </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
    </div>
  </div>


@endsection


@section('scripts')
  <script src="{{asset('js/close2U.js')}}"></script>
@endsection
