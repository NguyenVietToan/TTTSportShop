@extends('user.master')
@section('content')

<div class="delivery-address">
	<div class="container">
		<ul class="breadcrumb">
    		<li><a href="{{ url('trang-chu') }}"><i class="fa fa-home" aria-hidden="true"></i> {{ (session('lang'))?Config::get('lang.'.session('lang'))['home_page']:Config::get('lang.vi')['home_page'] }}</a><span class="divider"></span></li>
    		<li class="active">{{ (session('lang'))?Config::get('lang.'.session('lang'))['checkout']:Config::get('lang.vi')['checkout'] }}</li>
  		</ul>
  		<!-- /.breadcrumb -->

  		<div class="row">
  			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
  				<h2 class="title text-center checkout">{{ (session('lang'))?Config::get('lang.'.session('lang'))['checkout']:Config::get('lang.vi')['checkout'] }}</h2>
  				<!-- /.title text-center -->
  			</div>
  		</div>

	  	<form action="{{ route('checkout') }}" method="post">
			{{ csrf_field() }}
			<div class="checkout-page">
				@if($cartItems->isEmpty())
					<div class="text-center">
						<span style="font-size: 14px">Giỏ hàng chưa có sản phẩm nào. Bạn cần tiến hành thêm hàng vào giỏ trước khi thanh toán. Xin cảm ơn!</span>
					</div>
					<a href="{!! url('/') !!}" class="btn btn-default pull-right functionButton">Về trang chủ</a>
				@else
			  		<div class="row">
						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
							<div class="your-order" style="height: 310px;">
								<h5 class="your-order-head">Đơn hàng của quý khách <a href="{{ route('getCartInfo') }}" class="backtocart">Chỉnh sửa</a></h5>
								<div class="your-order-body" style="padding: 15px 20px 60px;">
									<table class="table table-striped table-bordered">
						              	<tr>
							                <th class="name">Tên sản phẩm</th>
							                <th class="size">Kích cỡ</th>
							                <th class="quantity">Số lượng</th>
							                <th class="oprice">Đơn giá</th>
							                <th class="total">Thành tiền</th>
						              	</tr>
						              	<?php $count = 1; ?>
						              	@foreach ($cartItems as $item)
					              		<tr>
							                <td class="name"><a href="{{ route('productDetail', $item->id) }}">{{ $item->name }}</a></td>
							                <td class="size">{{ $item->size }}</td>
							                <td class="quantity">
							                	{{$item->qty}}
											</td>
							                <td class="oprice">{{ number_format($item->price, 0, ',', '.') }} VNĐ</td>
							                <td class="total">{{ number_format($item->price * $item->qty, 0, ',', '.') }} VNĐ</td>
						              	</tr>
						              	<?php $count++ ; ?>
						              	@endforeach
						            </table>
						            <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 pull-right">
						            	<table class="table table-striped table-bordered table2">
						            		<tr>
								                <td><span class="total-amount"><b>Mã giảm giá:</b></span></td>
								                <td><span class="total-amount pull-right"><input type="text" class="form-control" name="salecode" placeholder="Nhập mã nếu có"></span></td>
								               <input type="hidden" name="salecode_id">
							              	</tr>
							              	<tr>
								                <td><span class="total-amount"></span></td>
								                <td><button type="button" class="btn btn-defaul apply" >Áp dụng</button></td>
							              	</tr>
					      					<tr>
								                <td><span class="total-amount"><b>Tổng tiền:</b></span></td>
								                <td><span class="total-amount pull-right total-text" style="color: red; font-size: 16px;"><b><span id="total-money">{{ $total }}</span> VNĐ</b></span></td>
							              	</tr>
							            </table>
							            <div class="sale-noti">
							            	<div class="noti-text alert"></div>
							            </div>
						            </div>
								</div>
							</div>
							<!-- /.your-order -->
						</div>

						<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
							<div class="your-info">
								<h5 class="your-order-head">Địa chỉ giao hàng của quý khách</h5>

								<div class="col-xs-10 col-sm-8 col-md-8 col-lg-8 col-md-push-2">
									@if (count($errors) > 0)
									    <div class="error alert alert-danger">
									        <ul>
									            @foreach ($errors->all() as $error)
									                <li>{{ $error }}</li>
									            @endforeach
									        </ul>
									    </div>
									@endif
								</div>

								<div class="new-address">
									<div class="form-group">
				                    	<label>Họ tên <span class="asterisk">*</span></label>
										<input type="text" class="form-control" name="name" value="{{ Auth::check()?Auth::user()->name:'' }}">
				                    </div>

				                    <div class="form-group">
						                <label>Địa chỉ <span class="asterisk">*</label>
						                <br>
						                @if(Auth::check())
						                	<div class="col-md-4" style="padding-left: 0;">
							                    <select name="province" id="province" class="form-control">
							                        <option value="0">Tỉnh/Thành phố</option>
							                        @foreach($provinces as $item)
							                        <option value="{{ $item->provinceid }}" @if($province_id == $item->provinceid) selected @endif>{{ $item->name }}</option>
							                        @endforeach
							                    </select>
							                </div>
							                <div class="col-md-4" style="padding-left: 0;">
							                    <select name="district" id="district" class="form-control">
							                        <option value="0">Quận/Huyện</option>
							                        @foreach($districts as $item)
							                        <option value="{{ $item->districtid }}" @if($district_id == $item->districtid) selected @endif>{{ $item->name }}</option>
							                        @endforeach
							                    </select>
							                </div>
							                <div class="col-md-4" style="padding-left: 0;">
							                    <select name="ward" id="ward" class="form-control">
							                        <option value="0">Phường/Xã</option>
							                        @foreach($wards as $item)
							                        <option value="{{ $item->wardid }}" @if($ward_id == $item->wardid) selected @endif>{{ $item->name }}</option>
							                        @endforeach
							                    </select>
							                </div>
						                @else
							                <div class="col-md-4" style="padding-left: 0;">
							                    <select name="province" id="province" class="form-control">
							                        <option value="0">Tỉnh/Thành phố</option>
							                        @foreach($provinces as $item)
							                        <option value="{{ $item->provinceid }}">{{ $item->name }}</option>
							                        @endforeach
							                    </select>
							                </div>
							                <div class="col-md-4" style="padding-left: 0;">
							                    <select name="district" id="district" class="form-control" disabled>
							                        <option value="0">Quận/Huyện</option>
							                    </select>
							                </div>
							                <div class="col-md-4" style="padding-left: 0;">
							                    <select name="ward" id="ward" class="form-control" disabled>
							                        <option value="0">Phường/Xã</option>
							                    </select>
							                </div>
						                @endif
						                <div class="col-md-12" style="padding: 0;">
						                    <input type="text" style="margin: 7px 0 15px;" class="form-control" id="" name="address" placeholder="Nhập địa chỉ cụ thể (số nhã, ngõ, đường...)" value="{{ Auth::check()?Auth::user()->address:'' }}">
						                </div>
						            </div>

									<div class="form-group">
										<label>Số điện thoại <span class="asterisk">*</span></label>
										<input type="text" class="form-control" name="phone" value="{{ Auth::check()?Auth::user()->phone:'' }}">
									</div>

									<div class="form-group">
										<label>Email <span class="asterisk">*</span></label>
										<input type="email" class="form-control" name="email" value="{{ Auth::check()?Auth::user()->email:'' }}">
									</div>
									<div class="form-group">
										<label style="margin-right: 15px">Giới tính</label>
										<input type="radio" name="gender" value="1"
											@if (Auth::check())
												@if (Auth::user()->gender == '1')
													checked
												@endif
											@endif
										> Nam
										<input type="radio" name="gender" style="margin-left: 15px"  value="2"
											@if (Auth::check())
												@if (Auth::user()->gender == '2')
													checked
												@endif
											@endif
										> Nữ
									</div>
								</div>
								<!-- /.new-address -->

								<h5 class="your-order-head" style="border-top: 1px solid #e8e8e8">Phương thức thanh toán</h5>

								<div class="checkout-method">
									<p style="margin-left: 40px;">Ship COD</p>
								</div>
							</div>
							<!-- /.your-info -->
						</div>

						<button type="submit" class="btn btn-default functionButton" style="float: right; margin-top: 20px; margin-right: 15px">Thanh toán</button>
					</div>
				@endif
			</div>
		</form>
	</div>
