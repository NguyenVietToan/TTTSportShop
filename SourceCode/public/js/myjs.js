//Lấy danh sách huyện theo tỉnh, xã theo huyện
//Ban đầu thì phần select huyện, xã bị disabled
//Khi click vào select tỉnh thì loại bỏ disabled ở huyện và đổ ra các huyện tương ứng với tỉnh đó, trong khi xã vẫn bị disabled
//Khi click vào select huyện thì loại bỏ disabled ở xã và đổ ra các xã tương ứng với huyện đó
$(document).ready(function() {
	$('#province').change(function() {  //change(): Xác định một thành phần đã được thay đổi.
		//disabled xã
		$('#ward').html('<option value="0">Phường/Xã</option>');  //Gán nội dung HTML cho thành phần
		$('#ward').attr('disabled','disabled');  //gán giá trị cho thuộc tính

		var id_province = $(this).val();
		var url         = GET_ADDRESS_URL+"/province/";
		var _token      = $("form[name='update_attribute']").find("input[name='_token']").val();  //đặt tên cho form này, tìm đến thẻ input _token để lấy giá trị _token

		$.ajax({
			type: "GET",
			url: url+id_province,
			cache: false,
			data: {
				'_token':_token,
				'id':id_province
			},
			success: function(data) {
				if (data != null) {
					//hiển thị các huyện tương ứng với tỉnh và loại bỏ disabled ở huyện
					$('#district').html(data);
					$('#district').removeAttr('disabled');
				} else {
					alert("Lỗi! Vui lòng liên hệ với quản trị viên!");
				}
			}
		});
	});

	$('#district').change(function() {
		var id_district = $(this).val();
		var url         = GET_ADDRESS_URL+"/district/";
		var _token      = $("form[name='update_attribute']").find("input[name='_token']").val();

		$.ajax({
			type: "GET",
			url: url+id_district,
			cache: false,
			data: {
				'_token':_token,
				'id':id_district
			},
			success: function(data) {
				if (data != null) {
					$('#ward').html(data);
					$('#ward').removeAttr('disabled');
				} else {
					alert("Lỗi! Vui lòng liên hệ với quản trị viên!");
				}
			}
		});
	});
});


//Thông báo lỗi và thông báo khác
$(document).ready(function() {
	$('.message.alert').delay(5000).slideUp();

	$('.error.alert').delay(5000).slideUp();
});