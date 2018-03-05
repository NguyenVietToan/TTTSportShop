@extends('user.master')
@section('content')

<section id="my-profile">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{ url('/') }}">Trang chủ</a></li>
            <li><a href="{{ route('getAccount') }}">Quản lý tài khoản</a></li>
            <li class="active">Đơn hàng của bạn</li>
        </ul>
        <!-- /.breadcrums -->


        <div class="row">
            @include('user.profile.left_menu')
            <div class="col-xs-12 col-sm-6 col-md-7 col-md-push-1">
                <h2 class="title text-center" style="margin: 0 0 30px;">Đơn hàng của bạn</h2>

                @if (count($orders) == 0 )
                    <span>Bạn không có đơn hàng nào</span>
                @else
                    <table class="table table-striped table-bordered table-hover">
                        <thead>
                            <tr align="center">
                                <th>Số thứ tự</th>
                                <th>Ngày đặt hàng</th>
                                <th>Địa chỉ giao hàng</th>
                                <th>Giá trị</th>
                                <th>Trạng thái</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $stt = 1; ?>
                            @foreach($orders as $order)
                                <tr class="odd gradeX" align="center">
                                    <td>{{ $stt++ }}</td>
                                    <td>{{ Date('d/m/Y', strtotime($order->date_order)) }}</td>
                                    <td>{{ $order->full_address }}</td>
                                    <td>{{ $order->total }}</td>
                                    <td>{!! Config::get('constants.status_orders')[$order->status_order] !!}</td>
                                    <td><a href="{{ route('getOrderDetail', $order->id) }}">Chi tiết </a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
            </div>
        </div>

    </div>
</section>

@endsection