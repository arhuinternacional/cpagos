<div class="form-group">
	<div class="row">
		 <div class="col-8 col-sm-6">
			{!!Form::label('usuario','DNI: ')!!}
			{!!Form::text('usuario',null, ['id'=>'dni','class'=>'form-control', 'placeholder' => 'Ingresa el DNI', 'required'=>''])!!}

			{!!Form::label('usuario','Nombre: ')!!}
			{!!Form::text('usuario',null, ['id'=>'name','class'=>'form-control', 'placeholder' => 'Ingresa el nombre', 'required'=>''])!!}

			{!!Form::label('usuario','Correo: ')!!}
			{!!Form::text('usuario',null, ['id'=>'email','class'=>'form-control', 'placeholder' => 'Ingresa el correo', 'required'=>''])!!}
				@if ($errors->has('email'))
	                <span class="invalid-feedback">
	                    <strong>{{ $errors->first('email') }}</strong>
	                </span>
	            @endif

			{!!Form::label('usuario','Usuario: ')!!}
			{!!Form::text('usuario',null, ['id'=>'username','class'=>'form-control', 'placeholder' => 'Ingresa el usuario', 'required'=>''])!!}

		</div>
		<div class="col-8 col-sm-6">

			{!!Form::label('usuario','Contraseña: ')!!}
			{!!Form::password('usuario', ['id'=>'password', 'class'=>'form-control', 'placeholder' => 'Ingresa el contraseña', 'required'=>''])!!}
				 @if ($errors->has('password'))
	                <span class="invalid-feedback">
	                    <strong>{{ $errors->first('password') }}</strong>
	                </span>
	             @endif

			{!!Form::label('usuario','Telefono: ')!!}
			{!!Form::text('usuario',null, ['id'=>'telefono','class'=>'form-control', 'placeholder' => 'Ingresa el telefono', 'required'=>''])!!}

			{!!Form::label('usuario','Perfil: ')!!}
			
			{!!Form::select('usuario', ['Administrador' => 'Administrador', 'Operador' => 'Operador', 'Consultor' => 'Consultor'], null, ['id'=>'perfil','placeholder' => 'Seleccionar Perfil','class'=>'form-control', 'required'=>''])!!}

</div>
</div>
</div>

