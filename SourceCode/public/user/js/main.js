
//-------------------------------------------------------------------------------------------
// Click vào nút messenger thì hiển thị khung chat FB
var countClickMess = 0;
function messenger() {
    countClickMess += 1;
    if (countClickMess % 2 == 1) {
        $("#messBox").css("display", "block");
    } else {
        $("#messBox").css("display", "none");
    }
}



//-------------------------------------------------------------------------------------------
// Bắt sự kiện thay đổi ngôn ngữ
$(function() {
    $('.lang').change(function() {
        var url = BASE_URL + '/lang';
        var _token = $('form[name="lang_form"]').find('input[name="_token"]').val();
        var lang = $(this).val();
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: {
                lang: lang,
                _token: _token
            }
        }).done(function(data) {
            if (data.state == 1) { //do data trả về từ controller là chuỗi json nên phải viết dạng data.state
                location.reload();
            }
        });
    });
});



//-------------------------------------------------------------------------------------------
// Hiệu ứng của Dropdown Menu
jQuery(document).ready(function() {
    $(".dropdown").hover(function() {
        $('.dropdown-menu', this).fadeIn("fast");
    }, function() {
        $('.dropdown-menu', this).fadeOut("fast");
    });
});



//-------------------------------------------------------------------------------------------
// Hiệu ứng cuộn về đầu trang
$(document).ready(function() {
    var scrollTop = $(".scrollTop");
    $(scrollTop).css("opacity", "0");  //ban đầu cho nó ẩn đi

    //khi cuộn đến vị trí cách top > 80px thì cho nó hiện lên
    $(window).scroll(function() {
        var topPos = $(this).scrollTop();
        if (topPos > 80) {
            $(scrollTop).css("opacity", "1");

        } else {
            $(scrollTop).css("opacity", "0");
        }
    });


    //khi click vào back to top
    $(scrollTop).click(function() {
        $('html, body').animate({
            scrollTop: 0
    }, 800);
    return false;
    });
});



//-------------------------------------------------------------------------------------------
$(function() {

//Hàm lấy giá trị filter theo mảng, tức là lấy liên tiếp giá trị filter được click
    function multiple_values(inputclass) {
        var val = new Array();  //mảng này sẽ lưu giá trị của các checkbox
        $("." + inputclass + ":checked").each(function() { //:checked để kiểm tra trạng thái của checkbox trong jquery
            val.push($(this).val()); //Hàm array.push() để thêm một phần tử vào cuối mảng.
        });
        return val;
    }


    //Lấy và truyền giá trị tham số
    function filter() {
        sport  = multiple_values('sport');
        cate   = multiple_values('cate');
        brand  = multiple_values('brand');
        gender = multiple_values('gender');
        sort   = $('.sort').val();
        sprice = $('.sprice').val();
        eprice = $('.eprice').val();
        $.ajax({
            url: URL_GET_PRODUCT_AJAX.url, //lấy từ bên product.blade.php truyền sang --> tương đương với url: route('getProductAjax')
            type: 'get',
            data: { //chuỗi json
                sport: sport,
                cate: cate,
                brand: brand,
                gender: gender,
                sort: sort,
                sprice: sprice,
                eprice: eprice,
                paginateUrl: URL_GET_PRODUCT_AJAX.paginate_url //tương đương với paginateUrl: $paginateUrl
            },
            success: function(result) {
                console.log(result);
                $('#updateDiv').html(result);
            }
        });
    }


    //Lọc theo các itemFiler trước rồi sau đó mới chọn theo slider-range
    var sort, sport, cate, brand, gender;
    $('.itemFilter').change(function() {
        $('#updateDiv').html('<div id="loaderpro"></div>');
        filter();
    });


    //Lọc theo slider-range xong rồi mới click vào các itemFiler
    var sprice = $(".sprice").val();
    var eprice = $(".eprice").val();
    $("#slider-range").slider({
        range: true,
        min: 100000,
        max: 10000000,
        step: 50000, //khoảng cách mỗi bước nhảy là 50k
        values: [sprice, eprice],
        slide: function(event, ui) {
            $("#priceshow").html(ui.values[0] + "VND - " + ui.values[1] + "VND");
            $(".sprice").val(ui.values[0]);
            $(".eprice").val(ui.values[1]);
            filter();
        }
    });
    $("#priceshow").html($("#slider-range").slider("values", 0) + "VND - " + $("#slider-range").slider("values", 1) + "VND");


//Lấy danh sách video theo filter
    var videocate;
    $('.videoFilter').change(function() {
        $('#updateVideoDiv').html('<div id="loaderpro"></div>');
        videocate  = multiple_values('videocate');
        $.ajax({
            url: URL_GET_VIDEO_AJAX.url,  //lấy từ bên video.blade.php truyền sang --> tương đương với url: route('getVideoAjax')
            type: 'get',
            data: {   //chuỗi json
                videocate: videocate,
                paginateUrl: URL_GET_VIDEO_AJAX.paginate_url //lấy từ bên video.blade.php truyền sang --> tương đương với paginateUrl: $paginateUrl
            },
            success:function(result){
                console.log(result);
                $('#updateVideoDiv').html(result);
            }
        });
    });


//Lấy danh sách tin tức theo filter
    var newscate;
    $('.newsFilter').change(function() {
        $('#updateNewsDiv').html('<div id="loaderpro"></div>');
        newscate  = multiple_values('newscate');
        $.ajax({
            url: URL_GET_NEWS_AJAX.url,  //lấy từ bên video.blade.php truyền sang --> tương đương với url: route('getNewsAjax')
            type: 'get',
            data: {   //chuỗi json
                newscate: newscate,
                paginateUrl: URL_GET_NEWS_AJAX.paginate_url //lấy từ bên video.blade.php truyền sang --> tương đương với paginateUrl: $paginateUrl
            },
            success:function(result){
                console.log(result);
                $('#updateNewsDiv').html(result);
            }
        });
    });

});



