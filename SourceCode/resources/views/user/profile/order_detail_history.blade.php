@extends('user.master')
@section('content')

<section id="my-profile">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{ url('trang-chu') }}"><i class="fa fa-home" aria-hidden="true"></i> Trang chủ</a></li>
            <li><a href="{{ route('getAccount') }}">Quản lý tài khoản</a></li>
            <li><a href="{{ route('getOrder') }}">Đơn hàng của bạn</a></li>
            <li class="active">Chi tiết</li>
        </ul>
        <!-- /.breadcrums -->


        <div class="row">
            @include('user.profile.left_menu')
            <div class="col-xs-12 col-sm-6 col-md-7 col-md-push-1">
                <h2 class="title text-center" style="margin: 0 0 30px;">Chi tiết đơn hàng</h2>

                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr align="center">
                            <th>Số thứ tự</th>
                            <th>Sản phẩm</th>
                            <th>Size</th>
                            <th>Số lượng</th>
                            <th>Đơn giá</th>
                            <th>Thành tiền</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $stt = 1; ?>
                        @foreach($order_details as $od)
                            <tr class="odd gradeX" align="center">
                                <td>{{ $stt++ }}</td>
                                <td>{{ $od->pr_name }}</td>
                                <td>{{ $od->value }}</td>
                                <td>{{ $od->qty }}</td>
                                <td>{{ $od->real_price }}</td>
                                <td>{{ $od->qty*$od->real_price }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</section>

@endsection