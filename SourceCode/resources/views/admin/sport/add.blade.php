@extends('admin.master')
@section('controller', 'Bộ môn')
@section('action', 'Thêm')
@section('breadcrumb', 'Quản lý bộ môn')
@section('content')

<section class="content">
    <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6 col-sm-push-2 col-md-push-3">
        @include('admin.blocks.error')

        <form action="{{ route('admin.sport.postAdd') }}" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
                <label>Tên bộ môn <span class="asterisk">*</span></label>
                <input class="form-control" name="txtSportName" placeholder="Nhập tên bộ môn" value="{{ old('txtSportName') }}" />
            </div>
            <div class="form-group">
                <label>Hình ảnh <span class="asterisk">*</span></label>
                <input type="file" name="fImages">
            </div>
            <div class="form-group">
                <label>Mô tả</label>
                <textarea class="form-control" rows="5" name="txtDescription">{{ old('txtDescription') }}</textarea>
            </div>
            <div class="form-group" align="center">
                <button type="submit" class="btn btn-default functionButton">Thêm</button>
                <button type="button" class="btn btn-default functionButton" onclick = "window.location = '{{ route("admin.sport.getList") }}'">Quay lại</button>
            </div>
        <form>
    </div>
</section>

@endsection

