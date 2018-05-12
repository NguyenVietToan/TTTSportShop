@extends('user.master')
@section('content')

<div class="contact">
	<div class="container">
		<ul class="breadcrumb">
    		<li>
      			<a href="{{ route('getHome') }}"><i class="fa fa-home" aria-hidden="true"></i> {{ (session('lang'))?Config::get('lang.'.session('lang'))['home_page']:Config::get('lang.vi')['home_page'] }}</a>
      			<span class="divider"></span>
    		</li>
    		<li class="active">{{ (session('lang'))?Config::get('lang.'.session('lang'))['contact']:Config::get('lang.vi')['contact'] }}</li>
  		</ul>
  		<!-- /.breadcrumb -->



	<div id="contact-page">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<h2 class="title text-center">{{ (session('lang'))?Config::get('lang.'.session('lang'))['contact']:Config::get('lang.vi')['contact'] }}</h2>
				<div class="contact-map">
					<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3724.7391977247394!2d105.83915931493216!3d21.003088986012298!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ac7750538da7%3A0x83ef1bef028a60bf!2zNzUgR2nhuqNpIFBow7NuZywgxJDhu5NuZyBUw6JtLCDEkOG7kW5nIMSQYSwgSMOgIE7hu5lp!5e0!3m2!1svi!2s!4v1526047250240" width="600" height="450" frameborder="0" style="border:0" allowfullscreen></iframe>
				</div>
				<!-- /.map -->
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
				<div class="contact-message">
					<h2 class="title text-center">{{ (session('lang'))?Config::get('lang.'.session('lang'))['message']:Config::get('lang.vi')['message'] }} {{ (session('lang'))?Config::get('lang.'.session('lang'))['contact']:Config::get('lang.vi')['contact'] }}</h2>

					@if (Session::has('flash_message'))
			            <div class="message alert alert-{{ Session::get('flash_level') }}">
			                <p class="text-center">{{ Session::get('flash_message') }}</p>
			            </div>
			        @endif

					<form class="contact-form" action="{{ route('postContact') }}" method="post">
						{{ csrf_field() }}
						<div class="control-group">
							<label for="email">Email <span class="asterisk">*</span></span></label>
							<input class="form-control" type="email" id="email" name="email" value="{{ Auth::check() ? Auth::user()->email : ''
      							}}" required>
						</div>
						<div class="control-group">
							<label for="subject">{{ (session('lang'))?Config::get('lang.'.session('lang'))['subject']:Config::get('lang.vi')['subject'] }}</label>
							<input class="form-control" type="text" id="subject" name="subject">
						</div>
						<div class="control-group">
							<label for="message">{{ (session('lang'))?Config::get('lang.'.session('lang'))['message']:Config::get('lang.vi')['message'] }} <span class="asterisk">*</span></label>
  							<textarea class="form-control" id="message" name="message" required></textarea>
						</div>
						<div class="control-group">
							<div class="action">
								<button class="btn btn-default submit" type="submit" value="Gửi tin">Gửi tin</button>
		                	<button class="btn btn-default reset" type="reset" value="Đặt lại">Đặt lại</button>
							</div>
						</div>
					</form>
				</div>
				<!-- /.contact-message -->
			</div>

			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
				<div class="contact-info">
    				<h2 class="title text-center">{{ (session('lang'))?Config::get('lang.'.session('lang'))['information']:Config::get('lang.vi')['information'] }} {{ (session('lang'))?Config::get('lang.'.session('lang'))['contact']:Config::get('lang.vi')['contact'] }}</h2>
    				<div class="address">
	    				<ul>
	    					<p><i class="fa fa-map-marker" aria-hidden="true"></i> Cửa hàng: TTT Shop Số 8 Ngách 75/14 Giải Phóng - Hai Bà Trưng - Hà Nội</p>
	    					<li><i class="fa fa-phone" aria-hidden="true"></i> Điện thoại 1: 0964.600.170 - Mr.Toàn</li>
	    					<li><i class="fa fa-phone" aria-hidden="true"></i> Điện thoại 2: 0988.640.141 - Ms.Bích</li>
	    				</ul>
	    				
	    				<ul><i class="fa fa-clock-o" aria-hidden="true"></i> Thời gian làm việc: 8h - 20h các ngày trong tuần</ul>
	    				<ul>
	    					<p><i class="fa fa-user" aria-hidden="true"></i> Tài khoản ngân hàng</p>
	    					<li>Nguyễn Viết Toàn - VIETCOMBANK: TK 0861000058815 - Chi nhánh Nghệ An</li>
	    					<li>Nguyễn Viết Toàn - VIETINBANK: TK 105001186892 - Chi nhánh Hà Nội</li>
	    					<li>Lê Thị Bích - BIDV: TK 51310000160063 - Chi nhánh Nghệ An</li>
	    					<li>Nguyễn Viết Thắng - VIETCOMBANK: TK 0711000265281 - Chi nhánh Hà Nội</li>
	    				</ul>
    				</div>
    				<!-- /.address -->
    				<div class="social-networks text-center">
    					<h2 class="title">Mạng Xã Hội</h2>
						<a href="https://www.facebook.com/giaythethaonamnu2Tshoes/" data-original-title title><span class="facebook"><i class="fa fa-facebook-square" aria-hidden="true"></i></i></span></a>
						<a href="https://www.facebook.com/profile.php?id=100009479588425"><span class="twitter"><i class="fa fa-twitter-square" aria-hidden="true"></i></span></a>
						<a href="https://www.youtube.com/channel/UCAHurdWOD06LTUTA14ONcpg"><span class="youtube"><i class="fa fa-youtube-play" aria-hidden="true"></i></span></a>
    				</div>
    			</div>
				<!-- /.contact-info -->
			</div>
		</div>
	</div>
	<!-- /.contact-page -->


	</div>
</div>
<!-- /.contact -->

@endsection