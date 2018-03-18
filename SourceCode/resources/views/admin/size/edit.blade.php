@extends('admin.master')
@section('controller', 'Size')
@section('action', 'Sửa')
@section('breadcrumb', 'Quản lý size')
@section('content')

<section class="content">
	<div class="col-xs-12 col-sm-8 col-md-6 col-sm-push-2 col-md-push-3">
        @include('admin.blocks.error')
    	<form action="{{ route('admin.size.postEdit') }}" method="POST"  enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{ $size->id }}">
        	<div class="form-group">
                <label>Thể loại <span class="asterisk">*</span></label>
                <select class="form-control" name="cate_id" disabled="disabled" >
                	<option value="">Chọn thể loại</option>
	                @foreach ($cates as $item)
	                	<option value="{{ $item->id }}"
                            @if($size->cate_id == $item->id)
                                selected
                            @endif
                        >{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Giá trị <span class="asterisk">*</span></label>
                <input class="form-control" name="value" value="{{ old('value', isset($size) ? $size->value : null) }}" />
            </div>

            <div class="form-group" align="center">
                <button type="submit" class="btn btn-default functionButton">Sửa</button>
                <button type="button" class="btn btn-default functionButton" onclick = "window.location = '{{ route("admin.size.getList") }}'">Quay lại</button>
            </div>
        </form>
    </div>
</section>

@endsection
