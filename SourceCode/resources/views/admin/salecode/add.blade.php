@extends('admin.master')
@section('controller', 'Mã giảm giá')
@section('action', 'Thêm')
@section('breadcrumb', 'Quản lý mã giảm giá')
@section('content')

<section class="content">
    <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6 col-sm-push-2 col-md-push-3">
        @include('admin.blocks.error')

        <form action="{{ route('admin.salecode.postAdd') }}" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group">
                <!-- <button type="button" class="btn btn-default functionButton" id="genSaleCode" onclick="genSaleCode()">Tạo mã</button> -->
                <label >Mã: </label>
                <input class="form-control" name="salecode" id="salecode" style="font-size: 20px;" value="{{str_random(10)}}" />
            </div>
            <div class="form-group">
                <label>% giảm giá <span class="asterisk">*</span></label>
                <input type="number" class="form-control" name="salepercent" placeholder="Nhập % mã giảm giá" value="{{ old('salepercent') }}" />
            </div>
            
            <div class="form-group" align="center">
                <button type="submit" class="btn btn-default functionButton">Thêm</button>
                <button type="button" class="btn btn-default functionButton" onclick = "window.location = '{{ route("admin.salecode.getList") }}'">Quay lại</button>
            </div>
        <form>
    </div>
</section>

@endsection

<!-- @section('custom javascript')
<script type="text/javascript">
    // $(document).ready(function(){
    //     $('#genSaleCode').click(function(){
    //         // document.getElementById("saleCode").innerHTML = str_random(10);
    //         $('#saleCode').html(str_random(10));
    //     });
    // });
    function genSaleCode() {
        document.getElementById("saleCode").innerHTML = str_random(10);
    }
</script>
@endsection -->