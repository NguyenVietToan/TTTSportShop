@extends('shipper.master')
@section('controller', 'Quản lý tài khoản')
@section('action', 'Thông tin cá nhân')
@section('breadcrumb', 'Quản lý tài khoản')
@section('content')

<div class="container-fluid">
	<div class="row">
		<div class="col-md-6 col-md-push-3">
			<div class="panel panel-default order-detail" style="margin-top: 30px; margin-bottom: 40px">
				<div class="panel-heading" align="center">Thông tin cá nhân</div>
				<div class="panel-body">
					<div class="row form-horizontal">
						<div class="form-group">
							<label class="col-md-3 control-label" for="">Họ tên:</label>
							<div class="col-md-8">
								<label for="">{{ $shipper->name }}</label>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label" for="">Giới tính:</label>
							<div class="col-md-8">
								<label for="">
									@if ($shipper->gender == 1)
										Nam
									@else
										Nữ
									@endif
								</label>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label" for="">Ngày sinh:</label>
							<div class="col-md-8">
								<label for="">{{ Date('d/m/Y', strtotime($shipper->birthday)) }}</label>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label" for="">Số CMND:</label>
							<div class="col-md-8">
								<label for="">{{ $shipper->identity_card }}</label>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label" for="">Địa chỉ:</label>
							<div class="col-md-8">
								<label for="">{{ $shipper->full_address }}</label>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label" for="">Số điện thoại:</label>
							<div class="col-md-8">
								<label for="">0{{ $shipper->phone }}</label>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label" for="">Email:</label>
							<div class="col-md-8">
								<label for="">{{ $shipper->email }}</label>
							</div>
						</div>
					</div>

					<div class="form-group" align="center">
						<div class="col-md-12">
							<button type="submit" class="btn btn-default functionButton" onclick = "window.location = '{{ route('shipper.getEditInfo') }}'">Cập nhật</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection

@section('custom javascript')
<script type="text/javascript">
    $(document).ready(function() {
        $('.mytreeview').removeClass('active');  //loại bỏ active ở cái hiện tại
        $("#account").addClass('active');   //active sang cái mới
        $("#profile").addClass('active');
    });
</script>
@stop