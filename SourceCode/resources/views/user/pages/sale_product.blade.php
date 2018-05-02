@extends('user.master')
@section('content')

<div class="container">
	<ul class="breadcrumb">
		<li><a href="{{ url('trang-chu') }}"><i class="fa fa-home" aria-hidden="true"></i> {{ (session('lang'))?Config::get('lang.'.session('lang'))['home_page']:Config::get('lang.vi')['home_page'] }}</a>
      			<span class="divider"></span></li>
		<li class="active">{{ (session('lang'))?Config::get('lang.'.session('lang'))['promotion']:Config::get('lang.vi')['promotion'] }}</li>
	</ul>
	<!-- /.breadcrumb -->

	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<h2 class="title text-center">{{ (session('lang'))?Config::get('lang.'.session('lang'))['sale_product']:Config::get('lang.vi')['sale_product'] }}</h2>

			@if (count($sale_products) == 0)
				<div class="row">
					<div class="search-result">
						<p class="pull-left">Không có sản phẩm khuyến mãi nào. Hẹn bạn một dịp khác nha! Mong bạn tiếp tục ủng hộ cửa hàng của chúng tôi</p>
						<div class="clear-fix"></div>
					</div>
				</div>
			@else
				<div class="row">
					@foreach ($sale_products as $newest_prod)
						<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
							<div class="product-info text-center">
								<a href="{{ route('productDetail', $newest_prod->id) }}"><img src="{{ asset('resources/upload/images/product/small/'.$newest_prod->id.'/'.$newest_prod->image) }}" /></a>

								<p class="pro-name"><a href="{{ route('productDetail', $newest_prod->id) }}">{{ $newest_prod->name }}</a></p>

								@if ($newest_prod->sale_price == null)
									<p style="padding-bottom: 10px"></p>
									<p class="price">{{ number_format($newest_prod->price, 0, ',', '.') }} VNĐ</p>
								@else
									<div class="ribbon-wrapper"><div class="ribbon sale">Sale</div></div>
									<div>
										<p class="old-price">{{ number_format($newest_prod->price, 0, ',', '.') }} VNĐ</p>
	                                	<p class="sale-price">{{ number_format($newest_prod->sale_price, 0, ',', '.') }} VNĐ</p>
									</div>
								@endif

								<div class="action @if(count($newest_prod->sizes) <= 0) no-size @endif" pro_id="{{ $newest_prod->id }}"  style="position:relative">
									@if(count($newest_prod->sizes) > 0)
										<div class="size show-size">
					  						<div class="chooseSize">
					  							<span>
					  								Chọn kích cỡ
					  							</span>
					      						<span class="pull-right close-popup" style="cursor:pointer">&times;</span>
					      					</div>
					      					<!-- /.chooseSize -->
					      					<ul class="listSize">
					  						@foreach ($newest_prod->sizes as $size)
					  							<li class="listSize-item list {{ $size->qty > 0 ? 'active' : 'disabled' }}" @if($size->qty == 0) data-toggle="tooltip" title="Hết hàng" @endif size="{{ $size->value }}">{{ $size->value }}</li>
					  						@endforeach
					      					</ul>
					      				</div>
					  				@endif

									<div class="wishlist">
										@if(Auth::check())
											@if($newest_prod->is_liked == 1)
												<span  class="btn btn-xs add-to-wishlist" pro_id = "{{ $newest_prod->id }}" data-toggle="tooltip" title="Đã thích"><i class="fa fa-heart fa-lg" style="color: red;"></i></span>
											@else
	                            				<span style="cursor: pointer" class="btn btn-xs add-to-wishlist" pro_id = "{{ $newest_prod->id }}" data-toggle="tooltip" title="Thêm vào danh sách yêu thích"><i class="fa fa-heart fa-lg"></i></span>
	                        				@endif
										@else
											<a class="btn btn-xs" href="{{ route('getWishList') }}" data-toggle="tooltip" title="Thêm vào danh sách yêu thích"><i class="fa fa-heart fa-lg"></i></a>
										@endif
		                        		<span class="like_count">{{ $newest_prod->like }}</span>
									</div>
									<!-- /.wishlist -->

					        		<button class="btn btn-default add-to-cart" data-toggle="tooltip" title="Thêm 1 sản phẩm vào giỏ hàng"><i class="fa fa-shopping-cart"></i> Thêm vào giỏ</button>
								</div>
								<!-- /.action -->
							</div>
						</div>
					@endforeach
				</div>

				<div class="row">
					<ul class="pagination">
						{!! $sale_products->render() !!}
					</ul>
				</div>
			@endif
		</div>
	</div>
</div>

@endsection