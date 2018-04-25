@extends('admin.master')
@section('controller', 'Thể loại sản phẩm')
@section('action', 'Danh sách')
@section('breadcrumb', 'Quản lý thể loại sản phẩm')
@section('content')

<section class="content">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-right: 0">
        <a href="{{ URL::route('admin.cate.getAdd') }}" class="pull-right btn btn-default addItem"> Thêm thể loại</a>
    </div>

    <form action="{{ route('admin.cate.postDelete') }}" method="POST" role="form">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr align="center">
                    <th><input type="checkbox" id="check" /></th>
                    <th>Số thứ tự</th>
                    <th>Tên thể loại</th>
                    <th>Mô tả</th>
                    <th>Ngày tạo lập</th>
                    <th>Lần chỉnh sửa cuối</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php $stt = !empty($_GET['page']) ? ($_GET['page']-1)*7+1 : 1 ?>
                @foreach ($cates as $item)
                    <tr class="odd gradeX" align="center">
                        <td><input type="checkbox" class="check_class" name="checks[]" value="{{ $item->id }}"></td>
                        <td>{{ $stt++ }}</td>
                        <td>{{ $item->name }}</td>
                        <td>{{ $item->description }}</td>
                        <td>
                            {{ stranslateTime(\Carbon\Carbon::createFromTimestamp(strtotime($item->created_at))->diffForHumans()) }}

                            <!-- createFromTimestamp là hàm tính lượng thời gian hiện tại so với thời gian được truyền vào,
                                 diffForHumans là hàm thêm hậu tố before/ago hoặc from now/after -->
                        </td>
                        <td>
                            {{ stranslateTime(\Carbon\Carbon::createFromTimestamp(strtotime($item->updated_at))->diffForHumans()) }}
                        </td>
                        <td class="center"><i class="fa fa-trash-o fa-fw"></i><a href="{{ URL::route('admin.cate.getDelete', $item->id) }}" onclick="return confirm('Bạn Có Chắc Là Muốn Xóa Không?')" > Xóa</a></td>
                        <td class="center"><i class="fa fa-pencil fa-fw"></i><a href="{{ URL::route('admin.cate.getEdit', $item->id) }}"> Sửa</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <button type="submit" class="btn btn-default" style="background: #337ab7; border-color: #337ab7; color:#fff;" onclick="return confirm('Bạn có chắc là muốn xóa các thể loại đã chọn không?')">Xóa</button>

        <div class="paginate pull-right">@include('pagination.paging', ['paginator' => $cates])</div>
    </form>
</section>

@endsection()

@section('custom javascript')

<script type="text/javascript">
    $(document).ready(function(){
        $('.mytreeview').removeClass('active');  //loại bỏ active ở cái hiện tại
        $("#product").addClass('active');       //active sang menu product
        $("#listcate").addClass('active');   //active sang sub menu category
        var check = false;
        $('#check').click(function(){   //set check all
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