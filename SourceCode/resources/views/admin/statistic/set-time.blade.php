@extends('admin.master')
@section('controller', 'Thống kê bán hàng')
@section('action', 'Tùy chọn')
@section('breadcrumb', 'Thống kê')
@section('content')

<div class="container-fluid content">
	<div class="row">
		<div class="col-md-10 col-md-push-1" style="margin-top: 30px;">
			<div class="panel panel-default">
				<div class="panel-heading" align="center">Thống kê bán hàng theo ngày</div>
				<div class="panel-body">
					<form action = "{{ route('admin.statistic.getResult') }}" method = "GET" id = "listForm">
						<input type="hidden" name = "_token" value = "{!! csrf_token() !!}">
						<div class="frame_box">
							<div class="col-xs-12 col-md-6" style="border-right:1px solid black">
								<label class="control-label col-md-12">Thời gian bắt đầu</label>
								<div class="col-md-12">
									<input type="text" name="start_date" class="form-control" value="{{ old('start_date')==null ? Date('d/m/20y') : old('start_date') }}" id="start-date-option" required/>
								</div>
							</div>
							<div class="col-xs-12 col-md-6">
								<label class="control-label col-md-12">Thời gian kết thúc</label>
								<div class="col-md-12">
									<input type="text" name="end_date" class="form-control" value="{{ old('end_date')==null ? Date('d/m/20y') : old('end_date') }}" id="end-date-option" required/>
								</div>
							</div>
							<div style="clear:both"></div>
							<div class="col-md-12 " style="margin-left: 15px;" align="center">
								<button type="submit" id="submit" class="btn btn-default functionButton">Thống Kê</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@section('custom javascript')
<script type="text/javascript">
	$(document).ready(function() {
		$('.mytreeview').removeClass('active');
		$("#statistic").addClass('active');
	});

	$(document).ready(function() {
		$('#start-date-option').datepicker({ format : 'dd/mm/yyyy'});
		$('#end-date-option').datepicker({ format : 'dd/mm/yyyy'});
	});
</script>
@stop