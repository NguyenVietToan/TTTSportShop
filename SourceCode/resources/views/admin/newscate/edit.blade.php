@extends('admin.master')
@section('controller', 'Loại tin')
@section('action', 'Sửa')
@section('breadcrumb', 'Quản lý loại tin')
@section('content')

<section class="content">
    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-push-2 col-md-push-3">
        @include('admin.blocks.error')

        <form action="{{ route('admin.newscate.postEdit') }}" method="POST">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="id" value="{{ $newscate->id }}">
            <div class="form-group">
                <label>Tên loại tin <span class="asterisk">*</span></label>
                <input class="form-control" name="txtNewsCateName" value="{{ old('txtNewsCateName', isset($newscate) ? $newscate->name : null) }}" />
            </div>
            <div class="form-group">
                <label>Mô tả</label>
                <textarea class="form-control" rows="5" name="txtDescription">{{ old('txtDescription', isset($newscate) ? $newscate->description : null) }}</textarea>
            </div>
            <div class="form-group" align="center">
                <button type="submit" class="btn btn-default functionButton">Sửa</button>
                <button type="button" class="btn btn-default functionButton" onclick = "window.location = '{{ route("admin.newscate.getList") }}'">Quay lại</button>
            </div>
        <form>
    </div>
</section>

@endsection()

