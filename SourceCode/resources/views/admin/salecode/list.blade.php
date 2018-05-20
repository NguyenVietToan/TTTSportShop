@extends('admin.master')
@section('controller', 'Mã giảm giá')
@section('action', 'Danh sách')
@section('breadcrumb', 'Quản lý mã giảm giá')
@section('content')

<section class="content">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-right: 0">
        <a href="{{ URL::route('admin.salecode.getAdd') }}" class="pull-right btn btn-default addItem"> Thêm mã giảm giá</a>
    </div>

    <form action="{{ route('admin.salecode.postDelete') }}" method="POST" role="form">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr align="center">
                    <th><input type="checkbox" id="check" /></th>
                    <th>Số thứ tự</th>
                    <th>Mã giảm giá</th>
                    <th>% giảm giá</th>
                    <th>Đã dùng</th>
                    <th>Ngày tạo lập</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php $stt = !empty($_GET['page']) ? ($_GET['page']-1)*7+1 : 1 ?>
                @foreach ($salecodes as $item)
                    <tr class="odd gradeX" align="center">
                        <td><input type="checkbox" class="check_class" name="checks[]" value="{{ $item->id }}"></td>
                        <td>{{ $stt++ }}</td>
                        <td>{{ $item->salecode }}</td>
                        <td>{{ $item->salepercent }}</td>
                        <td>
                            <input type="checkbox" name="checks[]" {{ $item->used == 1 ? 'checked' : '' }} disabled />
                        </td>
                        <td>
                            {{ stranslateTime(\Carbon\Carbon::createFromTimestamp(strtotime($item->created_at))->diffForHumans()) }}
                        </td>
                        <td class="center"><i class="fa fa-trash-o fa-fw"></i><a href="{{ URL::route('admin.salecode.getDelete', $item->id) }}" onclick="return confirm('Bạn Có Chắc Là Muốn Xóa Không?')" > Xóa</a></td>
                        
                    </tr>
                @endforeach
            </tbody>
        </table>

        <button type="submit" class="btn btn-default" style="background: #337ab7; border-color: #337ab7; color:#fff;" onclick="return confirm('Bạn có chắc là muốn xóa các mã đã chọn không?')">Xóa</button>

        <div class="paginate pull-right">@include('pagination.paging', ['paginator' => $salecodes])</div>
    </form>
</section>

@endsection

@section('custom javascript')

<script type="text/javascript">
    $(document).ready(function(){
        $('.mytreeview').removeClass('active');  //loại bỏ active ở cái hiện tại
        $("#salecode").addClass('active');       // active sang menu salecode
        var check = false;
        $('#check').click(function(){
            if(check == false){
                check = true;
                $(".check_class").prop("checked",true);
            }else{
                check = false;
                $(".check_class").prop("checked",false);
            }
        });
    });
</script>

@endsection