<div class="video-page">
	<h2 class="title text-center">Video Clip</h2>
	@foreach ($all_videos as $video)
	<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
		<div class="video">
			<a href="">
				<div class="img">
					<div class="img_video" style="background: url('{{ asset("public/user/images/playvideo2.png") }}') no-repeat center center;"></div>
					<div class="limit">
						<img src="{{ asset('resources/upload/images/video/'.$video->id.'/'.$video->image) }}" alt="">
					</div>
				</div>
			</a>
			<h4><a href="">{{ $video->title }}</a></h4>
		</div>
		
		<!-- /.video -->
	</div>
	@endforeach
</div>
<!-- /.video-page -->

<ul class="pagination">
	{!! $all_videos->appends(['videocate' => $videocate])->render() !!}
</ul>
<!-- /.pagination -->