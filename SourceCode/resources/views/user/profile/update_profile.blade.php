@extends('user.master')
@section('content')

<section id="update-profile">
    <div class="container">
        <ul class="breadcrumb">
            <li><a href="{{ url('trang-chu') }}"><i class="fa fa-home" aria-hidden="true"></i> {{ (session('lang'))?Config::get('lang.'.session('lang'))['home_page']:Config::get('lang.vi')['home_page'] }}</a></li>
            <li><a href="{{ route('getAccount') }}">{{ (session('lang'))?Config::get('lang.'.session('lang'))['account_management']:Config::get('lang.vi')['account_management'] }}</a></li>
            <li class="active">{{ (session('lang'))?Config::get('lang.'.session('lang'))['update_profile']:Config::get('lang.vi')['update_profile'] }}</li>
        </ul>
        <!-- /.breadcrums -->

        <div class="row">
            @include('user.profile.left_menu')
			
            <form action="{{ route('updateProfile') }}" method="POST" enctype="multipart/form-data">
	            <input type="hidden" name="_token" value="{{ csrf_token() }}">
	            <input type="hidden" name="id" value="{{ Auth::id() }}">
	            <input type="hidden" name="email" value="{{ Auth::user()->email }}">
	            <div class="col-xs-12 col-sm-6 col-md-7 col-md-push-1">
	                <h2 class="title text-center" style="margin: 0 0 30px;">{{ (session('lang'))?Config::get('lang.'.session('lang'))['update_profile']:Config::get('lang.vi')['update_profile'] }}</h2>
					
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

	                <div class="form-group">
		                <label>{{ (session('lang'))?Config::get('lang.'.session('lang'))['email']:Config::get('lang.vi')['email'] }} <span class="asterisk">*</span></label>
		                <input type="email" class="form-control" name="email" value="{{ old('email', isset($user) ? $user->email : null) }}">
		            </div>

					<div class="form-group">
	                	<label>{{ (session('lang'))?Config::get('lang.'.session('lang'))['name']:Config::get('lang.vi')['name'] }} <span class="asterisk">*</span></label>
						<input type="text" class="form-control" name="name" value="{{ old('name', isset($user) ? $user->name : null) }}">
	                </div>

	                <div class="form-group">
		                <label>{{ (session('lang'))?Config::get('lang.'.session('lang'))['avatar']:Config::get('lang.vi')['avatar'] }}</label><br>
		                @if ($user->avatar == null)
		                	<img src="{{ asset('public/user/images/default-user.png') }}">
		                @else
		                	<img src="{{ asset('resources/upload/images/user/'.$user->id.'/'.$user->avatar) }}">
		                @endif
		                <input type="hidden" name="img_current" value="{{ $user->avatar }}" />
		            </div>
		            <div class="form-group">
		                <label>{{ (session('lang'))?Config::get('lang.'.session('lang'))['change_avatar']:Config::get('lang.vi')['change_avatar'] }}</label>
		                <input type="file" name="avatar">
		            </div>

	                <div class="form-group">
	                    <label style="margin-right: 15px;">{{ (session('lang'))?Config::get('lang.'.session('lang'))['gender']:Config::get('lang.vi')['gender'] }} <span class="asterisk">*</span></label>
						<input name="gender" type="radio" class="input-radio" value="1"
							@if ($user->gender == 1)
								checked
							@endif
						><span style="margin-right: 25px;">{{ (session('lang'))?Config::get('lang.'.session('lang'))['male']:Config::get('lang.vi')['male'] }}</span>
						<input name="gender" type="radio" class="input-radio" value="2"
							@if ($user->gender == 2)
								checked
							@endif
						><span>{{ (session('lang'))?Config::get('lang.'.session('lang'))['female']:Config::get('lang.vi')['female'] }}</span>
	                </div>

	                <div class="form-group">
		                <label>{{ (session('lang'))?Config::get('lang.'.session('lang'))['birthday']:Config::get('lang.vi')['birthday'] }} <span class="asterisk">*</span></label>
		                <br>
		                <div class="col-md-4" style="padding-left: 0;">
		                    <select name="day" class="form-control">
		                        @for($day = $day_arr[0]; $day <= $day_arr[1]; $day++ )
		                        <option value="{{ $day }}"
		                            @if ($day == $birthday[2])
		                                selected
		                            @endif
		                        >{{ $day }}</option>
		                        @endfor
		                    </select>
		                </div>
		                <div class="col-md-4" style="padding-left: 0;">
		                    <select name="month" class="form-control">
		                        @for($month = $month_arr[0]; $month <= $month_arr[1]; $month++ )
		                        <option value="{{ $month }}"
		                            @if ($month == $birthday[1])
		                                selected
		                            @endif
		                        >{{ $month }}</option>
		                        @endfor
		                    </select>
		                </div>
		                <div class="col-md-4" style="padding-left: 0;">
		                    <select name="year" class="form-control">
		                        @for($year = $year_arr[0]; $year <= $year_arr[1]; $year++ )
		                        <option value="{{ $year }}"
		                            @if ($year == $birthday[0])
		                                selected
		                            @endif
		                        >{{ $year }}</option>
		                        @endfor
		                    </select>
		                </div>
		            </div>

	                <div class="form-group">
		                <label style="margin-top: 15px">{{ (session('lang'))?Config::get('lang.'.session('lang'))['address']:Config::get('lang.vi')['address'] }} <span class="asterisk">*</label>
		                <br>
		                <div class="col-md-4" style="padding-left: 0;">
		                    <select name="province" id="province" class="form-control">
		                       	@foreach($provinces as $item)
		                        <option value="{{ $item->provinceid }}"
			                        @if ($item->provinceid == $province->provinceid)
			                        	selected
			                        @endif
		                        >{{ $item->name }}</option>
		                        @endforeach
		                    </select>
		                </div>
		                <div class="col-md-4" style="padding-left: 0;">
		                    <select name="district" id="district" class="form-control">
		                        <option value="{{ $district->districtid }}">{{ $district->name }}</option>
		                    </select>
		                </div>
		                <div class="col-md-4" style="padding-left: 0;">
		                    <select name="ward" id="ward" class="form-control">
		                        <option value="{{ $user->wardid }}">{{ $ward->name }}</option>
		                    </select>
		                </div>
		                <div class="col-md-12" style="padding: 0;">
		                    <input type="text" style="margin: 7px 0 15px;" class="form-control" id="" name="address" placeholder="Nhập địa chỉ cụ thể (số nhã, ngõ, đường...)" value="{{ $user->address }}">
		                </div>
		            </div>

					<div class="form-group">
						<label>{{ (session('lang'))?Config::get('lang.'.session('lang'))['phone']:Config::get('lang.vi')['phone'] }} <span class="asterisk">*</span></label>
						<input type="text" class="form-control" name="phone" value="{{ old('phone', isset($user) ? $user->phone : null) }}">
					</div>

					<div class="text-center">
						<button type="submit" class="btn btn-default functionButton" style="margin-right: 30px">{{ (session('lang'))?Config::get('lang.'.session('lang'))['update']:Config::get('lang.vi')['update'] }}</button>
            			<button type="button" class="btn btn-default functionButton" onclick = "window.location = '{{ route("getAccount") }}'">{{ (session('lang'))?Config::get('lang.'.session('lang'))['back']:Config::get('lang.vi')['back'] }}</button>
					</div>
				</div>
        	<form>
        </div>
    </div>
</section>

@endsection