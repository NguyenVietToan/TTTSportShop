@extends('user.master')
@section('content')

<section id="my-profile">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{ url('trang-chu') }}"><i class="fa fa-home" aria-hidden="true"></i> {{ (session('lang'))?Config::get('lang.'.session('lang'))['home_page']:Config::get('lang.vi')['home_page'] }}</a></li>
            <li><a href="{{ route('getAccount') }}">{{ (session('lang'))?Config::get('lang.'.session('lang'))['account_management']:Config::get('lang.vi')['account_management'] }}</a></li>
            <li><a href="{{ route('getOrder') }}">{{ (session('lang'))?Config::get('lang.'.session('lang'))['order_list']:Config::get('lang.vi')['order_list'] }}</a></li>
            <li class="active">{{ (session('lang'))?Config::get('lang.'.session('lang'))['order_detail']:Config::get('lang.vi')['order_detail'] }}</li>
        </ul>
        <!-- /.breadcrums -->


        <div class="row">
            @include('user.profile.left_menu')
            <div class="col-xs-12 col-sm-6 col-md-7 col-md-push-1">
                <h2 class="title text-center" style="margin: 0 0 30px;">{{ (session('lang'))?Config::get('lang.'.session('lang'))['order_detail']:Config::get('lang.vi')['order_detail'] }}</h2>

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
                                <td>{{ $od->size }}</td>
                                <td>{{ $od->qty }}</td>
                                <td>{{ number_format($od->real_price, 0, ',', '.')  }}</td>
                                <td>{{ number_format($od->qty*$od->real_price, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</section>

@endsection