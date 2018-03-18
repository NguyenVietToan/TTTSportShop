@extends('admin.master')
@section('controller', 'Giao hàng')
@section('action', 'Phân công')
@section('breadcrumb', 'Quản lý giao dịch')
@section('content')

<section class="content">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
		<form class="form-horizontal" action="{{ route('admin.shipping.postAssign') }}" method="POST" role="form" enctype="multipart/form-data">
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

			<div class="form-group">
				<div class="col-md-2"></div>
				<label for="" class="control-label col-md-3" >Nhân viên giao hàng:</label>
				<div class="col-md-4">
					<select name="shipper_id" class="form-control" id="">
						@foreach($shippers as $item)
						<option value="{{ $item->id }}">{{ $item->name }}</option>
						@endforeach
					</select>
				</div>
			</div>

			<div class="form-group" style="margin-top: 30px;">
				<label class="col-md-12 control-label"  for="" style="text-align:center; font-size: 18px">Danh sách đơn hàng cần phân công</label>
				<hr>
				<div class="col-md-12">
					<table class="table table-striped table-bordered table-hover">
						<thead>
							<tr align="center">
								<th>STT</th>
								<th>Tên khách hàng</th>
								<th>Số điện thoại</th>
								<th>Địa chỉ giao hàng</th>
								<th></th>
								<th>Phân công</th>
							</tr>
						</thead>
						<?php $i = 1; ?>
						<tbody >
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

			<div class="form-group" align="center">
				<div class="col-md-12 col-md-offset-0">
					<button type="submit" class="btn btn-default functionButton">Phân công</button>
				</div>
			</div>
		</form>
	</div>
</section>

@endsection


@section('custom javascript')
@stop
