<!DOCTYPE html>
<html lang="en">

<head>
  
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <meta name="site_csrf_token" id="site_csrf_token" content="{{ csrf_token() }}">
  <title>@yield('title') : {{ config('app.name', 'Admin') }}</title>
  <link rel="stylesheet" href="{{ asset('css/app.css') }}">
  @stack('add-css')
</head>
@if (count($errors) > 0)
<div class="alert alert-danger calltimer alert-dismissible w-50 mx-auto msg-class">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    @foreach ($errors->all() as $error)
        <p class=""><i class="icon fa fa-check"></i> {{ $error }}</p>
@endforeach
</div>
@endif
@if ($message = Session::pull('success'))
<div class="alert alert-success calltimer alert-dismissible w-50 mx-auto msg-class">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <p class=""><i class="icon fa fa-check"></i> {{ $message }}</p>
</div>
@endif
@if ($message = Session::pull('error'))
<div class="alert alert-danger calltimer alert-dismissible w-50 mx-auto msg-class">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
  <p class=""><i class="icon fa fa-check"></i> {{ $message }}</p>
</div>
@endif

<body class="hold-transition login-page">
    <div class="login-box">
        @yield('content')
    </div>
</body>
<script src="{{ asset('js/app.js') }}"></script>
@stack('add-script')
</html>
