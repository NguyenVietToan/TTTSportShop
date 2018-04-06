@extends('auth.master')
@section('content')

<div class="container">
    <div class="row" style="margin-top: 10%;">
        <div class="col-md-12">
            <div class="wrap">
                <p class="form-title">
                    MEMBER <span style="background: #fb383b; padding: 5px;">TTT</span> SHOP</p>

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
                <p class="text-center" style="color: white;">{{ Session::get('flash_message') }}</p>
            </div>
        @endif

                <form class="login" action="{{ route('member.postLogin') }}" method="post">
                	<input type="hidden" name="_token" value="{{ csrf_token() }}">
                	<div class="form-group has-feedback">
                		<input type="email" placeholder="Username" name="email" value="{{ isset($email) ? $email : old('email') }}" />
                		<span class="glyphicon glyphicon-envelope form-control-feedback" style="color: white;"></span>
                	</div>
                	<div class="form-group has-feedback">
                		<input type="password" placeholder="Password" name="password" />
                		<span class="glyphicon glyphicon-lock form-control-feedback" style="color: white;"></span>
            		</div>
                	<input type="submit" value="Đăng nhập" class="btn btn-success btn-sm" />
                
                </form>
            </div>
        </div>
    </div>
    
</div>

@endsection