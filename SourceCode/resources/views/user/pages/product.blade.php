@extends('user.master')
@section('content')

<div class="main-content">
	<div class="container">
		<ul class="breadcrumb">
    		<li><a href=""><i class="fa fa-home" aria-hidden="true"></i> {{ (session('lang'))?Config::get('lang.'.session('lang'))['home_page']:Config::get('lang.vi')['home_page'] }}</a><span class="divider"></span></li>
    		<li class="active">Sản phẩm</li>
  		</ul>
  		<!-- /.breadcrumb -->

		<div class="row">
			<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
				<div class="sidebar-left">
					<div class="product-sort list-group">
						<h2>{{ (session('lang'))?Config::get('lang.'.session('lang'))['sort']:Config::get('lang.vi')['sort'] }}</h2>
						<div class="sort-prod">
							<select name="sort" id="" class="form-control itemFilter sort">
								<option value="">Chọn để sắp xếp</option>
								@foreach ($sorts as $key => $value)
									<option type="checkbox" class="itemFilter sort" value="{{ $key }}"
										@if (!empty($sort))
											@if ($sort == $key)
												selected
											@endif
										@endif
									>{{ $value }}</option>
								@endforeach
							</select>
						</div>
					</div><!-- /.product-sort -->

					<div class="product-sport list-group">
						<h2>{{ (session('lang'))?Config::get('lang.'.session('lang'))['sport']:Config::get('lang.vi')['sport'] }}</h2>
						<div class="name">
							<ul class="nav nav-pills nav-stacked">
							@if(count($sports) > 1)
								@foreach ($sports as $sp)
									<li>
										<input type="checkbox" class="itemFilter sport" value="{{ $sp->id }}"
											@if (!empty($sport))
												@if (in_array($sp->id, $sport))
													checked
												@endif
											@endif
										/>
										{{ ucwords($sp->name) }}
									</li>
								@endforeach
							@else
								<li>
									<input type="checkbox" class="itemFilter sport" value="{{ $sports->id }}" checked disabled> {{ $sports->name }}
								</li>
							@endif
							</ul>
						</div>
					</div><!-- /.product-sport -->

					<div class="product-cate list-group">
						<h2>{{ (session('lang'))?Config::get('lang.'.session('lang'))['category']:Config::get('lang.vi')['category'] }}</h2>
						<div class="name">
							<ul class="nav nav-pills nav-stacked">
								@if(count($cates) > 1)
									@foreach ($cates as $ct)
									<li>
										<input type="checkbox" class="itemFilter cate" value="{{ $ct->id }}"
											@if (!empty($cate))
												@if (in_array($ct->id, $cate))
													checked
												@endif
											@endif
										/>
										{{ ucwords($ct->name) }}
									</li>
									@endforeach
								@else
									<li>
										<input type="checkbox" class="itemFilter cate" value="{{ $cates->id }}" checked disabled> {{ $cates->name }}
									</li>
								@endif
							</ul>
						</div>
					</div><!-- /.product-cate -->

					<div class="product-brand list-group">
						<h2>{{ (session('lang'))?Config::get('lang.'.session('lang'))['brand']:Config::get('lang.vi')['brand'] }}</h2>
						<div class="name">
							<ul class="nav nav-pills nav-stacked">
								@if(count($brands) > 1)
									@foreach ($brands as $br)
									<li>
										<input type="checkbox" class="itemFilter brand" value="{{ $br->id }}"
											@if (!empty($brand))
												@if (in_array($br->id, $brand))
													checked
												@endif
											@endif
										/>
										{{ ucwords($br->name) }}
									</li>
									@endforeach
								@else
									<li>
										<input type="checkbox" class="itemFilter brand" value="{{ $brands->id }}" checked disabled> {{ $brands->name }}
									</li>
								@endif
							</ul>
						</div>
					</div><!-- /.product-brand -->

					<div class="product-gender list-group">
						<h2>{{ (session('lang'))?Config::get('lang.'.session('lang'))['gender']:Config::get('lang.vi')['gender'] }}</h2>
						<div class="name">
							<ul class="nav nav-pills nav-stacked">
								@foreach ($genders as $key => $gen)
								<li>
									<input type="checkbox" class="itemFilter gender" value="{{ $key }}"
										@if (!empty($gender))
											@if (in_array($key, $gender))
												checked
											@endif
										@endif
									/>
									{{ ucwords($gen) }}
								</li>
								@endforeach
							</ul>
						</div>
					</div><!-- /.product-gender -->

					<div class="price-range list-group">
						<h2>{{ (session('lang'))?Config::get('lang.'.session('lang'))['filter_price']:Config::get('lang.vi')['filter_price'] }}</h2>
						<input type="hidden" class="sprice" value="{{ isset($sprice) ? $sprice : 100000 }}">
					    <input type="hidden" class="eprice" value="{{ isset($eprice) ? $eprice : 10000000 }}">
						<p id="priceshow"></p>
					    <div id="slider-range"></div>
					</div><!-- /.price-range -->
				</div>
				<!-- /.sidebar-left -->
			</div>

			<div class="col-xs-9 col-sm-9 col-md-9 col-lg-9" id="updateDiv">
				<div class="newest-product">
					<h2 class="title text-center">{{ (session('lang'))?Config::get('lang.'.session('lang'))['products']:Config::get('lang.vi')['products'] }}</h2>
					@foreach ($all_products as $newest_prod)
					<div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
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
												<span  class="btn btn-xs add-to-wishlist" pro_id = "{{ $newest_prod->id }}"><i class="fa fa-heart fa-lg" style="color: red;"></i></span>
											@else
	                            				<span style="cursor: pointer" class="btn btn-xs add-to-wishlist" pro_id = "{{ $newest_prod->id }}"><i class="fa fa-heart fa-lg"></i></span>
                            				@endif
										@else
											<a class="btn btn-xs" href="{{ route('getWishList') }}"><i class="fa fa-heart fa-lg"></i></a>
										@endif
	                        		<span class="like_count">{{ $newest_prod->like }}</span>
								</div>
								<!-- /.wishlist -->

                        		<button class="btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i> Thêm vào giỏ</button>
							</div>
							<!-- /.action -->
						</div>
					</div>
					@endforeach
				</div>
				<!-- /.newest-product -->

				@if (isset($sport) || isset($brand) || isset($cate) || isset($gender) || isset($sprice) || isset($eprice) || isset($sort))
				<ul class="pagination">
					{!! $all_products->appends(['sort' => $sort, 'sport' => $sport, 'cate' => $cate, 'brand' => $brand, 'gender' => $gender, 'sprice' => $sprice, 'eprice' => $eprice])->render() !!}
				</ul>
				@else
				<ul class="pagination">
					{!! $all_products->render() !!}
				</ul>
				@endif
				<!-- /.pagination -->
			</div>
		</div>
	</div>
</div>
<!-- /.main-content -->

<script>
	URL_GET_PRODUCT_AJAX = {!! json_encode(['url' => route('getProductAjax'), 'paginate_url' => $paginateUrl]) !!}   //  hàm json_encode($array) sẽ chuyển mảng $array thành 1 chuỗi json
</script>

@endsection