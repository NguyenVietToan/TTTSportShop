@extends('user.master')
@section('content')

<div class="main-content">
	<div class="container">
  		<ul class="breadcrumb">
    		<li><a href="{{ url('trang-chu') }}"><i class="fa fa-home" aria-hidden="true"></i> {{ (session('lang'))?Config::get('lang.'.session('lang'))['home_page']:Config::get('lang.vi')['home_page'] }}</a><span class="divider"></span></li>
    		<li class="active">{{ (session('lang'))?Config::get('lang.'.session('lang'))['news']:Config::get('lang.vi')['news'] }}</li>
  		</ul>
  		<!-- /.breadcrumb -->

		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
				<div class="sidebar-left">
					<h2>{{ (session('lang'))?Config::get('lang.'.session('lang'))['news_cate']:Config::get('lang.vi')['news_cate'] }}</h2>
					<div class="name">
						<ul class="nav nav-pills nav-stacked">
							@foreach ($newscates as $ncate)
							<li>
								<input type="checkbox" class="newsFilter newscate" value="{{ $ncate->id }}"
									@if (!empty($newscate))
										@if (in_array($ncate->id, $newscate))
										checked
										@endif
									@endif
								/> {{ ucwords($ncate->name) }}
							</li>
							@endforeach
						</ul>
					</div>
				</div>
				<!-- /.sidebar-left -->
			</div>

			<div class="col-xs-12 col-sm-6 col-md-9 col-lg-9" id="updateNewsDiv">
				<div class="news-page">
					<h2 class="title text-center">{{ (session('lang'))?Config::get('lang.'.session('lang'))['news']:Config::get('lang.vi')['news'] }}</h2>

					<div class="news-list">
						@foreach ($all_news as $news)
						<div class="news-item">
							<div class="news-image">
								<a href="{{ route('newsDetails', $news->id) }}">
									<img src="{{ asset('resources/upload/images/news/thumbnail/'.$news->id.'/'.$news->image) }}" alt="">
								</a>
							</div>
							<h3><a href="{{ route('newsDetails', $news->id) }}">{{ $news->title }}</a></h3>
							<div class="news-date">({{ date('H:i:s - d/m/y', strtotime($news->updated_at)) }})</div>
							<div class="short-news-content">{!! $news->summary !!}</div>
						</div>
						@endforeach
					</div>
				</div>
				<!-- /.news-page -->

				@if (isset($newscate))
				<ul class="pagination news">
					{!! $all_news->appends(['newscate' => $newscate])->render() !!}
				</ul>
				@else
				<ul class="pagination news">
					{!! $all_news->render() !!}
				</ul>
				@endif
				<!-- /.pagination -->

			</div>
		</div>
	</div>
</div>
<!-- /.main-content -->

<script>
	URL_GET_NEWS_AJAX = {!! json_encode(['url' => route('getNewsAjax'), 'paginate_url' => $paginateUrl]) !!}   //  hàm json_encode($array) sẽ chuyển mảng $array thành 1 chuỗi json
</script>

@endsection