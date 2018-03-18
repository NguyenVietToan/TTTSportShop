@extends('admin.master')
@section('controller', 'Video')
@section('action', 'Thêm')
@section('breadcrumb', 'Quản lý video')
@section('content')

<section class="content">
    <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6 col-sm-push-2 col-md-push-3">
        @include('admin.blocks.error')

        <form action="{{ route('admin.video.postAdd') }}" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
                <label>Thể loại video <span class="asterisk">*</span></label>
                <select class="form-control" name="vcate_id">
                    <option value="">Chọn thể loại video</option>
                    @foreach ($videocates as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Tiêu đề <span class="asterisk">*</span></label>
                <input class="form-control" name="title" placeholder="Nhập tiêu đề video" value="{{ old('title') }}" />
            </div>
            <div class="form-group">
                <label>Hình ảnh thumbnail</label>
                <input type="file" name="image">
            </div>
            <div class="form-group">
                <label>ID video trên Youtube</label>
                <input class="form-control" name="link" placeholder="Nhập id video trên youtube" value="{{ old('link') }}" />
            </div>
            <div class="form-group" align="center">
                <button type="submit" class="btn btn-default functionButton">Thêm</button>
                <button type="button" class="btn btn-default functionButton" onclick = "window.location = '{{ route("admin.video.getList") }}'">Quay lại</button>
            </div>
        <form>
    </div>
</section>

@endsection

