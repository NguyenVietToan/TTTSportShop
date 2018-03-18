@extends('auth.master')
@section('content')

<div class="login-box">
    <div class="login-logo">
        <b>Member</b>TPS
    </div>
    <!-- /.login-logo -->

    <div class="login-box-body">
        @if (count($errors) > 0)
            <div class="error alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (Session::has('flash_message'))
            <div class="message alert alert-{{ Session::get('flash_level') }}">
                <p class="text-center">{{ Session::get('flash_message') }}</p>
            </div>
        @endif

        <form action="{{ route('member.postLogin') }}" method="post">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <div class="form-group has-feedback">
                <input type="email" class="form-control" name="email" value="{{ isset($email) ? $email : old('email') }}">
                <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
            </div>
            <div class="form-group has-feedback">
                <input type="password" class="form-control" name="password">
                <span class="glyphicon glyphicon-lock form-control-feedback"></span>
            </div>
            <div class="row">
                <div class="col-xs-4 col-md-push-4" style="margin-top: 20px;">
                    <button type="submit" class="btn btn-primary btn-block btn-flat">Đăng nhập</button>
                </div>
            </div>
        </form>

    </div>
    <!-- /.login-box-body -->
</div>

@endsection
