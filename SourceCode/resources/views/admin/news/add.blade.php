@extends('admin.master')
@section('controller', 'Tin tức')
@section('action', 'Thêm')
@section('breadcrumb', 'Quản lý tin tức')
@section('content')

<section class="content">
    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-push-2 col-md-push-3">
        @include('admin.blocks.error')

        <form action="{{ route('admin.news.postAdd') }}" method="POST"  enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
                <label>Loại tin <span class="asterisk">*</span></label>
                <select class="form-control" name="newsCate">
                    <option value="">Chọn loại tin</option>
                    @foreach ($newscate as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Tiêu đề <span class="asterisk">*</span></label>
                <input class="form-control" name="txtTitle" placeholder="Nhập tiêu đề tin" value="{{ old('txtTitle') }}" />
            </div>
            <div class="form-group">
                <label>Tóm tắt <span class="asterisk">*</span></label>
                <textarea class="form-control" rows="3" name="txtSummary">{{ old('txtSummary') }}</textarea>
                <script type="text/javascript">ckeditor("txtSummary")</script>
            </div>
            <div class="form-group">
                <label>Nội dung <span class="asterisk">*</span></label>
                <textarea class="form-control" rows="5" name="txtContent">{{ old('txtContent') }}</textarea>
                <script type="text/javascript">ckeditor("txtContent")</script>
            </div>
            <div class="form-group">
                <label>Hình ảnh</label>
                <input type="file" name="fImages">
            </div>
            <div class="form-group">
                <label>Nguồn</label>
                <input class="form-control" name="txtSource" placeholder="Nhập nguồn tin" value="{{ old('txtSource') }}" />
            </div>
            <div class="form-group">
                <label>Tác giả</label>
                <input class="form-control" name="txtAuthor" placeholder="Nhập tác giả" value="{{ old('txtAuthor') }}" />
            </div>
            <div class="form-group" align="center">
                <button type="submit" class="btn btn-default functionButton">Thêm</button>
                <button type="button" class="btn btn-default functionButton" onclick = "window.location = '{{ route("admin.news.getList") }}'">Quay lại</button>
            </div>
        <form>
    </div>
</section>

@endsection()

