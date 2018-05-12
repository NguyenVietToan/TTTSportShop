@extends('user.master')
@section('content')

<div class="introduce">
	<div class="container">
		<ul class="breadcrumb">
    		<li>
      			<a href="{{ route('getHome') }}"><i class="fa fa-home" aria-hidden="true"></i> {{ (session('lang'))?Config::get('lang.'.session('lang'))['home_page']:Config::get('lang.vi')['home_page'] }}</a></a>
      			<span class="divider"></span>
    		</li>
    		<li class="active">{{ (session('lang'))?Config::get('lang.'.session('lang'))['introduce']:Config::get('lang.vi')['introduce'] }}</li>
  		</ul>
  		<!-- /.breadcrumb -->

	<div id="introduce-page">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<h2 class="title text-center">Giới thiệu về cửa hàng</h2>
				
			</div>
		</div>


	</div>
</div>

@endsection