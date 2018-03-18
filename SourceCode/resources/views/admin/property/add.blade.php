@extends('admin.master')
@section('controller', 'Thuộc tính sản phẩm')
@section('action', 'Thêm')
@section('breadcrumb', 'Quản lý thuộc tính sản phẩm')
@section('content')

<section class="content">
    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-push-2 col-md-push-3">
        @include('admin.blocks.error')

    	<form action="{{ route('admin.property.postAdd') }}" method="POST"  enctype="multipart/form-data">
            {{ csrf_field() }}
        	<div class="form-group">
                <label>Sản phẩm <span class="asterisk">*</span></label>
                <select class="form-control" name="pro_id" id="pro_id">
                	<option value="">Chọn sản phẩm</option>
	                @foreach ($products as $item)
	                	<option value="{{ $item->id }}" @if(old('pro_id') == $item->id) selected @endif>{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="form-group" id="size-group">
                <label>Size</label>
                <select class="form-control" name="size_id" id="size">
                </select>

            </div>
            <div class="form-group">
                <label>Số lượng</label>
                <input type="number" min="0" step="1" class="form-control" name="qty" value="old('qty')">
            </div>
            <div class="form-group" align="center">
                <button type="submit" class="btn btn-default functionButton">Thêm</button>
                <button type="button" class="btn btn-default functionButton" onclick = "window.location = '{{ route("admin.property.getList") }}'">Quay lại</button>
            </div>
        </form>
    </div>
</section>

@endsection
