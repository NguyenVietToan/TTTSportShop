<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>TTT member login</title>

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('public/admin/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('public/admin/bower_components/font-awesome/css/font-awesome.min.css') }}">

    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('public/admin/bower_components/Ionicons/css/ionicons.min.css') }}">

    <!-- Theme style -->
    <!-- <link rel="stylesheet" href="{{ asset('public/admin/css/AdminLTE.min.css') }}"> -->
    <link rel="stylesheet" href="{{ asset('public/admin/css/login.css') }}">

    <!-- AdminLTE Skins -->
    <link rel="stylesheet" href="{{ asset('public/admin/css/skins/_all-skins.min.css') }}">

    <!-- iCheck -->
    {{-- <link rel="stylesheet" href="{{ asset('public/admin/plugins/iCheck/square/blue.css') }}"> --}}

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">


</head>
<body class="hold-transition login-page">

    @yield('content')

    <!-- jQuery 3 -->
    <script src="{{ asset('public/admin/bower_components/jquery/dist/jquery.min.js') }}"></script>

    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('public/admin/bower_components/jquery-ui/jquery-ui.min.js') }}"></script>

    <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
    <script>
        $.widget.bridge('uibutton', $.ui.button);
    </script>

    <!-- Bootstrap 3.3.7 -->
    <script src="{{ asset('public/admin/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>

    <!-- My JS -->
    <script src="{{ asset('public/admin/js/myscript.js') }}"></script>

</body>