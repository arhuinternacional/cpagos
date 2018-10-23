<div class="form-group">

	{!!Form::label('usuario','DNI: ')!!}
	{!!Form::text('usuario',null, ['id'=>'dni','class'=>'form-control input-lg', 'placeholder' => 'Ingresa el DNI', 'required'=>''])!!}

	{!!Form::label('usuario','Nombre: ')!!}
	{!!Form::text('usuario',null, ['id'=>'name','class'=>'form-control input-lg', 'placeholder' => 'Ingresa el nombre', 'required'=>''])!!}

	{!!Form::label('usuario','Correo: ')!!}
	{!!Form::text('usuario',null, ['id'=>'email','class'=>'form-control input-lg', 'placeholder' => 'Ingresa el correo', 'required'=>''])!!}

	{!!Form::label('usuario','Usuario: ')!!}
	{!!Form::text('usuario',null, ['id'=>'username','class'=>'form-control input-lg', 'placeholder' => 'Ingresa el usuario', 'required'=>''])!!}

	{!!Form::label('usuario','Contraseña: ')!!}
	{!!Form::password('usuario', ['id'=>'password', 'class'=>'form-control input-lg', 'placeholder' => 'Ingresa el contraseña', 'required'=>''])!!}

	{!!Form::label('usuario','Telefono: ')!!}
	{!!Form::text('usuario',null, ['id'=>'telefono','class'=>'form-control input-lg', 'placeholder' => 'Ingresa el telefono', 'required'=>''])!!}

	{!!Form::label('usuario','Perfil: ')!!}
	
	{!!Form::select('usuario', ['Administrador' => 'Administrador', 'Operador' => 'Operador', 'Consultor' => 'Consultor'], null, ['id'=>'perfil','placeholder' => 'Seleccionar Perfil','class'=>'form-control input-lg', 'required'=>''])!!}
</div>

