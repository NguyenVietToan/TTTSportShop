@extends('admin.master')
@section('controller', 'Giao hàng')
@section('action', 'Cập nhật phân công')
@section('breadcrumb', 'Quản lý giao dịch')
@section('content')

<section class="content">
	<form class="form-horizontal" name="update_shipping" action="{{ route('admin.shipping.postUpdate') }}" method="POST" role="form" enctype="multipart/form-data">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">
		<input type="hidden" name="shipper_id" value="{!! $member->id !!}">
		@if (count($errors) > 0)
		<div class="alert alert-danger message">
			<strong>Lỗi!</strong> Xảy ra một vài vấn đề với dữ liệu nhập vào<br><br>
			<ul>
				@foreach ($errors->all() as $error)
				<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
		@endif

		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr>
					<th>
						<div class="form-group">
							<label class="col-md-2 control-label" style="padding: 0">Nhân viên giao hàng:</label>
							<div class="col-md-4">
								{{ $member->name}}
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-2 control-label" style="padding: 0">Số điện thoại:</label>
							<div class="col-md-4">
								{{ $member->phone}}
							</div>
						</div>
					</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<div class="form-group">
							<label class="col-md-12 control-label" for="" style="text-align:center; font-size:18px; margin-bottom:10px;">Đơn hàng được phân công</label>
							<div class="col-md-12">
								<table class="table table-striped table-bordered table-hover">
									<thead>
										<tr align="center">
											<th>STT</th>
											<th>Tên khách hàng</th>
											<th>Số điện thoại</th>
											<th style="text-align:center">Địa chỉ giao hàng</th>
											<th></th>
											<th></th>
										</tr>
									</thead>
									<?php $i = 1; ?>
									<tbody >
										@foreach($assigned_orders as $item)
										<tr id="{{ $item->order_id }}" align="center">
											<td class="stt">{{ $i++ }}</td>
											<td>{{ $item->customer }}</td>
											<td>{{ $item->phone }}</td>
											<td>{{ $item->location }}</td>
											<td><a href="{{ url('admin/order/detail').'/'.$item->order_id }}">Chi tiết</a></td>
											<td><a href="#" class="cancel" idOrder="{{ $item->order_id }}">Hủy</a></td>

										</tr>
										@endforeach
									</tbody>
								</table>

							</div>
						</div>
					</td>
				</tr>
				<tr>
					<td>
						<div class="form-group">
							<label class="col-md-12 control-label"  for="" style="text-align:center; font-size:18px; margin-bottom:10px; margin-top: 20px;">Đơn hàng cần phân công</label>
							<div class="col-md-12">
								<table class="table table-striped table-bordered table-hover">
									<thead>
										<tr align="center">
											<th>STT</th>
											<th>Tên khách hàng</th>
											<th>Số điện thoại</th>
											<th style="text-align:center">Địa chỉ giao hàng</th>
											<th></th>
											<th>Phân công</th>
										</tr>
									</thead>
									<?php $i = 1; ?>
									<tbody id="list_order" sum_order="{{ count($orders) }}" >
										@foreach($orders as $item)
										<tr align="center">
											<td>{{ $i++ }}</td>

											<td>{{ $item->customer }}</td>
											<td>{{ $item->phone }}</td>
											<td>{{ $item->location }}</td>
											<td><a href="{{ route('admin.order.getDetail', ['id' => $item->id]) }}">Chi tiết</a></td>
											<td><input type="checkbox" name="order_ids[]"  value="{{$item->id}}" /></td>

										</tr>
										@endforeach
									</tbody>
								</table>
							</div>
						</div>
					</td>
				</tr>
			</tbody>
		</table>

		<div class="form-group" align="center">
			<div class="col-md-12 col-md-offset-0">
				<button type="submit" class="btn btn-default functionButton">Cập nhật phân công</button>
				<button type="button" class="btn btn-default functionButton" onclick = "window.history.go(-1); return false;">Quay lại</button>
			</div>
		</div>
	</form>
</section>

@endsection


@section('custom javascript')
<script type="text/javascript">

	//Hủy phân công giao hàng
	$(document).ready(function() {
		var max_count = parseInt($('#list_order').attr('sum_order'));  //đếm số đơn hàng chưa được phân công (ban đầu), lấy số max đó, khi hủy 1 đơn hàng (tương đương xóa 1 <td> trong bảng) thì cái đơn hàng đó khi thêm vào phần chưa được phân công phải có thứ tự = max + 1
		var now_count = max_count; //dùng để đếm

		$('.cancel').click(function() {
			var order_id = $(this).attr('idOrder');
			var url = URL_GET_DELETE_ASSIGN_SHIPPING;
			var _token = $("form[name='update_shipping']").find("input[name='_token']").val();

			$.ajax({
				type: "POST",
				url: url,
				cache: false,
				data: {
					'_token' : _token,
					'order_id' : order_id
				},
				success: function(data){
					if (data == "Ok") {
						location.reload();  //ajax gọi đến hàm xóa, xóa xong thì DB cập nhật lại, khi đó reload lại trang này
					}else{
						alert("Lỗi! Vui lòng liên hệ với admin.");
					}
				}
			});
		});
	});

</script>

@stop