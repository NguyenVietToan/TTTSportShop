@extends('admin.master')
@section('controller', 'Banner nhỏ')
@section('action', 'Danh sách')
@section('breadcrumb', 'Quản lý banner nhỏ')
@section('content')

<section class="content">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-right: 0">
        <a href="{{ URL::route('admin.smallbanner.getAdd') }}" class="pull-right btn btn-default addItem"> Thêm banner nhỏ</a>
    </div>

    <form action="{{ route('admin.smallbanner.postDelete') }}" method="POST" role="form">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <table class="table table-striped table-bordered table-hover">
            <thead>
                <tr align="center">
                    <th><input type="checkbox" id="check" /></th>
                    <th>Số thứ tự</th>
                    <th>Tên banner</th>
                    <th>Hình ảnh</th>
                    <th>Hiển thị</th>
                    <th>Ngày tạo lập</th>
                    <th>Lần chỉnh sửa cuối</th>
                    <th></th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php $stt = !empty($_GET['page']) ? ($_GET['page']-1)*3+1 : 1 ?>
                @foreach ($small_banners as $item)
                    <tr class="odd gradeX" align="center">
                        <td><input type="checkbox" class="check_class" name="checks[]" value="{{ $item->id }}"></td>
                        <td>{{ $stt++ }}</td>
                        <td>{{ $item->name }}</td>
                        <td>
                            <img src="{{ asset('resources/upload/images/banner/smallbanner/thumbnail/'.$item->id.'/'.$item->image) }}">
                        </td>
                        <td>
                            <input type="checkbox" name="checks[]" {{ $item->display == 1 ? 'checked' : '' }} disabled />
                        </td>
                        <td>
                            {{ stranslateTime(\Carbon\Carbon::createFromTimestamp(strtotime($item->created_at))->diffForHumans()) }}
                        </td>
                        <td>
                            {{ stranslateTime(\Carbon\Carbon::createFromTimestamp(strtotime($item->updated_at))->diffForHumans()) }}
                        </td>
                        <td class="center"><i class="fa fa-trash-o fa-fw"></i><a href="{{ URL::route('admin.smallbanner.getDelete', $item->id) }}" onclick="return confirm('Bạn Có Chắc Là Muốn Xóa Không?')" > Xóa</a></td>
                        <td class="center"><i class="fa fa-pencil fa-fw"></i><a href="{{ URL::route('admin.smallbanner.getEdit', $item->id) }}"> Sửa</a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <button type="submit" class="btn btn-default" style="background: #337ab7; border-color: #337ab7; color:#fff;" onclick="return confirm('Bạn có chắc là muốn xóa các banner đã chọn không?')">Xóa</button>

        <div class="paginate pull-right">@include('pagination.paging', ['paginator' => $small_banners])</div>
    </form>
</section>

@endsection()

@section('custom javascript')

<script type="text/javascript">
    $(document).ready(function(){
        $('.mytreeview').removeClass('active');  //loại bỏ active ở cái hiện tại
        $("#banner").addClass('active');   //active sang cái mới
        $("#smallbanner").addClass('active');
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