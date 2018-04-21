@extends('user.master')
@section('content')

<section id="my-profile">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{ url('trang-chu') }}"><i class="fa fa-home" aria-hidden="true"></i> {{ (session('lang'))?Config::get('lang.'.session('lang'))['home_page']:Config::get('lang.vi')['home_page'] }}</a></li>
            <li class="active">{{ (session('lang'))?Config::get('lang.'.session('lang'))['account_management']:Config::get('lang.vi')['account_management'] }}</li>
        </ul>
        <!-- /.breadcrums -->

        <div class="row">
            @include('user.profile.left_menu')
            <div class="col-md-8 col-md-push-1">
                @if (Session::has('flash_message'))
                    <div class="message alert alert-{{ Session::get('flash_level') }}">
                        <p class="text-center">{{ Session::get('flash_message') }}</p>
                    </div>
                @endif

                <h2 class="title text-center" style="margin: 0 0 30px;">{{ (session('lang'))?Config::get('lang.'.session('lang'))['profile']:Config::get('lang.vi')['profile'] }}</h2>
                <!-- /.title -->

                <div class="info-profile">
                    <div class="form-group">
                      <span class="col-md-3" for="">{{ (session('lang'))?Config::get('lang.'.session('lang'))['name']:Config::get('lang.vi')['name'] }}</span>
                      <div class="col-md-8">
                        <span for="">{{ Auth::user()->name }}</span>
                      </div>
                    </div>

                    <div class="form-group">
                        <span class="col-md-3" for="">{{ (session('lang'))?Config::get('lang.'.session('lang'))['gender']:Config::get('lang.vi')['gender'] }}</span>
                        <div class="col-md-8">
                          <span for="">
                              @if (Auth::user()->gender == '1')
                                  <span>Nam</span>
                              @else
                                  <span>Nữ</span>
                              @endif
                          </span>
                        </div>
                    </div>

                    <div class="form-group">
                        <span class="col-md-3" for="">{{ (session('lang'))?Config::get('lang.'.session('lang'))['birthday']:Config::get('lang.vi')['birthday'] }}</span>
                        <div class="col-md-8">
                          <span for="">{{ getTimeForList(Auth::user()->birthday) }}</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <span class="col-md-3" for="">{{ (session('lang'))?Config::get('lang.'.session('lang'))['address']:Config::get('lang.vi')['address'] }}</span>
                        <div class="col-md-8">
                          <span for="">{{ $full_address }}</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <span class="col-md-3" for="">{{ (session('lang'))?Config::get('lang.'.session('lang'))['email']:Config::get('lang.vi')['email'] }}</span>
                        <div class="col-md-8">
                          <span for="">{{ Auth::user()->email }}</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <span class="col-md-3" for="">{{ (session('lang'))?Config::get('lang.'.session('lang'))['phone']:Config::get('lang.vi')['phone'] }}</span>
                        <div class="col-md-8">
                          <span for="">0{{ Auth::user()->phone }}</span>
                        </div>
                    </div>
                </div>
                <!-- /.info-profile -->
            </div>

        </div>
    </div>
</section>

@endsection