</div>

@endsection
@section('custom javascript')
	<script>
		$(function(){
			$('.apply').on('click', function(){
				$('input[name="salecode_id"]').val('');
				var salecode = $('input[name="salecode"]').val();
				var url = "{!! route('checkSaleCode') !!}";
				$('.noti-text').show();
				$('.noti-text').removeClass("alert-danger");
				$('.noti-text').removeClass("alert-success");
				$.ajax({
					type: 'GET',
					url: url,
					dataType: 'json',
					data:{
						salecode: salecode
					}
				}).done(function(response){
					var alert_class = 'alert-danger';
					var noti_text = response.msg;
					if(response.state){
						alert_class = 'alert-success';
						var current_total = parseInt($('#total-money').text().split('.').join(''));
						var sale_percent = parseInt(response.data.salepercent);
						var total_money = Math.round(current_total * (100 - sale_percent)/100);
						total_money = total_money.toFixed().replace(/(\d)(?=(\d{3})+(,|$))/g, '$1.');
						$('#total-money').text(total_money);
						$('input[name="salecode_id"]').val(response.data.id);
					}
					$('.noti-text').addClass(alert_class);
					$('.noti-text').text(noti_text);
					$('.noti-text').slideUp(2000);
				});
			});
		});
	</script>
@stop