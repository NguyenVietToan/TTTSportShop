@extends('user.master')
@section('content')

<div class="contact">
	<div class="container">
		<ul class="breadcrumb">
    		<li>
      			<a href="{{ route('getHome') }}">Trang chủ</a>
      			<span class="divider"></span>
    		</li>
    		<li class="active">Liên hệ</li>
  		</ul>
  		<!-- /.breadcrumb -->



	<div id="contact-page">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<h2 class="title text-center">Liên Hệ</h2>
				<div class="contact-map">
					<iframe style="border: 0;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7448.170107348817!2d105.82728668203579!3d21.0292825308759!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ab9f6ce26215%3A0x6407040e1a13763e!2zQ-G7rWEgSMOgbmcgVHXhuqVuIFBoxrDGoW5n!5e0!3m2!1svi!2s!4v1498818475145" frameborder="0" allowfullscreen="allowfullscreen"></iframe>
				</div>
				<!-- /.map -->
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 ">
				<div class="contact-message">
					<h2 class="title text-center">Tin nhắn liên hệ</h2>

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
							<label for="subject">Chủ đề</label>
							<input class="form-control" type="text" id="subject" name="subject">
						</div>
						<div class="control-group">
							<label for="message">Tin nhắn <span class="asterisk">*</span></label>
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
    				<h2 class="title text-center">Thông tin liên hệ</h2>
    				<div class="address">
	    				<ul>
	    					<p><i class="fa fa-map-marker" aria-hidden="true"></i> Cửa hàng 1: Số 8 Trịnh Hoài Đức - Cát Linh - Đống Đa - Hà Nội</p>
	    					<li><i class="fa fa-phone" aria-hidden="true"></i> Điện thoại: 0989.85.7777 / 0913.123.569 - Mr.Phương</li>
	    				</ul>
	    				<ul>
	    					<p><i class="fa fa-map-marker" aria-hidden="true"></i> Cửa hàng 2: Số 10 Lê Trực - Ba Đình - Hà Nội</p>
	    					<li><i class="fa fa-phone" aria-hidden="true"></i> Điện thoại: 0912.818.789 - Mr.Tuấn</li>
	    				</ul>
	    				<ul><i class="fa fa-clock-o" aria-hidden="true"></i> Thời gian làm việc: 8h - 20h các ngày trong tuần</ul>
	    				<ul>
	    					<p><i class="fa fa-user" aria-hidden="true"></i> Tài khoản ngân hàng</p>
	    					<li>Nguyễn Anh Tuấn - VIETCOMBANK: TK 0011004004952 - Chi nhánh Hà Nội</li>
	    					<li>Nguyễn Anh Tuấn - AGRIBANK: TK 1504205005481 - Chi nhánh Hà Nội</li>
	    					<li>Tạ Hữu Phương - BIDV: TK 12310000383858 - Chi nhánh Hà Nội</li>
	    					<li>Tạ Hữu Phương - VPBANK: TK 587777 - Chi nhánh Hà Nội</li>
	    				</ul>
    				</div>
    				<!-- /.address -->
    				<div class="social-networks text-center">
    					<h2 class="title">Mạng Xã Hội</h2>
						<a href="https://www.facebook.com/tuanphuongsports.com.vn/" data-original-title title><span class="facebook"><i class="fa fa-facebook-square" aria-hidden="true"></i></i></span></a>
						<a href="https://www.facebook.com/tuanphuongsports.com.vn/"><span class="twitter"><i class="fa fa-twitter-square" aria-hidden="true"></i></span></a>
						<a href="https://www.facebook.com/tuanphuongsports.com.vn/"><span class="youtube"><i class="fa fa-youtube-play" aria-hidden="true"></i></span></a>
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