@extends('user.master')
@section('content')

<!-- <div id="mySlider" class="carousel slide mySlider" data-ride="carousel" data-wrap="true" data-interval="5000">
    <div class="section-container">
        <div>
            <ol class="carousel-indicators">
            	@for ($i = 0; $i <= 5 ; $i++)
	            	<?php $addClass = '';
	            	if($i == 0)
	            		$addClass = 'active';
	            	?>
            		<li class="{{ $addClass }}" data-target="#mySlider" data-slide-to="{{ $i }}"></li>
            	@endfor
            </ol>

			<?php $i = 0; ?>
            <div class="carousel-inner" role="listbox">
                @foreach ($large_banners as $large_banner)
	                <?php $addClass = '';
	                if($i == 0)
	                	$addClass = 'active';
	                $i ++ ;
	                ?>
                	<div class="item center {{ $addClass }}" style="background-image: url('{{ asset("resources/upload/images/banner/largebanner/large/".$large_banner->id."/".$large_banner->image) }}')">
                </div>
                @endforeach
            </div>

            <a href="#mySlider" class="left carousel-control" data-slide="prev">
                <i class="fa fa-angle-left" aria-hidden="true"></i>
            </a>
            <a href="#mySlider" class="right carousel-control" data-slide="next">
                <i class="fa fa-angle-right" aria-hidden="true"></i>
            </a>
        </div>
    </div>
</div> -->
<!-- /#mySlider -->

