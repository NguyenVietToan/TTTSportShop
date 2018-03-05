<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Trang chủ</title>

	<!-- JS Library -->
	<script src="https://code.jquery.com/jquery-3.2.1.js"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
	<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

	<!-- Google Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,400i,500,500i,700,900" rel="stylesheet">

	<!-- CSS Library -->
	<link rel="stylesheet" type="text/css" href="{{ asset('public/user/css/bootstrap.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('public/user/css/jquery-ui.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/user/css/font-awesome.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('public/user/css/price-range.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('public/user/css/reset.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('public/user/bootstrapformhelpers/css/bootstrap-formhelpers.min.css') }}">

	<!-- XZoom -->
	<link rel="stylesheet" type="text/css" href="{{ asset('public/user/css/xzoom.css') }}">
	<script type="text/javascript" src="{{ asset('public/user/js/xzoom.min.js') }}"></script>
	<script type="text/javascript" src="{{ asset('public/user/js/setup.js') }}"></script>

	<!-- Fancybox -->
	<link type="text/css" rel="stylesheet" href="{{ asset('public/user/fancybox/jquery.fancybox.css') }}" />
	<script type="text/javascript" src="{{ asset('public/user/fancybox/jquery.fancybox.js') }}"></script>

	<!-- Magnific-popup -->
	<link type="text/css" rel="stylesheet" href="{{ asset('public/user/magnific-popup/magnific-popup.css') }}" />
	<script type="text/javascript" src="{{ asset('public/user/magnific-popup/magnific-popup.js') }}"></script>
	<link rel="stylesheet" type="text/css" href="{{ asset('public/user/bootstrapformhelpers/js/bootstrap-formhelpers.js') }}">

	<!-- My CSS -->
	<link rel="stylesheet" type="text/css" href="{{ asset('public/user/css/main.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('public/user/css/header.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('public/user/css/slider.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('public/user/css/contact.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('public/user/css/responsive.css') }}">

	<!-- Thiết lập các đường dẫn -->
	<script type="text/javascript">
		BASE_URL = "{{ url('/') }}";
		var ADD_TO_CART_URL = "{{ route('postAddItem') }}";
        var CSRF_TOKEN = "{{ csrf_token() }}";
        var CART_URL = "{{ route('getCartInfo') }}";
        var ADD_TO_WISHLIST_URL = "{{ route('addToWishList') }}";
        var DELETE_FROM_WISHLIST_URL = "{{ route('postDeleteWishList') }}";
        var GET_ADDRESS_URL = "{{ url('address') }}";
	</script>
</head>
<body>
	<div id="fb-root"></div>
	<script>
		(function(d, s, id) {
		  var js, fjs = d.getElementsByTagName(s)[0];
		  if (d.getElementById(id)) return;
		  js = d.createElement(s); js.id = id;
		  js.src = 'https://connect.facebook.net/vi_VN/sdk.js#xfbml=1&version=v2.11&appId=259596271235378';
		  fjs.parentNode.insertBefore(js, fjs);
		}(document, 'script', 'facebook-jssdk'));
	</script>

	<div class="wrapper">
		<header>
			@include('user.blocks.header')
		</header>
		<!-- /header -->

		<div class="wrapper-content">
			<!-- Main Content Start -->
			@yield('content')
			<!-- Main Content End -->
		</div>
		<!-- /.wrapper-content -->

		<footer>
			@include('user.blocks.footer')
		</footer>
		<!-- /footer -->
	</div>
	<!-- /.wrapper -->


	<script type="text/javascript" src="{{ asset('public/user/js/bootstrap.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/user/js/main.js') }}"></script>
    <script type="text/javascript" src="{{ asset('public/js/myjs.js') }}"></script>

    <script>
	$(document).ready(function($) {
		$(window).scroll(function() {
			if ($(this).scrollTop()>150) {
				$(".header-bottom").addClass('fixNav')
			} else {
				$(".header-bottom").removeClass('fixNav')
			}
		});
	});
	</script>

    @yield('custom javascript')

</body>
</html>