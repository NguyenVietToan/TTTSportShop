@extends('admin.master')
@section('controller', 'Nhà cung cấp')
@section('action', 'Sửa')
@section('breadcrumb', 'Quản lý nhà cung cấp')
@section('content')

<section class="content">
    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 col-sm-push-2">
        @include('admin.blocks.error')

        <form action="{{ route('admin.supplier.postEdit') }}" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <input type="hidden" name="id" value="{{ $supplier->id }}">
            <div class="form-group">
                <label>Tên nhà cung cấp <span class="asterisk">*</span></label>
                <input type="text" class="form-control" name="name" value="{{ $supplier->name }}" />
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
                    <input type="text" style="margin: 7px 0 15px;" class="form-control" id="" name="address" value="{{ $full_address }}">
                </div>
            </div>
            <br>
            <div class="form-group">
                <label>Số điện thoại <span class="asterisk">*</label>
                <input type="text" class="form-control" name="phone" value="{{ '0'.$supplier->phone }}" />
            </div>
            <div class="form-group">
                <label>Email <span class="asterisk">*</label>
                <input type="email" class="form-control" name="email" value="{{ $supplier->email }}" />
            </div>
            <div class="form-group" align="center">
                <button type="submit" class="btn btn-default functionButton">Sửa</button>
                <button type="button" class="btn btn-default functionButton" onclick = "window.location = '{{ route("admin.supplier.getList") }}'">Quay lại</button>
            </div>
        <form>
    </div>
</section>

@endsection