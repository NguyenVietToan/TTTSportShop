@extends('shipper.master')
@section('controller', 'Đơn hàng được phân công')
@section('action', 'Danh sách')
@section('breadcrumb', 'Quản lý đơn hàng')
@section('content')

<div class="container-fluid content">
    <div class="row">
        <div class="col-md-push-0 col-md-12">
            <form class="form-horizontal" action="{{ route('shipper.postAccept') }}" method="POST" role="form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">

                <table class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên khách hàng</th>
                            <th>Địa chỉ giao hàng</th>
                            <th>Giá trị đơn hàng</th>
                            <th>Ngày đặt hàng</th>
                            <th></th>
                            <th></th>
                            <th><input type="checkbox" id="check" /> Đã ship</th>
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
                            <td>{!! number_format($item->sum_price, 0, ',', '.') !!} VNĐ</td>
                            <td>{{ Date('d/m/Y',strtotime($item->date_order)) }}</td>
                            <td><a href="{{ url('shipper/detail') }}/{{ $item->order_id }}">Chi tiết</a></td>
                            <td><a href="{{ url('shipper/update') }}/{{ $item->order_id }}">Sửa</a></td>
                            <td><input type="checkbox" class="check_class" name="order_ids[]" value="{{ $item->order_id }}"></td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td class="text-center" colspan="8">Không có đơn hàng nào được phân công</td>
                        </tr>
                    @endif
                    </tbody>
                </table>

                <div class="row">
                    <div class="col-md-12" align="center">
                        <button type="submit" class="btn btn-default functionButton">Xác nhận đã chuyển hàng</button>
                    </div>
                </div>
            </form>
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
      $("#processing").addClass('active');
      var check = false;
      $('#check').click(function(){
          if(check == false){
              check = true;
              $(".check_class").prop("checked",true);
          }else{
              check =false;
              $(".check_class").prop("checked",false);
          }
      });
  });
</script>
@stop