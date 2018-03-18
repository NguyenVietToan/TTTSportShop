@extends('admin.master')
@section('controller', 'Thương hiệu sản phẩm')
@section('action', 'Thêm')
@section('breadcrumb', 'Quản lý thương hiệu sản phẩm')
@section('content')

<section class="content">
    <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6 col-sm-push-2 col-md-push-3">
        @include('admin.blocks.error')

        <form action="{{ route('admin.brand.postAdd') }}" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
                <label>Tên thương hiệu <span class="asterisk">*</span></label>
                <input type="text" class="form-control" name="txtBrandName" placeholder="Nhập tên thương hiệu" value="{{ old('txtBrandName') }}" />
            </div>
            <div class="form-group">
                <label>Logo <span class="asterisk">*</span></label>
                <input type="file" name="fImages">
            </div>
            <div class="form-group">
                <label>Mô tả</label>
                <textarea class="form-control" rows="5" name="txtDescription">{{ old('txtDescription') }}</textarea>
            </div>
            <div class="form-group" align="center">
                <button type="submit" class="btn btn-default functionButton">Thêm</button>
                <button type="button" class="btn btn-default functionButton" onclick = "window.location = '{{ route("admin.brand.getList") }}'">Quay lại</button>
            </div>
        <form>
    </div>
</section>

@endsection

