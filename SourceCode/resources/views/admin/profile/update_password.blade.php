@extends('admin.master')
@section('controller', 'Quản lý tài khoản')
@section('action', 'Đổi mật khẩu')
@section('breadcrumb', 'Quản lý tài khoản')
@section('content')

<section class="content">
	<div class="col-xs-12 col-sm-8 col-md-6 col-lg-6 col-sm-push-2 col-md-push-3">
		<form action="{{ route('admin.updatePassword') }}" method="POST" role="form" class="list-pro-data">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">

			<div class="form-group col-md-8 col-md-push-2">
				<label for="example-text-input">Mật khẩu hiện tại <span class="asterisk">*</span></label>
				<input class="form-control" type="password"  name="oldPassword" required>
				<br>
				<label for="example-text-input">Mật khẩu mới <span class="asterisk">*</span></label>
				<input class="form-control" type="password"  name="newPassword" required>
				<br>
				<label for="example-text-input">Xác nhận mật khẩu mới <span class="asterisk">*</span></label>
				<input class="form-control" type="password"  name="re_newPassword" required>
				<br>
				<div align="center">
					<button type="submit" class="btn btn-default functionButton" style="margin-top: 30px; margin-bottom: 40px;">Cập nhật</button>
				</div>
			</div>
		</form>
	</div>
</section>

@endsection
