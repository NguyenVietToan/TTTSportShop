// Page-Level Demo Scripts - Tables - Use for reference
$(document).ready(function() {
    $('#dataTables-example').DataTable({
        responsive: true
    });
});


// Thông báo thành công khi thêm, sửa, xóa dữ liệu: sau 1000ms = 1s thì mất đi (cuộn lên) theo kiểu slide up
$('.message.alert').delay(1000).slideUp();
//Thông báo lỗi khi thêm, sửa dữ liệu
$('.error.alert').delay(1000).slideUp();


//Thêm ảnh chi tiết: click vào AddImages thì sẽ thêm vào trong thẻ có #insert những mục chọn file để chọn ảnh chi tiết
$(document).ready(function() {
    $("#addImages").click(function() {
        $("#insert").append('<div class="form-group"><input type="file" name="fProductDetailImage[]" style="margin-bottom: 10px;"></div>');
    });
});


//Xóa hình ảnh chi tiết bằng Ajax
$(document).ready(function() {
    $("a#del_img").on('click', function() {
        var url = URL_GET_DELETE_PRO_IMG+"/delimg/"; //đường dẫn tới route delimg để trỏ tới hàm getDelImg($id) trong controller
        var _token = $("form[name='formEditProduct']").find("input[name='_token']").val(); //khi tác động đến form cần có _token để bảo mật: trong cái form có tên là formEditProduct, tìm kiếm cái input có tên là _token (xem ở edit.blade.php)
        var urlImage = $(this).parent().find("img").attr("src"); //lấy đường dẫn hình
        var idImage = $(this).parent().find("img").attr("idImage"); //lấy id gốc của hình
        var rid = $(this).parent().find("img").attr("rid"); //lấy số thứ tự của hình trong danh sách hình chi tiết của sản phẩm đó
        $.ajax({
            type: "GET", //phải trùng với phương thức ở route tương ứng
            url: url + idImage, //vì trong route có /{id}
            cache: false,
            data: { //những tham số cần thiết để truyền sang controller
                '_token': _token,
                'urlImage': urlImage,
                'idImage': idImage
            },
            success: function(data) {
                if (data == "Ok") { //chính là "Ok" trong return "OK" ở bên controller
                    $("#" + rid).remove();
                } else {
                    alert("Lỗi xóa hình chi tiết. Vui lòng xem lại!");
                }
            }
        });
    });
});


//Lấy size theo thể loại sản phẩm
$(document).ready(function() {
    $("#pro_id").change(function() {
        var pro_id = $(this).val();
        $.ajax({
            type: 'get',
            dataType: 'html',
            url: URL_GET_SIZE_BY_CATEID,
            data: {
                pro_id: pro_id
            },
            success: function(response) {
                if (response == '') {
                    $('#size').prop('disabled', true); //disabled thẻ input trong jquery
                } else {
                    $('#size').prop('disabled', false);
                    $('#size').html(response);
                }
            }
        });
    });
});


//Tooltip
$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
});


