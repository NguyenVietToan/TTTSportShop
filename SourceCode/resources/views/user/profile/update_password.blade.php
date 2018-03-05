@extends('user.master')
@section('content')

<section id="my-profile">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{ url('/') }}">Trang chủ</a></li>
            <li><a href="{{ route('getAccount') }}">Quản lý tài khoản</a></li>
            <li class="active">Đổi mật khẩu</li>
        </ul>
        <!-- /.breadcrums -->


        <div class="row">
            @include('user.profile.left_menu')
            <div class="col-xs-12 col-sm-6 col-md-7 col-md-push-1">
                <h2 class="title text-center">Cập nhật mật khẩu</h2>

                @if (Session::has('flash_message'))
			    	<div class="message alert alert-{{ Session::get('flash_level') }}">
			      		<p class="text-center">{{ Session::get('flash_message') }}</p>
			      	</div>
			    @endif

                <form action="{{ route('updatePassword') }}" method="POST" role="form" class="list-pro-data">
        			<input type="hidden" name="_token" value="{{ csrf_token() }}">

	                <div class="container" >
	                    <div class="form-group row">
	                        <div class="form-group col-md-5 col-md-push-1">
	                            <label for="example-text-input">Mật khẩu hiện tại <span class="asterisk">*</span></label>
	                            <input class="form-control" type="password"  name="oldPassword">
	                            <br>
	                            <label for="example-text-input">Mật khẩu mới <span class="asterisk">*</span></label>
	                            <input class="form-control" type="password"  name="newPassword">
	                            <br>
                                <label for="example-text-input">Xác nhận mật khẩu mới <span class="asterisk">*</span></label>
                                <input class="form-control" type="password"  name="re_newPassword">
                                <br>
	                            <div align="right"><input type="submit" value="Cập nhật mật khẩu" class="btn btn-primary" style="margin-top: 30px; margin-bottom: 50px;"></div>
	                        </div>
	                    </div>
	                </div>
                </form>
            </div>
        </div>

    </div>
</section>

@endsection