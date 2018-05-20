<aside class="main-sidebar">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel -->
        <div class="user-panel">
            <div class="pull-left image">
                <img src="{{ asset('resources/upload/images/member/'.Session::get('member')['id'].'/'.Session::get('member')['image']) }}" class="img-circle"
                alt="User Image">
            </div>
            <div class="pull-left info">
                <p>{{ Session::get('member')['name'] }}</p>
                <a href=""><i class="fa fa-circle text-success"></i> Online</a>
            </div>
        </div>

        <!-- sidebar menu: : style can be found in sidebar.less -->
        <ul class="sidebar-menu" data-widget="tree">
            <li class="mytreeview" id="home">
                <a href="{{ url('admin/home/') }}">
                    <i class="fa fa-home"></i> <span>Trang chủ</span>
                </a>
            </li>

            <li class="treeview mytreeview" id="product">
                <a href="">
                    <i class="fa fa-product-hunt"></i>
                    <span>Quản lý sản phẩm</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li id="listcate"><a href="{{ URL::route('admin.cate.getList') }}"><i class="fa fa-circle-o"></i>Quản lý thể loại</a></li>
                    <li id="listsport"><a href="{{ URL::route('admin.sport.getList') }}"><i class="fa fa-circle-o"></i>Quản lý bộ môn</a></li>
                    <li id="listbrand"><a href="{{ URL::route('admin.brand.getList') }}"><i class="fa fa-circle-o"></i>Quản lý thương hiệu</a></li>
                    <li id="listsupplier"><a href="{{ URL::route('admin.supplier.getList') }}"><i class="fa fa-circle-o"></i>Quản lý nhà cung cấp</a></li>
                    <li id="listproduct"><a href="{{ URL::route('admin.product.getList') }}"><i class="fa fa-circle-o"></i>Quản lý sản phẩm</a></li>
                    <li id="listproperty"><a href="{{ URL::route('admin.property.getList') }}" data-toggle="tooltip" data-placement="bottom" title="Kích cỡ và số lượng"><i class="fa fa-circle-o"></i>Thuộc tính sản phẩm</a></li>
                    <li id="listsize"><a href="{{ URL::route('admin.size.getList') }}"><i class="fa fa-circle-o"></i>Quản lý size</a></li>
                </ul>
            </li>

            <li class="treeview mytreeview" id="news">
                <a href="">
                    <i class="fa fa-newspaper-o"></i>
                    <span>Quản lý tin tức</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li id="listnewscate"><a href="{{ URL::route('admin.newscate.getList') }}"><i class="fa fa-circle-o"></i>Quản lý loại tin</a></li>
                    <li id="listnews"><a href="{{ URL::route('admin.news.getList') }}"><i class="fa fa-circle-o"></i>Quản lý tin tức</a></li>
                </ul>
            </li>

            <li class="treeview mytreeview" id="video">
                <a href="">
                    <i class="fa fa-video-camera"></i>
                    <span>Quản lý video</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li id="listvideocate"><a href="{{ URL::route('admin.videocate.getList') }}"><i class="fa fa-circle-o"></i>Quản lý loại video</a></li>
                    <li id="listvideo"><a href="{{ URL::route('admin.video.getList') }}"><i class="fa fa-circle-o"></i>Quản lý video</a></li>
                </ul>
            </li>

            <li class="treeview mytreeview" id="banner">
                <a href="">
                    <i class="fa fa-picture-o"></i>
                    <span>Quản lý banner</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li id="largebanner"><a href="{{ URL::route('admin.largebanner.getList') }}"><i class="fa fa-circle-o"></i>Banner lớn</a></li>
                    <li id="smallbanner"><a href="{{ URL::route('admin.smallbanner.getList') }}"><i class="fa fa-circle-o"></i>Banner nhỏ</a></li>
                </ul>
            </li>

            <li class="treeview mytreeview" id="people">
                <a href="">
                    <i class="fa fa-users"></i>
                    <span>Quản lý người dùng</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li id="customer"><a href="{{ URL::route('admin.customer.getList') }}"><i class="fa fa-circle-o"></i>Quản lý khách hàng</a></li>
                    <li id="user"><a href="{{ URL::route('admin.user.getList') }}"><i class="fa fa-circle-o"></i>Quản lý thành viên</a></li>
                    <li id="member"><a href="{{ URL::route('admin.member.getList') }}"><i class="fa fa-circle-o"></i>Quản lý nhân viên</a></li>
                </ul>
            </li>

            <li class="treeview mytreeview" id="deal">
                <a href="">
                    <i class="fa fa-shopping-cart"></i>
                    <span>Quản lý giao dịch</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li id="listorder"><a href="{{ URL::route('admin.order.getList') }}"><i class="fa fa-circle-o"></i>Quản lý đơn hàng</a></li>
                    <li id="listshipping"><a href="{{ route('admin.shipping.getList') }}"><i class="fa fa-circle-o"></i>Phân công giao hàng</a></li>
                </ul>
            </li>
            
            <li class="mytreeview" id="salecode">
                <a href="{{ route('admin.salecode.getList') }}">
                    <i class="fa fa-barcode"></i>
                    <span>Quản lý mã giảm giá</span>
                </a>
            </li>

            <li class="mytreeview" id="statistic">
                <a href="{{ route('admin.statistic.getTimeStatistic') }}">
                    <i class="fa fa-bar-chart"></i>
                    <span>Thống kê bán hàng</span>
                </a>
            </li>

        </ul>
    </section>
    <!-- /.sidebar -->
</aside>