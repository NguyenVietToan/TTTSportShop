<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Shipper</title>

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    @include('shipper.blocks.css')

    <script type="text/javascript">
        var GET_ADDRESS_URL = "{{ url('address') }}";
    </script>
</head>
<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">
        @include('shipper.blocks.header')
        @include('shipper.blocks.leftmenu')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    @yield('controller')
                    <small>@yield('action')</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="{{ route('shipper.index') }}"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
                    <li class="active">@yield('breadcrumb')</li>
                </ol>
            </section>
            <!-- /.content-header -->
            @include('shipper.blocks.flash')
            <!-- Main content -->
        @yield('content')
        <!-- /.Main content -->
        </div>
        <!-- /.content-wrapper -->
        @include('shipper.blocks.footer')

    </div>
    <!-- ./wrapper -->

    @include('shipper.blocks.js')
    @yield('custom javascript')

</body>
</html>
