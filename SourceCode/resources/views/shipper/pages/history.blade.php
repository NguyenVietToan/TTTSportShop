@extends('shipper.master')
@section('controller', 'Đơn hàng đã được giao')
@section('action', 'Danh sách')
@section('breadcrumb', 'Quản lý đơn hàng')
@section('content')

<div class="container-fluid content">
    <div class="row">
        <div class="col-md-push-0 col-md-12">
            <table class="table table-hover table-bordered table-striped">
                <thead>
                    <tr>
                        <th>STT</th>
                        <th>Tên khách hàng</th>
                        <th>Địa chỉ giao hàng</th>
                        <th>Giá trị đơn hàng</th>
                        <th>Ngày đặt hàng</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $stt = !empty($_GET['page']) ? ($_GET['page']-1)*7+1 : 1; ?>
                    @if(count($orders) > 0)
                        @foreach($orders as $item)
                          <tr align="center">
                              <td>{{ $stt++ }}</td>
                              <td>{{ $item->customer }}</td>
                              <td>{!! $item->location !!}</td>
                              <td>{!! number_format($item->sum_price,0,',','.')!!} VNĐ</td>
                              <td>{{ Date('d/m/Y',strtotime($item->date_order)) }}</td>
                              <td><a href="{{ url('shipper/detail') }}/{{ $item->order_id }}">Chi tiết</a></td>
                          </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="text-center" colspan="{{ 8 }}">Không tồn tại đơn hàng nào đã được giao</td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
    <div class="paginate pull-right">@include('pagination.paging', ['paginator' => $orders])</div>
</div>

@endsection

@section('custom javascript')
<script type="text/javascript">
  $(document).ready(function() {
      $('.mytreeview').removeClass('active');  //loại bỏ active ở cái hiện tại
      $("#order").addClass('active');   //active sang cái mới
      $("#history").addClass('active');
  });
</script>
@stop
