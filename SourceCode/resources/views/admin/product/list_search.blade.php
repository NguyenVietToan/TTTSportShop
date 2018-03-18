
<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr align="center">
            <th><input type="checkbox" id="check" /></th>
            <th>STT</th>
            <th>Tên sản phẩm</th>
            <th>Giới tính</th>
            <th>Ảnh đại diện</th>
            <th>Giá</th>
            <th>Giảm giá</th>
            <th>Thể loại</th>
            <th>Bộ môn</th>
            <th>Thương hiệu</th>
            <th>Ngày tạo lập</th>
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
                @else
                <?php echo "Cả hai" ?>
                @endif
            </td>
            <td>
                <img src="{{ asset('resources/upload/images/product/thumbnail/'.$item->id.'/'.$item->image) }}">
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
                    {{ stranslateTime(\Carbon\Carbon::createFromTimestamp(strtotime($item->created_at))->diffForHumans()) }}
                </td>
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

<button type="submit" class="btn btn-default delete">Xóa</button>

<div class="paginate pull-right">
    @include('pagination.paging', ['paginator' => $products->appends(['keyword' => $keyword, 'cate_id' => $cate_id, 'sport_id' => $sport_id, 'brand_id' => $brand_id, 'gender' => $gender])])
</div>
<!-- /.pagination -->

<script>
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