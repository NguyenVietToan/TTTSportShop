@extends('admin.master')
@section('controller', 'Thể loại video')
@section('action', 'Sửa')
@section('breadcrumb', 'Quản lý thể loại video')
@section('content')

<section class="content">
    <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6 col-sm-push-2 col-md-push-3">
        @include('admin.blocks.error')

        <form action="{{ route('admin.videocate.postEdit') }}" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="id" value="{{ $videocate->id }}">
            <div class="form-group">
                <label>Tên thể loại video <span class="asterisk">*</span></label>
                <input type="text" class="form-control" name="name" value="{{ old('name', isset($videocate) ? $videocate->name : null) }}" />
            </div>
            <div class="form-group">
                <label>Mô tả</label>
                <textarea class="form-control" rows="5" name="description">{{ old('description', isset($videocate) ? $videocate->description : null) }}</textarea>
            </div>
            <div class="form-group" align="center">
                <button type="submit" class="btn btn-default functionButton">Sửa</button>
                <button type="button" class="btn btn-default functionButton" onclick = "window.location = '{{ route("admin.videocate.getList") }}'">Quay lại</button>
            </div>
        <form>
    </div>
</section>

@endsection