 <!-- ========== Left Sidebar Start ========== -->
 <div class="vertical-menu">

<div data-simplebar class="h-100">

    <!--- Sidemenu -->
    <div id="sidebar-menu">
        <!-- Left Menu Start -->
        <ul class="metismenu list-unstyled" id="side-menu">
            <li class="menu-title" key="t-menu">Menu</li>
            <li>
                <a href="<?=base_url('portal/dashboard')?>" class="waves-effect">
                <i class="bx bx-home-circle"></i>
                    <span >Dashboard</span>
                </a>
            </li>
            <!-- Master dropdown starts -->
            <li>
                <a href="javascript: void(0);" class="has-arrow waves-effect">
                    <i class="bx bx-cog"></i>
                    <span>Master</span>
                </a>
                <ul class="sub-menu" aria-expanded="false">
                    <li><a href="<?= base_url('portal/categories') ?>">Categories</a></li>
                </ul>
            </li>
            <!-- Master dropdown ends -->
            <li>
                <a href="<?=base_url('portal/products')?>" class="waves-effect">
                <i class="bx bx-power-off"></i>
                    <span >Products</span>
                </a>
            </li>
            <li>
                <a href="<?=base_url('portal/logout')?>" class="waves-effect">
                <i class="bx bx-power-off"></i>
                    <span >Logout</span>
                </a>
            </li>
        </ul>
    </div>
    <!-- Sidebar -->
</div>
</div>
<!-- Left Sidebar End -->