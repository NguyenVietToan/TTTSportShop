@extends('admin.master')
@section('controller', 'Khách hàng')
@section('action', 'Thêm')
@section('breadcrumb', 'Quản lý khách hàng')
@section('content')

<section class="content">
    <div class="col-xs-12 col-sm-8 col-md-6 col-lg-6 col-sm-push-2 col-md-push-3">
        @include('admin.blocks.error')
        <form action="{{ route('admin.customer.postAdd') }}" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">

            <div class="form-group">
                <label>Thành viên <span class="asterisk">*</span></label>
                <select class="form-control" name="user_id"  id="user_id">
                    <option value="">Chọn thành viên</option>
                    @foreach ($users as $item)
                        <option value="{{ $item->id }}" @if(old('user_id') == $item->id) selected @endif>{{ $item->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label>Email <span class="asterisk">*</span></label>
                <input type="email" class="form-control" name="email" id="email" value="{{ old('email') }}">
            </div>

            <div class="form-group">
                <label>Tên đầy đủ <span class="asterisk">*</span></label>
                <input type="text" class="form-control" name="name" id="name" value="{{ old('name') }}">
            </div>

            <div class="form-group">
                <label style="margin-right: 15px;">Giới tính <span class="asterisk">*</span></label>
                <input name="gender" type="radio" id="male" class="input-radio" value="1"><span style="margin-right: 25px;">Nam</span>
                <input name="gender" type="radio" id="female" class="input-radio" value="2"><span>Nữ</span>
            </div>

            <div class="form-group">
                <label>Số điện thoại <span class="asterisk">*</span></label>
                <input type="text" class="form-control" name="phone" id="phone" value="{{ old('phone') }}">
            </div>

            <div class="form-group" align="center">
                <button type="submit" class="btn btn-default functionButton">Thêm</button>
                <button type="button" class="btn btn-default functionButton" onclick = "window.location = '{{ route("admin.customer.getList") }}'">Quay lại</button>
            </div>
        <form>
    </div>
</section>

@endsection


@section('custom javascript')

<script type="text/javascript">
    $(document).ready(function(){
        $('.mytreeview').removeClass('active');  //loại bỏ active ở cái hiện tại
        $("#customer").addClass('active');   //active sang cái mới
    });


    //lấy thông tin theo user_id (khi thêm khách hàng đang là thành viên của hệ thống)
    $(document).ready(function() {
        $("#user_id").change(function() {
            var user_id = $(this).val();
            $.ajax({
                type: 'get',
                dataType: 'json',
                url: URL_GET_INFO_BY_USERID,
                data: {
                    user_id: user_id
                },
                success: function(response) {
                    $('#email').val(response.email);  //ở đây là đổ dữ liệu vào trong <input> nên phải dùng val(), .name là phần đc trả về từ controller
                    $('#name').val(response.name);
                    if(response.gender == 1) {
                        $('#male').prop('checked', true);  //thêm thuộc tính checked
                    } else {
                        $('#female').prop('checked', true);
                    }
                    $('#phone').val('0'+response.phone);
                }
            });
        });
    });
</script>

@endsection