<div class="main-content" style="margin-top: 50px;">
	<div class="container">
		<div class="row">
			<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 main-left">
				<div class="promotion-news">
					<h2 class="title text-center">{{ (session('lang'))?Config::get('lang.'.session('lang'))['promotion_news']:Config::get('lang.vi')['promotion_news'] }}</h2>
					@foreach ($promotion_news as $promo)
						<div class="new-content">
							<a href=""><img src="{{ asset('resources/upload/images/news/thumbnail/'.$promo->n_id.'/'.$promo->image) }}" alt=""></a>
							<h5><a href="">{{ $promo->title }}</a></h5>
						</div>
					@endforeach
				</div>
				<!-- /.promotion-news -->

				<div class="sport-news">
					<h2 class="title text-center">{{ (session('lang'))?Config::get('lang.'.session('lang'))['sport_news']:Config::get('lang.vi')['sport_news'] }}</h2>
					<ul>
						<marquee behavior="scroll" direction="up" onmouseover="this.stop()" onmouseout="this.start()" scrollmount="3">
						@foreach ($sport_news as $sport_news)
							<li><i class="fa fa-angle-double-right"></i> <a href="">{{ $sport_news->title }}</a> <span class="news-date">( {{ Date('H:i:s - d/m/y', strtotime($sport_news->updated_at)) }} )</span></li>
						@endforeach
						</marquee>
					</ul>
				</div>
				<!-- /.sport-news -->

				<div class="advisory">
					<h2 class="title text-center">{{ (session('lang'))?Config::get('lang.'.session('lang'))['advisory']:Config::get('lang.vi')['advisory'] }}</h2>
					<ul>
					@foreach ($advisory_news as $advi)
						<li><i class="fa fa-angle-double-right"></i> <a href="">{{ $advi->title }}</a> <span class="news-date">( {{ $advi->updated_at }} )</span></li>
					@endforeach
					</ul>
				</div>
				<!-- /.advisory -->

				<div class="recruitment">
					<h2 class="title text-center">{{ (session('lang'))?Config::get('lang.'.session('lang'))['recruitment']:Config::get('lang.vi')['recruitment'] }}</h2>
					<ul>
						<marquee behavior="scroll" direction="up" onmouseover="this.stop()" onmouseout="this.start()" scrollmount="3">
						@foreach ($recruitment_news as $recuit)
							<li><i class="fa fa-angle-double-right"></i> <a href="">{{ $recuit->title }}</a> <span class="news-date">( {{ $recuit->updated_at }} )</span></li>
						@endforeach
						</marquee>
					</ul>
				</div>
				<!-- /.recruitment -->

				<div id="small-Slider" class="carousel slide mySlider" data-ride="carousel" data-wrap="true">
				    <div class="section-container">
				        <div>
				            <ol class="carousel-indicators">
				            	@for ($i = 0; $i <= 2 ; $i++)
				            	<?php $addClass = '';
				            	if($i == 0)
				            		$addClass = 'active';
				            	?>
				            	<li class="{{ $addClass }}" data-target="#small-Slider" data-slide-to="{{ $i }}"></li>
				            	@endfor
				            </ol>

							<?php $i = 0; ?>
				            <div class="carousel-inner" role="listbox">
				            	@foreach ($small_banners as $small_banner)
					            	<?php $addClass = '';
					            	if($i == 0)
					            		$addClass = 'active';
					            	$i ++ ;
					            	?>
				                	<div class="item center {{ $addClass }}" style="background-image: url('{{ asset("resources/upload/images/banner/smallbanner/large/".$small_banner->id."/".$small_banner->image) }}')">
				                </div>
				                @endforeach
				            </div>
				        </div>
				    </div>
				</div>
				<!-- /#small-Slider -->
			</div>
			<!-- /.main-left -->

			<div class="col-xs-12 col-sm-6 col-md-9 col-lg-9 main-right">
				<div class="newest-product">
					<h2 class="title text-center">{{ (session('lang'))?Config::get('lang.'.session('lang'))['newsest_product']:Config::get('lang.vi')['newsest_product'] }}</h2>

					@foreach ($newest_products as $newest_prod)
						<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
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

								{{-- Nếu ko có size thì có class no-size --}}
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
			          							<li class="listSize-item list {{ $size->qty > 0 ? 'active' : 'disabled' }}" @if($size->qty == 0) data-toggle="tooltip" title="Hết hàng" @endif size="{{ $size->id }}">{{ $size->value }}</li>
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

				<div class="category-tab cates">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<ul class="nav nav-tabs">
							<?php $i = 0; ?>
							@foreach ($cates as $cate)
								<?php $addHeaderClass = '';
									if($i == 0)
										$addHeaderClass = 'active';
									$i ++ ;
								?>
								<li class='{{ $addHeaderClass }}'><a href="#{{ $cate->alias }}" data-toggle="tab">{{ $cate->name }}</a></li>
							@endforeach
						</ul>
					</div>

					<?php $i = 0; ?>
					<div class="tab-content">
						@foreach ($cates as $cate)
						<?php $addClass = '';
							if($i == 0)
								$addClass = 'active in';
							$i ++ ;
						?>
						<div class="tab-pane fade {{ $addClass }}" id="{{ $cate->alias }}" >
							@foreach ($cate->newest_products as $newest_prod)
							<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
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
				          							<li class="listSize-item list {{ $size->qty > 0 ? 'active' : 'disabled' }}" @if($size->qty == 0) data-toggle="tooltip" title="Hết hàng" @endif size="{{ $size->id }}">{{ $size->value }}</li>
				          						@endforeach
				              					</ul>
				              				</div>
			              				@endif

										<div class="wishlist">
											@if(Auth::check())
												@if($newest_prod->is_liked == 1)
													<span  class="btn btn-xs add-to-wishlist" pro_id = "{{ $newest_prod->id }}" data-toggle="tooltip" title="Đã thích"><i class="fa fa-heart fa-lg" style="color: red;"></i></span>
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
						@endforeach
					</div>
					<!-- /.tab-content -->
				</div>
				<!-- /.category-tab -->

				<div class="category-tab sports">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<ul class="nav nav-tabs">
							<?php $i = 0; ?>
							@foreach ($sports as $sport)
								<?php $addHeaderClass = '';
									if($i == 0)
										$addHeaderClass = 'active';
									$i ++ ;
								?>
								<li class='{{ $addHeaderClass }}'><a href="#{{ $sport->alias }}" data-toggle="tab">{{ $sport->name }}</a></li>
							@endforeach
						</ul>
					</div>

					<?php $i = 0; ?>
					<div class="tab-content">
						@foreach ($sports as $sport)
						<?php $addClass = '';
							if($i == 0)
								$addClass = 'active in';
							$i ++ ;
						?>
						<div class="tab-pane fade {{ $addClass }}" id="{{ $sport->alias }}" >
							@foreach ($sport->newest_products as $newest_prod)
							<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
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
				          							<li class="listSize-item list {{ $size->qty > 0 ? 'active' : 'disabled' }}" @if($size->qty == 0) data-toggle="tooltip" title="Hết hàng" @endif size="{{ $size->id }}">{{ $size->value }}</li>
				          						@endforeach
				              					</ul>
				              				</div>
			              				@endif

										<div class="wishlist">
											@if(Auth::check())
												@if($newest_prod->is_liked == 1)
													<span  class="btn btn-xs add-to-wishlist" pro_id = "{{ $newest_prod->id }}" data-toggle="tooltip" title="Đã thích"><i class="fa fa-heart fa-lg" style="color: red;"></i></span>
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
						@endforeach
					</div>
					<!-- /.tab-content -->
				</div>
				<!-- /.category-tab -->

				<div class="category-tab brands">
					<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
						<ul class="nav nav-tabs">
							<?php $i = 0; ?>
							@foreach ($brands as $brand)
								<?php $addHeaderClass = '';
									if($i == 0)
										$addHeaderClass = 'active';
									$i ++ ;
								?>
								<li class='{{ $addHeaderClass }}'><a href="#{{ $brand->alias }}" data-toggle="tab">{{ $brand->name }}</a></li>
							@endforeach
						</ul>
					</div>

					<?php $i = 0; ?>
					<div class="tab-content">
						@foreach ($brands as $brand)
						<?php $addClass = '';
							if($i == 0)
								$addClass = 'active in';
							$i ++ ;
						?>
						<div class="tab-pane fade {{ $addClass }}" id="{{ $brand->alias }}" >
							@foreach ($brand->newest_products as $newest_prod)
							<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
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
				          							<li class="listSize-item list {{ $size->qty > 0 ? 'active' : 'disabled' }}" @if($size->qty == 0) data-toggle="tooltip" title="Hết hàng" @endif size="{{ $size->id }}">{{ $size->value }}</li>
				          						@endforeach
				              					</ul>
				              				</div>
			              				@endif

										<div class="wishlist">
											@if(Auth::check())
												@if($newest_prod->is_liked == 1)
													<span class="btn btn-xs add-to-wishlist" pro_id = "{{ $newest_prod->id }}" data-toggle="tooltip" title="Đã thích"><i class="fa fa-heart fa-lg" style="color: red;"></i></span>
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
						@endforeach
					</div>
					<!-- /.tab-content -->
				</div>
				<!-- /.category-tab -->


				<!-- Sản phẩm đc yêu thích nhiều -->
				@if (count($products1) > 0)
				<div class="favorited-product best-sell-product">
					<h2 class="title text-center">{{ (session('lang'))?Config::get('lang.'.session('lang'))['favorited_product']:Config::get('lang.vi')['favorited_product'] }}</h2>

					<div id="best-sell-product-carousel" class="carousel slide" data-ride="carousel">
						<div class="carousel-inner">
							<div class="item active">
								@foreach ($products1 as $newest_prod)
									<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
										<div class="product-info text-center">
											<a href="{{ route('productDetail', $newest_prod->pro_id) }}"><img src="{{ asset('resources/upload/images/product/small/'.$newest_prod->pro_id.'/'.$newest_prod->image) }}" /></a>

											<p class="pro-name"><a href="{{ route('productDetail', $newest_prod->pro_id) }}">{{ $newest_prod->name }}</a></p>

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

											<div class="action @if(count($newest_prod->sizes) <= 0) no-size @endif" pro_id="{{ $newest_prod->pro_id }}"  style="position:relative">
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
						          							<li class="listSize-item list {{ $size->qty > 0 ? 'active' : 'disabled' }}" @if($size->qty == 0) data-toggle="tooltip" title="Hết hàng" @endif size="{{ $size->id }}">{{ $size->value }}</li>
						          						@endforeach
						              					</ul>
						              				</div>
						          				@endif

												<div class="wishlist">
													@if(Auth::check())
														@if($newest_prod->is_liked == 1)
															<span  class="btn btn-xs add-to-wishlist" pro_id = "{{ $newest_prod->pro_id }}" data-toggle="tooltip" title="Đã thích"><i class="fa fa-heart fa-lg" style="color: red;"></i></span>
														@else
				                            				<span style="cursor: pointer" class="btn btn-xs add-to-wishlist" pro_id = "{{ $newest_prod->pro_id }}"><i class="fa fa-heart fa-lg"></i></span>
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

							<div class="item">
								@foreach ($products2 as $newest_prod)
									<div class="col-xs-6 col-sm-6 col-md-4 col-lg-4">
										<div class="product-info text-center">
											<a href="{{ route('productDetail', $newest_prod->pro_id) }}"><img src="{{ asset('resources/upload/images/product/small/'.$newest_prod->pro_id.'/'.$newest_prod->image) }}" /></a>

											<p class="pro-name"><a href="{{ route('productDetail', $newest_prod->pro_id) }}">{{ $newest_prod->name }}</a></p>

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

											<div class="action @if(count($newest_prod->sizes) <= 0) no-size @endif" pro_id="{{ $newest_prod->pro_id }}"  style="position:relative">
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
						          							<li class="listSize-item list {{ $size->qty > 0 ? 'active' : 'disabled' }}" @if($size->qty == 0) data-toggle="tooltip" title="Hết hàng" @endif size="{{ $size->id }}">{{ $size->value }}</li>
						          						@endforeach
						              					</ul>
						              				</div>
						          				@endif

												<div class="wishlist">
													@if(Auth::check())
														@if($newest_prod->is_liked == 1)
															<span  class="btn btn-xs add-to-wishlist" pro_id = "{{ $newest_prod->pro_id }}" data-toggle="tooltip" title="Đã thích"><i class="fa fa-heart fa-lg" style="color: red;"></i></span>
														@else
				                            				<span style="cursor: pointer" class="btn btn-xs add-to-wishlist" pro_id = "{{ $newest_prod->pro_id }}"><i class="fa fa-heart fa-lg"></i></span>
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
						</div>

						<a class="left best-sell-product-control" href="#best-sell-product-carousel" data-slide="prev">
							<i class="fa fa-angle-left" aria-hidden="true"></i>
						</a>
						<a class="right best-sell-product-control" href="#best-sell-product-carousel" data-slide="next">
							<i class="fa fa-angle-right" aria-hidden="true"></i>
						</a>
					</div>
				</div>
				@endif
				<!-- /.favorited-product -->

			</div>
			<!-- /.main-right -->
		</div>
	</div>
</div>
<!-- /.main-content -->
@endsection

