@extends('admin.master')
@section('controller', 'Nhà cung cấp')
@section('action', 'Danh sách')
@section('breadcrumb', 'Quản lý nhà cung cấp')
@section('content')

@section('content')

<section class="content">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-right: 0">
        <a href="{{ URL::route('admin.supplier.getAdd') }}" class="pull-right btn btn-default addItem"> Thêm nhà cung cấp</a>
    </div>

    <form action="{{ route('admin.supplier.postDelete') }}" method="POST" role="form">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr align="center">
                    <th><input type="checkbox" id="check" /></th>
                    <th>Số thứ tự</th>
                    <th>Tên nhà cung cấp</th>
                    <th>Địa chỉ</th>
                    <th>Số điện thoại</th>
                    <th>Email</th>
                    <th>Ngày tạo lập</th>
                    <th>Lần chỉnh sửa cuối</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php $stt = !empty($_GET['page']) ? ($_GET['page']-1)*7+1 : 1 ?>
                @foreach ($suppliers as $item)
                    <tr class="odd gradeX" align="center">
                        <td><input type="checkbox" class="check_class" name="checks[]" value="{{ $item->id }}"></td>
                        <td>{{ $stt++ }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->full_address }}</td>
                        <td>0{{ $item->phone }}</td>
                        <td>{{ $item->email }}</td>
                        <td>
                            {{ stranslateTime(\Carbon\Carbon::createFromTimestamp(strtotime($item->created_at))->diffForHumans()) }}
                        </td>
                        <td>
                            {{ stranslateTime(\Carbon\Carbon::createFromTimestamp(strtotime($item->updated_at))->diffForHumans()) }}
                        </td>
                        <td class="center"><i class="fa fa-trash-o fa-fw"></i><a href="{{ URL::route('admin.supplier.getDelete', $item->id) }}" onclick="return confirm('Bạn Có Chắc Là Muốn Xóa Không?')" > Xóa</a></td>
                        <td class="center"><i class="fa fa-pencil fa-fw"></i><a href="{{ URL::route('admin.supplier.getEdit', $item->id) }}"> Sửa</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <button type="submit" class="btn btn-default delete">Xóa</button>

        <div class="paginate pull-right">@include('pagination.paging', ['paginator' => $suppliers])</div>
    </form>
</section>

@endsection


@section('custom javascript')
<script type="text/javascript">
    $(".link").removeClass('active');
    $("#product").addClass('active');
    $("#listsupplier").addClass('active');
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
</script>

@endsection