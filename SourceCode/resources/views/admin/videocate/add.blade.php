@extends('admin.master')
@section('controller', 'Thể loại video')
@section('action', 'Thêm')
@section('breadcrumb', 'Quản lý thể loại video')
@section('content')

<section class="content">
    <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6 col-sm-push-2 col-md-push-3">
        @include('admin.blocks.error')

        <form action="{{ route('admin.videocate.postAdd') }}" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
                <label>Tên thể loại video <span class="asterisk">*</span></label>
                <input type="text" class="form-control" name="name" placeholder="Nhập tên thể loại video" value="{{ old('name') }}" />
            </div>
            <div class="form-group">
                <label>Mô tả</label>
                <textarea class="form-control" rows="5" name="description">{{ old('description') }}</textarea>
            </div>
            <div class="form-group" align="center">
                <button type="submit" class="btn btn-default functionButton">Thêm</button>
                <button type="button" class="btn btn-default functionButton" onclick = "window.location = '{{ route("admin.videocate.getList") }}'">Quay lại</button>
            </div>
        <form>
    </div>
</section>

@endsection