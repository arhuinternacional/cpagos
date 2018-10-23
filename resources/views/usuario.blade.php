@extends('layouts.admin')

@section('content')

  <!--=====================================
        TABLA DE USUARIOS
   ======================================-->
<div class="content">

  <section class="content-header">
    
    <h1>
      
      Administrar usuarios
    
    </h1>

  </section>

  <section class="content">

    <div class="box">

      <div class="box-header with-border">
  
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalAgregarUsuario">
          
          Agregar usuario

        </button>

      </div>
      <hr>

      <div class="box-body">
        
       <table class="table table-bordered table-striped responsive" width="100%" id="TablaDatos">
         
        <thead>
         
         <tr>
           
           
           <th>DNI</th>
           <th>Nombre</th>
           <th>Correo</th>
           <th>Usuario</th>
           <th>Telefono</th>
           <th>Perfil</th>
           <th>Estado</th>
           <th>Acción</th>
           
          
         </tr> 

        </thead>

       


       </table>

      </div>

    </div>

  </section>

</div>
<!--=====================================
MODAL AGREGAR USUARIO
======================================-->

<div id="modalAgregarUsuario" class="modal fade" role="dialog">
  
  <div class="modal-dialog modal-lg">

    <div class="modal-content">

      <form role="form" method="post" enctype="multipart/form-data">

        <!--=====================================
        CABEZA DEL MODAL
        ======================================-->

        <div class="modal-header " style="background:#3c8dbc; color:white">


          <h4 class="modal-title">Agregar usuario</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>

        </div>

        <!--=====================================
        CUERPO DEL MODAL
        ======================================-->

        <div class="modal-body">

          <div class="box-body">

            @include('usuario.form.usuario')
        <!--=====================================
        PIE DEL MODAL
        ======================================-->

        <div class="modal-footer">

          <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Salir</button>


          <button type="button" class="btn btn-primary" id="registro">Guardar usuario</button>

        </div>

      </form>

    </div>

  </div>

</div>
</div>
</div>


@endsection

@section('scripts')
  {!!Html::script('js/script.js')!!}
@endsection
