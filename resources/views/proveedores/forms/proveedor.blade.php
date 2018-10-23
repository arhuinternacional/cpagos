<div class="form-group">
    {!! Form::label('', 'Company_ID') !!}
    {!! Form::text('company_id', null, ['class' => 'form-control', 'id' => 'company_id', 'required' => '']) !!}
 </div>
 <div class="form-group">
    {!! Form::label(' ', 'Company_Name') !!}
    {!! Form::text('company_name', null, ['class' => 'form-control', 'id' => 'company_name', 'required' => '']) !!}
 </div>
 <div class="form-group">
    {!! Form::label(' ', 'Company_Phone') !!}
    {!! Form::text('company_phone', null, ['class' => 'form-control', 'id' => 'company_phone', 'required' => '']) !!}
 </div>
 <div class="form-group">
    {!! Form::label(' ', 'Company_Mail') !!}
    {!! Form::text('company_email', null, ['class' => 'form-control', 'id' => 'company_email', 'required' => '']) !!}
 </div>
 <div class="form-group">
    {!! Form::label(' ', 'tax_code') !!}
    {!! Form::text('tax_code', null, ['class' => 'form-control', 'id' => 'tax_code', 'required' => '']) !!}
 </div>
 <div class="form-group">
	{!! Form::label('', 'Close2You') !!}
	{!! Form::select('company_notes', ['0' => 'Afiliado', '1' => 'Sin Afiliar'], null, ['class' => 'form-control', 'placeholder' => 'Seleccione: ', 'id' => 'company_notes', 'required' => '']) !!}
 </div>