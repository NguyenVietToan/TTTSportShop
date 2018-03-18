<!DOCTYPE html>
<html lang="vi">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>@yield('title')</title>

	<link href="{{ asset('public/css/app.css') }}" rel="stylesheet">
	@yield('css_framework')
	<!-- Fonts -->
	<link href='//fonts.googleapis.com/css?family=Roboto:400,300' rel='stylesheet' type='text/css'>
	
	<link rel="stylesheet" href="{{ asset('public/font-awesome/css/font-awesome.css') }}">
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->
	
	<link rel="stylesheet" href="{{ asset('public/css/admin/admin.css') }}">
	
	@yield('css')
		<!-- Scripts -->
	<script src="{{ url('public/js/jquery.min.js') }}"></script>
	@yield('js')
	
	<script src="{{ url('public/bootstrap/js/bootstrap.min.js') }}"></script>
	
	
	<script type = "text/javascript" src="{!! url('public/js/editor/ckeditor/ckeditor.js') !!}"></script>
	<script type = "text/javascript" src="{!! url('public/js/editor/ckfinder/ckfinder.js') !!}"></script>
    <script type = "text/JavaScript">
        var baseURL = "{!! url('/') !!}";
    </script>
    <script type = "text/javascript" src="{!! url('public/js/editor/func_ckfinder.js') !!}"></script>

    <script src="{{ asset('public/js/admin.js') }}"></script>
    <style>
        body{
            background: #404040;
        }
        .content{
            margin-top:40px;
            height:100%;
        }
    </style>
</head>
<body>
<div id="header">
    <div class="row">
        <div class="logo">
            <div class="info_admin">
                <img src="{!!url('resources/upload/staff/'.(!empty(Session::get('admin')['avatar'])?Session::get('admin')['avatar']:'default/default.jpg'))!!}" alt="" style="height: 45px;width:45px;border-radius: 20px">
                <span style="padding-top:40px"><?php $admin= Session::get('admin'); echo $admin['ten_day_du'] ?></span>
            </div>
        </div>
        <div class="info_manage">
            <a><span>Nhân viên giao hàng</span>
                <i class="fa fa-chevron-down"></i>
            </a>
            <ul>
                <li><a href="{!!url('staff/update')!!}"><i class="fa fa-gears"></i> Cập nhật</a></li>
                <li><a href="{!!url('/staff/logout')!!}"><i class="fa fa-power-off"></i> Đăng xuất</a></li>
            </ul>
        </div>
    </div>
    
</div> <!-- End of Header -->
				<!-- menu side -->
	@yield('content');
	@yield('custom javascript')
</body>
</html>