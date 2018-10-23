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
	              <li class="breadcrumb-item"><a href="{{ url('/admin') }}">Principal</a></li>
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
	                       src="{{ asset('dist/img/avatr.png') }}"
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
	                </ul>
	              </div><!-- /.card-header -->
	              <div class="card-body">
	              	{{ Form::model($prov, ['route' => ['proveedor.update', $prov->id], 'method' => 'put']) }}
	                <div class="tab-content">
	                  <div class="active tab-pane" id="settings">
	                    <div class="form-horizontal">
	                    	<input type="hidden" id="compaID" value="{{ $prov->id }}">
	                      <div class="form-group">
	                        <label for="companyId" class="col-sm-2 control-label">Company ID</label>

	                        <div class="col-sm-10">
	                          <input type="text" class="form-control" name="companyId" placeholder="{{ $prov->company_id }}" disabled>
	                        </div>
	                      </div>
	                      <div class="form-group">
	                        <label for="companyName" class="col-sm-2 control-label">Company Name</label>

	                        <div class="col-sm-10">
	                          <input type="text" class="form-control" name="companyName" placeholder="{{ $prov->company_name }}">
	                        </div>
	                      </div>
	                      <div class="form-group">
	                        <label for="CompanyPhone" class="col-sm-2 control-label">Company Phone</label>

	                        <div class="col-sm-10">
	                          <input type="text" class="form-control" name="CompanyPhone" placeholder="{{ $prov->company_phone }}" >
	                        </div>
	                      </div>
	                      <div class="form-group">
	                        <label for="taxCode" class="col-sm-2 control-label">Tax Code</label>

	                        <div class="col-sm-10">
	                          <input type="text" class="form-control" name="taxCode" placeholder="{{ $prov->tax_code }}" >
	                        </div>
	                      </div>
	                      <div class="form-group">
	                        <label for="companyEmail" class="col-sm-2 control-label">Email</label>

	                        <div class="col-sm-10">
	                          <input type="text" class="form-control" name="companyEmail" placeholder="{{ $prov->company_email }}">
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
	                          <input type="text" class="form-control" name="bankHolderName" placeholder="{{ $prov->bank_account_holder_name }}">
	                        </div>
	                      </div>
	                      <div class="form-group">
	                        <label for="bankTaxCodeName" class="col-sm-2 control-label">Tipo de Documento</label>

	                        <div class="col-sm-10">
	                          <input type="text" class="form-control" name="bankTaxCodeName" placeholder="{{ $prov->bank_tax_code_name }}">
	                        </div>
	                      </div>
	                      <div class="form-group">
	                        <label for="bankTaxCode" class="col-sm-2 control-label">Tipo de Documento</label>

	                        <div class="col-sm-10">
	                          <input type="text" class="form-control" name="bankTaxCode" placeholder="{{ $prov->bank_tax_code }}">
	                        </div>
	                      </div>
	                      <div class="form-group">
	                        <label for="bankAccountNumber" class="col-sm-2 control-label">Cuenta Bancaria</label>

	                        <div class="col-sm-10">
	                          <input type="text" class="form-control" name="bankAccountNumber" placeholder="{{ $prov->bank_account_number }}" >
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
	                <button class="btn btn-danger">Editar</button>
	                {{ Form::close() }}
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