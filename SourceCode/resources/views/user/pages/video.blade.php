@extends('user.master')
@section('content')

<div class="main-content">
	<div class="container">
		<ul class="breadcrumb">
			<li>
				<a href="#">Trang chủ</a>
				<span class="divider"></span>
			</li>
			<li class="active">Video</li>
		</ul>
		<!-- /.breadcrumb -->

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
				<div class="sidebar-left">
					<div class="video-filter list-group">
						<h2>Thể loại video</h2>
						<div class="name">
							<ul class="nav nav-pills nav-stacked">
							@foreach ($videocates as $vcate)
								<li>
									<input type="checkbox" class="videoFilter videocate" value="{{ $vcate->id }}"
										@if (!empty($videocate))
											@if (in_array($vcate->id, $videocate))
												checked
											@endif
										@endif
									/> {{ ucwords($vcate->name) }}
								</li>
							@endforeach
							</ul>
						</div>
					</div>
				</div>
				<!-- /.sidebar-left -->
			</div>

			<div class="col-xs-12 col-sm-12 col-md-9 col-lg-9" id="updateVideoDiv">
				<div class="video-page">
					<h2 class="title text-center">Video Clip</h2>
					@foreach ($all_videos as $video)
						<div class="col-xs-6 col-sm-6 col-md-3 col-lg-3">
							<div class="video">
								<a href="{{ route('videoDetails', $video->id) }}">
									<div class="img">
										<div class="img_video" style="background: url('{{ asset("public/user/images/playvideo2.png") }}') no-repeat center center;"></div>
										<div class="limit">
											<img src="{{ asset('resources/upload/images/video/'.$video->id.'/'.$video->image) }}" alt="">
										</div>
									</div>
								</a>
								<h4><a href="{{ route('videoDetails', $video->id) }}">{{ $video->title }}</a></h4>
							</div>
							<!-- /.video -->
						</div>
					@endforeach
				</div>
				<!-- /.video-page -->

				@if (isset($videocate))
				<ul class="pagination myvideo">
					{!! $all_videos->appends(['videocate' => $videocate])->render() !!}
				</ul>
				@else
				<ul class="pagination myvideo">
					{!! $all_videos->render() !!}
				</ul>
				@endif
				<!-- /.pagination -->

			</div>
		</div>
	</div>
</div>
<!-- /.main-content -->

<script>
	URL_GET_VIDEO_AJAX = {!! json_encode(['url' => route('getVideoAjax'), 'paginate_url' => $paginateUrl]) !!}   //  hàm json_encode($array) sẽ chuyển mảng $array thành 1 chuỗi json
</script>

@endsection