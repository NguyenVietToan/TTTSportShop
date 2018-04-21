@extends('user.master')
@section('content')

<div class="shopping-cart">
	<div class="container">
		<ul class="breadcrumb">
    		<li><a href="{{ url('trang-chu') }}"><i class="fa fa-home" aria-hidden="true"></i> {{ (session('lang'))?Config::get('lang.'.session('lang'))['home_page']:Config::get('lang.vi')['home_page'] }}</a><span class="divider"></span></li>
    		<li class="active">{{ (session('lang'))?Config::get('lang.'.session('lang'))['cart']:Config::get('lang.vi')['cart'] }}</li>
  		</ul>
  		<!-- /.breadcrumb -->


  		<div class="cart-page">
  			<div class="row" id="updateDiv">
  				<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
  					<h2 class="title text-center">{{ (session('lang'))?Config::get('lang.'.session('lang'))['cart']:Config::get('lang.vi')['cart'] }}</h2>
						@if (Session::has('flash_message'))
				            <div class="message alert alert-{{ Session::get('flash_level') }}">
				                <p class="text-center">{{ Session::get('flash_message') }}</p>
				            </div>
				        @endif

	  					@if($cartItems->isEmpty())
	  						<div class="text-center">
	  							<span style="font-size: 14px">Giỏ hàng chưa có sản phẩm nào</span>
	  							<img src="{{ asset('public/user/images/menu_logo.gif') }}" alt="">
	  						</div>
	  						<a href="{{ route('getHome') }}" class="btn btn-default pull-right functionButton">Tiếp tục mua sắm</a>

						@else

  					<div class="cart-detail">
  						@include('user.blocks.error')

			            <table class="table table-striped table-bordered">
			              	<tr>
				                <th class="image">Hình Ảnh</th>
				                <th class="name">Tên sản phẩm</th>
				                <th class="size">Kích cỡ</th>
				                <th>Còn lại</th>
				                <th class="quantity">Số lượng đặt</th>
				                <th class="cprice">Đơn giá</th>
				                <th class="ctotal">Tổng</th>
				                <th></th>
			              	</tr>

							<?php $count = 1;?>
			              	@foreach ($cartItems as $item)
		              		<tr>
				                <td class="image">
				                	<a href="{{ route('productDetail', $item->id) }}">
				                		<img title="product" alt="product" src="{{ asset('resources/upload/images/product/thumbnail/'.$item->id.'/'.$item->options->image) }}">
				                	</a>
				                </td>
				                <td class="name"><a href="{{ route('productDetail', $item->id) }}">{{ $item->name }}</a></td>
				                <td class="size">{{ $item->options->size }}</td>
				                <td>{{ $item->options->maxQty }}</td>
				                <td class="quantity">
				                	<div class="quantity-button">
				                		<input type="hidden" class="rowId" id="rowId<?php echo $count; ?>" value="{{$item->rowId}}"/>
				                		<input type="hidden" class="proId" id="proId<?php echo $count; ?>" value="{{$item->id}}"/>
				                		<input type="number" size="2" class="changeQty" value="{{$item->qty}}" name="qty"
				                			   id="changeQty<?php echo $count; ?>"
				                			   autocomplete="off"
				                			   style="text-align:center; max-width:50px;"
				                			   min="1" max="{{ $item->options->maxQty }}"
				                		/>
				                	</div>
								</td>
				                <td class="cprice">{{ number_format($item->price, 0, ',', '.') }} VNĐ</td>
				                <td class="ctotal">{{ number_format($item->price * $item->qty, 0, ',', '.') }} VNĐ</td>
				                <td class="delete">
				                	<a href="{{ route('getDeleteItem', $item->rowId) }}" class="delete-item" data-toggle="tooltip" title="Xóa sản phẩm này?"><i class="fa fa-trash-o"></i></a>
				                </td>
			              	</tr>
			              	<?php $count++;?>
			              	@endforeach

			            </table>
		          	</div>
  				</div>

  				<div class="col-xs-12 col-sm-8 col-md-5 col-lg-5 pull-right table2">
  					<table class="table table-striped table-bordered">
      					<tr>
			                <td><span class="total-amount">Tổng tiền:</span></td>
			                <td><span class="total-amount pull-right">{{ $total }} VNĐ</span></td>
		              	</tr>
		            </table>
		            <a href="{{ url('trang-chu') }}" class="btn btn-default pull-left functionButton" >Tiếp tục mua hàng</a>
		            <a href="{{  route('getDeliveryAddress') }}" value="Thanh toán" class="btn btn-default pull-right functionButton">Thanh toán</a>
  				</div>
  					@endif
  			</div>
  		</div>
  		<!-- /.cart-page -->
	</div>
</div>
<!-- /.shopping-cart -->

<script type="text/javascript">

	//Thay đổi số lượng sản phẩm
	$(document).ready(function(){
		<?php
			for($i=1; $i<20; $i++) {
		?>
			$('#changeQty<?php echo $i;?>').on('change keyup', function() {
				var newqty = $('#changeQty<?php echo $i;?>').val();
				var rowId = $('#rowId<?php echo $i;?>').val();
				var proId = $('#proId<?php echo $i;?>').val();

				//nếu ko phải số (Not a Number) thì sau đó sẽ tự động set lại = 1
				//nếu là số thì so sánh với số lượng sp còn lại
				//nếu > thì báo lỗi và sau đó sẽ tự động set lại = max_qty
				if (isNaN(parseInt(newqty))) {
					alert('Vui lòng nhập số lượng hợp lệ, ít nhất 1 sản phẩm !');
					newqty = parseInt($(this).val());
					$(this).val(1);
				} else {
					var max_qty = parseInt($(this).attr('max'));
					newqty = parseInt(newqty);
					if (newqty > max_qty) {
						alert('Số lượng sản phẩm có thể đặt tối đa là ' + max_qty);
						$(this).val(max_qty);
						newqty = max_qty;
					}
					$.ajax({
						type: 'get',
						dataType: 'html',
						url: '<?php echo url('/gio-hang/sua');?>/'+proId,
						data: "qty=" + newqty + "& rowId=" + rowId + "& proId=" + proId,
						success: function (response) {
							console.log(response);
							$('#updateDiv').html(response);
						}
					});
				}
			});
		<?php
			}
		?>
	});


	//Tooltip hiển thị text khi hover
	$(document).ready(function(){
	    $('[data-toggle="tooltip"]').tooltip();
	});

</script>

@endsection