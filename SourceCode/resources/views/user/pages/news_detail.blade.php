@extends('user.master')
@section('content')

<div class="main-content">
	<div class="container">
		<ul class="breadcrumb">
    		<li><a href="{{ url('trang-chu') }}"><i class="fa fa-home" aria-hidden="true"></i> {{ (session('lang'))?Config::get('lang.'.session('lang'))['home_page']:Config::get('lang.vi')['home_page'] }}</a><span class="divider"></span></li>
    		<li class="active"><a href="{{ url('tin-tuc') }}">{{ (session('lang'))?Config::get('lang.'.session('lang'))['news']:Config::get('lang.vi')['news'] }}</a>
      			<span class="divider"></span>
    		</li>
    		<li class="active">{{ $news->title }}</li>
  		</ul>
  		<!-- /.breadcrumb -->

  		<div class="row">
  			<div class="col-xs-12 col-sm-6 col-md-7 col-lg-7">
  				<div class="new-details-page">
					<div class="main-news">
						<h1 class="title">{{ $news->title }}</h1>
						<div class="news-content">
							<div class="news-date">
								{{ date('l, d/m/y, H:i:s', strtotime($news->updated_at)) }} GMT+7
							</div>
							<div class="short-news-content">
								{!! $news->summary !!}
							</div>
							<div class="news-image">
								<img src="{{ asset('resources/upload/images/news/large/'.$news->id.'/'.$news->image) }}" alt="">
							</div>
							<div class="full-news-content">
								<p>{!! $news->content !!}</p>
								<p class="pull-right"><b>Tác giả: {{ $news->author }}</b></p>
								<div style="clear: both;"></div>
								<p class="pull-right"><i>Nguồn: {{ $news->source }}</i></p>
							</div>
						</div>
						<!-- /.news-content -->
					</div>
					<!-- /.main-news -->
				</div>
				<!-- /.new-details-page -->

				<hr>

				@if (Session::has('flash_message'))
		            <div class="message alert alert-{{ Session::get('flash_level') }}">
		                <p class="text-center">{{ Session::get('flash_message') }}</p>
		            </div>
		        @endif

				@if (Auth::check())
					<div class="well">
		                <h4>Viết bình luận ...<span class="glyphicon glyphicon-pencil"></span></h4>
		                <form action="{{ route('postComment', $news->id) }}" role="form" method="post">
		                	{{ csrf_field() }}
		                	<input type="hidden" name="id" value="{{ $news->id }}">
		                    <div class="form-group">
		                        <textarea class="form-control" rows="3" name="content"></textarea>
		                    </div>
		                    <button type="submit" class="btn btn-primary">Gửi</button>
		                </form>
		            </div>

		            <hr>
				@endif

	            <!-- Comment -->
	            <div class="comment">
	            	<h3>Bình luận</h3>
	            	@foreach ($comments as $comment)
	            		<div class="media" style="margin-top: 7px;">
			                <a class="pull-left" href="#">
			                	@if (!$comment->user_avatar)

			                		<img class="media-object" src="{{ asset('public/user/images/default-user.png') }}" alt="" width="64px">
			                	@else
			                	
			                		<img class="media-object" src="{{ asset('resources/upload/images/user/'.$comment->user_id.'/'.$comment->user_avatar) }}" alt="">
			                	@endif
			                </a>
			                <div class="media-body">
			                    <h4 class="media-heading">{{ $comment->user_name }}
			                        <small>{{ date('H:i:s - d/m/y', strtotime($comment->created_at)) }}</small>
			                    </h4>
			                    {{ $comment->content }}
			                </div>

		            	</div>
	            	@endforeach
	            </div>
			</div>

			<div class="col-xs-12 col-sm-6 col-md-4 col-lg-4 col-md-push-1">
				<div class="panel panel-default">
                    <div class="panel-heading" style="font-size:18px;"><b>Tin cùng loại</b></div>
                    <div class="panel-body">
	                    @foreach ($similar_news as $snews)
	                    	<div class="row similar-news">
	                            <div class="col-md-5">
	                                <a href="{{ route('newsDetails', $snews->news_id) }}">
	                                    <img class="img-responsive" src="{{ asset('resources/upload/images/news/thumbnail/'.$snews->news_id.'/'.$snews->image) }}" alt="">
	                                </a>
	                            </div>
	                            <div class="col-md-7" style="padding-left: 0">
	                                <a href="{{ route('newsDetails', $snews->news_id) }}"><b>{{ $snews->title }}</b></a>
	                                <p>{!! $snews->summary !!}</p>
	                            </div>
	                            <div class="break"></div>
	                        </div>
	                    @endforeach
                    </div>
                </div>
			</div>
  		</div>

  	</div>
</div>
<!-- /.main-content -->

@endsection