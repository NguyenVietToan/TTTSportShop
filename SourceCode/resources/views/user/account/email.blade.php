@extends('user.master')
@section('content')

<div class="inner-header">
	  <div class="container">
		    <ul class="breadcrumb">
    		    <li>
      			    <a href="{{ url('trang-chu') }}"><i class="fa fa-home" aria-hidden="true"></i>  {{ (session('lang'))?Config::get('lang.'.session('lang'))['home_page']:Config::get('lang.vi')['home_page'] }}</a>
      			    <span class="divider"></span>
    		    </li>
    		    <li class="active">{{ (session('lang'))?Config::get('lang.'.session('lang'))['forget_pwd']:Config::get('lang.vi')['forget_pwd'] }}</li>
  		  </ul>
  		  <!-- /.breadcrumb -->
		    <div class="clearfix"></div>
	  </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-success" style="margin-bottom: 60px;">
                <div class="panel-heading">{{ (session('lang'))?Config::get('lang.'.session('lang'))['forget_pwd']:Config::get('lang.vi')['forget_pwd'] }}</div>
                <div class="panel-body">
                    @if (Session::has('flash_message'))
                        <div class="message alert alert-{{ Session::get('flash_level') }}">
                            <p class="text-center">{{ Session::get('flash_message') }}</p>
                        </div>
                    @endif

                    <form class="form-horizontal" role="form" method="POST" action="{{ route('password.email') }}">
                        {{ csrf_field() }}

                        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                            <label for="email" class="col-md-4 control-label">E-Mail</label>

                            <div class="col-md-6">
                                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Nhập email của bạn" required>

                                @if ($errors->has('email'))
                                    <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-6 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">
                                    Gửi mã reset password
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection