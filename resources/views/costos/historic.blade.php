@extends('layouts.admin')

@section('content')
	<div class="content">
	    <section class="content-header">
	      
	      <h1 class="float-left">
	        
	        Historial de Costos
	      
	      </h1>

        <div class="float-right">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Principal</a></li>
            <li class="breadcrumb-item active">Historico Costos</li>
          </ol>
        </div><!-- /.col -->

	    </section>
	    <br>
	    <hr>
	    <section class="content">

      <div class="box">

        <div class="box-body">          
         <costo-historico></costo-historico>
        </div>
      </div>
    </section>
	</div>
@endsection

@section('scripts')
  
@endsection