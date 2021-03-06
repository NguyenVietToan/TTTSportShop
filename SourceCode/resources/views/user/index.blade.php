<!DOCTYPE html>
<html lang="en">

<head>
	<title>TTT Shop</title>
	<base href="{{asset('')}}">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	
	<script type="application/x-javascript">
		addEventListener("load", function () {
			setTimeout(hideURLbar, 0);
		}, false);

		function hideURLbar() {
			window.scrollTo(0, 1);
		}
	</script>
	<!-- //custom-theme -->
	<link href="public/source/css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
	<link rel="stylesheet" href="public/source/css/shop.css" type="text/css" media="screen" property="" />
	<link href="public/source/css/style7.css" rel="stylesheet" type="text/css" media="all" />
	<link href="public/source/css/style.css" rel="stylesheet" type="text/css" media="all" />
	<!-- font-awesome-icons -->
	<link href="public/source/css/font-awesome.css" rel="stylesheet">
	<!-- //font-awesome-icons -->
	<link href="//fonts.googleapis.com/css?family=Montserrat:100i,200,200i,300,300i,400,400i,500,500i,600,600i,700,700i,800"
	    rel="stylesheet">
	<link href="//fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800" rel="stylesheet">
</head>

<body>
	<!-- banner -->
	<div class="banner_top" id="home">
		<div class="wrapper_top_w3layouts">

			<div class="header_agileits">
				<div class="logo">
					<h1><a class="navbar-brand" href="{{URL('/')}}"><span>TTT</span> <i>Shop</i></a></h1>
				</div>
				
				<!-- search -->
				<div class="search_w3ls_agileinfo">
					<div class="cd-main-header">
						<ul class="cd-header-buttons">
							<li><a class="cd-search-trigger" href="#cd-search"> <span></span></a></li>
						</ul>
					</div>
					<div id="cd-search" class="cd-search">
						<form action="{{ route('getSearch') }}">
							<input name="Search" type="search" placeholder="Tìm kiếm ở đây...">
						</form>
					</div>
				</div>
				<!-- //search -->

				<div class="clearfix"></div>
			</div>
			<!-- /slider -->
			<div class="slider">
				<div class="callbacks_container">
					<ul class="rslides callbacks callbacks1" id="slider4">
						@foreach ($large_banners as $large_banner)
						<li>
							<div class="banner-top" style="background-image: url('{{ asset("resources/upload/images/banner/largebanner/large/".$large_banner->id."/".$large_banner->image) }}')">
								<div class="banner-info-wthree">
									<h3>{{$large_banner->name}}</h3>
									<p>{{strip_tags($large_banner->description, 'p')}}</p>

								</div>

							</div>
						 </li>
						 @endforeach
						
					</ul>
				</div>
				<div class="clearfix"> </div>
			</div>
			<!-- //slider -->
			<ul class="top_icons">
				<li><a href="https://www.facebook.com/giaythethaonamnu2Tshoes/"><span class="fa fa-facebook" aria-hidden="true"></span></a></li>
				<li><a href="https://www.facebook.com/profile.php?id=100009479588425"><span class="fa fa-twitter" aria-hidden="true"></span></a></li>
				<li><a href="https://www.facebook.com/profile.php?id=100009479588425"><span class="fa fa-linkedin" aria-hidden="true"></span></a></li>
				<li><a href="https://www.youtube.com/channel/UCAHurdWOD06LTUTA14ONcpg"><span class="fa fa-google-plus" aria-hidden="true"></span></a></li>

			</ul>
		</div>
	</div>
	<!-- //banner -->
	<!-- /girds_bottom-->
	<div class="grids_bottom">
		<div class="style-grids">
			<div class="col-md-6 style-grid style-grid-1">
				<img src="public/source/images/b1.jpg" alt="shoe">
			</div>
		</div>
		<div class="col-md-6 style-grid style-grid-2">
			<div class="style-image-1_info">
				<div class="style-grid-2-text_info">
					<h3>Nike DOWNSHIFTER</h3>
					<p>Nike là một trong những thương hiệu giày hàng đầu thế giới được thành lập vào năm 1964. Đến nay đã tung ra hàng chục siêu phẩm đình đám như Nike LunarGlide, Nike Downshifter, Nike Kyrie... đều được đưa vào danh sách những đôi giày được yêu thích nhất.</p>
					<div class="shop-button">
						<a href="{{ URL('thuong-hieu/nike') }}">Xem thêm</a>
					</div>
				</div>
			</div>
			<div class="style-image-2">
				<img src="public/source/images/b2.jpg" alt="shoe">
				<div class="style-grid-2-text">
					<h3>Air force</h3>
				</div>
			</div>
		</div>
		<div class="clearfix"></div>
	</div>
	</div>
	<!-- //grids_bottom-->
	<!-- /girds_bottom2-->
	<div class="grids_sec_2">
		<div class="style-grids_main">
			<div class="col-md-6 grids_sec_2_left">
				<div class="grid_sec_info">
					<div class="style-grid-2-text_info">
						<h3>Heels</h3>
						<p>Đối với nữ doanh nhân, lợi thế của những đôi giày cao gót rất rõ rệt, khiến nó trở thành trợ thủ đắc lực trong việc làm đẹp hàng ngày của chị em, nổi trội hơn, tự tin hơn và thành công nhiều hơn trong kinh doanh.</p>
						<div class="shop-button">
							<a href="{{ URL('thuong-hieu/christian-louboutin') }}">Xem thêm</a>
						</div>
					</div>
				</div>
				<div class="style-image-2">
					<img src="public/source/images/b7.jpg" alt="shoe">
					<div class="style-grid-2-text">
						<h3>Pumps</h3>
					</div>
				</div>
			</div>
			<div class="col-md-6 grids_sec_2_left">

				<div class="style-image-2">
					<img src="public/source/images/b5.jpg" alt="shoe">
					<div class="style-grid-2-text">
						<h3>Lace-up</h3>
					</div>
				</div>
				<div class="grid_sec_info last">
					<div class="style-grid-2-text_info">
						<h3>Giày tây</h3>
						<p>Giày tây được phái mạnh yêu thích với phong cách lịch lãm, sang trọng và hiện đại. Giày tây nam phù hợp với nơi công sở hay gặp mặt đối tác, khẳng định vị thế quý ông. Dòng giày nam cao cấp này được ưa chuộng từ kiểu dáng tới chất liệu.</p>
						<div class="shop-button two">
							<a href="{{ URL('thuong-hieu/gucci') }}">Xem thêm</a>
						</div>
					</div>
				</div>
			</div>
			<div class="clearfix"></div>
		</div>
	</div>
	<!-- //grids_bottom2-->
	<!-- /Properties -->
	<div class="mid_slider_w3lsagile">
		<div class="col-md-3 mid_slider_text">
			<h5>Sản phẩm khác</h5>
		</div>
		<div class="col-md-9 mid_slider_info">
			<div id="myCarousel" class="carousel slide" data-ride="carousel">
				<!-- Indicators -->
				<ol class="carousel-indicators">
					<li data-target="#myCarousel" data-slide-to="0" class="active"></li>
					<li data-target="#myCarousel" data-slide-to="1" class=""></li>
					<li data-target="#myCarousel" data-slide-to="2" class=""></li>
					<li data-target="#myCarousel" data-slide-to="3" class=""></li>
				</ol>
				<div class="carousel-inner" role="listbox">
					<div class="item active">
						<div class="row">
							<div class="col-md-3 col-sm-3 col-xs-3 slidering">
								<div class="thumbnail"><img src="public/source/images/g7.jpg" alt="Image" style="max-width:100%;"></div>
							</div>
							<div class="col-md-3 col-sm-3 col-xs-3 slidering">
								<div class="thumbnail"><img src="public/source/images/g8.jpg" alt="Image" style="max-width:100%;"></div>
							</div>
							<div class="col-md-3 col-sm-3 col-xs-3 slidering">
								<div class="thumbnail"><img src="public/source/images/g1.jpg" alt="Image" style="max-width:100%;"></div>
							</div>
							<div class="col-md-3 col-sm-3 col-xs-3 slidering">
								<div class="thumbnail"><img src="public/source/images/g2.jpg" alt="Image" style="max-width:100%;"></div>
							</div>
						</div>
					</div>
					<div class="item">
						<div class="row">
							<div class="col-md-3 col-sm-3 col-xs-3 slidering">
								<div class="thumbnail"><img src="public/source/images/g9.jpg" alt="Image" style="max-width:100%;"></div>
							</div>
							<div class="col-md-3 col-sm-3 col-xs-3 slidering">
								<div class="thumbnail"><img src="public/source/images/g10.jpg" alt="Image" style="max-width:100%;"></div>
							</div>
							<div class="col-md-3 col-sm-3 col-xs-3 slidering">
								<div class="thumbnail"><img src="public/source/images/g3.jpg" alt="Image" style="max-width:100%;"></div>
							</div>
							<div class="col-md-3 col-sm-3 col-xs-3 slidering">
								<div class="thumbnail"><img src="public/source/images/g4.jpg" alt="Image" style="max-width:100%;"></div>
							</div>
						</div>
					</div>
					<div class="item">
						<div class="row">
							<div class="col-md-3 col-sm-3 col-xs-3 slidering">
								<div class="thumbnail"><img src="public/source/images/g1.jpg" alt="Image" style="max-width:100%;"></div>
							</div>
							<div class="col-md-3 col-sm-3 col-xs-3 slidering">
								<div class="thumbnail"><img src="public/source/images/g2.jpg" alt="Image" style="max-width:100%;"></div>
							</div>
							<div class="col-md-3 col-sm-3 col-xs-3 slidering">
								<div class="thumbnail"><img src="public/source/images/g3.jpg" alt="Image" style="max-width:100%;"></div>
							</div>
							<div class="col-md-3 col-sm-3 col-xs-3 slidering">
								<div class="thumbnail"><img src="public/source/images/g4.jpg" alt="Image" style="max-width:100%;"></div>
							</div>
						</div>
					</div>
					<div class="item">
						<div class="row">
							<div class="col-md-3 col-sm-3 col-xs-3 slidering">
								<div class="thumbnail"><img src="public/source/images/g5.jpg" alt="Image" style="max-width:100%;"></div>
							</div>
							<div class="col-md-3 col-sm-3 col-xs-3 slidering">
								<div class="thumbnail"><img src="public/source/images/g6.jpg" alt="Image" style="max-width:100%;"></div>
							</div>
							<div class="col-md-3 col-sm-3 col-xs-3 slidering">
								<div class="thumbnail"><img src="public/source/images/g9.jpg" alt="Image" style="max-width:100%;"></div>
							</div>
							<div class="col-md-3 col-sm-3 col-xs-3 slidering">
								<div class="thumbnail"><img src="public/source/images/g10.jpg" alt="Image" style="max-width:100%;"></div>
							</div>
						</div>
					</div>
				</div>
				<a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
			<span class="fa fa-chevron-left" aria-hidden="true"></span>
			<span class="sr-only">Previous</span>
		</a>
				<a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
			<span class="fa fa-chevron-right" aria-hidden="true"></span>
			<span class="sr-only">Next</span>
		</a>
				<!-- The Modal -->

			</div>
		</div>

		<div class="clearfix"> </div>
	</div>
	<!--//banner -->

	<!-- /newsletter-->
	<div class="newsletter_w3layouts_agile">
		<div class="col-sm-4">
			
		</div>
		<div class="col-sm-4 text-center big_shop_now" >
				<a href="{{route('getHome')}}" class="btn btn-danger">Mua sắm ngay</a>

		</div>
	<div class="col-sm-4" >
			
		</div>
		<div class="clearfix"></div>
	</div>
	<!-- //newsletter-->
	<!-- footer -->
	<div class="footer_agileinfo_w3">
		<div class="footer_inner_info_w3ls_agileits">
			<div class="col-md-4 footer-left">
				<h2><a href="{{URL('/')}}"><span>TTT</span> Shop </a></h2>
				<p>Shop chuyên bán giày chính hãng của các thương hiệu nổi tiếng trên thế giới</p>
				<ul class="social-nav model-3d-0 footer-social social two" style="padding-left: 0px;">
					<li>
						<a href="https://www.facebook.com/giaythethaonamnu2Tshoes/" class="facebook">
							<div class="front"><i class="fa fa-facebook" aria-hidden="true"></i></div>
							<div class="back"><i class="fa fa-facebook" aria-hidden="true"></i></div>
						</a>
					</li>
					<li>
						<a href="https://www.facebook.com/profile.php?id=100009479588425" class="twitter">
							<div class="front"><i class="fa fa-twitter" aria-hidden="true"></i></div>
							<div class="back"><i class="fa fa-twitter" aria-hidden="true"></i></div>
						</a>
					</li>
					<li>
						<a href="https://www.facebook.com/profile.php?id=100009479588425" class="instagram">
							<div class="front"><i class="fa fa-instagram" aria-hidden="true"></i></div>
							<div class="back"><i class="fa fa-instagram" aria-hidden="true"></i></div>
						</a>
					</li>
					<li>
						<a href="https://www.youtube.com/channel/UCAHurdWOD06LTUTA14ONcpg" class="pinterest">
							<div class="front"><i class="fa fa-linkedin" aria-hidden="true"></i></div>
							<div class="back"><i class="fa fa-linkedin" aria-hidden="true"></i></div>
						</a>
					</li>
				</ul>
			</div>
			<div class="col-md-8 footer-right">
				<div class="sign-grds">
					<div class="col-md-6 sign-gd">
						<h4>Thông tin <span>website</span> </h4>
						<ul style="padding-left: 0px;">
							<li><a href="{{route('getHome')}}">Trang chủ</a></li>    <!-- route(alias) -->
							<li><a href="{{ url('san-pham') }}">Sản phẩm</a></li>    <!-- url(dia_chi) -->
							<li><a href="{{ route('getSaleProduct') }}">Khuyến mãi</a></li>
							<li><a href="{{ route('getNews') }}">Tin tức</a></li>
							<li><a href="{{ route('getContact') }}">Liên hệ</a></li>
						</ul>
					</div>

					<div class="col-md-6 sign-gd-two">
						<h4>Thông tin <span>cửa hàng</span></h4>
						<div class="address">
							<div class="address-grid">
								<div class="address-left">
									<i class="fa fa-phone" aria-hidden="true"></i>
								</div>
								<div class="address-right">
									<h6>Số điện thoại</h6>
									<p>+84 964 600 170</p>
								</div>
								<div class="clearfix"> </div>
							</div>
							<div class="address-grid">
								<div class="address-left">
									<i class="fa fa-envelope" aria-hidden="true"></i>
								</div>
								<div class="address-right">
									<h6>Địa chỉ email</h6>
									<p>Email :<a href="mailto:nguyenviettoan161095@gmail.com"> nguyenviettoan161095@gmail.com</a></p>
								</div>
								<div class="clearfix"> </div>
							</div>
							<div class="address-grid">
								<div class="address-left">
									<i class="fa fa-map-marker" aria-hidden="true"></i>
								</div>
								<div class="address-right">
									<h6>Vị trí</h6>
									<p>75 Giải Phóng, Q. Hai Bà Trưng, Hà Nội, Việt Nam.

									</p>
								</div>
								<div class="clearfix"> </div>
							</div>
						</div>
					</div>
					
					<div class="clearfix"></div>
				</div>
			</div>
			<div class="clearfix"></div>

			<p class="copy-right-w3ls-agileits">&copy 2018 TTT Shop. All rights reserved | Design by <a href="#">Nguyễn Viết Toàn</a></p>
		</div>
	</div>
	
	<!-- //footer -->
    <a href="#home" id="toTop" class="scroll" style="display: block;"> <span id="toTopHover" style="opacity: 1;"> </span></a>
	<!-- js -->
	<script type="text/javascript" src="public/source/js/jquery-2.1.4.min.js"></script>
	<!-- //js -->
	<!-- <!-- /nav -->
	<script src="public/source/js/modernizr-2.6.2.min.js"></script>
	<script src="public/source/js/classie.js"></script>
	<script src="public/source/js/demo1.js"></script>
	<!-- //nav -->
	<!-- cart-js -->
	<script src="public/source/js/minicart.js"></script>
	<script>
		shoe.render();

		shoe.cart.on('shoe_checkout', function (evt) {
			var items, len, i;

			if (this.subtotal() > 0) {
				items = this.items();

				for (i = 0, len = items.length; i < len; i++) {}
			}
		});
	</script>
	<!-- //cart-js --> 
	<!--search-bar-->
	<script src="public/source/js/search.js"></script>
	<!--//search-bar-->
	<script src="public/source/js/responsiveslides.min.js"></script>
	<script>
		$(function () {
			$("#slider4").responsiveSlides({
				auto: true,
				pager: true,
				nav: true,
				speed: 1000,
				namespace: "callbacks",
				before: function () {
					$('.events').append("<li>before event fired.</li>");
				},
				after: function () {
					$('.events').append("<li>after event fired.</li>");
				}
			});
		});
	</script>
	<!-- js for portfolio lightbox -->
	<!-- start-smoth-scrolling -->
	<script type="text/javascript" src="public/source/js/move-top.js"></script>
	<script type="text/javascript" src="public/source/js/easing.js"></script>
	<script type="text/javascript">
		jQuery(document).ready(function ($) {
			$(".scroll").click(function (event) {
				event.preventDefault();
				$('html,body').animate({
					scrollTop: $(this.hash).offset().top
				}, 1000);
			});
		});
	</script>
	<!-- //end-smoth-scrolling -->

	<script type="text/javascript" src="public/source/js/bootstrap-3.1.1.min.js"></script>


</body>

</html>