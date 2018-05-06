@extends('admin.master')
@section('controller', 'Đơn hàng')
@section('action', 'Danh sách')
@section('breadcrumb', 'Quản lý đơn hàng')
@section('content')

<section class="content">
	<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-right: 0">
        <a href="{{ URL::route('admin.order.getAdd') }}" class="pull-right btn btn-default addItem"> Đặt hàng</a>
    </div>

	<form class="form-horizontal" action="{{ route('admin.order.postDelete') }}" method="POST" role="form">
		<input type="hidden" name="_token" value="{{ csrf_token() }}">

		<table class="table table-striped table-bordered table-hover">
			<thead>
				<tr align="center">
					<th><input type="checkbox" id="check" class='check-all-list'/></th>
                    <th>STT</th>
                    <th>Tên khách hàng</th>
                    <th>Địa chỉ giao hàng</th>
                    <th>Giá trị</th>
                    <th>Ngày đặt hàng</th>
                    <th>Người tạo</th>
                    <th>Trạng thái</th>
                    <th></th>
                    <th></th>
                    <th></th>
                </tr>
			</thead>

			<tbody>
				@if(count($orders) > 0)
					@foreach($orders as $key => $item)
					<tr class="odd gradeX" align="center" creator = {{ $item->creator }}
						status_order = '{{ $item->status_order }}'
					>
						<td><input type="checkbox" class="check-item check_class" name="checks[]" value="{{ $item->id }}"></td>
						<td>
							@if(request()->get('page') != null && request()->get('page') > 1)
								{{ (request()->get('page') - 1) * 7 + $key + 1 }}
							@else
								{{ $key + 1 }}
							@endif
						</td>
						<td>{{ $item->customer }}</td>
						<td>{{ $item->location }}</td>
						<td>{{ number_format($item->sum_price,0,',','.') }} VNĐ</td>
						<td>{{ Date('d/m/Y',strtotime($item->date_order)) }}</td>
						<td>{{ Config::get('constants.creator')[$item->creator] }}</td>
						<td>{{ Config::get('constants.status_orders')[$item->status_order] }}</td>
						<td><i class="fa fa-info-circle" style="margin-right: 4px"></i><a href="{{ route('admin.order.getDetail', ['id' => $item->id]) }}">Chi tiết</a></td>
						<td><i class="fa fa-trash-o fa-fw"></i><a class="delete" href="{{ route('admin.order.getDelete',['id' => $item->id]) }}" class="delete_order">Xóa</a></td>
						<td><i class="fa fa-pencil fa-fw"></i><a class="edit" href="{{ route('admin.order.getEdit', ['id' => $item->id]) }}">Sửa</a></td>
					</tr>
					@endforeach
				@else
					<tr>
						<td style="text-align:center" colspan="11">Không tồn tại đơn hàng nào</td>
					</tr>
				@endif
			</tbody>
		</table>

		<button type="submit" class="btn btn-default" style="background: #337ab7; border-color: #337ab7; color:#fff;" onclick="return confirm('Bạn chắc chắn muốn xóa những đơn hàng này không?')">Xóa</button>

		<div class="paginate pull-right">@include('pagination.paging', ['paginator' => $orders])</div>
	</form>
</section>

@endsection

@section('custom javascript')

<script type="text/javascript">
    $(document).ready(function(){
        $('.mytreeview').removeClass('active');  //loại bỏ active ở cái hiện tại
        $("#deal").addClass('active');
        $("#listorder").addClass('active');   //active sang cái mới
        var check = false;
        $('#check').click(function(){
            if(check == false){
                check = true;
                $(".check_class").prop("checked",true);
            }else{
                check =false;
                $(".check_class").prop("checked",false);
            }
        });
    });
</script>

@endsection