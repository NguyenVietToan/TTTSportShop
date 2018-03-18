@extends('admin.master')
@section('controller', 'Thành viên')
@section('action', 'Danh sách')
@section('breadcrumb', 'Quản lý thành viên')
@section('content')

<section class="content">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-right: 0">
        <a href="{{ URL::route('admin.customer.getAdd') }}" class="pull-right btn btn-default addItem"> Thêm khách hàng</a>
    </div>

    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr align="center">
                <th>Số thứ tự</th>
                <th>Tên khách hàng</th>
                <th>Mã thành viên</th>
                <th>Giới tính</th>
                <th>Email</th>
                <th>Số điện thoại</th>
                <th>Ngày tạo lập</th>
                <th>Lần chỉnh sửa cuối</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php $stt = !empty($_GET['page']) ? ($_GET['page']-1)*7+1 : 1 ?>
            @foreach ($customers as $item)
                <tr class="odd gradeX" align="center">
                    <td>{{ $stt++ }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->user_id }}</td>
                    <td>
                        @if ($item->gender == 1)
                            <?php echo "Nam" ?>
                        @else
                            <?php echo "Nữ" ?>
                        @endif
                    </td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->phone }}</td>
                    <td>
                        {{ date('d/m/y', strtotime($item->created_at)) }}
                    </td>
                    <td>
                        {{ stranslateTime(\Carbon\Carbon::createFromTimestamp(strtotime($item->updated_at))->diffForHumans()) }}
                    </td>
                    <td class="center"><i class="fa fa-trash-o fa-fw"></i><a href="{{ URL::route('admin.customer.getDelete', $item->id) }}" class="del-customer" order-exist="{{ $item->order_exist }}" > Xóa</a></td>
                    <td class="center"><i class="fa fa-trash-o fa-fw"></i><a href="{{ URL::route('admin.customer.getEdit', $item->id) }}"> Sửa</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <button type="submit" class="btn btn-default delete">Xóa</button>

    <div class="paginate pull-right">@include('pagination.paging', ['paginator' => $customers])</div>
</section>

@endsection

@section('custom javascript')

<script type="text/javascript">
    $(document).ready(function(){
        $('.mytreeview').removeClass('active');  //loại bỏ active ở cái hiện tại
        $("#people").addClass('active');
        $("#customer").addClass('active');   //active sang cái mới

        $('.del-customer').click(function(){
            var order_exist = $(this).attr('order-exist');
            if (order_exist == 0) {
                return confirm('Bạn có chắc chắn muốn xóa khách hàng này không?');  //khi ko có đơn hàng: khi nhấn xác nhận xóa thì nó sẽ return true, khi đó mới thực hiện xóa
            } else {
                alert('Khách hàng bạn muốn xóa đang có đơn hàng đang xử lý hoặc đang chuyển hàng!');
                return false;  //ko thực hiện xóa
            }
        });
    });
</script>

@endsection