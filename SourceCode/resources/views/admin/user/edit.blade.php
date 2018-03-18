@extends('admin.master')
@section('controller', 'Thành viên')
@section('action', 'Sửa')
@section('breadcrumb', 'Quản lý thành viên')
@section('content')

<section class="content">
    <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6 col-sm-push-2 col-md-push-3">
        @include('admin.blocks.error')
        <form action="{{ route('admin.user.postEdit') }}" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="id" value="{{ $user->id }}">

            <div class="form-group">
                <label>Email <span class="asterisk">*</span></label>
                <input type="email" class="form-control" name="email" value="{{ old('email', isset($user) ? $user->email : null) }}">
            </div>

            <div class="form-group">
                <label>Tên đầy đủ <span class="asterisk">*</span></label>
                <input type="text" class="form-control" name="name" value="{{ old('name', isset($user) ? $user->name : null) }}">
            </div>

            <div class="form-group">
                <label>Ảnh đại diện hiện tại</label>
                <div id="img_current">
                    <img src="{{ asset('resources/upload/images/user/'.$user->id.'/'.$user->avatar) }}" alt="" class="img_current">
                    <input type="hidden" name="img_current" value="{{ $user->avatar }}" />
                </div>
                <br>
                <label>Ảnh đại diện mới</label>
                <input type="file" name="avatar">
            </div>

            <div class="form-group">
                <label style="margin-right: 15px;">Giới tính <span class="asterisk">*</span></label>
                <input name="gender" type="radio" class="input-radio" value="1"
                    @if ($user->gender == 1)
                        checked
                    @endif
                ><span style="margin-right: 25px;">Nam</span>
                <input name="gender" type="radio" class="input-radio" value="2"
                    @if ($user->gender == 2)
                        checked
                    @endif
                ><span>Nữ</span>
            </div>

            <div class="form-group">
                <label>Ngày sinh <span class="asterisk">*</span></label>
                <br>
                <div class="col-md-4" style="padding-left: 0;">
                    <select name="day" class="form-control">
                        @for($day = $day_arr[0]; $day <= $day_arr[1]; $day++ )
                        <option value="{{ $day }}"
                            @if ($day == $birthday[2])
                                selected
                            @endif
                        >{{ $day }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-4" style="padding-left: 0;">
                    <select name="month" class="form-control">
                        @for($month = $month_arr[0]; $month <= $month_arr[1]; $month++ )
                        <option value="{{ $month }}"
                            @if ($month == $birthday[1])
                                selected
                            @endif
                        >{{ $month }}</option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-4" style="padding-left: 0;">
                    <select name="year" class="form-control">
                        @for($year = $year_arr[0]; $year <= $year_arr[1]; $year++ )
                        <option value="{{ $year }}"
                            @if ($year == $birthday[0])
                                selected
                            @endif
                        >{{ $year }}</option>
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
                        <option value="{{ $item->provinceid }}" {{ $item->provinceid == $location[2]?'selected':'' }}>{{$item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4" style="padding-left: 0;">
                    <select name="district" id="district" class="form-control">
                        <option value="0">Quận/Huyện</option>
                        @foreach($districts as $item)
                        <option value="{{ $item->districtid }}" {{ $item->districtid == $location[1]?'selected':'' }}>{{$item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4" style="padding-left: 0;">
                    <select name="ward" id="ward" class="form-control">
                        <option value="0">Phường/Xã</option>
                        @foreach($wards as $item)
                        <option value="{{ $item->wardid }}" {{ $item->wardid == $location[0]?'selected':'' }}>{{$item->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-12" style="padding: 0;">
                    <input type="text" style="margin: 7px 0 15px;" class="form-control" id="" name="address" value="{{ old('address', isset($user) ? $user->address : null) }}">
                </div>
            </div>

            <div class="form-group">
                <label>Số điện thoại <span class="asterisk">*</span></label>
                <input type="text" class="form-control" name="phone" value="{{ old('phone', isset($user) ? $user->phone : null) }}">
            </div>

            <div class="form-group" align="center">
                <button type="submit" class="btn btn-default functionButton">Sửa</button>
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