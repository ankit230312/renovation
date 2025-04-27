<aside class="right_menu">
    <?php if ($this->session->userdata('role') == 'admin') { ?>
        <div class="menu-app">
            <div class="slim_scroll">
                <div class="card">
                    <div class="header">
                        <h2><strong>App</strong> Menu</h2>
                    </div>
                    <div class="body">
                        <ul class="list-unstyled menu">
                            <li><a href="<?= base_url("home/admin") ?>"><i class="zmdi zmdi-face"></i><span>Admin</span></a></li>
                            <li><a href="<?= base_url("home/delivery_agent") ?>"><i class="zmdi zmdi-local-offer"></i><span>Delivery Agent</span></a></li>
                            <li><a href="<?= base_url("Slots") ?>"><i class="zmdi zmdi-timer"></i><span>Slots</span></a></li>
                            <li><a href="<?= base_url("schedule_hour") ?>"><i class="zmdi zmdi-calendar-check"></i><span>Schedule Hours</span></a></li>
                            <li><a href="<?= base_url("settings") ?>"><i class="zmdi zmdi-wrench"></i><span>Site Setting</span></a></li>
                            <li><a href="<?= base_url("pages") ?>"><i class="zmdi zmdi-file"></i><span>CMS Pages</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    <?php } ?>
    <div id="leftsidebar" class="sidebar" style="background:#6a6f95;">
        <div class="menu">
            <ul class="list">
                <li>
                    <div class="user-info m-b-20">
                        <div class="image">
                            <a href="javascript:void()"><img src="<?= base_url("uploads/") . $_SESSION['image'] ?>" alt="User"></a>
                        </div>
                        <div class="detail">
                            <h6><?= $_SESSION['name'] ?></h6>
                            <p class="m-b-0"><?= $_SESSION['mobile'] ?></p>
                            <h6 class="m-b-0"><?= strtoupper($_SESSION['role']) ?></h6>
                        </div>
                    </div>
                </li>
                <li> <a href="<?= base_url("home") ?>"><i class="zmdi zmdi-home"></i><span>Dashboard</span></a></li>
                <li class=""><a href="<?= base_url("home/vendor") ?>"><i class="zmdi zmdi-face"></i><span>Vendor</span></a></li>
                <?php if ($_SESSION['role'] == 'admin') { ?>

                    <li class="d-none"><a href="<?= base_url("home/vendor") ?>"><i class="zmdi zmdi-face"></i><span>Vendor</span></a></li>
                <?php } ?>
                <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'subadmin') { ?>
                    <li> <a href="<?= base_url('brand') ?>"><i class="zmdi zmdi-view-list-alt"></i><span>Brand</span></a></li>
                    <li> <a href="<?= base_url('category') ?>"><i class="zmdi zmdi-view-list-alt"></i><span>Category</span></a></li>
                <?php } ?>
                <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'subadmin' || $_SESSION['role'] != 'order_manager') { ?>
                    <li> <a href="<?= base_url('products') ?>"><i class="zmdi zmdi-shopping-cart"></i><span>Products</span></a></li>
                <?php } ?>
                <!-- <li> <a href="<?= base_url('products/get_product_detail') ?>"><i class="zmdi zmdi-view-list-alt"></i><span>Products Detail</span></a></li> -->
                <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'subadmin') { ?>
                    <!-- <li> <a href="<?= base_url('basket') ?>"><i class="zmdi zmdi-shopping-basket"></i><span>Basket</span></a></li> -->
                    <?php
                    $enquiryCount = '';
                    $total_enquiry = $this->db->query("select count(*) as enquiry from enquiry where status='NEW'")->row();
                    if ($total_enquiry->enquiry > 0) {
                        $enquiryCount = $total_enquiry->enquiry;
                    } else {
                        $enquiryCount = 0;
                    }
                    ?>
                    <li class="d-none"> <a href="<?= base_url('enquiry') ?>"><i class="zmdi zmdi-label"></i><span>Enquiry <span class="badge"><?= $enquiryCount ?></span></span></a></li>
                    <li class="d-none"> <a href="<?= base_url('deals') ?>"><i class="zmdi zmdi-local-offer"></i><span>Deals</span></a></li>
                    <li><a href="<?= base_url("banners") ?>" onclick="return false;" class="menu-toggle"><i class="zmdi zmdi-slideshow"></i><span>Banners</span></a>
                        <ul class="ml-menu">
                            <li><a href="<?= base_url("banners/app_banners/") ?>">App Banners</a></li>
                            <li><a href="<?= base_url("banners/featured_prod_banners") ?>">Featured Product</a></li>
                            <li><a href="<?= base_url("banners/gift_banners") ?>">Gift Banners</a></li>
                            <li><a href="<?= base_url("banners/deal_banners") ?>">Deal Banners</a></li>
                          
                            <li><a href="<?= base_url("banners/new_banners") ?>">New Banners</a></li>
                          
                        </ul>
                    </li>
                <?php } ?>
                <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'subadmin' || $_SESSION['role'] == 'order_manager') { ?>
                    <li><a href="<?= base_url("orders") ?>" onclick="return false;" class="menu-toggle"><i class="zmdi zmdi-shopping-cart"></i><span>Orders</span></a>
                        <ul class="ml-menu">
                            <li><a href="<?= base_url("orders/new_orders/") ?>">New Orders</a></li>

                            <li><a href="<?= base_url("orders/ongoing_orders") ?>">Ongoing Orders</a></li>
                            <li><a href="<?= base_url("orders/completed_orders") ?>">Completed Orders</a></li>
                            <li><a href="<?= base_url("orders/cancelled_orders") ?>">Cancelled Orders</a></li>
                            <li><a href="<?= base_url("orders/all_orders") ?>">All Orders</a></li>
                              <li><a href="<?= base_url("orders/order_allocate") ?>">Order Allocate</a></li>

                        </ul>
                    </li>
                <?php } ?>
                <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'subadmin' || $_SESSION['role'] == 'order_manager') { ?>
                    <li class="d-none"><a href="<?= base_url("abandon_cart") ?>"><i class="zmdi zmdi-shopping-cart"></i><span>Abandon Cart</span></a>
                    </li>
                <?php } ?>
                <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'subadmin') { ?>
                    <li> <a href="<?= base_url('coupons') ?>"><i class="zmdi zmdi-label"></i><span>Coupons</span></a></li>
                <?php } ?>
                <?php if ($_SESSION['role'] == 'admin') { ?>
                    <li> <a href="<?= base_url('users') ?>"><i class="zmdi zmdi-folder-person"></i><span>Users</span></a></li>
                    <!--<li><a href="<?= base_url("notification") ?>" onclick="return false;" class="menu-toggle"><i class="zmdi zmdi-notifications-none"></i><span>Notification</span></a>-->
                    <!--    <ul class="ml-menu">-->
                    <!--        <li><a href="<?= base_url("notification/index/") ?>">All User</a></li>-->
                    <!--        <li><a href="<?= base_url("notification/Specific") ?>">Specific Users</a></li>-->
                    <!-- <li><a href="<?= base_url("notification/all_user_sms/") ?>">All User SMS</a></li>
                <!--        <li><a href="<?= base_url("notification/specific_user_sms") ?>">Specific Users SMS</a></li> -->
                    <!--    </ul>-->
                    <!--</li>-->
                <?php } ?>
                <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'subadmin') {  ?>
                    <li> <a href="<?= base_url('city') ?>"><i class="zmdi zmdi-my-location"></i><span>City</span></a></li>
                    <li> <a href="<?= base_url('locality') ?>"><i class="zmdi zmdi-my-location"></i><span>Locality</span></a></li>
                <?php } ?>
                <!-- <li> <a href="<?= base_url('home/stock_report') ?>"><i class="zmdi zmdi-home"></i><span>Stock Purchase Report</span></a></li> -->
                <?php if ($_SESSION['role'] == 'admin') { ?>

                    <!-- <li class=""><a href="<?php // base_url("stock") ?>"  class="menu-toggle"><i class="zmdi zmdi-home"></i><span>Stock</span></a></li> -->
                    <li class="d-none"><a href="<?= base_url("notification") ?>" onclick="return false;" class="menu-toggle"><i class="zmdi zmdi-home"></i><span>Report</span></a>
                        <ul class="ml-menu">
                            <li><a href="<?= base_url("orders/report") ?>">Order Invoice</a></li>
                            <li><a href="<?= base_url("orders/vendor") ?>">Vendor Order</a></li>
                            <li><a href="<?= base_url("users/report") ?>">Users</a></li>
                            <li><a href="<?= base_url("home/report") ?>">Sales Report</a></li>
                            <li><a href="<?= base_url("reports/transactions") ?>">Tansactions</a></li>
                            <li><a href="<?= base_url("reports/today_order") ?>">Today Order</a></li>
                        </ul>
                    </li>
                <?php } ?>
            </ul>
        </div>
    </div>
</aside>