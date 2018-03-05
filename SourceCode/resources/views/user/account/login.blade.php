@extends('user.master')
@section('content')

<div class="inner-header">
	<div class="container">
		<ul class="breadcrumb">
    		<li>
      			<a href=""><i class="fa fa-home" aria-hidden="true"></i>  Trang chủ</a>
      			<span class="divider"></span>
    		</li>
    		<li class="active">Đăng nhập</li>
  		</ul>
  		<!-- /.breadcrumb -->
		<div class="clearfix"></div>
	</div>
</div>

@include('user.blocks.error')

<div class="container">
	<div class="user-login">
		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-md-push-3">
				<form action="{{ route('postLogin') }}" method="post" class="form-horizontal" role="form" style="margin-bottom: 70px;">
					<input type="hidden" name="_token" value="{{ csrf_token() }}">

					<h2 class="title text-center">Đăng nhập</h2>
					<div class="form-group">
						<label>Email *</label>
						<input type="email" class="form-control" name="email">
					</div>
					<div class="form-group">
						<label>Mật khẩu *</label>
						<input type="password" class="form-control" name="password">
					</div>
					<div class="form-group">
						<input type="checkbox" class="checkbox" name="remember_token"> Ghi nhớ đăng nhập
					</div>
					<div class="form-group" style="display: inline-block;">
						<button type="submit" class="btn btn-primary">
	                        <i class="fa fa-btn fa-sign-in"></i> Đăng nhập
	                    </button>
	                    <span class="forgot-password" style="margin-left: 30px;"><a href="{{ route('password.request') }}" style=" color: #428bca !important">Quên mật khẩu?</a></span>
					</div>
					<div class="form-group">
						<strong>Đăng nhập với: </strong></br>
						<table width="50%" style="margin-left: 50px">
							<tr>
								<th>FaceBook</th>
								<th>Google</th>
							</tr>
							<tr>
								<td>
									<a class="btn-login_facebook" href="{{ url('/auth/login/facebook') }}"><img src="{{url('/public/user/images/facebook.jpg')}}" width="30px"></a>
								</td>
								<td>
									<a class="btn-login_google" href="{{ url('/auth/login/google') }}"><img src="{{url('/public/user/images/google.jpg')}}" width="30px"></a>
								</td>
							</tr>
						</table>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>

@endsection