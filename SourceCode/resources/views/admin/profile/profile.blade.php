@extends('admin.master')
@section('controller', 'Thông tin cá nhân')
@section('action', '')
@section('breadcrumb', 'Quản lý tài khoản')
@section('content')

<div class="container-fluid">
	<div class="row">
		<div class="col-md-6 col-md-push-3">
			<div class="panel panel-default order-detail" style="margin-top: 30px; margin-bottom: 40px">
				<div class="panel-heading" align="center">Thông tin cá nhân của Admin</div>
				<div class="panel-body">
					<div class="row form-horizontal">
						<div class="form-group">
							<label class="col-md-3 control-label" for="">Họ tên:</label>
							<div class="col-md-8">
								<label for="">{{ $admin->name }}</label>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label" for="">Giới tính:</label>
							<div class="col-md-8">
								<label for="">
									@if ($admin->gender == 1)
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
								<label for="">{{ Date('d/m/Y', strtotime($admin->birthday)) }}</label>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label" for="">Số CMND:</label>
							<div class="col-md-8">
								<label for="">{{ $admin->identity_card }}</label>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label" for="">Địa chỉ:</label>
							<div class="col-md-8">
								<label for="">{{ $admin->full_address }}</label>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label" for="">Số điện thoại:</label>
							<div class="col-md-8">
								<label for="">0{{ $admin->phone }}</label>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label" for="">Email:</label>
							<div class="col-md-8">
								<label for="">{{ $admin->email }}</label>
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-3 control-label" for="">Ngày bắt đầu:</label>
							<div class="col-md-8">
								<label for="">{{ getTimeForList($admin->start_date) }}</label>
							</div>
						</div>
					</div>

					<div class="form-group" align="center">
						<div class="col-md-12">
							<button type="submit" class="btn btn-default functionButton" onclick = "window.location = '{{ route('admin.getEditInfo') }}'">Cập nhật</button>
							<button type="submit" class="btn btn-default functionButton" onclick = "window.location = '{{ route('admin.getPassword') }}'">Đổi mật khẩu</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection
