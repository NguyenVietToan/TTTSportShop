@extends('user.master')
@section('content')

<script>
$(document).ready(function() {
	// Thông báo thành công
	$('.message.alert').delay(1000).slideUp();

	//Thông báo lỗi
	$('.error.alert').delay(1000).slideUp();
});

</script>

<div class="inner-header">
	<div class="container">
		<ul class="breadcrumb">
    		<li><a href="{{ url('trang-chu') }}"><i class="fa fa-home" aria-hidden="true"></i> {{ (session('lang'))?Config::get('lang.'.session('lang'))['home_page']:Config::get('lang.vi')['home_page'] }}</a><span class="divider"></span></li>
    		<li class="active">{{ (session('lang'))?Config::get('lang.'.session('lang'))['register']:Config::get('lang.vi')['register'] }}</li>
  		</ul>
  		<!-- /.breadcrumb -->
	</div>
</div>

@include('user.blocks.error')

<div class="container">
	<div class="user-register">
		<form action="{{ route('postRegister') }}" class="form-horizontal" role="form" method="POST">
			{{ csrf_field() }}
			<div class="row">
				<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3"></div>
				<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
					<h2 class="title text-center" style="margin-bottom: 35px;">{{ (session('lang'))?Config::get('lang.'.session('lang'))['register']:Config::get('lang.vi')['register'] }}</h2>

					<div class="form-group">
                    	<label>Email <span class="asterisk">*</span></label>
						<input type="email" class="form-control" name="email" value="{{ old('email') }}">
                    </div>

                    <div class="form-group">
						<label>Mật khẩu <span class="asterisk">*</span></label>
						<input type="password" class="form-control" name="password">
					</div>

					<div class="form-group">
						<label>Nhập lại mật khẩu <span class="asterisk">*</span></label>
						<input type="password" class="form-control" name="re_password">
					</div>

                    <div class="form-group">
                    	<label>Tên đầy đủ <span class="asterisk">*</span></label>
						<input type="text" class="form-control" name="name" value="{{ old('name') }}">
                    </div>

                    <div class="form-group">
		                <label>Ảnh đại diện</label>
		                <input type="file" name="avatar">
		            </div>

                    <div class="form-group">
                        <label style="margin-right: 15px;">Giới tính <span class="asterisk">*</span></label>
						<input name="gender" type="radio" class="input-radio" value="1"><span style="margin-right: 25px;">Nam</span>
						<input name="gender" type="radio" class="input-radio" value="2"><span>Nữ</span>
                    </div>

                    <div class="form-group">
                    	<label>Ngày sinh <span class="asterisk">*</span></label>
						<br>
		                <div class="col-md-4" style="padding-left: 0;">
		                    <select name="day" class="form-control">
		                        <option value="0">Ngày</option>
		                        @for($day = $day_arr[0]; $day <= $day_arr[1];$day++ )
		                        <option value="{{ $day }}">{{ $day }}</option>
		                        @endfor
		                    </select>
		                </div>
		                <div class="col-md-4" style="padding-left: 0;">
		                    <select name="month" class="form-control">
		                        <option>Tháng</option>
		                        @for($month = $month_arr[0]; $month <= $month_arr[1];$month++ )
		                        <option value="{{ $month }}">{{ $month }}</option>
		                        @endfor
		                    </select>
		                </div>
		                <div class="col-md-4" style="padding-left: 0;">
		                    <select name="year" class="form-control">
		                        <option value="0">Năm</option>
		                        @for($year = $year_arr[0]; $year <= $year_arr[1];$year++ )
		                        <option value="{{ $year }}">{{ $year }}</option>
		                        @endfor
		                    </select>
		                </div>
                    </div>

                    <div class="form-group">
		                <label>Địa chỉ <span class="asterisk">*</label>
		                <br>
		                <div class="col-md-4" style="padding-left: 0;">
		                    <select name="province" id="province" class="form-control">
		                        <option value="0">Tỉnh/Thành phố</option>
		                        @foreach($provinces as $item)
		                        <option value="{{ $item->provinceid }}">{{ $item->name }}</option>
		                        @endforeach
		                    </select>
		                </div>
		                <div class="col-md-4" style="padding-left: 0;">
		                    <select name="district" id="district" class="form-control" disabled>
		                        <option value="0">Quận/Huyện</option>
		                    </select>
		                </div>
		                <div class="col-md-4" style="padding-left: 0;">
		                    <select name="ward" id="ward" class="form-control" disabled>
		                        <option value="0">Phường/Xã</option>
		                    </select>
		                </div>
		                <div class="col-md-12" style="padding: 0;">
		                    <input type="text" style="margin: 7px 0 15px;" class="form-control" id="" name="address" placeholder="Nhập địa chỉ cụ thể (số nhã, ngõ, đường...)" value="{{ old('address') }}">
		                </div>
		            </div>

					<div class="form-group">
						<label>Số điện thoại <span class="asterisk">*</span></label>
						<input type="text" class="form-control" name="phone" value="{{ old('phone') }}">
					</div>

					<div class="form-group text-center">
						<button type="submit" class="btn btn-primary" style="margin-top: 30px;">
                            <i class="fa fa-btn fa-user"></i> Đăng ký
                        </button>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

@endsection
