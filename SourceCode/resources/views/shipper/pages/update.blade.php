@extends('shipper.master')
@section('controller', 'Đơn hàng')
@section('action', 'Cập nhật')
@section('breadcrumb', 'Quản lý đơn hàng')
@section('content')
@section('content')

<div class="container-fluid content">
	<div class="row">
		<div class="col-md-push-0 col-md-12">
			<form class="form-horizontal" action="{{ route('shipper.postEdit') }}" method="POST" role="form">
				<input type="hidden" name="_token" value="{{ csrf_token() }}">
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

				<table class="table table-hover table-bordered table-striped
				">
					<thead>
						<tr>
							<th>STT</th>
							<th>Tên mặt hàng</th>
							<th>Số lượng</th>
							<th>Kích thước</th>
							<th>Giá</th>
							<th>Trạng thái nhận</th>
						</tr>
					</thead>
					<?php $i = 1;?>
					<tbody id="product-import">
						@foreach($order_details as $item)
							<tr>
								<td>{{ $i++ }}</td>
								<td>{{ $item->name }}</td>
								<td>{{ $item->qty }}</td>
								<td>{{ $item->value }}</td>
								<td>{!! number_format($item->price,0,',','.') !!} VNĐ</td>

								<td>
									<select class="form-control" name="received_status[]" id="">
										<option value="{{$item->order_id.'-'.$item->pro_id.'-'.$item->size_id.'-1' }}" {{ $item->status == 1?'selected':'' }}>Thành công</option>
										<option value="{{$item->order_id.'-'.$item->pro_id.'-'.$item->size_id.'-0' }}" {{ $item->status == 0?'selected':'' }}>Bị hủy</option>
									</select>
								</td>
							</tr>
						@endforeach
					</tbody>
				</table>

				<div align="center">
					<button type="submit" class="btn btn-default functionButton" >Cập nhật</button>
					<button class="btn btn-default functionButton" onclick = "window.location = '{{ route('shipper.getProcessing') }}'">Quay lại</button>
				</div>
			</form>
		</div>
	</div>
</div>

@stop
