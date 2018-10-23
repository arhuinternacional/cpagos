<!DOCTYPE html>
<html>
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>Cabify - Disfruta del viaje</title>

  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  <link rel="icon" href="{{asset('img/plantilla/favicon.ico')}}">
  @include('layouts.css')
</head>

<body class="hold-transition skin-blue sidebar-collapse sidebar-mini login-page">
  @yield('content')
  @include('layouts.js')

</body>
</html>