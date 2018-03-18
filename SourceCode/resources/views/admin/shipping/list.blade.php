@extends('admin.master')
@section('controller', 'Giao hàng')
@section('action', 'Danh sách phân công')
@section('breadcrumb', 'Quản lý giao dịch')
@section('content')

<section class="content">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-right: 0">
        <a href="{{ URL::route('admin.shipping.getAssign') }}" class="pull-right btn btn-default addItem"> Phân công</a>
    </div>

	<form class="form-horizontal" action="{{ route('admin.order.postDelete') }}" method="POST" role="form">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">

		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th>STT</th>
					<th>Người giao hàng</th>
					<th>Đơn hàng được phân công</th>
					<th></th>
				</tr>

			</thead>
			<?php $i = 1; ?>
			<tbody>
				@foreach($order_ships as $item)
					<tr align="center">
						<td style="vertical-align: middle;">{{ $i++ }}</td>
						<td rowspan="{{ count($item) }}" style="vertical-align: middle;">{{ $item->name }}</td>
						<td colspan="{{ count($item) }}" style="vertical-align: middle;"><?php $k = 1; ?>
							<table class="table table-striped table-bordered table-hover">
								<thead>
									<tr align="center">
										<th>STT</th>
										<th>Tên khách hàng</th>
										<th>Ngày đặt hàng</th>
										<th>Địa chỉ giao hàng</th>
										<th>Trạng thái đơn hàng</th>
										<th></th>
										<th></th>
									</tr>
								</thead>
								<tbody>
									@foreach($item->order as $sub_item)
									<tr align="center">
										<td>{{ $k++ }}</td>
										<td>{{ $sub_item->customer }}</td>
										<td>{{ Date('d/m/Y', strtotime($sub_item->date_order)) }}</td>
										<td>{{ $sub_item->location }}</td>
										<td>{!! Config::get('constants.status_shipping')[$sub_item->status] !!}</td>
										<td><a href="{{ route('admin.order.getDetail', ['id' => $sub_item->id]) }}">Chi tiết</a></td>
										<td><a href="{{ url('admin/order/edit').'/'.$sub_item->order_id }}" class="update-order" id="{{ $sub_item->status }}">Xác nhận</a></td>
									</tr>
									@endforeach
								</tbody>
							</table>
						</td>
						<td style="vertical-align: middle;"><a href="{{ url('admin/shipping/update').'/'.$item->id }}">Sửa</a></td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</form>
</section>

@endsection


@section('custom javascript')
<script type="text/javascript">
    $('.mytreeview').removeClass('active');  //loại bỏ active ở cái hiện tại
    $("#deal").addClass('active');
    $("#listshipping").addClass('active');   //active sang cái mới
	$(document).ready(function(){
		$('.update-order').click(function(){
			var shipping_status = $(this).attr('id');
			if(shipping_status == 0){
				alert('Bạn cần nhận được sự xác nhận thành công của nhân viên giao hàng trước');
				return false;
			}
		});
	});
</script>

@stop