@extends('shipper.master')
@section('controller', 'Đơn hàng')
@section('action', 'Danh sách')
@section('breadcrumb', 'Quản lý đơn hàng')
@section('content')
<div class="container-fluid content">
  <div class="row">
      <div class="col-md-push-0 col-md-12">
        <form class="form-horizontal" action="{{ route('shipper.postAccept') }}" method="POST" role="form">
          <input type="hidden" name="_token" value="{{ csrf_token() }}">
          <legend>
            <h2 class="col-md-7">Danh sách đơn hàng</h2>
            <div class="paginate col-md-5 text-right">{{ $orders->render() }}</div>
          </legend>
          <table class="table table-hover table-bordered table-striped">
            <thead>
              <tr>
                <th>STT</th>
                <th></th>
                <th>Tên khách hàng</th>
                <th>Địa chỉ giao hàng</th>
                <th>Giá trị đơn hàng</th>
                <th>Ngày đặt hàng</th>
                <th></th>
                <th><input type="checkbox" id="check" />Đã ship</th>
              </tr>

            </thead>
            <tbody>
            <?php $i = 1; ?>
              @if(count($orders) > 0)
                @foreach($orders as $item)
                <tr>
                  <td>{{ $i++ }}</td>
                  <td><a href="{{ url('shipper/update') }}/{{ $item->order_id }}">Sửa</a></td>
                  <td>{{ $item->customer }}</td>
                  <td>{!! $item->location !!}</td>
                  <td>{!!number_format($item->sum_price,0,',','.')!!}đ</td>
                  <td>{{Date('y-m-d',strtotime($item->date_order)) }}</td>
                  <td><a href="{{ url('shipper/detail') }}/{{ $item->order_id }}">Chi tiết</a></td>
                  <td><input type="checkbox" class="check_class" name="order_ids[]" value="{{ $item->order_id }}"></td>
                </tr>
                @endforeach
              @else
                <tr>
                  <td class="text-center" colspan="{{ 8 }}">Không tồn tại đơn hàng nào</td>
                </tr>
              @endif
            </tbody>
          </table>
        
          <div class="row">
          <div class="col-md-12 text-right">
            <button type="submit" class="btn btn-success">Xác nhận đã chuyển hàng</button>
            </div>
          </div>
          
        </form>
      </div>
      
  </div>
</div>
@endsection
@section('custom javascript')
<script type="text/javascript">
  $(document).ready(function (){
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