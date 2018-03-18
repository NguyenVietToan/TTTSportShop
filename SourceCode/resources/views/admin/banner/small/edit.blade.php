@extends('admin.master')
@section('controller', 'Banner nhỏ')
@section('action', 'Sửa')
@section('breadcrumb', 'Quản lý banner nhỏ')
@section('content')

<section class="content">
    <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6 col-sm-push-2 col-md-push-3">
        @include('admin.blocks.error')

        <form action="{{ route('admin.smallbanner.postEdit') }}" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="id" value="{{ $small_banner['id'] }}">
            <div class="form-group">
                <label>Tên banner</span></label>
                <input class="form-control" name="txtBannerName" value="{{ old('txtBannerName', isset($small_banner) ? $small_banner['name'] : null) }}">
            </div>
            <div class="form-group">
                <label>Hình ảnh hiện tại <span class="asterisk">*</span></label><br>
                <img src="{{ asset('resources/upload/images/banner/smallbanner/thumbnail/'.$small_banner['id'].'/'.$small_banner['image']) }}">
                <input type="hidden" name="img_current" value="{{ $small_banner['image'] }}" />
            </div>
            <div class="form-group">
                <label>Thay đổi hình ảnh</label>
                <input type="file" name="fImages">
            </div>
            <div class="form-group">
                <label style="margin-right: 20px">Hiển thị</label>
                <input type="checkbox" style="width: 20px; height: 15px; margin-top: 0; vertical-align: middle;" name="display"  value="display" {{ $small_banner['display'] == 1 ? 'checked' : '' }} >
            </div>
            <div class="form-group">
                <label>Mô tả</label>
                <textarea class="form-control" rows="3" name="txtDescription">{{ old('txtDescription', isset($small_banner) ? $small_banner['description'] : null) }}</textarea>
                <script type="text/javascript">ckeditor("txtDescription")</script>
            </div>
            <div class="form-group" align="center">
                <button type="submit" class="btn btn-default functionButton">Sửa</button>
                <button type="button" class="btn btn-default functionButton" onclick = "window.location = '{{ route("admin.smallbanner.getList") }}'">Quay lại</button>
            </div>
        <form>
    </div>
</section>

@endsection()

