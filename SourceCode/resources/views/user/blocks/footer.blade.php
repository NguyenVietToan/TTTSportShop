<div class="footer_agileinfo_w3">
		<div class="footer_inner_info_w3ls_agileits">
			<div class="col-md-4 footer-left">
				<h2><a href="index.html"><span>TTT</span> Shop </a></h2>
				<p>Shop chuyên bán giày chính hãng của các thương hiệu nổi tiếng trên thế giới</p>
				<ul class="social-nav model-3d-0 footer-social social two">
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
						<h4>{{ (session('lang'))?Config::get('lang.'.session('lang'))['information']:Config::get('lang.vi')['information'] }} <span>Website</span> </h4>
						<ul>
							<li><a href="{{route('getHome')}}">{{ (session('lang'))?Config::get('lang.'.session('lang'))['home_page']:Config::get('lang.vi')['home_page'] }}</a></li>
							<li><a href="{{ url('san-pham') }}">{{ (session('lang'))?Config::get('lang.'.session('lang'))['product']:Config::get('lang.vi')['product'] }}</a></li>
							<li><a href="{{ route('getSaleProduct') }}">{{ (session('lang')) ? Config::get('lang.'.session('lang'))['promotion'] : Config::get('lang.vi')['promotion'] }}</a></li>
							<li><a href="{{ route('getNews') }}">{{ (session('lang'))?Config::get('lang.'.session('lang'))['news']:Config::get('lang.vi')['news'] }}</a></li>
							<li><a href="{{ route('getContact') }}">{{ (session('lang'))?Config::get('lang.'.session('lang'))['contact']:Config::get('lang.vi')['contact'] }}</a></li>
						</ul>
					</div>

					<div class="col-md-6 sign-gd-two">
						<h4>{{ (session('lang'))?Config::get('lang.'.session('lang'))['information']:Config::get('lang.vi')['information'] }} <span>{{ (session('lang'))?Config::get('lang.'.session('lang'))['store']:Config::get('lang.vi')['store'] }}</span></h4>
						<div class="address">
							<div class="address-grid">
								<div class="address-left">
									<i class="fa fa-phone" aria-hidden="true"></i>
								</div>
								<div class="address-right">
									<h6>{{ (session('lang'))?Config::get('lang.'.session('lang'))['phone']:Config::get('lang.vi')['phone'] }}</h6>
									<p>+84 964 600 170</p>
								</div>
								<div class="clearfix"> </div>
							</div>
							<div class="address-grid">
								<div class="address-left">
									<i class="fa fa-envelope" aria-hidden="true"></i>
								</div>
								<div class="address-right">
									<h6>{{ (session('lang'))?Config::get('lang.'.session('lang'))['email']:Config::get('lang.vi')['email'] }}</h6>
									<p>Email :<a href="mailto:nguyenviettoan161095@gmail.com"> nguyenviettoan161095@gmail.com</a></p>
								</div>
								<div class="clearfix"> </div>
							</div>
							<div class="address-grid">
								<div class="address-left">
									<i class="fa fa-map-marker" aria-hidden="true"></i>
								</div>
								<div class="address-right">
									<h6>{{ (session('lang'))?Config::get('lang.'.session('lang'))['address']:Config::get('lang.vi')['address'] }}</h6>
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

<!-- <a href="#trang-chu" id="toTop" class="scroll" style="display: block;"> <span id="toTopHover" style="opacity: 1;"> </span></a> -->
	
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