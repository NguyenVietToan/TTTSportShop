@extends('admin.master')
@section('controller', 'Đơn hàng')
@section('action', 'Sửa')
@section('breadcrumb', 'Quản lý đơn hàng')
@section('content')

<section class="content">
    <div class="col-xs-12 col-sm-8 col-md-6 col-sm-push-2 col-md-push-3">
        @include('admin.blocks.error')

        <form class="form-horizontal" id="update-order-form" action="{{ route('admin.order.postEdit') }}" method="POST" role="form" enctype="multipart/form-data">
        	<input type="hidden" name="_token" value="{{ csrf_token() }}">
        	<input type="hidden" name="id" value="{!! $order->id !!}">

        	@if (count($errors) > 0)
	        	<div class="error alert alert-danger">
	        		<ul>
	        			@foreach ($errors->all() as $error)
	        			<li>{{ $error }}</li>
	        			@endforeach
	        		</ul>
	        	</div>
        	@endif

        	@if($order->creator == 1 || $order->status_order == 2)
	        	<div class="form-group">
	        		<label>Tên khách hàng:</label>
	        		<input type="text" class="form-control" value="{{ $customer->name }}" readonly>
	        	</div>

	        	<div class="form-group">
	        		<label>Địa chỉ giao hàng:</label>
	        		<input type="text" class="form-control" value="{{ $order->str_locate }}" readonly>
	        	</div>

	        	<div class="form-group">
	        		<label>Trạng thái giao hàng:</label>
	        		<br />
	        		@if($order->status_order == 0)
		        		<div class="col-md-9 col-md-push-1">
		        			<div class="row">
		        				<div class="col-md-4">
		        					<input type="radio" name="status_order" value="0" checked>Chờ xử lý
		        				</div>
		        				<div class="col-md-4">
		        					<input type="radio" name="status_order" value="1">Đang xử lý
		        				</div>
		        				<div class="col-md-4">
		        					<input type="radio" name="status_order" value="4">Hủy đơn hàng
		        				</div>
		        			</div>
		        		</div>
	        		@elseif($order->status_order == 1)
		        		<div class="col-md-9">
		        			<div class="row">
		        				<div class="col-md-4">
		        					<input type="radio" name="status_order" value="1" checked> Đang xử lý
		        				</div>
		        				<div class="col-md-4">
		        					<input type="radio" name="status_order" value="2" > Đang chuyển hàng
		        				</div>
		        				<div class="col-md-4">
		        					<input type="radio" name="status_order" value="4"> Hủy đơn hàng
		        				</div>
		        			</div>
		        		</div>
	        		@elseif($order->status_order == 2)
	        			<div class="row">
		        			<div class="col-md-1">
	        				</div>
	        				<div class="col-md-3">
	        					<input type="radio" name="status_order" value="2" checked>Đang chuyển hàng
	        				</div>
	        				<div class="col-md-4">
	        					<input type="radio" name="status_order" value="3">Đã hoàn thành
	        				</div>
	        				<div class="col-md-4">
	        					<input type="radio" name="status_order" value="4">Hủy đơn hàng
	        				</div>
	        			</div>
	        		@endif
	        	</div>

	        	<div class="form-group">
	        		<label style="text-align:center; margin-bottom:15px" for="">Sản phẩm đã đặt hàng:</label>
        			<table class="table table-bordered table-tripped table-hover">
        				<thead>
        					<tr>
        						<th>STT</th>
        						<th style="text-align:center">Tên mặt hàng</th>
        						<th>Kích thước</th>
        						<th>Số lượng</th>
        						<th>Giá</th>
        						@if($order->status_order == 2)
        							<th>Trạng thái giao hàng</th>
        						@endif

        					</tr>
        				</thead>
        				<?php $i = 1;?>
        				<tbody>
        					@foreach($order->data as $p_item)
	        					<tr>
	        						<td>{{ $i++ }}</td>
	        						<td>{{ $p_item->name }}</td>
	        						<td>{{ $p_item->size }}</td>
	        						<td>{{ $p_item->qty }}</td>
	        						<td>{!! number_format($p_item->price,0,',','.') !!} VNĐ</td>
	        						@if($order->status_order == 2)
	        							<td>{{ Config::get('constants.detail_status_shipping')[$p_item->status] }}</td>
	        						@endif
	        					</tr>
        					@endforeach
        				</tbody>
        			</table>
	        	</div>

        	@elseif($order->creator == 2)
	        	@if($order->status_order == 1)
		        	<div class="form-group">
		        		<label>Tên khách hàng</label>
	        			<select class="form-control" name="customer_id" id="">
	        				@foreach($customers as $item)
	        				<option value="{{ $item->id }}" {{ $item->id == $order->customer_id?'selected':''}}>{{ $item->name }}</option>
	        				@endforeach
	        			</select>
		        	</div>

		        	<div class="form-group" style="margin-bottom: 0">
		        		<label>Địa chỉ giao hàng</label>
						<br>
		        		<div class="col-md-4">
		        			<select name="id_tinh" id="province" class="col-md-3 form-control">
		        				<option value="0">Tỉnh/Thành phố</option>
		        				@foreach($provinces as $item)
		        				<option value="{{ $item->provinceid }}" {{ $item->provinceid == $province->provinceid?'selected':'' }}>{{$item->name }}</option>
		        				@endforeach
		        			</select>
		        		</div>
		        		<div class="col-md-4">
		        			<select name="id_huyen" id="district" class="col-md-3 form-control">
		        				<option value="0">Quận/Huyện</option>
		        				@foreach($districts as $item)
		        				<option value="{{ $item->districtid }}" {{ $item->districtid == $district->districtid?'selected':'' }}>{{$item->name }}</option>
		        				@endforeach
		        			</select>
		        		</div>
		        		<div class="col-md-4">
		        			<select name="ward" id="ward" class="col-md-3 form-control">
		        				<option value="0">Phường/Xã</option>
		        				@foreach($wards as $item)
		        				<option value="{{ $item->wardid }}" {{ $item->wardid == $ward->wardid?'selected':'' }}>{{$item->name }}</option>
		        				@endforeach
		        			</select>
		        		</div>
		        		<div class="col-md-12">
		        			<input type="text" name="delivery_address" class="form-control" id="date-option" value="{{ $order->delivery_address }}" placeholder="Nhập địa chỉ giao hàng" style="margin: 7px 0 15px;"  />
		        		</div>

		        	</div>
		        	<div class="form-group">
		        		<label>Trạng thái</label>
	        			<div class="row">
	        				<div class="col-md-1">
	        				</div>
	        				<div class="col-md-3">
	        					<input type="radio" name="status_order" value="1" checked>Đang xử lý
	        				</div>
	        				<div class="col-md-4">
	        					<input type="radio" name="status_order" value="2">Đang chuyển hàng
	        				</div>
	        				<div class="col-md-3">
	        					<input type="radio" name="status_order" value="4">Hủy đơn hàng
	        				</div>
	        			</div>
		        	</div>

		        	<div class="form-group">
		        		<label>Sản phẩm</label>
	        			<table class="table table-bordered table-tripped table-hover">
	        				<thead>
	        					<tr>
	        						<th>STT</th>
	        						<th>Tên mặt hàng</th>
	        						<th>Kích thước</th>
	        						<th>Số lượng</th>
	        					</tr>
	        				</thead>
	        				<?php $i = 1;?>
	        				<tbody id="product-import">
	        					@foreach($order->data as $p_item)
	        					<tr class="odd gradeX">
	        						<td>{{ $i++ }}</td>
	        						<td>
	        							<input type="hidden" class="pro_id" name="order_detail_products[]" value="{{ $p_item->pro_id }}">
	        							<input type="hidden" class="old-size" name="order_detail_old_sizes[]" value="{{ !empty($p_item->size_id)?$p_item->size_id:'-1' }}">
	        							<input type="hidden" class="old-qty" value="{{ $p_item->qty }}">
	        							<input class="form-control" type="text" value="{{ $p_item->name }}" readonly/>
	        						</td>
	        						<td>
	        							@if(count($p_item->options) > 0)
	        							<select class="form-control size" name="order_detail_sizes[]" id="" required>
	        								<option value="" selected>Chọn kích cỡ</option>
	        								@foreach($p_item->options as $size)
	        								<option value="{{ $size->id }}" @if($p_item->size_id == $size->id) selected @endif>{{ $size->value }}</option>
	        								@endforeach
	        							</select>
	        							@else
	        							<select class="form-control" style="display:none" name="order_detail_sizes[]" id="">
	        								<option value="-1"></option>
	        							</select>
	        							@endif
	        						</td>
	        						<td>
	        							<input type="number" class="form-control qty" id="product-amount" name="order_detail_qtys[]" min="1" step="1" max="{{ $p_item->maxQty }}" value="{{ $p_item->qty }}" placeholder = "Nhập số lượng" />
	        						</td>
	    						</tr>
	    						@endforeach
	    						<tr id="first-row" style="display:none">
	    							<input type="hidden" name="check_has_new_detail" value='0'>
	    							<td id="first-count">{{ count($order->data) + 1 }}</td>
	    							<td id="list-product-first">
	    								<select class="form-control pro_id" name="pro_ids[]" id="">
	    									<option value="0" selected>Chọn sản phẩm</option>
	    									@foreach($products as $item)
	    									<option value="{{ $item->id }}">{{ $item->name }}</option>
	    									@endforeach
	    								</select>
	    							</td>
	    							<td class="size-wrapper">
	    							</td>
	    							<td>
	    								<input class="form-control qty" type="number" min="1" id="product-amount" name="qtys[]" value="1" placeholder = "Nhập số lượng" required/>
	    							</td>
	    						</tr>
							</tbody>
						</table>

						<div id="add-product-edit" class="col-md-12">
							<span class="btn btn-primary">+</span>
						</div>
					</div>
				@endif
			@endif
			<div class="form-group" align="center">
				<button type="submit" class="btn btn-default functionButton">Sửa</button>
				<button type="button" class="btn btn-default functionButton" onclick = "window.location = '{{ route("admin.order.getList") }}'">Quay lại</button>
				</div>
			</div>
        </form>
    </div>
</section>

@endsection