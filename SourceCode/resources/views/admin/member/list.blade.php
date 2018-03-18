@extends('admin.master')
@section('controller', 'Nhân viên')
@section('action', 'Danh sách')
@section('breadcrumb', 'Quản lý nhân viên')
@section('content')

@section('content')

<section class="content">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-right: 0">
        <a href="{{ URL::route('admin.member.getAdd') }}" class="pull-right btn btn-default addItem"> Thêm nhân viên</a>
    </div>

    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr align="center">
                <th><input type="checkbox" id="check" /></th>
                <th>Số thứ tự</th>
                <th>Tên nhân viên</th>
                <th>Hình ảnh</th>
                <th>Email</th>
                <th>Địa chỉ</th>
                <th>Số điện thoại</th>
                <th>Vai trò</th>
                <th>Ngày bắt đầu</th>
                <th>Lần chỉnh sửa cuối</th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
            <?php $stt = !empty($_GET['page']) ? ($_GET['page']-1)*7+1 : 1 ?>
            @foreach ($members as $item)
                <tr class="odd gradeX" align="center">
                    <td>
                        <input type="checkbox" class="check_class" name="checks[]" value="{{ $item->id }}"
                            @if ($item->level == 0)
                                disabled
                            @endif
                        >
                    </td>
                    <td>{{ $stt++ }}</td>
                    <td>{{ $item->name }}</td>
                    <td>
                        <img src="{{ asset('resources/upload/images/member/'.$item->id.'/'.$item->image) }}">
                    </td>
                    <td>{{ $item->email }}</td>
                    <td>{{ $item->full_address }}</td>
                    <td>{{ $item->phone }}</td>
                    <td>
                        @if ($item->level == 0)
                        <span style="color: red;">Admin</span>
                    @else
                        <span style="color: blue;">Shipper</span>
                    @endif
                    </td>
                    <td>{{ getTimeForList($item->start_date) }}</td>
                    <td>
                        {{ stranslateTime(\Carbon\Carbon::createFromTimestamp(strtotime($item->updated_at))->diffForHumans()) }}
                    </td>
                    <td class="center"><i class="fa fa-trash-o fa-fw"></i><a href="{{ URL::route('admin.member.getDelete', $item->id) }}" onclick="return confirm('Bạn Có Chắc Là Muốn Xóa Không?')"
                    > Xóa</a></td>
                    <td class="center"><i class="fa fa-pencil fa-fw"></i><a href="{{ URL::route('admin.member.getEdit', $item->id) }}"> Sửa</a></td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="paginate pull-right">@include('pagination.paging', ['paginator' => $members])</div>
</section>

@endsection


@section('custom javascript')
<script type="text/javascript">
    $(".link").removeClass('active');
    $("#people").addClass('active');
    $("#member").addClass('active');
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