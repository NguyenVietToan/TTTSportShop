@extends('admin.master')
@section('controller', 'Đơn hàng')
@section('action', 'Chi tiết')
@section('breadcrumb', 'Quản lý đơn hàng')
@section('content')
<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-push-2">
			<div class="panel panel-default order-detail" style="margin-top: 30px; margin-bottom: 40px;">
				<div class="panel-heading" align="center">Thông tin chi tiết đơn hàng</div>
				<div class="panel-body">
					<div class="row form-horizontal">
						<div class="form-group">
							<label class="col-md-3 control-label" for="">Tên khách hàng:</label>
							<div class="col-md-8">
								<label for="">{{ $order->customer }}</label>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label" for="">Số điện thoại:</label>
							<div class="col-md-8">
								<label for="">{{ $order->phone }}</label>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label" for="">Email:</label>
							<div class="col-md-8">
								<label for="">{{ $order->email }}</label>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label" for="">Giới tính:</label>
							<div class="col-md-8">
								<label for="">{{ Config::get('constants.gender_admin')[$order->gender] }}</label>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label" for="">Địa chỉ giao hàng:</label>

							<div class="col-md-8">
								<label for="">{{ $order->address }}</label>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label" for="">Trạng thái:</label>
							<div class="col-md-8">
								<label for="">{{ Config::get('constants.status_orders')[$order->status_order] }}</label>
							</div>
						</div>

						<?php $sum_price = 0;
						 ?>
						<div class="form-group">
							<label class="col-md-3 control-label"  for="">Chi tiết sản phẩm:</label><br />
							<div class="col-md-10 col-md-push-1">
								<table class="table table-hover table-striped table-bordered" >
									<thead>
										<tr align="center">
											<th>STT</th>
											<th>Tên mặt hàng</th>
											<th>Số lượng</th>
											<th>Kích thước</th>
											<th>Giá</th>
											@if($order->status_order == 3)
												<th>Trạng thái giao hàng</th>
											@endif
										</tr>
									</thead>
									<?php $i = 1; ?>
									<tbody id="product-import">
										@if($order->status_order == 3)
											@foreach($order->data as $p_item)
												<tr align="center">
													<td>{{ $i++ }}</td>
													<td>{{ $p_item->name }}</td>
													<td>{{ $p_item->qty }}</td>
													<td>{{ $p_item->size }}</td>
													<td>{!! number_format($p_item->price,0,',','.') !!} VNĐ</td>
													<td>
														{{ Config::get('constants.detail_status_shipping')[$p_item->status] }}
													</td>
												</tr>
											@endforeach
										@else
											@foreach($order->data as $p_item)
												<tr>
													<td>{{ $i++ }}</td><td>{{ $p_item->name }}</td>
													<td>{{ $p_item->qty }}</td>
													<td>{{ $p_item->size }}</td>
													<td>{!!number_format($p_item->price,0,',','.')!!} VNĐ</td>
												</tr>
											@endforeach
										@endif
									</tbody>
								</table>
							</div>
						</div>

						<div class="form-group ">
							<label class="col-md-3 control-label" for="">Tổng giá trị:</label>
							<div class="col-md-8" style="color: red;">
								<label for="">{!! number_format($order->sum_price, 0, ',', '.') !!} VNĐ</label>
							</div>
						</div>
					</div>

					<div class="form-group" align="center">
						<div class="col-md-12">
							<button type="button" class="btn btn-default functionButton" onclick = "window.history.go(-1); return false;">Quay lại</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@stop