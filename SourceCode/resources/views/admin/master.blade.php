<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Admin</title>

    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

    <!-- Bootstrap 3.3.7 -->
    <link rel="stylesheet" href="{{ asset('public/admin/bower_components/bootstrap/dist/css/bootstrap.min.css') }}">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('public/admin/bower_components/font-awesome/css/font-awesome.min.css') }}">

    <!-- Ionicons -->
    <link rel="stylesheet" href="{{ asset('public/admin/bower_components/Ionicons/css/ionicons.min.css') }}">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('public/admin/css/AdminLTE.min.css') }}">

    <!-- AdminLTE Skins -->
    <link rel="stylesheet" href="{{ asset('public/admin/css/skins/_all-skins.min.css') }}">

    <!-- Date Picker -->
    <link rel="stylesheet"
    href="{{ asset('public/admin/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css') }}">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="{{ asset('public/admin/bower_components/datatables-plugins/integration/bootstrap/3/dataTables.bootstrap.css') }}">

    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

    <!-- My CSS -->
    <link rel="stylesheet" type="text/css" href="{{ asset('public/admin/css/mystyle.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/admin/css/responsive.css') }}">

    <!-- CKEditor & CKFinder -->
    <script type="text/javascript" src="{{ url('public/admin/js/ckeditor/ckeditor.js') }}"></script>
    <script type="text/javascript" src="{{ url('public/admin/js/ckfinder/ckfinder.js') }}"></script>
    <script type="text/javascript" src="{{ url('public/admin/js/func_ckfinder.js') }}"></script>

    <!-- Các url sử dụng -->
    <script type="text/javascript">
        var baseURL = "{{ url('/') }}";
        var GET_ADDRESS_URL = "{{ url('address') }}";
        var URL_GET_SIZE_BY_CATEID = "{{ route('admin.property.getSizeByCateId') }}"  //  hàm json_encode($array) sẽ chuyển mảng $array thành 1 chuỗi json
        var URL_GET_SIZE_BY_PROID_EXIST = "{{ route('admin.property.getSizeByProIdExist') }}"
        var URL_GET_INFO_BY_USERID = "{{ route('admin.customer.getInfoByUserId') }}"
        var URL_GET_MAX_QTY = "{{ route('getMaxQty') }}"
        var URL_GET_DELETE_PRO_IMG = "{{ url('admin/product') }}"
        var URL_GET_DELETE_ASSIGN_SHIPPING= "{{ route('admin.shipping.postDelete') }}"
    </script>

</head>
<body class="hold-transition skin-red sidebar-mini">
    <div class="wrapper">
        <!--.main-header-->
        <header class="main-header">
            <!-- Logo -->
            <a href="{{ url('admin/home/') }}" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><b>TTT Shop</b> - <i style="font-size: 13px;">Admin</i></span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>TTT Shop</b> - <i style="font-size: 13px;">Admin</i></span>
            </a>
            <!-- Header Navbar: style can be found in header.less -->
            <nav class="navbar navbar-static-top">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>

                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <!-- User Account: style can be found in dropdown.less -->
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <img src="{{ asset('resources/upload/images/member/'.Session::get('member')['id'].'/'.Session::get('member')['image']) }}" class="user-image" alt="User Image">
                                <span class="hidden-xs">{{ Session::get('member')['name'] }}</span>
                            </a>
                            <ul class="dropdown-menu">
                                <!-- User image -->
                                <li class="user-header">
                                    <img src="{{ asset('resources/upload/images/member/'.Session::get('member')['id'].'/'.Session::get('member')['image']) }}" class="img-circle"
                                         alt="User Image">

                                    <p>
                                        {{ Session::get('member')['name'] }} - Admin
                                        <small>Từ {{Date('d/m/Y', strtotime(Session::get('member')['start_date'])) }}</small>
                                    </p>
                                </li>
                                <!-- Menu Footer-->
                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="{{ route('admin.getProfile') }}" class="btn btn-default btn-flat">Profile</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="{{ route('member.getLogout') }}" class="btn btn-default btn-flat">Đăng xuất</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!--/.main-header-->

        <!-- Left side column. contains the logo and sidebar -->
        @include('admin.leftmenu')
        <!-- /.main-sidebar -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    @yield('controller')
                    <small>@yield('action')</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="{{ route('admin.home') }}"><i class="fa fa-dashboard"></i> Trang chủ</a></li>
                    <li class="active">@yield('breadcrumb')</li>
                </ol>
            </section>
            <!-- /.content-header -->

            {{-- Hiển thị thông báo khi thêm, sửa, xóa dữ liệu: flash_level ở đây là cấp độ của thông báo, có thể là success, danger...; flash_message là nội dung thông báo; 2 thành phần này được truyền từ controller sang --}}
            <div class="row">
                <div class="col-xs-6 col-sm-4 col-md-4 col-xs-push-3 col-sm-push-4">
                    @if (Session::has('flash_message'))
                        <div class="message alert alert-{{ Session::get('flash_level') }}">
                            <p class="text-center">{{ Session::get('flash_message') }}</p>
                        </div>
                    @endif
                </div>
            </div>

        <!-- Main content -->
        @yield('content')
        <!-- /.Main content -->
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>NVT</b>
            </div>
            <strong>Copyright &copy; 2018</strong>
        </footer>

    </div>
    <!-- ./wrapper -->

    <!-- jQuery 3 -->
    <script src="{{ asset('public/admin/bower_components/jquery/dist/jquery.min.js') }}"></script>

    <!-- jQuery UI 1.11.4 -->
    <script src="{{ asset('public/admin/bower_components/jquery-ui/jquery-ui.min.js') }}"></script>

    <!-- Bootstrap 3.3.7 -->
    <script src="{{ asset('public/admin/bower_components/bootstrap/dist/js/bootstrap.min.js') }}"></script>

    <!-- datepicker -->
    <script src="{{ asset('public/admin/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

    <!-- Bootstrap WYSIHTML5 -->
    <script src="{{ asset('public/admin/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js') }}"></script>

    <!-- AdminLTE App -->
    <script src="{{ asset('public/admin/js/adminlte.min.js') }}"></script>

    <!-- My JS -->
    <script src="{{ asset('public/admin/js/myscript.js') }}"></script>
    <script src="{{ asset('public/js/myjs.js') }}"></script>

    @yield('custom javascript')

</body>
</html>
