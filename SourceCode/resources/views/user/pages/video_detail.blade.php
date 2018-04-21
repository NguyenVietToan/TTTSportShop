@extends('user.master')
@section('content')

<div class="main-content">
	<div class="container">
		<ul class="breadcrumb">
			<li>
				<li><a href="{{ url('trang-chu') }}"><i class="fa fa-home" aria-hidden="true"></i> {{ (session('lang'))?Config::get('lang.'.session('lang'))['home_page']:Config::get('lang.vi')['home_page'] }}</a><span class="divider"></span></li>
    		<li class="active"><a href="{{ url('video') }}">{{ (session('lang'))?Config::get('lang.'.session('lang'))['video']:Config::get('lang.vi')['video'] }}</a>
      			<span class="divider"></span>
    		</li>
			<li class="active">{{ $video->title }}</li>
		</ul>
		<!-- /.breadcrumb -->

		<div class="row">
  			<div class="col-xs-12 col-sm-6 col-md-7 col-lg-7">
				<div class="video-details-page">
					<h1 class="title">{{ $video->title }}</h1>
					<div class="video-content">
						<iframe width="650" height="400" src="https://www.youtube.com/embed/{{ $video->link  }}" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen></iframe>
					</div>
				</div>
			</div>

			<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-md-push-1">
				<div class="panel panel-default">
                    <div class="panel-heading" style="font-size:18px;"><b>Video cùng loại</b></div>
                    <div class="panel-body">
	                    @foreach ($similar_videos as $svideo)
	                    	<div class="row similar-video video">
	                            <div class="col-md-7">
	                                <a href="{{ route('videoDetails', $svideo->video_id) }}">
									<div class="img">
										<div class="img_video" style="background: url('{{ asset("public/user/images/playvideo2.png") }}') no-repeat center center;"></div>
										<div class="limit">
											<img src="{{ asset('resources/upload/images/video/'.$svideo->video_id.'/'.$svideo->image) }}" alt="">
										</div>
									</div>
								</a>
	                            </div>
	                            <div class="col-md-5" style="padding-left: 0">
	                                <h4><a href="{{ route('videoDetails', $svideo->video_id) }}">{{ $svideo->title }}</a></h4>
	                            </div>
	                            <div class="break"></div>
	                        </div>
	                    @endforeach
                    </div>
			</div>
  		</div>

	</div>
</div>
<!-- /.main-content -->

@endsection