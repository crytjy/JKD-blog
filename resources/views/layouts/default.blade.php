<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name') }} | Log in</title>
    <link rel="icon" href="{{ asset('/images/favicon.ico') }}" type="image/x-icon"/>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset("/bower_components/admin-lte/plugins/fontawesome-free/css/all.min.css")}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset("/bower_components/admin-lte/plugins/icheck-bootstrap/icheck-bootstrap.min.css")}}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset("/bower_components/admin-lte/dist/css/adminlte.min.css")}}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

    @yield('headjs')
</head>

<body class="hold-transition register-page">

@yield('content')

<!-- ./wrapper -->
<!-- REQUIRED JS SCRIPTS -->
<script src="{{ asset("/bower_components/admin-lte/plugins/jquery/jquery.min.js")}}"></script>	<!-- Bootstrap 3.3.7 -->
<script src="{{ asset("/bower_components/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js")}}"></script>	<!-- AdminLTE App -->
<script src="{{ asset("/bower_components/admin-lte/dist/js/adminlte.min.js")}}"></script>
@yield('bodyjs')
<!-- Optionally, you can add Slimscroll and FastClick plugins.
	Both of these plugins are recommended to enhance the
	user experience. -->
</body>
</html>