//-------------------------------------------------------------------------------------------
// Hiệu ứng sản phẩm bay vào giỏ hàng
function animationAddToCart(object){
    if ($(object).hasClass('disable')) {
        return false;
    }
    // $(document).find('.add-to-cart').addClass('disable');
    var parent     = $(object).parents('.product-info'); //parents là lấy tất cả các thằng tổ tiên của thằng this
    var src        = parent.find('img').attr('src'); //lấy đường dẫn hình ảnh của sản phẩm
    var cart       = $(document).find('#shopping-cart');  //ở view header
    var parentTop  = parent.offset().top; //hàm offset lấy ra vị trí top, left... của 1 thành phần nào đó
    var parentLeft = parent.offset().left;
    $('<img />', {
        class: 'img-pro-fly',
        src: src,
    }).appendTo('body').css({ //.css() ở đây để hình ảnh xuất hiện bên trong khung của .product-info
        'top': parentTop,
        'left': parentLeft + parent.width() - 50 //vị trí bên trái + chiều rộng của .product-info - chiều rộng của .img-pro-fly
    });; //khi click thì sẽ thêm vào 1 thẻ img vào body
    setTimeout(function() {
        $(document).find('.img-pro-fly').css({
            'top': cart.offset().top,
            'left': cart.offset().left
        });
        setTimeout(function() {
            $(document).find('.img-pro-fly').remove(); //bay vào sau 1s thì nó mất đi
            var cart_count = parseInt($('.cart-count').text()) + 1;  //tăng số lượng sản phẩm trong giỏ, text() dùng để lấy đoạn text nằm trong cặp thẻ
            $('.cart-count').text(cart_count);
        }, 1000);
    }, 500); //sau 500ms thì .img-pro-fly sẽ xuất hiện ở vị trí giỏ hàng #shopping-cart
    setTimeout(function() {
            location.reload();  //sau khi sp bay vào giỏ thì reload lại để hiển thị ngay nội dung ở trên giỏ hàng trên header
        }, 1500);
}



