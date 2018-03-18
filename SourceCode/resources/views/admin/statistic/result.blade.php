@extends('admin.master')
@section('controller', 'Thống kê bán hàng')
@section('action', 'Kết quả')
@section('breadcrumb', 'Thống kê')
@section('content')

<section style="padding: 15px 25px 25px;">
	<div class="col-md-12">
		<div class="col-md-3"></div>
		<div class="col-md-4">
			<h3>Từ ngày: {{ Date('d/m/Y', strtotime($start_date)) }}</h3>
		</div>
		<div class="col-md-4">
			<h3>Đến ngày: {{ Date('d/m/Y', strtotime($end_date)) }}</h3>
		</div>
	</div>

	<div class="col-md-12" style="margin-bottom: 30px">
		<form class="form-horizontal" action="{{ route('admin.statistic.getFilter') }}" name="filter" method="GET" role="form">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">
			<input type="hidden" name="start_date" value="{{ $start_date }}">
			<input type="hidden" name="end_date" value="{{ $end_date }}">

			<div class="row">
				<div class="col-md-12 pull-right" style="font-size: 14px; margin-top:30px;">
					<div class="col-md-3">
						<div class="col-md-5">
							<label for="" class="control-label">Thể loại</label>
						</div>
						<div class="col-md-7">
							<select class="form-control" name="cate_id" id="">
								<option value="0">Tất cả</option>
								@foreach($cates as $item)
								<option value="{{ $item->id }}" @if(!empty($cate_id) && $cate_id == $item->id) selected @endif>{{ $item->name }}</option>
								@endforeach
							</select>
						</div>
					</div>

					<div class="col-md-3">
						<div class="col-md-5">
							<label for="" class="control-label">Bộ môn</label>
						</div>
						<div class="col-md-7">
							<select class="form-control" name="sport_id" id="">
								<option value="0">Tất cả</option>
								@foreach($sports as $item)
								<option value="{{ $item->id }}" @if(!empty($sport_id) && $sport_id == $item->id) selected @endif>{{ $item->name }}</option>
								@endforeach
							</select>
						</div>
					</div>

					<div class="col-md-4">
						<div class="col-md-5">
							<label for="" class="control-label">Thương hiệu</label>
						</div>
						<div class="col-md-7">
							<select class="form-control" name="brand_id" id="">
								<option value="0">Tất cả</option>
								@foreach($brands as $item)
								<option value="{{ $item->id }}" @if(!empty($brand_id) && $brand_id == $item->id) selected @endif>{{ $item->name }}</option>
								@endforeach
							</select>
						</div>
					</div>

					<div class="col-md-2 col-md-push-1">
						<button type="submit" class="btn btn-default functionButton" style="margin: 0 !important">Lọc</button>
					</div>
				</div>
			</div>
		</form>
	</div>

	<div class="row" style="font-size:16px; margin: 30px 0">
		<div class="col-md-12">
			<div class="col-md-4"></div>
			<div class="col-md-3"><b>Tổng số lượng bán được:</b></div>
			<div class="col-md-4" style="color: red">{{ $sum_qty }} sản phẩm</div>
		</div>

		<div class="col-md-12">
			<div class="col-md-4"></div>
			<div class="col-md-3"><b>Tổng doanh thu:</b></div>
			<div class="col-md-4" style="color: red">{{ number_format($revenue, 0, ',', '.') }} VNĐ</div>
		</div>

		<div class="col-md-12">
			<div class="col-md-4"></div>
			<div class="col-md-3"><b>Tổng lợi nhuận:</b></div>
			<div class="col-md-4" style="color: red">{{ number_format($profit, 0, ',', '.') }} VNĐ</div>
		</div>
	</div>

	<table class="table table-striped table-bordered table-hover">
		<thead>
			<tr align="center">
				<th>STT</th>
				<th>Tên sản phẩm</th>
				<th>Số lượng bán được</th>
				<th>Lãi trên 1 sản phẩm</th>
				<th>Tổng doanh thu</th>
				<th>Tổng lợi nhuận</th>
			</tr>
		</thead>
		<tbody>
			@if (count($products) > 0)
				@foreach($products as $key => $product)
				<tr class="odd gradeX" align="center">
					<td>{{ $key + 1 }}</td>
					<td>{{ $product->name }}</td>
					<td>{{ $product->sum_qty }}</td>
					<td>{{ number_format($product->profitOne, 0, ',', '.') }} VNĐ</td>
					<td>{{ number_format($product->revenue, 0, ',', '.') }} VNĐ</td>
					<td>{{ number_format($product->profit, 0, ',', '.') }} VNĐ</td>
				</tr>
				@endforeach
			@else
				<tr>
					<td colspan="6" style="text-align:center">Không có sản phẩm nào được bán trong khoảng thời gian này</td>
				</tr>
			@endif
		</tbody>
	</table>

	<div align="center">
		<button type="button" class="btn btn-default functionButton" onclick = "window.location = '{{ route("admin.statistic.getTimeStatistic") }}'">Quay lại</button>
	</div>
</section>

@endsection

@section('custom javascript')
<script type="text/javascript">
	$(document).ready(function(){
		$('.mytreeview').removeClass('active');
		$("#statistic").addClass('active');
	});
</script>

@stop