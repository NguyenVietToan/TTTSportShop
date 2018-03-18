@extends('admin.master')
@section('controller', 'Thành viên')
@section('action', 'Thêm')
@section('breadcrumb', 'Quản lý thành viên')
@section('content')

<section class="content">
    <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6 col-sm-push-2 col-md-push-3">
        @include('admin.blocks.error')
        <form action="{{ route('admin.user.postAdd') }}" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="form-group">
                <label>Email <span class="asterisk">*</span></label>
                <input type="email" class="form-control" name="email" value="{{ old('email') }}">
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
                <label style="margin-top: 15px;">Địa chỉ <span class="asterisk">*</label>
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

            <div class="form-group" align="center">
                <button type="submit" class="btn btn-default functionButton">Thêm</button>
                <button type="button" class="btn btn-default functionButton" onclick = "window.location = '{{ route('admin.user.getList') }}'">Quay lại</button>
            </div>
        <form>
    </div>
</section>

@endsection


@section('custom javascript')

<script type="text/javascript">
    $(document).ready(function(){
        $('.mytreeview').removeClass('active');  //loại bỏ active ở cái hiện tại
        $("#user").addClass('active');   //active sang cái mới
    });
</script>

@endsection