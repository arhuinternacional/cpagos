@extends('layouts.admin')

@section('content')

  <div class="content">

    <section class="content-header">
      
      <h1 class="float-left">
        
        Administrar Costos
      
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
          <button type="button" class="btn btn-primary float-right" data-toggle="modal" data-target="#modal-import">
              Importar Costos
            </button>
        </div>
        
        <div class="box-body">     
            <costo-principal></costo-principal>
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
              <Costo v-bind:costos="costos"></Costo>
              <costos :messages2="messages2"></costos>
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
  {!!Html::script('js/costosindex.js')!!}
@endsection
