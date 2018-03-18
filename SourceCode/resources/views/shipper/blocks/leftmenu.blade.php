<!-- Left side column. contains the logo and sidebar -->
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
            <li class="mytreeview @if(request()->is('shipper/home')) active @endif" id="home">
                <a href="{{ route('shipper.index') }}">
                    <i class="fa fa-home"></i> <span>Trang chủ</span>
                </a>
            </li>

            <li class="treeview mytreeview" id="order">
                <a href="">
                    <i class="fa fa-shopping-bag"></i>
                    <span>Quản lý đơn hàng</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li id="processing"><a href="{{ route('shipper.getProcessing') }}"><i class="fa fa-circle-o"></i>Đơn hàng được phân công</a></li>
                    <li id="waiting-accepted"><a href="{{ route('shipper.getWaitingAccepted') }}"><i class="fa fa-circle-o"></i>Đơn hàng chờ xác nhận</a></li>
                    <li id="history"><a href="{{ route('shipper.getHistory') }}"><i class="fa fa-circle-o"></i>Lịch sử giao hàng</a></li>
                </ul>
            </li>

            <li class="treeview mytreeview" id="account">
                <a href="">
                    <i class="fa fa-user-circle-o"></i>
                    <span>Quản lý tài khoản</span>
                    <span class="pull-right-container">
                        <i class="fa fa-angle-left pull-right"></i>
                    </span>
                </a>
                <ul class="treeview-menu">
                    <li id="profile"><a href="{{ route('shipper.getProfile') }}"><i class="fa fa-circle-o"></i>Thông tin cá nhân</a></li>
                    <li id="update-password"><a href="{{ route('shipper.getPassword') }}"><i class="fa fa-circle-o"></i>Đổi mật khẩu</a></li>
                </ul>
            </li>
        </ul>
    </section>
    <!-- /.sidebar -->
</aside>
<!-- /.main-sidebar -->