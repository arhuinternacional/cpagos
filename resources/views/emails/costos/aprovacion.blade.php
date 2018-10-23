@component('mail::message')
# Aprobacion de Costos

Se solicita la aprovacion de los costos. ingrese al siguiente enlace para continuar

@component('mail::button', ['url' => 'http://localhost:8000/admin/costos/aprov'])
Enlace
@endcomponent

Gracias,<br>

@endcomponent
