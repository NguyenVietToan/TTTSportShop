@extends('admin.master')
@section('controller', 'Thuộc tính sản phẩm')
@section('action', 'Sửa')
@section('breadcrumb', 'Quản lý thuộc tính sản phẩm')
@section('content')

<section class="content">
	<div class="col-xs-12 col-sm-8 col-md-6 col-sm-push-2 col-md-push-3">
        @include('admin.blocks.error')
    	<form action="{{ route('admin.property.postEdit') }}" method="POST"  enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="hidden" name="id" value="{{ $property->id }}">

        	<div class="form-group">
                <label>Sản phẩm <span class="asterisk">*</span></label>

                <select class="form-control" name="pro_id" disabled="disabled">
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                </select>
            </div>
            <div class="form-group">
                <label>Size</label>
                <select class="form-control" name="size_id" id="size">
                    @foreach ($sizes as $size)
                        <option value="{{ $size->id }} " @if($size->id == $property->size_id) selected @endif>{{ $size->value }} </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label>Số lượng</label>
                <input type="number" min="0" step="1" class="form-control" name="qty" value="{{ $property->qty }}">
            </div>
            <div class="form-group" align="center">
                <button type="submit" class="btn btn-default functionButton">Sửa</button>
                <button class="btn btn-default functionButton" onclick = "window.location = '{{ route("admin.property.getList") }}'">Quay lại</button>
            </div>

        </form>
    </div>
</section>

@endsection()

