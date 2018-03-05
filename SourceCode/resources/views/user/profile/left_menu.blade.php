<div class="col-xs-12 col-sm-6 col-md-3">
	<h2 class="title text-center" style="margin: 0 0 25px">{{ (session('lang'))?Config::get('lang.'.session('lang'))['management']:Config::get('lang.vi')['management'] }}</h2>
	<ul class="nav navbar well well-sm">
		<li><a href="{{ url('/thong-tin') }}">{{ (session('lang'))?Config::get('lang.'.session('lang'))['update_profile']:Config::get('lang.vi')['update_profile'] }}</a></li>
		<li><a href="{{ url('/don-hang') }}">{{ (session('lang'))?Config::get('lang.'.session('lang'))['order_history']:Config::get('lang.vi')['order_history'] }}</a></li>
		<li><a href="{{ url('/mat-khau') }}">{{ (session('lang'))?Config::get('lang.'.session('lang'))['change_password']:Config::get('lang.vi')['change_password'] }}</a></li>
	</ul>
</div>