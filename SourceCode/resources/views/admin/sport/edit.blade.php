@extends('admin.master')
@section('controller', 'Bộ môn')
@section('action', 'Sửa')
@section('breadcrumb', 'Quản lý bộ môn')
@section('content')

<section class="content">
    <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6 col-sm-push-2 col-md-push-3">
        @include('admin.blocks.error')

        <form action="{{ route('admin.sport.postEdit') }}" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="id" value="{{ $sport['id'] }}">
            <div class="form-group">
                <label>Tên bộ môn <span class="asterisk">*</span></label>
                <input class="form-control" name="txtSportName" placeholder="Nhập tên bộ môn" value="{{ old('txtSportName', isset($sport) ? $sport['name'] : null) }}" />
            </div>
            <div class="form-group">
                <label>Hình ảnh hiện tại <span class="asterisk">*</span></label><br>
                <img src="{{ asset('resources/upload/images/sport/'.$sport['id'].'/'.$sport['image']) }}">
                <input type="hidden" name="img_current" value="{{ $sport['image'] }}" />
            </div>
            <div class="form-group">
                <label>Thay đổi hình ảnh</label>
                <input type="file" name="fImages">
            </div>
            <div class="form-group">
                <label>Mô tả</label>
                <textarea class="form-control" rows="5" name="txtDescription">{{ old('txtDescription', isset($sport)) ? $sport['description'] : null }}</textarea>
            </div>
            <div class="form-group" align="center">
                <button type="submit" class="btn btn-default functionButton">Sửa</button>
                <button class="btn btn-default functionButton" onclick = "window.location = '{{ route("admin.sport.getList") }}'">Quay lại</button>
            </div>
        <form>
    </div>
</section>

@endsection

