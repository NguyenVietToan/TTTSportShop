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

<button type="submit" class="btn btn-default delete">Xóa</button>

<div class="paginate pull-right">
    @include('pagination.paging', ['paginator' => $properties->appends(['keyword' => $keyword])])
</div>