//Thêm vào giỏ
$(function() {
//Trang home
    $('.add-to-cart').click(function() {  //click vào Thêm vào giỏ
        $('.size').slideUp();  //ẩn (slideUp()) hết các list size của các sản phẩm khác (nếu đang hiện)
        var action_wrapper = $(this).parent();
        if ( ! action_wrapper.hasClass('no-size') ) {  //nếu sản phẩm ko có no-size, tức là có size thì mới hiện (slideDown()) list size lên
            $(this).parent().find('.size').slideDown();
        } else {  //sản phẩm ko có size thì click vào "Thêm vào giỏ" sẽ bay vào giỏ hàng luôn
            var add_to_cart = $(this);
            var pro_id      = $(this).parent().attr('pro_id');  //lấy giá trị thuộc tính
            var url         = ADD_TO_CART_URL;  //ở master
            var _token      = CSRF_TOKEN;    //ở master
            $.ajax({
                type: 'POST',
                url: url,   //gọi đến postAddItem() trong CartController
                dataType: 'json',
                data: {
                    pro_id: pro_id,
                    _token: _token,
                    url: url
                }
            }).done(function(data) {
                if (data.state == 1) {   //1 ở đây là trạng thái trả về từ controller
                    animationAddToCart(add_to_cart);   //hiệu ứng bay vào giỏ
                }else{
                    alert(data.msg);
                }
            });
        }
    });


    //Click vào dấu x để ẩn bảng chọn size
    $('.close-popup').click(function() {
        $(this).parent().parent().slideUp();
    });


    //Khi list size được hiển thị (sp có size)
    //Khi size còn hàng thì thêm vào giỏ (nếu hết hàng thì disabled)
    $('.list.active').click(function() {
        var size_wrapper = $(this).parent().parent();   //là phần hiển thị danh sách size
        var add_to_cart  = $(this).parent().parent().parent().find('.add-to-cart');
        var pro_id       = $(this).parent().parent().parent().attr('pro_id');
        var size         = $(this).attr('size');
        var url          = ADD_TO_CART_URL;
        var _token       = CSRF_TOKEN;
        $.ajax({
            type: 'POST',
            url: url,
            dataType: 'json',
            data: {
                pro_id: pro_id,
                size: size,
                _token: _token,
                url: url
            }
        }).done(function(data) {
            if (data.state == 1) {
                $(size_wrapper).slideUp();  //sau khi thêm vào giỏ thì danh sách size ẩn đi
                animationAddToCart(add_to_cart);
            }
        });
    });

    //Sử dụng cho list size ở chi tiết mặt hàng
    $('.list-detail.active').click(function() {
        var size_wrapper = $(this).parent().parent();   //là phần hiển thị danh sách size
        var add_to_cart  = $(this).parent().parent().parent().find('.add-to-cart');
        var pro_id       = $(this).parent().parent().parent().attr('pro_id');
        var size         = $(this).attr('size');
        var url          = ADD_TO_CART_URL;
        var _token       = CSRF_TOKEN;
        $.ajax({
            type: 'POST',
            url: url,
            dataType: 'json',
            data: {
                pro_id: pro_id,
                size: size,
                _token: _token,
                url: url
            }
        }).done(function(data) {
            if(data.state == 1){
                location.reload();
            }
        });
    });


//Trang product_detail: thêm vào giỏ thì ko có hiệu ứng bay vào giỏ, chuyển sang trang giỏ hàng luôn
    //Không có size thì mới có nút Thêm vào giỏ
    $('.add-to-cart-detail').click(function() {
        var action_wrapper = $(this).parent().parent();  //là thằng ul
        var pro_id         = $(this).parent().parent().attr('pro_id');
        var url            = ADD_TO_CART_URL;
        var _token         = CSRF_TOKEN;
        $.ajax({
            type: 'POST',
            url: url,
            dataType: 'json',
            data: {
                pro_id: pro_id,
                _token: _token,
                url: url
            }
        }).done(function(data) {
            if (data.state == 1) {
                var cart_count = parseInt($('.cart-count').text()) + 1;
                $('.cart-count').text(cart_count);  //tăng số lượng
                window.location = CART_URL;
            } else {
                alert(data.msg);
            }
        });

    });


    //Có size thì hiển thị ds size và khi click vào size thì sẽ thêm vào giỏ
    $('.detail.active').click(function() {
        var pro_id = $(this).parent().parent().parent().attr('pro_id');
        var size   = $(this).attr('size');
        var url    = ADD_TO_CART_URL;
        var _token = CSRF_TOKEN;
        $.ajax({
            type: 'POST',
            url: url,
            dataType: 'json',
            data: {
                pro_id: pro_id,
                size: size,
                _token: _token,
                url: url
            }
        }).done(function(data) {
            if(data.state == 1){
                var cart_count = parseInt($('.cart-count').text()) + 1;
                $('.cart-count').text(cart_count);
                window.location = CART_URL;
            }
        });
    });


//-------------------------------------------------------------------------------------------
//Thêm vào danh sách yêu thích
    $('.add-to-wishlist').click(function(){
        var pro_id = $(this).attr('pro_id');
        var heart  = $(this).find('.fa-heart');
        var parent = $(this).parent();
        var _token = CSRF_TOKEN;
        var url    = ADD_TO_WISHLIST_URL;
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: {
                pro_id: pro_id,
                _token: _token
            }
        }).done(function(data){
            if(data.state == 1){
                var like_count = parent.find('.like_count');  //đếm số lượt thích
                if (data.is_liked == 1) {  //đổi màu thành đỏ
                    heart.css('color', 'red');
                } else {
                    heart.css('color', 'black');
                }
                like_count.text(data.like_number);
                $('.total_user_like_number').text(data.total_user_like_number);
            }
        });
    });


//Xóa một sản phẩm đã được like trong danh sách yêu thích
    $('.delete-like').click(function(){
        var _token          = CSRF_TOKEN;
        var pro_id          = $(this).parent().attr('pro_id');
        var product_wrapper = $(this).parent().parent();  //cái thẻ div ngoài
        var url             = DELETE_FROM_WISHLIST_URL;
        var _token          = CSRF_TOKEN;
        $.ajax({
            url: url,
            type: 'POST',
            dataType: 'json',
            data: {
                pro_id: pro_id,
                _token: _token
            }
        }).done(function(data){
            if(data.state == 1){
                $(product_wrapper).remove();  //xóa cả cái thẻ div ngoài
                $('.total_user_like_number').text(data.total_user_like_number);
            }
        });
    });
});

//-------------------------------------------------------------------------------------------
//Tooltip
$(document).ready(function() {
    $('[data-toggle="tooltip"]').tooltip();
});