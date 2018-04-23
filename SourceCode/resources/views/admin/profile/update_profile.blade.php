@extends('admin.master')
@section('controller', 'Thông tin cá nhân')
@section('action', 'Cập nhật')
@section('breadcrumb', 'Quản lý tài khoản')
@section('content')

<section class="content">
    <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6 col-sm-push-2 col-md-push-3">
        @include('admin.blocks.error')
        <form action="{{ route('admin.postEditInfo') }}" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="id" value="{{ $member->id }}">

            <div class="form-group">
                <label>Ngày bắt đầu <span class="asterisk">*</span></label>
                <input type="text" id="date-option" class="form-control col-md-8" name="start_date" placeholder="Nhập ngày bắt đầu" value="{{ old('start_date')==null ? Date('d/m/20y') : old('start_date') }}">
            </div>

            <div class="form-group">
                <label>Email <span class="asterisk">*</span></label>
                <input type="email" class="form-control" name="email" placeholder="Nhập địa chỉ email" 
                value="{{ old('email', isset($member) ? $member->email : null) }}" />
            </div>

            <div class="form-group">
                <label>Họ tên <span class="asterisk">*</span></label>
                <input type="text" class="form-control" name="name" placeholder="Nhập họ tên thành viên" value="{{ old('name', isset($member) ? $member->name : null) }}" />
            </div>

            <div class="form-group">
                <label>Ảnh đại diện hiện tại</label>
                <div id="img_current">
                    <img src="{{ asset('resources/upload/images/member/'.$member->id.'/'.$member->image) }}" alt="" class="img_current">
                    <input type="hidden" name="img_current" value="{{ $member->image }}" />
                </div>
                <br>
                <label>Ảnh đại diện mới</label>
                <input type="file" name="image">
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
                <label style="margin-right: 15px; margin-top: 15px;">Giới tính <span class="asterisk">*</span></label>
                <input type="radio" name="gender" value="1"
                    @if ($member->gender == 1)
                        checked
                    @endif
                >Nam
                <input type="radio" name="gender" value="2" style="margin-left: 10px;"
                    @if ($member->gender == 2)
                        checked
                    @endif
                >Nữ
            </div>

            <div class="form-group">
                <label>Số chứng minh thư <span class="asterisk">*</span></label>
                <input type="text" class="form-control" name="identity_card" placeholder="Nhập số chứng minh thư nhân dân" value="{{ old('identity_card', isset($member) ? $member->identity_card : null) }}">
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
                    <input type="text" style="margin: 7px 0 15px;" class="form-control" id="" name="address" value="{{ old('address', isset($member) ? $member->address : null) }}">
                </div>
            </div>

            <div class="form-group">
                <label>Số điện thoại <span class="asterisk">*</span></label>
                <input type="text" class="form-control" name="phone" placeholder="Nhập số điện thoại" value="{{ old('phone', isset($member) ? $member->phone : null) }}">
            </div>

            <div class="form-group" align="center">
                <button type="submit" class="btn btn-default functionButton">Cập nhật</button>
                <button type="button" class="btn btn-default functionButton" onclick = "window.location = '{{ route('admin.getProfile') }}'">Quay lại</button>
            </div>
        <form>
    </div>
</section>

@endsection

@section('custom javascript')

<script type="text/javascript">
    $(document).ready(function(){
        $("#date-option").datepicker({ format : 'dd/mm/yyyy'});
    });
</script>

@endsection