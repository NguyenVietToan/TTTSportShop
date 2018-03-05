<div class="footer-account">
	<div class="container">
		<div class="row">
			<div class="contact col-xs-12 col-sm-12 col-md-4 col-lg-4">
				<h2>{{ (session('lang'))?Config::get('lang.'.session('lang'))['contact']:Config::get('lang.vi')['contact'] }}</h2>
                <p><i class="fa fa-location-arrow"></i> <b>Địa chỉ 1:</b> Số 8 Trịnh Hoài Đức - Cát Linh - Đống Đa - Hà Nội
				ĐT: 0989.85.7777 - 0913.123.569 MR.PHƯƠNG</p>
                <p><i class="fa fa-location-arrow"></i> <b>Địa chỉ 2:</b> Số 10 Lê Trực - Ba Đình - Hà Nội
				ĐT: 0912.818.789 MR.TUẤN</p>
                <p><i class="fa fa-phone"></i> <b>Hotline:</b> 0912.818.789 | 0913.123.569</p>
                <p><i class="fa fa-clock-o"></i> <b>Thời gian làm việc:</b> 08h00 đến 20h00 tất cả các ngày </p>
                <p>
                  	<p><i class="fa fa-user" aria-hidden="true"></i> <b>Thông tin tài khoản:</b></p>
					<p>Nguyễn Anh Tuấn - VIETCOMBANK: TK 0011004004952 - Chi nhánh Hà Nội</p>
					<p>Nguyễn Anh Tuấn - AGRIBANK: TK 1504205005481 - Chi nhánh Hà Nội</p>
					<p>Tạ Hữu Phương - BIDV: TK 12310000383858 - Chi nhánh Quang Trung - Hà Nội</p>
					<p>Tạ Hữu Phương - VPBANK: TK 587777 - Chi nhánh Cát Linh - Hà Nội</p>
                </p>
	        </div>

	        <div class="map col-xs-12 col-sm-12 col-md-4 col-lg-4">
	          	<h2>{{ (session('lang')) ? Config::get('lang.'.session('lang'))['map'] : Config::get('lang.vi')['map'] }}</h2>
	          	<div id="googlemap">
	          		<iframe style="border: 0;" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d7448.170107348817!2d105.82728668203579!3d21.0292825308759!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3135ab9f6ce26215%3A0x6407040e1a13763e!2zQ-G7rWEgSMOgbmcgVHXhuqVuIFBoxrDGoW5n!5e0!3m2!1svi!2s!4v1498818475145" width="600" height="200" frameborder="0" allowfullscreen="allowfullscreen"></iframe>
	          	</div>
	        </div>

			<div class="facebook col-xs-12 col-sm-12 col-md-4 col-lg-4">
	  			<h2>Facebook</h2>
	  			<div class="fb-page" data-href="https://www.facebook.com/tuanphuongsports.com.vn/" data-hide-cover="false" data-show-facepile="true" data-show-posts="false"></div>
			</div>
		</div>
	</div>
</div>


<div id="messBox" style="display: none">
	<div class="fb-page" data-href="https://www.facebook.com/tuanphuongsports.com.vn/" data-tabs="messages" data-height="300px" data-small-header="false" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true"><blockquote cite="https://www.facebook.com/tuanphuongsports.com.vn/" class="fb-xfbml-parse-ignore"><a href="https://www.facebook.com/tuanphuongsports.com.vn/">Vợt Tennis Tuanphuongsports</a></blockquote></div>
</div>
<div><a id="messenger" onclick="messenger()" style="background-image: url('{{ asset('public/user/images/messenger.jpg') }}');"></a></div>

<section class="quick-alo-phone quick-alo-green quick-alo-show" id="quick-alo-phoneIcon">
   	<a href="tel:0912818789">
      <section class="quick-alo-ph-circle"></section>
      <section class="quick-alo-ph-circle-fill"></section>
      <section class="quick-alo-ph-img-circle"></section>
   	</a>
</section>

<div class="footer-copyright">
	<div class="container">
		<div class="row">
	        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
	         	<p style="margin: 10px 0;">Copyright &copy; 2017 Tuấn Phương Sports.</p>
	        </div>
	        <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
	         	<p class="pull-right" style="margin: 10px 0;">Made by Tạ Hữu Công</p>
	        </div>
		</div>
	</div>
</div>

<a class="scrollTop" href="#">
	<i class="fa fa-angle-up"></i>
</a>
{{--
<script type="text/javascript">
	var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
	(function(){
	var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
	s1.async=true;
	s1.src='https://embed.tawk.to/595606c4e9c6d324a4738172/default';
	s1.charset='UTF-8';
	s1.setAttribute('crossorigin','*');
	s0.parentNode.insertBefore(s1,s0);
	})();
</script> --}}


