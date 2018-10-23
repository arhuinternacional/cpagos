@extends('layouts.admin')

@section('content')
	<br>
	<div class="container">
		<div class="row col-12">
			<div class="col-3 card">
				
				<div class="card-body">
					<a class="btn btn-success mx-auto" style="width: 100px;" href="{{ url('/storage/formatos/proveedores.xlsx') }}"><i class="fa fa-file-excel" aria-hidden="true"></i></a>
					<br><br>
					<p class="card-text">Formato de Proveedores</p>
				</div>
			</div>
			<div class="col-3 card">
				
				<div class="card-body">
					<a class="btn btn-success mx-auto" style="width: 100px;" href="{{ url('/storage/formatos/costos.xlsx') }}"><i class="fa fa-file-excel" aria-hidden="true"></i></a>
					<br><br>
					<p class="card-text">Formato de Costos</p>
				</div>
			</div>
			<div class="col-3 card">
				
				<div class="card-body">
					<a class="btn btn-success mx-auto" style="width: 100px;" href="{{ url('/storage/formatos/factura_manual.xlsx') }}"><i class="fa fa-file-excel" aria-hidden="true"></i></a>
					<br><br>
					<p class="card-text">Formato de Factura Manual</p>
				</div>
			</div>
			<div class="col-3 card">
				
				<div class="card-body">
					<a class="btn btn-success mx-auto" style="width: 100px;" href="{{ url('/storage/formatos/validacion_close.xlsx') }}"><i class="fa fa-file-excel" aria-hidden="true"></i></a>
					<br><br>
					<p class="card-text">Formato de Validacion Close2U</p>
				</div>
			</div>
		</div>
		<div class="row"></div>
		<div class="row"></div>
		<div class="row"></div>
	</div>
	
@endsection