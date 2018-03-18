@extends('admin.master')
@section('controller', 'Video')
@section('action', 'Sửa')
@section('breadcrumb', 'Quản lý video')
@section('content')

<section class="content">
    <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6 col-sm-push-2 col-md-push-3">
        @include('admin.blocks.error')

        <form action="{{ route('admin.video.postEdit') }}" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="id" value="{{ $video->id }}">
            <div class="form-group">
                <label>Thể loại video <span class="asterisk">*</span></label>
                <select class="form-control" name="vcate_id" disabled>
                    <option value="">Chọn thể loại video</option>
                    @foreach ($videocates as $item)
                        <option value="{{ $item->id }}" {{ ($video->vcate_id == $item->id) ? 'selected' : '' }}>{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Tiêu đề <span class="asterisk">*</span></label>
                <input class="form-control" name="title" value="{{ old('title', isset($video) ? $video->title : null) }}" />
            </div>
            <div class="form-group">
                <label>Hình ảnh hiện tại</label>
                <div id="img_current">
                    <img src="{{ asset('resources/upload/images/video/'.$video->id.'/'.$video->image) }}" alt="" class="img_current">
                    <input type="hidden" name="img_current" value="{{ $video->image }}" />
                </div>
                <br>
                <label>Hình ảnh mới</label>
                <input type="file" name="image">
            </div>
            <div class="form-group">
                <label>ID video trên Youtube</label>
                <input class="form-control" name="link" value="{{ old('link', isset($video) ? $video->link : null) }}" />
            </div>
            <div class="form-group" align="center">
                <button type="submit" class="btn btn-default functionButton">Sửa</button>
                <button type="button" class="btn btn-default functionButton" onclick = "window.location = '{{ route("admin.video.getList") }}'">Quay lại</button>
            </div>
        <form>
    </div>
</section>

@endsection

