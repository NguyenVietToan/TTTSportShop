@extends('admin.master')
@section('controller', 'Sản phẩm')
@section('action', 'Danh sách')
@section('breadcrumb', 'Quản lý sản phẩm')
@section('content')

<section class="content">
    <div class="col-xs-2 col-sm-3 col-md-4"></div>
    <div class="col-xs-8 col-sm-6 col-md-4">
        <input class="form-control" type="text" id="search" name="search" value="{{ isset($keyword) ? $keyword : null }}" placeholder="Nhập nội dung tìm kiếm ở đây...">
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="col-xs-8 col-sm-6 col-md-4 col-xs-push-2 col-sm-push-3 col-md-push-4">
            @if(session('status'))
                <div class="message alert alert-success">
                    {{session('status')}}
                </div>
            @endif
            @if(session('error'))
                <div class="error alert alert-danger">
                    {{session('error')}}
                </div>
            @endif
        </div>
    </div>
    <!-- /.row -->

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="row">
            <form action="{{ route('admin.product.getList') }}" method="GET" role="form">
                <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 selectCate" style="padding-left: 0;">
                    <div class="form-group">
                        <select class="form-control" name="cateId">
                            <option value="0">Chọn thể loại</option>
                            @foreach ($cate as $c_item)
                                <option value="{{ $c_item['id'] }}" @if(!empty($cate_id) && ($c_item['id'] == $cate_id)) selected @endif>{{ $c_item['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 selectSport" style="padding-left: 0;">
                    <div class="form-group">
                        <select class="form-control" name="sportId">
                            <option value="0">Chọn bộ môn</option>
                            @foreach ($sport as $s_item)
                                <option value="{{ $s_item['id'] }}" @if(!empty($sport_id) && ($s_item['id'] == $sport_id)) selected @endif>{{ $s_item['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 selectBrand" style="padding-left: 0;">
                    <div class="form-group">
                        <select class="form-control" name="brandId">
                            <option value="0">Chọn thương hiệu</option>
                            @foreach ($brand as $b_item)
                                <option value="{{ $b_item['id'] }}" @if(!empty($brand_id) && ($b_item['id'] == $brand_id)) selected @endif>{{ $b_item['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-3 col-lg-2 selectGender" style="padding-left: 0;">
                    <div class="form-group">
                        <select class="form-control" name="gender">
                            <option value="0">Chọn giới tính</option>
                            <option value="1" @if(!empty($gender) && ($gender == "1")) selected @endif>nam</option>
                            <option value="2" @if(!empty($gender) && ($gender == "2")) selected @endif>nữ</option>
                            <option value="3" @if(!empty($gender) && ($gender == "3")) selected @endif>nam+nữ</option>
                            <option value="4" @if(!empty($gender) && ($gender == "4")) selected @endif>trẻ em</option>
                        </select>
                    </div>
                </div>

                <button type="submit" class="btn btn-default filter">Lọc</button>

                <a href="{{ URL::route('admin.product.getAdd') }}" class="pull-right btn btn-default addItem"> Thêm sản phẩm</a>
            </form>
        </div>
    </div>

    <form action="{{ route('admin.product.postDelete') }}" method="POST" role="form" class="list-pro-data">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">

        <div id="searchUpdateDiv">
            <table class="table table-striped table-bordered table-hover">
                <thead>
                    <tr align="center">
                        <th><input type="checkbox" id="check" /></th>
                        <th>STT</th>
                        <th>Tên sản phẩm</th>
                        <th>Giới tính</th>
                        <th>Ảnh đại diện</th>
                        <th>Giá nhập</th>
                        <th>Giá bán</th>
                        <th>Giảm giá</th>
                        <th>Thể loại</th>
                        <th>Bộ môn</th>
                        <th>Thương hiệu</th>
                        <th>Lần chỉnh sửa cuối</th>
                        <th></th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                <?php $stt = !empty($_GET['page']) ? ($_GET['page']-1)*7+1 : 1; ?>
                <?php $count = 1; ?>
                @foreach ($products as $item)
                    <tr class="odd gradeX" align="center">
                        <td><input type="checkbox" class="check_class" name="checks[]" value="{{ $item->id }}"></td>
                        <td>{{ $stt++ }}</td>
                        <td>{{ $item->name }}</td>
                        <td>
                            @if ($item->gender == 1)
                                <?php echo "Nam" ?>
                            @elseif ($item->gender == 2)
                                <?php echo "Nữ" ?>
                            @elseif ($item->gender == 3)
                                <?php echo "Nam+Nữ" ?>
                            @else
                                <?php echo "Trẻ em" ?>
                            @endif
                        </td>
                        <td>
                            <img src="{{ asset('resources/upload/images/product/thumbnail/'.$item->id.'/'.$item->image) }}">
                        </td>
                        <td>
                            {{ number_format($item->import_price, 0, ',', '.') }} VNĐ
                        </td>
                        <td>
                            {{ number_format($item->price, 0, ',', '.') }} VNĐ
                        </td>
                        <td>
                            <div id="checkSale<?php echo $count;?>">
                                <input type="checkbox" id="onSale<?php echo $count;?>"> Giảm giá
                            </div>
                            <div id="salePrice<?php echo $count;?>">
                                <input type="hidden" id="pro_id<?php echo $count;?>" value="{{ $item->id }}"/>
                                <br>
                                <input type="text" name="sale_price" id="sale_price<?php echo $count;?>" placeholder="Nhập giá giảm" size="10" value="{{ old('sale_price', isset($item->sale_price) ? $item->sale_price : null) }}"><br>
                                <button id="saveSPrice<?php echo $count;?>" class="btn btn-success" style="margin-top: 7px;">
                                    Lưu</button>
                            </div>
                        </td>
                        <td>{{ $item->ct_name }}</td>
                        <td>{{ $item->sp_name }}</td>
                        <td>{{ $item->br_name }}</td>
                        <td>
                            {{ stranslateTime(\Carbon\Carbon::createFromTimestamp(strtotime($item->updated_at))->diffForHumans()) }}
                        </td>
                        <td><i class="fa fa-trash-o fa-fw"></i><a href="{{ URL::route('admin.product.getDelete', $item->id) }}" onclick="return confirm('Bạn Có Chắc Là Muốn Xóa Không?')" > Xóa</a></td>
                        <td><i class="fa fa-pencil fa-fw"></i> <a href="{{ URL::route('admin.product.getEdit', $item->id) }}"> Sửa</a></td>
                    </tr>
                <?php $count++; ?>
                @endforeach
                </tbody>
            </table>

            <button type="submit" class="btn btn-default delete" onclick="return confirm('Bạn Có Chắc Là Muốn Xóa Không?')">Xóa</button>

            @if (isset($cate_id) || isset($sport_id) || isset($brand_id) || isset($gender))
                <div class="paginate pull-right">@include('pagination.paging', ['paginator' => $products->appends(Request::capture()->except('page'))])</div>
            @else
                <div class="paginate pull-right">@include('pagination.paging', ['paginator' => $products])</div>
            @endif
        </div>
    </form>

<script>
    URL_SEARCH_PRODUCT_AJAX = {!! json_encode(['url' => route('admin.product.getSearchProduct'), 'paginate_url' => $paginateUrl]) !!}   //  hàm json_encode($array) sẽ chuyển mảng $array thành 1 chuỗi json
</script>

</section>

@endsection

@section('custom javascript')

<script type="text/javascript">
    $(document).ready(function() {
        $('.mytreeview').removeClass('active');  //loại bỏ active ở cái hiện tại
        $("#product").addClass('active');   //active sang cái mới
        $("#listproduct").addClass('active');
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
                url: URL_SEARCH_PRODUCT_AJAX.url,
                data: {
                    keyword: keyword,
                    paginateUrl: URL_SEARCH_PRODUCT_AJAX.paginate_url
                },
                success: function(result) {
                    console.log(result);
                    $('#searchUpdateDiv').html(result);
                }
            });
        });
    });


    //Giảm giá
    $(document).ready(function() {
        <?php
            for ($i = 1; $i < 100; $i++) {
        ?>
                $('#salePrice<?php echo $i; ?>').hide();
                $('#onSale<?php echo $i; ?>').click(function() {
                    $('#salePrice<?php echo $i; ?>').toggle();
                    $('#saveSPrice<?php echo $i; ?>').click(function(){
                      var pro_id<?php echo $i; ?>     = $('#pro_id<?php echo $i; ?>').val();
                      var sale_price<?php echo $i; ?> = $('#sale_price<?php echo $i; ?>').val();
                        $.ajax({
                            type: 'get',
                            dataType: 'html',
                            url: '<?php echo url('/admin/product/sale');?>',
                            data: "sale_price=" + sale_price<?php echo $i; ?> + "& pro_id=" + pro_id<?php echo $i; ?>,
                            success: function (response) {
                                console.log(response);
                          }
                      });
                    });
                });
        <?php
            }
        ?>
    });

</script>

@endsection