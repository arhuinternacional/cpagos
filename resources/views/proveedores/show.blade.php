@extends('layouts.admin')

@section('content')
	<!-- Content Wrapper. Contains page content -->
	  <div class="content">
	    <!-- Content Header (Page header) -->
	    <section class="content-header">
	      <div class="container-fluid">
	        <div class="row mb-2">
	          <div class="col-sm-6">
	            <h1>{{ $prov->company_name }}</h1>
	          </div>
	          <div class="col-sm-6">
	            <ol class="breadcrumb float-sm-right">
	              <li class="breadcrumb-item"><a href="{{ url('/admin/proveedor') }}">Principal</a></li>
	              <li class="breadcrumb-item active">Proveedor Profile</li>
	            </ol>
	          </div>
	        </div>
	      </div><!-- /.container-fluid -->
	    </section>

	    <!-- Main content -->
	    <section class="content">
	      <div class="container-fluid">
	        <div class="row">
	          <div class="col-md-3">

	            <!-- Profile Image -->
	            <div class="card card-primary card-outline">
	              <div class="card-body box-profile">
	                <div class="text-center">
	                  <img class="profile-user-img img-fluid img-circle"
	                       src="../../dist/img/avatr.png"
	                       alt="User profile picture">
	                </div>

	                <h3 class="profile-username text-center">{{ $prov->company_name }}</h3>

	                <p class="text-muted text-center">{{ $prov->tax_code }}</p>

	                <ul class="list-group list-group-unbordered mb-3">
	                  <li class="list-group-item">
	                    <b>Telefono</b> <a class="float-right">{{ $prov->company_phone }}</a>
	                  </li>
	                  <li class="list-group-item">
	                    <b>Email</b> <a class="float-right">{{ $prov->company_email }}</a>
	                  </li>
	                </ul>
					<a class="btn btn-primary btn-block" href="{{ route('proveedor.edit', ['prov' => $prov->_id]) }}"><b>Editar</b></a>
	              </div>
	              <!-- /.card-body -->
	            </div>
	            <!-- /.card -->

	          </div>
	          <!-- /.col -->
	          <div class="col-md-9">
	            <div class="card">
	              <div class="card-header p-2">
	                <ul class="nav nav-pills">
	                  <li class="nav-item"><a class="nav-link active" href="#settings" data-toggle="tab">Datos de Proveedor</a></li>
	                  <li class="nav-item"><a class="nav-link" href="#bank" data-toggle="tab">Datos Bancarios</a></li>
	                  <li class="nav-item"><a class="nav-link" href="#drivers" data-toggle="tab">Drivers Asignados</a></li>
	                  <li id="licostos" class="nav-item"><a class="nav-link" href="#costos" data-toggle="tab">Costos</a></li>
	                  <li class="nav-item"><a class="nav-link" href="#facturas" data-toggle="tab">Facturas</a></li>
	                  <li class="nav-item"><a class="nav-link" href="#pagos" data-toggle="tab">Pagos</a></li>
	                </ul>
	              </div><!-- /.card-header -->
	              <div class="card-body">
	                <div class="tab-content">
	                  <div class="tab-pane" id="costos">
	                  	{{ Form::open() }}
				          <div class="form-inline">
				            {{ Form::label('c_property', 'Buscar Por: ', ['style' => 'margin-right: 10px;']) }}
				            {{ Form::select('c_property', ['y' => 'Año', 'w' => 'Semana', 'f' => 'Fecha'],null, ['class' => 'form-control', 'placeholder' => 'Seleccione...', 'style' => 'margin-right: 10px;']) }}
				            {{ Form::text('c_search', null, ['class' => 'form-control', 'style' => 'margin-right: 10px;', 'placeholder' => 'Ingresar....']) }}
				            {{ Form::label('c_status', 'Estado: ', ['style' => 'margin-right: 10px;']) }}
				            {{ Form::select('c_status', ['pp' => 'Por Procesar', 'pd' => 'Procesado', 'ob' => 'Observacion'], null, ['class' => 'form-control', 'style' => 'margin-right: 10px;', 'placeholder' => 'Seleccione...']) }}
				            {{ Form::submit('Buscar', ['class' => 'btn btn-primary', 'id' => 'c_submit']) }}
				          </div>
				        {{ Form::close() }}
				        <hr>
	                    <table id="tablaCostos" class="table table-bordered table-striped responsive" width="100%">
							<thead>
         
					         <tr>
					           <th></th>
					           <th>Semana</th>
					           <th>Año</th>
					           <th>Fecha</th>          	
					           <th>Driver ID</th>
					           <th>Costo</th>
					           <th>Bonus Category</th>
					           <th>Bonus Monto</th>
					           <th>Penalty Category</th>
					           <th>Penalty Monto</th>
					           <th>Payout Category/Explanation</th>
					           <th>Payout Monto</th>
					           <th>Monto Total a Facturar (calculado)</th>
					           <th>Monto Total a Pagar (calculado)</th>
					           <th>Estado</th>
					           <th>Nro° Factura</th>
					         </tr> 

					        </thead>
	                    </table>
	                  </div>
	                  <!-- /.tab-pane -->
	                  <div class="tab-pane" id="facturas">
	                  	{{ Form::open() }}
				          <div class="form-inline">
				            {{ Form::label('f_property', 'Buscar Por: ', ['style' => 'margin-right: 10px;']) }}
				            {{ Form::select('f_property', ['y' => 'Año', 'w' => 'Semana', 'f' => 'Fecha'],null, ['class' => 'form-control', 'placeholder' => 'Seleccione...', 'style' => 'margin-right: 10px;']) }}
				            {{ Form::text('f_search', null, ['class' => 'form-control', 'style' => 'margin-right: 10px;', 'placeholder' => 'Ingresar....']) }}
				            {{ Form::label('f_status', 'Estado: ', ['style' => 'margin-right: 10px;']) }}
				            {{ Form::select('f_status', ['pp' => 'Por Procesar', 'pg' => 'Por Pagar', 'pd' => 'Pagado', 'ob' => 'Observacion'], null, ['class' => 'form-control', 'style' => 'margin-right: 10px;', 'placeholder' => 'Seleccione...']) }}
				            {{ Form::submit('Buscar', ['class' => 'btn btn-primary', 'id' => 'f_submit']) }}
				          </div>
				        {{ Form::close() }}
				        <hr>
	                    <table id="tablaFacturas" class="table table-bordered table-striped dt-responsive tablas" width="100%">
							<thead>
         
					         <tr>
					           <th></th>
					           <th>Fecha Facturacion</th>
					           <th>Semana</th>
					           <th>Año</th>
					           <th>Total Facturado</th>
					           <th>Total Pagado</th>
					           <th>Tipo de Factura</th>
					           <th>Estado</th>
					         </tr> 

					        </thead>
	                    </table>
	                  </div>
	                  <!-- /.tab-pane -->
	                  <div class="tab-pane" id="pagos">
	                  	{{ Form::open() }}
				          <div class="form-inline">
				            {{ Form::label('c_property', 'Buscar Por: ', ['style' => 'margin-right: 10px;']) }}
				            {{ Form::select('c_property', ['y' => 'Año', 'w' => 'Semana', 'f' => 'Fecha'],null, ['class' => 'form-control', 'placeholder' => 'Seleccione...', 'style' => 'margin-right: 10px;']) }}
				            {{ Form::text('c_search', null, ['class' => 'form-control', 'style' => 'margin-right: 10px;', 'placeholder' => 'Ingresar....']) }}
				            {{ Form::label('c_status', 'Estado: ', ['style' => 'margin-right: 10px;']) }}
				            {{ Form::select('c_status', ['pp' => 'Por Procesar', 'pd' => 'Procesado', 'ob' => 'Observacion'], null, ['class' => 'form-control', 'style' => 'margin-right: 10px;', 'placeholder' => 'Seleccione...']) }}
				            {{ Form::submit('Buscar', ['class' => 'btn btn-primary', 'id' => 'c_submit']) }}
				          </div>
				        {{ Form::close() }}
				        <hr>
	                    <table id="tablaPagos" class="table table-bordered table-striped responsive" width="100%">
							<thead>
         
					         <tr>
					           <th></th>
					           <th>Fecha de Emision</th>
					           <th>Nro Operacion</th>
					           <th>Grupo</th>          	
					           <th>N° Cuenta</th>
					           <th>Importe</th>
					           <th>Fecha de Pago</th>
					           <th>Nro Transaccion Bancaria</th>
					           <th>Estado</th>
					           <th>Observacion</th>
					         </tr> 

					        </thead>
	                    </table>
	                  </div>
	                  <!-- /.tab-pane -->
	                  <div class="tab-pane" id="drivers">
	                    <table id="tablaDrivers" class="table table-bordered table-striped dt-responsive tablas" width="100%">
							<thead>
         
					         <tr>
					           <th></th>
					           <th>Driver ID</th>
					         </tr> 

					        </thead>
	                    </table>
	                  </div>
	                  <!-- /.tab-pane -->

	                  <div class="active tab-pane" id="settings">
	                    <div class="form-horizontal">
	                    	<input type="hidden" id="compaID" value="{{ $prov->_id }}">
	                      <div class="form-group">
	                        <label for="companyId" class="col-sm-2 control-label">Company ID</label>

	                        <div class="col-sm-10">
	                          <input type="text" class="form-control" id="companyId" value="{{ $prov->company_id }}" disabled>
	                        </div>
	                      </div>
	                      <div class="form-group">
	                        <label for="companyName" class="col-sm-2 control-label">Company Name</label>

	                        <div class="col-sm-10">
	                          <input type="text" class="form-control" id="companyName" value="{{ $prov->company_name }}" disabled>
	                        </div>
	                      </div>
	                      <div class="form-group">
	                        <label for="CompanyPhone" class="col-sm-2 control-label">Company Phone</label>

	                        <div class="col-sm-10">
	                          <input type="text" class="form-control" id="CompanyPhone" value="{{ $prov->company_phone }}" disabled>
	                        </div>
	                      </div>
	                      <div class="form-group">
	                        <label for="taxCode" class="col-sm-2 control-label">Tax Code</label>

	                        <div class="col-sm-10">
	                          <input type="text" class="form-control" id="taxCode" value="{{ $prov->tax_code }}" disabled>
	                        </div>
	                      </div>

	                      <div class="form-group">
	                        <label for="taxCode" class="col-sm-2 control-label">Email</label>

	                        <div class="col-sm-10">
	                          <input type="text" class="form-control" id="taxCode" value="{{ $prov->company_email }}" disabled>
	                        </div>
	                      </div>
	                      <div class="form-group">
	                        <label for="companyNotes" class="col-sm-2 control-label">Close2U</label>

	                        <div class="col-sm-10">
	                          <input type="text" class="form-control" id="companyNotes" value="@if($prov->company_notes === 1)Verificado
								@else No Verificado
								@endif
	                          " disabled>
	                          	{{-- expr --}}
	                        </div>
	                      </div>
	                      <!-- <div class="form-group">
	                        <div class="col-sm-offset-2 col-sm-10">
	                          <button type="submit" class="btn btn-danger">Submit</button>
	                        </div>
	                      </div> -->
	                    </div>
	                  </div>
	                  <!-- /.tab-pane -->

	                  <div class="tab-pane" id="bank">
	                    <div class="form-horizontal">
	                      <div class="form-group">
	                        <label for="bankHolderName" class="col-sm-4 control-label">Titular Cuenta Bancaria</label>

	                        <div class="col-sm-10">
	                          <input type="text" class="form-control" id="bankHolderName" value="{{ $prov->bank_account_holder_name }}" disabled>
	                        </div>
	                      </div>
	                      <div class="form-group">
	                        <label for="bankTaxCodeName" class="col-sm-2 control-label">Tipo de Documento</label>

	                        <div class="col-sm-10">
	                          <input type="text" class="form-control" id="bankTaxCodeName" value="{{ $prov->bank_tax_code_name }}" disabled>
	                        </div>
	                      </div>
	                      <div class="form-group">
	                        <label for="bankTaxCode" class="col-sm-2 control-label">Tipo de Documento</label>

	                        <div class="col-sm-10">
	                          <input type="text" class="form-control" name="bankTaxCode" placeholder="{{ $prov->bank_tax_code }}" disabled>
	                        </div>
	                      </div>
	                      <div class="form-group">
	                        <label for="CompanyPhone" class="col-sm-2 control-label">Cuenta Bancaria</label>

	                        <div class="col-sm-10">
	                          <input type="text" class="form-control" id="CompanyPhone" value="{{ $prov->bank_account_number }}" disabled>
	                        </div>
	                      </div>
	                      <!-- <div class="form-group">
	                        <div class="col-sm-offset-2 col-sm-10">
	                          <button type="submit" class="btn btn-danger">Submit</button>
	                        </div>
	                      </div> -->
	                    </div>
	                  </div>
	                  <!-- /.tab-pane -->
	                </div>
	                <!-- /.tab-content -->
	              </div><!-- /.card-body -->
	            </div>
	            <!-- /.nav-tabs-custom -->
	          </div>
	          <!-- /.col -->
	        </div>
	        <!-- /.row -->
	      </div><!-- /.container-fluid -->
	    </section>
	    <!-- /.content -->
	  </div>

@endsection

@section('scripts')
	{!!Html::script('js/proveedor.js')!!}
@endsection