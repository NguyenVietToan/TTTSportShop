@extends('admin.master')
@section('controller', 'Size')
@section('action', 'Thêm')
@section('breadcrumb', 'Quản lý size')
@section('content')

<section class="content">
	<div class="col-xs-12 col-sm-8 col-md-6 col-sm-push-2 col-md-push-3">
        @include('admin.blocks.error')
    	<form action="{{ route('admin.size.postAdd') }}" method="POST"  enctype="multipart/form-data">
            {{ csrf_field() }}
        	<div class="form-group">
                <label>Thể loại <span class="asterisk">*</span></label>
                <select class="form-control" name="cate_id">
                	<option value="">Chọn thể loại</option>
	                @foreach ($cates as $item)
	                	<option value="{{ $item->id }}" @if(old('cate_id') == $item->id) selected @endif>{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Giá trị <span class="asterisk">*</span></label>
                <input class="form-control" name="value[]" placeholder="Nhập size" value="{{ old('value') }}" />
            </div>

            <div id="insert"></div>

            <div class="form-group">
                <button type="button" class="btn btn-primary" id="addSize" style="margin-bottom: 10px;"><i class="fa fa-plus" aria-hidden="true"></i></button>
            </div>

            <div class="form-group" align="center">
                <button type="submit" class="btn btn-default functionButton">Thêm</button>
                <button type="button" class="btn btn-default functionButton" onclick = "window.location = '{{ route("admin.property.getList") }}'">Quay lại</button>
            </div>
        </form>
    </div>
</section>

@endsection

@section('custom javascript')

<script type="text/javascript">
    $(document).ready(function() {
        $("#addSize").click(function() {
            $("#insert").append('<div class="form-group"><input class="form-control" name="value[]" placeholder="Nhập size" value="" /></div>');
        });
    });
</script>

@endsection