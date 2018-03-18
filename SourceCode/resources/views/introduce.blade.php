@extends('user.master')
@section('content')

<div class="introduce">
	<div class="container">
		<ul class="breadcrumb">
    		<li>
      			<a href="{{ route('getHome') }}">Trang chủ</a>
      			<span class="divider"></span>
    		</li>
    		<li class="active">Giới thiệu</li>
  		</ul>
  		<!-- /.breadcrumb -->

	<div id="introduce-page">
		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<h2 class="title text-center">Giới thiệu về cửa hàng</h2>
				<img src="{{ asset('resources/upload/images/introduce/0.jpg') }}" alt="" width="100%">
				<h3 align="center" style="text-transform: uppercase; font-size: 20px !important"><b>Tuấn Phương Sports</b></h3>
				<p>
					<b>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Trong hơn một thập kỷ qua, nhắc đến Tuấn Phương Sports là nhắc đến thương hiệu rất quen thuộc và đáng tin cậy của người tiêu dùng trên cả nước về các mặt hàng đặc chủng chuyên ngành Thể Dục Thể Thao.</b>
				</p>
				<p>
					&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Tuấn Phương Sports luôn tự hào là nhà tiên phong cung cấp cho thị trường Việt Nam những sản phẩm Thể Thao mới nhất với những thương hiệu hàng đầu trên thế giới, hầu hết có xuất xứ từ Mỹ như: WILSON, JONHSON, BODY-SOLIDE, NIKE, ADIDAS... phong phú về kiểu dáng, chất lượng hoàn hảo, cấu trúc kỷ thuật của từng loại sản phẩm hoàn thiện đến từng chi tiết. Nằm ngay trung tâm thành phố, thuộc sở hữu của riêng mình, Tuấn Phương Sports đã gây dựng được uy tín, phát triển thương hiệu một cách bền vững và đã chiếm lĩnh được sự quan tâm của khách hàng.
				</p>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
				<img src="{{ asset('resources/upload/images/introduce/1.jpg') }}" alt="" width="100%" height="400">
			</div>
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
				<img src="{{ asset('resources/upload/images/introduce/2.jpg') }}" alt="" width="100%" height="400">
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<p style="margin-top: 10px">
					&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Với hơn 1000 sản phẩm thể thao, từ các loại máy dành cho các phòng tập chuyên nghiệp, bán chuyên nghiệp, phòng tập gia đình..., các loại vợt, quần áo và giày tennis, cầu lông, golf... đến các phụ kiện như nón, túi xách... và rất nhiều sản phẩm chăm sóc sức khoẻ như ghế massage cao cấp, đai massage làm eo thon, máy massage chân thư giãn, các dụng cụ massage toàn thân... Quý khách sẽ hoàn toàn hài lòng với <span style="color: red">Giá Cả Phải Chăng – Dịch Vụ Bảo Trì, Bảo Hành Chuyên Nghiệp - Dịch Vụ Hậu Mãi Chu Đáo.</span>
				</p>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
				<img src="{{ asset('resources/upload/images/introduce/3.jpg') }}" alt="" width="100%" height="400">
			</div>
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
				<img src="{{ asset('resources/upload/images/introduce/16.jpg') }}" alt="" width="100%" height="400">
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<p style="margin-top: 10px">
					&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Chọn lựa sản phẩm phù hợp với nhu cầu sử dụng đồng thời tương xứng với giá trị vật chất đã chi trả là điều bất cứ người tiêu dùng nào cũng quan tâm. Hiểu được điều này, Tuấn Phương Sports với xuất phát từ cái tâm của một nhà kinh doanh chân chính, luôn nhắc nhở khách hàng của mình, lựa chọn và cân nhắc kỹ lưỡng trước khi mua sản phẩm.
				</p>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
				<img src="{{ asset('resources/upload/images/introduce/5.jpg') }}" alt="" width="100%" height="400">
			</div>
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
				<img src="{{ asset('resources/upload/images/introduce/6.jpg') }}" alt="" width="100%" height="400">
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<p style="margin-top: 10px">
					&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Đặt mục tiêu lâu dài là phục vụ vì quyền lợi và sức khỏe người tiêu dùng, Tuấn Phương Sports luôn cố gắng tạo cho quý khách tâm lý thoải mái khi đến cửa hàng với nhiều cơ hội được tìm hiểu tính năng cũng như tư vấn từ kỹ thuật đến việc ổn định thống nhất biểu giá cố định khi giới thiệu và chào bán sản phẩm.
				</p>
			</div>
		</div>

		<div class="row">
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
				<img src="{{ asset('resources/upload/images/introduce/7.jpg') }}" alt="" width="100%" height="400">
			</div>
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
				<img src="{{ asset('resources/upload/images/introduce/8.jpg') }}" alt="" width="100%" height="400">
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<p style="margin-top: 10px">
					&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Không ngừng phát triển và phục vụ ngày càng tốt hơn khách hàng của mình, Tuấn Phương Sports đã đầu tư hơn 1 tỷ đồng cải tạo và xây dựng trung tâm trưng bày sản phẩm, tạo dựng mặt bằng khang trang, hiện đại hơn, từ đó khẳng định vị thế và tên tuổi Tuấn Phương Sports - Một trung tâm phân phối lớn và uy tín hàng đầu trên cả nước.
				</p>
			</div>
		</div>

		<div class="row" style="margin-bottom: 40px;">
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
				<img src="{{ asset('resources/upload/images/introduce/9.jpg') }}" alt="" width="100%" height="400">
			</div>
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
				<img src="{{ asset('resources/upload/images/introduce/10.jpg') }}" alt="" width="100%" height="400">
			</div>
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
				<img src="{{ asset('resources/upload/images/introduce/11.jpg') }}" alt="" width="100%" height="400">
			</div>
			<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
				<img src="{{ asset('resources/upload/images/introduce/12.jpg') }}" alt="" width="100%" height="400">
			</div>
			<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
				<p style="margin-top: 10px">
					&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; Sản phẩm <span style="color: red">100% hàng chính hãng</span> của công ty, các thương hiệu hàng đầu thế giới. Hãy đến với Tuấn Phương Sports - để chọn lựa cho gia đình bạn những sản phẩm thể thao hàng đầu thế giới !
				</p>
			</div>
		</div>
	</div>
</div>

@endsection