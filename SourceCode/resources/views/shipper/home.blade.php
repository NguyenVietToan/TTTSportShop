@extends('shipper.master')
@section('controller', 'Trang chủ')
@section('action', 'Bảng điều khiển')
@section('breadcrumb', 'Bảng điều khiển')
@section('content')

<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-lg-4 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                    <h3>{{ $deliveried_order }}</h3>

                    <p>Đơn hàng được phân công</p>
                </div>
                <div class="icon">
                    <i class="ion ion-document-text"></i>
                </div>
                <a href="{{ route('shipper.getProcessing') }}" class="small-box-footer">Chi tiết <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <h3>{{ $waitingAccepted_order }}</h3>

                    <p>Đơn hàng chờ xác nhận</p>
                </div>
                <div class="icon">
                    <i class="ion ion-load-b"></i>
                </div>
                <a href="{{ route('shipper.getWaitingAccepted') }}" class="small-box-footer">Chi tiết <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-4 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <h3>{{ $completed_order }}</h3>

                    <p>Đơn hàng đã hoàn thành</p>
                </div>
                <div class="icon">
                    <i class="ion ion-checkmark"></i>
                </div>
                <a href="{{ route('shipper.getHistory') }}" class="small-box-footer">Chi tiết <i class="fa fa-arrow-circle-right"></i></a>
            </div>
        </div>
        <!-- ./col -->
    </div>
    <!-- /.row -->

    <!-- Main row -->
    <div class="row">
    </div>
    <!-- /.row (main row) -->
</section>

@endsection