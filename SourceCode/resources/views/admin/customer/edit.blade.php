@extends('admin.master')
@section('controller', 'Khách hàng')
@section('action', 'Sửa')
@section('breadcrumb', 'Quản lý khách hàng')
@section('content')

<section class="content">
    <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6 col-sm-push-2 col-md-push-3">
        @include('admin.blocks.error')
        <form action="{{ route('admin.customer.postEdit') }}" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="id" value="{{ $customer->id }}">

            <div class="form-group">
                <label>Email <span class="asterisk">*</span></label>
                <input type="email" class="form-control" name="email" id="email" value="{{ old('email', isset($customer) ? $customer->email : null) }}">
            </div>

            <div class="form-group">
                <label>Tên đầy đủ <span class="asterisk">*</span></label>
                <input type="text" class="form-control" name="name" id="name" value="{{ old('name', isset($customer) ? $customer->name : null) }}">
            </div>

            <div class="form-group">
                <label style="margin-right: 15px;">Giới tính <span class="asterisk">*</span></label>
                <input name="gender" type="radio" id="male" class="input-radio" value="1"
                    @if ($customer->gender == 1)
                        checked
                    @endif
                ><span style="margin-right: 25px;">Nam</span>
                <input name="gender" type="radio" id="female" class="input-radio" value="2"
                    @if ($customer->gender == 2)
                        checked
                    @endif
                ><span>Nữ</span>
            </div>

            <div class="form-group">
                <label>Số điện thoại <span class="asterisk">*</span></label>
                <input type="text" class="form-control" name="phone" id="phone" value="{{ old('phone', isset($customer) ? $customer->phone : null) }}">
            </div>

            <div class="form-group" align="center">
                <button type="submit" class="btn btn-default functionButton">Sửa</button>
                <button type="button" class="btn btn-default functionButton" onclick = "window.location = '{{ route("admin.customer.getList") }}'">Quay lại</button>
            </div>
        <form>
    </div>
</section>

@endsection