@extends('admin.master')
@section('controller', 'Thể loại sản phẩm')
@section('action', 'Thêm')
@section('breadcrumb', 'Quản lý thể loại sản phẩm')
@section('content')

<section class="content">
    <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6 col-sm-push-2 col-md-push-3">
        @include('admin.blocks.error')

        <form action="{{ route('admin.cate.postAdd') }}" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
                <label>Tên thể loại <span class="asterisk">*</span></label>
                <input class="form-control" name="txtCateName" placeholder="Nhập tên thể loại sản phẩm" value="{{ old('txtCateName') }}" />
            </div>
            <div class="form-group">
                <label>Mô tả</label>
                <textarea class="form-control" rows="5" name="txtDescription">{{ old('txtDescription') }}</textarea>
            </div>
            <div class="form-group" align="center">
                <button type="submit" class="btn btn-default functionButton">Thêm</button>
                <button type="button" class="btn btn-default functionButton" onclick = "window.location = '{{ route("admin.cate.getList") }}'">Quay lại</button>
            </div>
        <form>
    </div>
</section>

@endsection

