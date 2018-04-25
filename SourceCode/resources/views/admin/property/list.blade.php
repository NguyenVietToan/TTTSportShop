@extends('admin.master')
@section('controller', 'Thuộc tính sản phẩm')
@section('action', 'Danh sách')
@section('breadcrumb', 'Quản lý thuộc tính sản phẩm')
@section('content')

<section class="content">
    <div class="col-xs-2 col-sm-3 col-md-4"></div>
    <div class="col-xs-8 col-sm-6 col-md-4">
        <input class="form-control" type="text" id="search" name="search" value="{{ isset($keyword) ? $keyword : null }}" placeholder="Nhập nội dung tìm kiếm ở đây...">
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="padding-right: 0; padding-left: 0">
        <a href="{{ route('admin.property.getAdd') }}" class="pull-right btn btn-default addItem"> Thêm thuộc tính</a>
    </div>

    <form action="{{ route('admin.property.postDelete') }}" method="POST" role="form">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div id="searchUpdateDiv">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr align="center">
                        <th><input type="checkbox" id="check" /></th>
                        <th>Số thứ tự</th>
                        <th>Tên sản phẩm</th>
                        <th>Size</th>
                        <th>Số lượng</th>
                        <th>Ngày tạo lập</th>
                        <th>Lần chỉnh sửa cuối</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    <?php $stt = !empty($_GET['page']) ? ($_GET['page']-1)*7+1 : 1 ?>
                    @foreach ($properties as $item)
                    <tr class="odd gradeX" align="center">
                        <td><input type="checkbox" class="check_class" name="checks[]" value="{{ $item->id }}"></td>
                        <td>{{ $stt++ }}</td>
                        <td>{{ $item->pr_name }}</td>
                        <td>{{ $item->size }}</td>
                        <td>{{ $item->qty }}</td>
                        <td>
                            {{ stranslateTime(\Carbon\Carbon::createFromTimestamp(strtotime($item->created_at))->diffForHumans()) }}
                        </td>
                        <td>
                            {{ stranslateTime(\Carbon\Carbon::createFromTimestamp(strtotime($item->updated_at))->diffForHumans()) }}
                        </td>
                        <td class="center"><i class="fa fa-trash-o fa-fw"></i><a href="{{ URL::route('admin.property.getDelete', $item->id) }}" onclick="return confirm('Bạn Có Chắc Là Muốn Xóa Không?')" > Xóa</a></td>
                        <td class="center"><i class="fa fa-pencil fa-fw"></i><a href="{{ URL::route('admin.property.getEdit', $item->id) }}"> Sửa</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <button type="submit" class="btn btn-default" style="background: #337ab7; border-color: #337ab7; color:#fff;" onclick="return confirm('Bạn có chắc là muốn xóa các thuộc tính đã chọn không?')">Xóa</button>

            <div class="paginate pull-right">@include('pagination.paging', ['paginator' => $properties])</div>
        </div>
    </form>

<script>
    URL_SEARCH_PROPERTY_AJAX = {!! json_encode(['url' => route('admin.property.getSearchProperty'), 'paginate_url' => $paginateUrl]) !!}   //  hàm json_encode($array) sẽ chuyển mảng $array thành 1 chuỗi json
</script>

</section>

@endsection

@section('custom javascript')

<script type="text/javascript">
    $(document).ready(function(){
        $('.mytreeview').removeClass('active');  //loại bỏ active ở cái hiện tại
        $("#product").addClass('active');   //active sang cái mới
        $("#listproperty").addClass('active');
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

    //Tìm kiếm
    $(document).ready(function() {
        $('#search').on('keyup', function() {
            var keyword = $(this).val();
            $.ajax({
                type: 'get',
                url: URL_SEARCH_PROPERTY_AJAX.url,
                data: {
                    keyword: keyword,
                    paginateUrl: URL_SEARCH_PROPERTY_AJAX.paginate_url
                },
                success: function(result) {
                    console.log(result);
                    $('#searchUpdateDiv').html(result);
                }
            });
        });
    });
</script>

@endsection