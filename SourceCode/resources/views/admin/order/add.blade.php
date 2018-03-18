@extends('admin.master')
@section('controller', 'Đơn hàng')
@section('action', 'Thêm')
@section('breadcrumb', 'Quản lý đơn hàng')
@section('content')

<section class="content">
    <div class="col-xs-12 col-sm-8 col-md-8 col-sm-push-2 col-md-push-2">
        @include('admin.blocks.error')

		<form class="form-horizontal" action="{{ route('admin.order.postAdd') }}" method="POST" role="form" enctype="multipart/form-data">
			<input type="hidden" name="_token" value="{{ csrf_token() }}">

			<div class="form-group">
				<label>Tên khách hàng <span class="asterisk">*</span></label>
				<select name="customer_id" class="form-control" id="">
					@foreach($customers as $item)
						<option value="{{ $item->id }}">{{ $item->name }} - {{ $item->email }}</option>
					@endforeach
				</select>
			</div>

			<div class="form-group" style="margin-bottom: 0">
				<label>Địa chỉ giao hàng <span class="asterisk">*</span></label>
				<br>
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
                <div class="col-md-12" style="padding: 0;">
                    <input type="text" style="margin: 7px 0 15px;" class="form-control" id="" name="address" placeholder="Nhập địa chỉ cụ thể (số nhã, ngõ, đường...)" value="{{ old('address') }}" required>
                </div>
			</div>

			<div class="form-group">
				<label>Sản phẩm <span class="asterisk">*</span></label>
				<div class="col-md-12" style="padding: 0;">
					<table class="table table-striped table-bordered table-hover" style="margin-top: 0">
						<thead>
							<tr>
								<th>STT</th>
								<th>Tên mặt hàng</th>
								<th>Kích cỡ</th>
								<th>Số lượng</th>
							</tr>
						</thead>
						<tbody id="product-import">
							<tr>
								<td>1</td>
								<td id="list-product-first">
									<select class="form-control pro_id" name="pro_ids[]" id="">
										<option value="0" selected>Chọn sản phẩm</option>
										@foreach($products as $item)
					                        <option value="{{ $item->id }}">{{ $item->name }}</option>
				                        @endforeach
									</select>
								</td>
								<td class="size-wrapper" width="25%"></td>
								<td>
									<input class="form-control qty" type="number" min="1" id="product-amount" name="qtys[]" value="1" placeholder = "Nhập số lượng" required/>
								</td>
							</tr>
						</tbody>
					</table>

					<div id="add-product" class="col-md-12">
						<span class="btn btn-primary">+</span>
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="col-md-12 col-md-offset-3">
					<button type="submit" class="btn btn-default functionButton">Đặt hàng</button>
					<button type="button" class="btn btn-default functionButton" onclick = "window.location = '../order/list'">Quay lại</button>
				</div>
			</div>
		</form>
    </div>
</section>

@endsection