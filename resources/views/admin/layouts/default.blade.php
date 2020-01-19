<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ config('app.name') }}</title>
    <link rel="icon" href="{{ asset('/images/favicon.ico') }}" type="image/x-icon"/>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{asset('/bower_components/admin-lte/plugins/fontawesome-free/css/all.min.css')}}">
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{asset('/bower_components/admin-lte/dist/css/adminlte.min.css')}}">
    <!-- overlayScrollbars -->
    <link rel="stylesheet"
          href="{{asset('/bower_components/admin-lte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css')}}">

    <link rel="stylesheet" href="{{asset('/bower_components/admin-lte/plugins/toastr/toastr.min.css')}}">
    <link rel="stylesheet"
          href="{{asset('/bower_components/admin-lte/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css')}}">

    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset("/bower_components/jquery-easyui/themes/bootstrap/easyui.css")}}">
    <link rel="stylesheet" href="{{ asset("/bower_components/jquery-easyui/themes/icon.css")}}">
    <link rel="stylesheet" href="{{ asset("/bower_components/jquery-easyui/themes/default/easyui.css")}}">
    <link href="{{ asset('css/default.css') }}" rel="stylesheet">
    @yield('headcss')
    @yield('headjs')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">

    <!-- Navbar -->
@include('admin.layouts.nav')
<!-- /.navbar -->

    <!-- Main Sidebar Container -->
@include('admin.layouts.sidebar')

<!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0 text-dark">JKD</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{ route('jkd') }}">主页</a></li>
                            @if(isset($title))
                                <li class="breadcrumb-item active">{{ $title }}</li>@endif
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <!-- Your Page Content Here -->
            @yield('content')
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->
@include('admin.layouts.footer')

<!-- Control Sidebar -->
    <aside class="control-sidebar control-sidebar-dark">
        <!-- Control sidebar content goes here -->
    </aside>
    <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{asset('/bower_components/admin-lte/plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('/bower_components/admin-lte/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button)
</script>
<!-- Bootstrap 4 -->
<script src="{{asset('/bower_components/admin-lte/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('/bower_components/admin-lte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('/bower_components/admin-lte/dist/js/adminlte.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
{{--<script src="{{asset('/bower_components/admin-lte/plugins/sweetalert2/sweetalert2.min.js')}}"></script>--}}
<script src="{{asset('/bower_components/admin-lte/plugins/toastr/toastr.min.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('/bower_components/admin-lte/dist/js/demo.js')}}"></script>

<script type="text/javascript" src="{{ asset("/bower_components/jquery-easyui/jquery.min.js")}}"></script>
<script type="text/javascript" src="{{ asset("/bower_components/jquery-easyui/jquery.easyui.min.js")}}"></script>
<script src="{{ asset("/bower_components/jquery-easyui/locale/easyui-lang-zh_CN.js")}}"></script>
<script src="{{asset('/js/common/common.js')}}"></script>

@yield('bodyjs')
</body>
</html>
