@extends('admin.master')
@section('controller', 'Nhân viên')
@section('action', 'Thêm')
@section('breadcrumb', 'Quản lý nhân viên')
@section('content')

<section class="content">
    <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6 col-sm-push-2 col-md-push-3">
        @include('admin.blocks.error')
        <form action="{{ route('admin.member.postAdd') }}" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="form-group">
                <label>Ngày bắt đầu <span class="asterisk">*</span></label>
                <input type="text" id="date-option" class="form-control col-md-8" name="start_date" placeholder="Nhập ngày bắt đầu" value="{{ old('start_date')==null ? Date('d/m/20y') : old('start_date') }}">
            </div>

            <div class="form-group">
                <label>Email <span class="asterisk">*</span></label>
                <input type="email" class="form-control" name="email" placeholder="Nhập địa chỉ email" value="{{ old('email') }}" />
            </div>

            <div class="form-group">
                <label>Mật khẩu <span class="asterisk">*</span></label>
                <input type="password" class="form-control" name="password" placeholder="Nhập mật khẩu" value="{{ old('password') }}" />
            </div>

            <div class="form-group">
                <label>Xác nhận mật khẩu <span class="asterisk">*</span></label>
                <input type="password" class="form-control" name="re_password" placeholder="Nhập lại mật khẩu" value="{{ old('re_password') }}" />
            </div>

            <div class="form-group">
                <label>Họ tên <span class="asterisk">*</span></label>
                <input type="text" class="form-control" name="name" placeholder="Nhập họ tên thành viên" value="{{ old('name') }}" />
            </div>

            <div class="form-group">
                <label>Hình ảnh <span class="asterisk">*</span></label>
                <input type="file" name="fImages">
            </div>

            <div class="form-group">
                <label style="margin-right: 15px;">Giới tính <span class="asterisk">*</span></label>
                <input type="radio" name="gender" value="1" checked>Nam
                <input type="radio" name="gender" value="2" style="margin-left: 10px;">Nữ
            </div>

            <div class="form-group">
                <label>Ngày sinh <span class="asterisk">*</span></label>
                <br>
                <div class="col-md-4" style="padding-left: 0;">
                    <select name="day" class="form-control">
                        <option value="0">Ngày</option>
                        @for($day = $day_arr[0]; $day <= $day_arr[1]; $day++ )
                        <option value="{{ $day }}">{{ $day }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-4" style="padding-left: 0;">
                    <select name="month" class="form-control">
                        <option>Tháng</option>
                        @for($month = $month_arr[0]; $month <= $month_arr[1]; $month++ )
                        <option value="{{ $month }}">{{ $month }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-4" style="padding-left: 0;">
                    <select name="year" class="form-control">
                        <option value="0">Năm</option>
                        @for($year = $year_arr[0]; $year <= $year_arr[1]; $year++ )
                        <option value="{{ $year }}">{{ $year }}</option>
                        @endfor
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label style="margin-top: 15px;">Số chứng minh thư <span class="asterisk">*</span></label>
                <input type="text" class="form-control" name="identity_card" placeholder="Nhập số chứng minh thư nhân dân" value="{{ old('identity_card') }}">
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
                <input type="text" class="form-control" name="phone" placeholder="Nhập số điện thoại" value="{{ old('phone') }}">
            </div>

            <div class="form-group">
                <label style="margin-right: 15px;">Vai trò</label>
                <input type="radio" name="level" value="0">Quản trị viên
                <input type="radio" name="level" value="1" checked style="margin-left: 10px;">Nhân viên giao hàng
            </div>

            <div class="form-group" align="center">
                <button type="submit" class="btn btn-default functionButton">Thêm</button>
                <button type="button" class="btn btn-default functionButton" onclick = "window.location = '{{ route('admin.member.getList') }}'">Quay lại</button>
            </div>
        <form>
    </div>
</section>

@endsection


@section('custom javascript')

<script type="text/javascript">
    $(document).ready(function(){
        $('.mytreeview').removeClass('active');  //loại bỏ active ở cái hiện tại
        $("#member").addClass('active');   //active sang cái mới
        $("#date-option").datepicker({ format : 'dd/mm/yyyy'});
    });
</script>

@endsection