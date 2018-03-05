@extends('user.master')
@section('content')

<div class="wishlist">
	<div class="container">
		<ul class="breadcrumb">
			<li>
				<a href="#">Trang chủ</a>
				<span class="divider"></span>
			</li>
			<li class="active">Danh Sách Yêu Thích</li>
		</ul>
		<!-- /.breadcrumb -->
		<div class="wishlist-page">
			<h2 class="title text-center">Danh Sách Yêu Thích</h2>

			@include('user.blocks.error')

			@if (count($products) == 0)
				<div class="text-center">
					<span style="font-size: 14px">Bạn chưa yêu thích sản phẩm nào</span>
				</div>
				<a href="{!! url('/') !!}" class="btn btn-default pull-right functionButton">Về trang chủ</a>
			@else
				@foreach ($products as $prod)
					<div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
						<div class="product-info text-center" pro_id = {{ $prod->id }} style="position: relative">
							<span title="Xóa khỏi danh sách yêu thích" class="btn btn-danger delete-like" style="position:absolute; padding: 3px 9px;border-radius: 100%; right: 5px; top: 5px; cursor: pointer">&times;</span>
							<a href="{{ route('productDetail', $prod->id) }}"><img src="{{ asset('resources/upload/images/product/small/'.$prod->id.'/'.$prod->image) }}" /></a>
							<h2>{{ $prod->price }} VNĐ</h2>
							<p><a href="">{{ $prod->name }}</a></p>
							<div class="action @if(count($prod->sizes) <= 0) no-size @endif" pro_id="{{ $prod->id }}"  style="position:relative">
								@if(count($prod->sizes) > 0)
									<div class="size show-size">
		          						<div class="chooseSize">
		          							<span>
		          								Chọn kích cỡ
		          							</span>
		              						<span class="pull-right close-popup" style="cursor:pointer">&times;</span>
		              					</div>
		              					<!-- /.chooseSize -->
		              					<ul class="listSize">
		          						@foreach ($prod->sizes as $size)
		          							<li class="listSize-item list {{ $size->qty > 0 ? 'active' : 'disabled' }}" @if($size->qty == 0) data-toggle="tooltip" title="Hết hàng" @endif size="{{ $size->value }}">{{ $size->value }}</li>
		          						@endforeach
		              					</ul>
		              				</div>
		          				@endif

		                		<button class="btn btn-default add-to-cart" data-toggle="tooltip" title="Thêm 1 sản phẩm vào giỏ hàng"><i class="fa fa-shopping-cart"></i> Thêm vào giỏ</button>
							</div>
							<!-- /.action -->
						</div>
					</div>
				@endforeach
			@endif
		</div>
		<!-- /.wishlist-page -->
	</div>
</div>
<!-- /.wishlist -->

@endsection