//Admin thêm, cập nhật đơn hàng
$(document).ready(function() {
    var list_product = $("#list-product-first").html();  //lấy cái select sp
    var i = 1; //số thứ tự trong bảng
    $('#add-product').click(function() {  //click vào dấu + để thêm
        i++;
        //trong <tbody id="product-import"> mở rộng thêm nội dung vào sau cái <tr> hiện tại
        $('#product-import').append('<tr><td>' + i + '</td><td>' + list_product + '</td><td  class="size-wrapper"></td><td><input  class="form-control qty" type="number" min="1" name="qtys[]" value="1" placeholder = "Nhập số lượng" /></td></tr>');
        assignmentSizeProduct();
    });
    assignmentSizeProduct();
    assignChangeSizeQty();
    assignChangeProductQty($('.pro_id'));

    //hiển thị các size còn hàng tương ứng cho từng sp
    function assignmentSizeProduct() {
        $('.pro_id').on('change', function() { //khi click thay đổi sp
            var pro_id = $(this).val();
            var object = $(this);  //đặt thế này để chỉ tác động đến 1 thằng (tức là 1 dòng trong bảng), nếu dùng .pro_id thì nó tác động đến tất cả
            var size_wrapper = $(this).parent().parent().find('.size-wrapper');
            $.ajax({
                type: 'get',
                dataType: 'html',
                url: URL_GET_SIZE_BY_PROID_EXIST,
                data: {
                    pro_id: pro_id
                },
                success: function(response) {
                    var str = '';
                    if (response == '') {  //ko có size thì coi như là có 1 size giá trị = -1
                        str = '<select style="display:none" name="sizes[]" required>';
                        str += '<option value="-1"></option>';
                        str += '</select>';
                    } else {
                        str = '<select class="form-control size" name="sizes[]" required>';
                        str += response;
                        str += '</select>';
                    }
                    size_wrapper.html(str); //thêm đống select vào <td class="size-wrapper">
                    if (response == '') {
                        assignChangeProductQty(object);
                    } else {
                        assignChangeSizeQty();
                    }
                }
            });
        });
    }


    //Tìm số lượng sản phẩm max còn lại khi thay đổi size (có size)
    function assignChangeSizeQty() {
        $('.size').change(function() {
            var wrapper = $(this).parent().parent();
            var pro_id = $(wrapper).find('.pro_id').val();
            var size_id = $(this).val();
            $.ajax({
                type: 'get',
                dataType: 'json',
                url: URL_GET_MAX_QTY,
                data: {
                    pro_id: pro_id,
                    size_id: size_id
                },
                success: function(response) {
                    console.log('max: ' + response.max_qty);
                    var old_qty = wrapper.find('.old-qty').val();  //khi sửa đơn hàng mới có
                    var max_qty = response.max_qty;
                    if (old_qty) {
                        var old_size_id = wrapper.find('.old-size').val();
                        var new_size_id = wrapper.find('.size').val();
                        if (old_size_id == new_size_id) {
                            max_qty += parseInt(old_qty);
                        }
                    }
                    wrapper.find('.qty').attr('max', max_qty);
                }
            });
        });
    }


    //Tìm số lượng max khi thay đổi sản phẩm, áp dụng khi không có size
    function assignChangeProductQty(object){
        $(object).change(function() {
            var pro_id = $(this).val();
            var wrapper = $(this).parent().parent();
            $.ajax({
                type: 'get',
                dataType: 'json',
                url: URL_GET_MAX_QTY,
                data: {
                    pro_id: pro_id,
                },
                success: function(response) {
                    console.log('max: ' + response.max_qty);
                    wrapper.find('.qty').attr('max', response.max_qty);
                }
            });
        });
    }


    //Cập nhật đơn hàng
    var first_row = true;   //mới load trang xong: ban đầu cái dòng đầu tiên thêm vào bị ẩn đi, khi click vào dấu + thì mới show ra
    var list_product = $("#list-product-first").html();
    var k = parseInt($('#first-count').text()); //số thứ tự trong bảng
    $('#add-product-edit').click(function() {
        if(first_row == true){
            $('#first-row').show();
            $('input[name="check_has_new_detail"]').val('1');
            first_row = false;
        }else{
            k++;
            $('#product-import').append('<tr><td>' + k + '</td><td>' + list_product + '</td><td class="size-wrapper"></td><td><input class="form-control qty" type="number" min="1" name="qtys[]" value="1" placeholder = "Nhập số lượng" /></td></tr>');
            assignmentSizeProduct();
        }
    });
});

//Danh sách đơn hàng
$(function(){
    check = false;
    $('.check-all-list').click(function() {
        if (check == false) {
            check = true;
            $(".check-item").prop("checked", true);
        } else {
            check = false;
            $(".check-item").prop("checked", false);
        }
    });

    //Sửa đơn hàng
    $('.edit').click(function() {
        var status = $(this).parent().parent().attr('status_order');
        var creator = $(this).parent().parent().attr('creator');
        if (status == 4) {
            alert('Đơn hàng đã bị hủy, không thể cập nhật');
            return false;
        } else if(status == 3) {
            alert('Đơn hàng đã hoàn thành, không thể cập nhật');
            return false;
        }
    });

    //Xóa đơn hàng
    $('.delete').click(function(){
        var status = $(this).parent().parent().attr('status_order');
        var creator = $(this).parent().parent().attr('creator');
        if (status == 0) {
            alert('Đơn hàng đang chờ xử lý, không thể xóa');
            return false;
        } else if (status == 1) {
            if (creator == 1) {  //khách hàng tạo
                alert('Đơn hàng đang đợi chuyển hàng, không thể xóa');
                return false;
            } else {  //admin tạo
                return confirm('Bạn có chắc muốn xóa đơn hàng này không?');
            }
        } else if (status == 2) {
            alert('Đơn hàng đang chuyển hàng, không thể xóa');
            return false;
        } else {  //đơn hàng đã thành công hoặc đã hủy thì cho phép xóa
            return confirm('Bạn có chắc muốn xóa đơn hàng này không?');
        }
    });
});

