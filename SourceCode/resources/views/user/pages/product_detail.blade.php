@extends('user.master')
@section('content')

<div class="main-content">
	<div class="container">
		<ul class="breadcrumb">
    		<li>
      			<a href="#">Trang chủ</a>
      			<span class="divider"></span>
    		</li>
    		<li>
      			<a href="#">Sản phẩm</a>
      			<span class="divider"></span>
    		</li>
    		<li class="active">{{ $product_detail->name }}</li>
  		</ul>
  		<!-- /.breadcrumb -->

		<div class="product-details">
			<div class="row">
				<div class="col-xs-12 col-sm-6 col-md-5">
					<div class="product-images">
						<div class="xzoom-container">
							<img class="xzoom5" id="xzoom-magnific" width="400" src="{{ asset('resources/upload/images/product/small/'.$product_detail->id.'/'.$product_detail->image) }}" xoriginal="{{ asset('resources/upload/images/product/large/'.$product_detail->id.'/'.$product_detail->image) }}" />
							<div class="xzoom-thumbs">
								<a href="{{ asset('resources/upload/images/product/large/'.$product_detail->id.'/'.$product_detail->image) }}">
									<img class="xzoom-gallery5" width="80" src="{{ asset('resources/upload/images/product/thumbnail/'.$product_detail->id.'/'.$product_detail->image) }}"  xpreview="{{ asset('resources/upload/images/product/small/'.$product_detail->id.'/'.$product_detail->image) }}" >
								</a>

								@foreach ($prod_images as $pimage)
								<a href="{{ asset('resources/upload/images/product/large/'.$id.'/detail/'.$pimage->name) }}">
									<img class="xzoom-gallery5" width="80" src="{{ asset('resources/upload/images/product/small/'.$id.'/detail/'.$pimage->name) }}" >
								</a>
								@endforeach
							</div>
						</div>
					</div>
					<!-- /.product-images -->
				</div>

				<div class="col-xs-12 col-sm-6 col-md-7">
					<div class="row">
						<div class="col-xs-12" pro_id="{{ $product_detail->id}}">
							<h1 class="productname"><span class="bgnone">{{ $product_detail->name }}</span></h1>
              				<div class="productprice col-md-12">
	              				@if ($product_detail->sale_price == null)
									<p class="pro_price">{{ number_format($product_detail->price, 0, ',', '.') }} VNĐ</p>
								@else
									<ul>
										<li class="old_price">{{ number_format($product_detail->price, 0, ',', '.') }} VNĐ</li>
	                                	<li class="sale_price">{{ number_format($product_detail->sale_price, 0, ',', '.') }} VNĐ</li>
	                                	<li class="sale_big">Sale</li>
									</ul>
								@endif
              				</div>

              				<div class="wishlist">
								@if(Auth::check())
									@if($product_detail->is_liked == 1)
										<span class="btn btn-xs add-to-wishlist" pro_id = "{{ $product_detail->id }}"><i class="fa fa-heart fa-lg" style="color: red;"></i></span>
									@else
	                    				<span style="cursor: pointer" class="btn btn-xs add-to-wishlist" pro_id = "{{ $product_detail->id }}"><i class="fa fa-heart fa-lg"></i></span>
	                				@endif
								@else
									<a class="btn btn-xs" href="{{ route('getWishList') }}" data-toggle="tooltip" title="Thêm vào danh sách yêu thích"><i class="fa fa-heart fa-lg"></i></a>
								@endif
	                    		<span class="like_count">{{ $product_detail->like }}</span>
							</div>
							<!-- /.wishlist -->

              				<div class="row" pro_id="{{ $product_detail->id }}">
								@if(count($sizes) > 0)
		              				<div class="size col-sm-4">
		              					<div class="size-header">
		              						<div class="chooseSize">
		          								Chọn kích cỡ để thêm hàng vào giỏ
			              					</div>
		              					</div>

		              					<!-- /.chooseSize -->
		              					<ul class="listSize">
		          						@foreach ($sizes as $size)
		          							<li class="listSize-item list-detail {{ $size->qty > 0 ? 'active' : 'disabled' }}" @if($size->qty == 0) data-toggle="tooltip" title="Hết hàng" @endif size="{{ $size->id }}">{{ $size->value }}</li>
		          						@endforeach
		              					</ul>
		              				</div>
		              			@else
			              			<div class="nosize col-sm-4" style="margin-top: 10px;">
			              				<ul style="padding-left: 0" class="action no-size" pro_id="{{ $product_detail->id }}">
							                <li>
							                	<a class="cart btn btn-primary add-to-cart-detail" href="#"><i class="fa fa-shopping-cart" style="margin-right: 5px;"></i>Thêm vào giỏ
							                	</a>
							                </li>
			              				</ul>
			              			</div>
	              				@endif
              				</div>
						</div>

						<br>

						<div class="col-xs-12">
							<div class="category-tab product-details-tab">
								<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding: 0;">
									<ul class="nav nav-tabs">
										<li class="active"><a href="#introduction" data-toggle="tab">Giới thiệu sản phẩm</a></li>
										<li><a href="#specification" data-toggle="tab">Thông tin sản phẩm</a></li>
										<li><a href="#reviews" data-toggle="tab">Đánh giá ({{ $count_review }})</a></li>
									</ul>
								</div>

								<div class="tab-content">
									<div class="tab-pane fade active in" id="introduction" >
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			            					{!! $product_detail->description !!}
										</div>
									</div>
									<!-- /#introduction -->

									<div class="tab-pane fade" id="specification" >
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											{!! $product_detail->info !!}
										</div>
									</div>
									<!-- /#specification -->

									<div class="tab-pane fade" id="reviews" >
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											@foreach ($reviews as $review)
												<div class="review" style="margin-bottom: 20px; border-bottom: 1px dotted #bdc3c7">
													<ul>
														<li><i class="fa fa-user"></i>{{ $review->person_name }}</li>
														<li><i class="fa fa-clock-o"></i>{{ date('H: i', strtotime($review->created_at)) }}</li>
														<li><i class="fa fa-calendar-o"></i>{{ date('F j, Y', strtotime($review->created_at)) }}</li>
													</ul>
													<p>{{ $review->review_content }}</p>
												</div>
											@endforeach
											<p style="color: #FF9800; font-size: 15px;"><b>Đánh giá của bạn</b></p>

											<form action="{{ route('addReview') }}" method="post">
												{{ csrf_field() }}
												<span>
													<input type="hidden" name="pro_id" value="{{ $product_detail->id }}" >
													<input type="text" name="person_name" placeholder="Tên của bạn"/ required>
													<input type="email" name="person_email" placeholder="Email"/ required>
												</span>
												<textarea name="review_content" required></textarea>
												<button type="submit" class="btn btn-default pull-right">Gửi đánh giá</button>
											</form>
										</div>
									</div>
									<!-- /#reviews -->
								</div>
							</div>
							<!--/category-tab-->

						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- /.product-details -->

		<div class="product-similar row">
			<h2 class="title text-center">Sản phẩm tương tự</h2>
			@foreach ($similar_products as $newest_prod)
				<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
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
			  							<li class="listSize-item list {{ $size->qty > 0 ? 'active' : 'disabled' }}" @if($size->qty == 1) data-toggle="tooltip" title="Hết hàng" @endif size="{{ $size->id }}">{{ $size->value }}</li>
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

		<div class="row paginate pull-left" style="margin-top: 20px;">@include('pagination.paging', ['paginator' => $similar_products])</div>
		<!-- /.product-similar -->

	</div>
</div>
<!-- /.main-content -->

@endsection


@section('custom javascript')
<script type="text/javascript">
	$(document).ready(function() {
		// XZoom: zoom ảnh chi tiết của sản phẩm
		$(".xzoom5, .xzoom-gallery5").xzoom({tint: '#333', Xoffset: 15});
	});
</script>
@endsection







