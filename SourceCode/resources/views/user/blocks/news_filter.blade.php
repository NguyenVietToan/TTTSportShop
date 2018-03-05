<div class="news-page">
	<h2 class="title text-center">Tin tức</h2>
	<div class="news-list filter">
		@foreach ($all_news as $news)
		<div class="news-item">
			<div class="news-image">
				<a href="">
					<img src="{{ asset('resources/upload/images/news/thumbnail/'.$news->id.'/'.$news->image) }}" alt="">
				</a>
			</div>
			<h3><a href="">{!! $news->title !!}</a></h3>
			<div class="news-date">{{ $news->updated_at }}</div>
			<div class="short-news-content">{!! $news->summary !!}</div>
			<a class="btn btn-default" href="">Chi tiết <i class="fa fa-angle-double-right" aria-hidden="true"></i></a>
		</div>
		@endforeach
	</div>
</div>
<!-- /.news-page -->

<ul class="pagination news">
	{!! $all_news->appends(['newscate' => $newscate])->render() !!}
</ul>
<!-- /.pagination -->