<?php $GetAllPermission = mysql_fetch_array(mysql_query("SELECT * FROM admin_group WHERE id = '".$_SESSION['modaratorid']."'")); ?>
<div class="leftNav">
    	<ul id="menu">
        	<li class="dash"><a href="index.php" title="" class="active"><span>Dashboard</span></a></li>
            <li class="dash"><a href="#" title="" <?php if(basename($_SERVER['PHP_SELF'])=='add-member.php' || basename($_SERVER['PHP_SELF'])=='manage-member.php' || basename($_SERVER['PHP_SELF'])=='add-group.php' || basename($_SERVER['PHP_SELF'])=='manage-group.php' || basename($_SERVER['PHP_SELF'])=='edit-member.php' || basename($_SERVER['PHP_SELF'])=='edit-group.php'){ ?>class="active"<?php } else { ?>class="exp"<?php } ?>><span>Administrator</span></a>
            	<ul class="sub">
                	<li><a href="add-group.php" title="">Add Groups/Permission</a></li>
                    <li><a href="manage-group.php" title="">Manage Groups</a></li>
                    <li><a href="add-member.php" title="">Add Members</a></li>
                    <li class="last"><a href="manage-member.php" title="">Manage Member</a></li>
                </ul>
            </li>
            
            <?php if($GetAllPermission['customer'] == 'Y' || $GetAllPermission['customer'] == '') { ?>
            <li class="dash"><a href="#" title="" <?php if(basename($_SERVER['PHP_SELF'])=='all-user.php' || basename($_SERVER['PHP_SELF'])=='approved-user.php' || basename($_SERVER['PHP_SELF'])=='blocked-user.php' || basename($_SERVER['PHP_SELF'])=='wishlist.php' || basename($_SERVER['PHP_SELF'])=='placed-orders.php' || basename($_SERVER['PHP_SELF'])=='search-orders.php' || basename($_SERVER['PHP_SELF'])=='hold-cart.php' || basename($_SERVER['PHP_SELF'])=='buyer-cancel.php' || basename($_SERVER['PHP_SELF'])=='reset-password.php'){ ?>class="active"<?php } else { ?>class="exp"<?php } ?>><span>Buyer Controls</span></a>
            	<ul class="sub">
                    <li><a href="all-user.php" title="">All Buyers</a></li>
                    <li><a href="approved-user.php" title="">Verified Buyers</a></li>
                    <li><a href="blocked-user.php" title="">Un-verified Buyers</a></li>
                    <li><a href="wishlist.php" title="">Manage Wishlist</a></li>
                    <li><a href="placed-orders.php" title="">Placed Orders</a></li>
                    <li><a href="search-orders.php" title=""><strong>Search Order</strong></a></li>
                    <li><a href="hold-cart.php" title="">Hold in Cart</a></li>
                    <li class="last"><a href="buyer-cancel.php" title="">Buyer Cancellation</a></li>
                </ul>
            </li>
            <?php } ?>
            
            <li class="dash"><a href="#" title="" <?php if(basename($_SERVER['PHP_SELF'])=='merchants.php' || basename($_SERVER['PHP_SELF'])=='merchantProducts.php' || basename($_SERVER['PHP_SELF'])=='merchantHistory.php' || basename($_SERVER['PHP_SELF'])=='seller-cancel.php' || basename($_SERVER['PHP_SELF'])=='withdrawRequest.php' || basename($_SERVER['PHP_SELF'])=='new-label-request.php' || basename($_SERVER['PHP_SELF'])=='designerLabels.php' || basename($_SERVER['PHP_SELF'])=='seller-details.php' || basename($_SERVER['PHP_SELF'])=='seller-report.php' || basename($_SERVER['PHP_SELF'])=='message-seller.php'){ ?>class="active"<?php } else { ?>class="exp"<?php } ?>><span>Sellers/Vendors</span></a>
            	<ul class="sub">
                    <li><a href="merchants.php" title="">All Sellers</a></li>
                    <li><a href="merchants.php?type=R" title="">Retailor</a></li>
                    <li><a href="merchants.php?type=M" title="">Manufacturer</a></li>
                    <li><a href="merchants.php?type=Di" title="">Distributer</a></li>
                    <li><a href="merchants.php?type=De" title="">Designer</a></li>
                    <li><a href="new-label-request.php" title="">New Label Request</a></li>
                    <li><a href="designerLabels.php" title="">Designer Labels</a></li>
                    <li><a href="merchantProducts.php" title="">Seller Products</a></li>
                    <li><a href="withdrawRequest.php" title="">Withdraw Requests</a></li>
                    <li><a href="merchantHistory.php" title="">Seller History</a></li>
                    <li><a href="seller-cancel.php" title="">Seller Cancellations</a></li>
                    <li><a href="message-seller.php" title="">Messages of Seller (from Buyer)</a></li>
                    <li class="last"><a href="seller-report.php" title="">Generate Seller Report</a></li>
                </ul>
            </li>
            
            <?php if($GetAllPermission['config'] == 'Y' || $GetAllPermission['config'] == '') { ?>
            <li class="dash"><a href="#" title="" <?php if(basename($_SERVER['PHP_SELF'])=='change-password.php' || basename($_SERVER['PHP_SELF'])=='website-settings.php' || basename($_SERVER['PHP_SELF'])=='owner-profile.php' || basename($_SERVER['PHP_SELF'])=='feetman_settings.php' || basename($_SERVER['PHP_SELF'])=='vendor-comission.php' || basename($_SERVER['PHP_SELF'])=='header_block.php' || basename($_SERVER['PHP_SELF'])=='header_block_banners.php' || basename($_SERVER['PHP_SELF'])=='page_banner.php' || basename($_SERVER['PHP_SELF'])=='listing_page_banner.php'){ ?>class="active"<?php } else { ?>class="exp"<?php } ?>><span>Site Management</span></a>
            	<ul class="sub">
                	<li><a href="website-settings.php" title="">Site Configuration</a></li>
                    <li><a href="owner-profile.php" title="">Owner's Profile</a></li>
                    <li><a href="listing_page_banner.php" title="">Listing Page Banners</a></li>
                    <li><a href="page_banner.php" title="">Details Page Banners</a></li>
                    <li><a href="vendor-comission.php" title="">Seller / Vendor Comissions</a></li>
                    <li><a href="change-password.php" title="">Change Password</a></li>
                    <li><a href="feetman_settings.php" title="">Feetman Settings</a></li>
                    <li><a href="header_block.php" title="">Home Page Header Blocks</a></li>
                    <li class="last"><a href="header_block_banners.php" title="">Home Page Banners</a></li>
                </ul>
            </li>
            <?php } ?>
            
            <?php if($GetAllPermission['config'] == 'Y' || $GetAllPermission['config'] == '') { ?>
            <li class="dash"><a href="#" title="" <?php if(basename($_SERVER['PHP_SELF'])=='payment-settings.php' || basename($_SERVER['PHP_SELF'])=='orders.php' || basename($_SERVER['PHP_SELF'])=='transaction.php' || basename($_SERVER['PHP_SELF'])=='order_details.php'){ ?>class="active"<?php } else { ?>class="exp"<?php } ?>><span>Payment</span></a>
            	<ul class="sub">
                	<li><a href="payment-settings.php" title="">Payment Getaway</a></li>
                    <li><a href="orders.php" title="">Manage Orders</a></li>
                    <li><a href="transaction.php" title="">Transaction Report</a></li>
                    <li class="last"><a href="withdrawRequest.php" title="">Manage Withdraw</a></li>
                </ul>
            </li>
            <?php } ?>
            
            <?php if($GetAllPermission['config'] == 'Y' || $GetAllPermission['config'] == '') { ?>
            <li class="dash"><a href="#" title="" <?php if(basename($_SERVER['PHP_SELF'])=='add-coupons.php' || basename($_SERVER['PHP_SELF'])=='manage-coupons.php' || basename($_SERVER['PHP_SELF'])=='coupon-logs.php'){ ?>class="active"<?php } else { ?>class="exp"<?php } ?>><span>Coupons</span></a>
            	<ul class="sub">
                	<li><a href="add-coupons.php" title="">Add Coupon</a></li>
                    <li><a href="manage-coupons.php" title="">Manage Coupons</a></li>
                    <li class="last"><a href="coupon-logs.php" title="">Coupon Logs</a></li>
                </ul>
            </li>
            <?php } ?>
            
            <?php if($GetAllPermission['catalog'] == 'Y' || $GetAllPermission['catalog'] == '') { ?>
            <li class="dash"><a href="#" title="" <?php if(basename($_SERVER['PHP_SELF'])=='add-category.php' || basename($_SERVER['PHP_SELF'])=='manage-category.php' || basename($_SERVER['PHP_SELF'])=='add-sub-category.php' || basename($_SERVER['PHP_SELF'])=='manage-sub-category.php' || basename($_SERVER['PHP_SELF'])=='edit-sub-category.php' || basename($_SERVER['PHP_SELF'])=='add-manufacturers.php' || basename($_SERVER['PHP_SELF'])=='manage-manufacturers.php' || basename($_SERVER['PHP_SELF'])=='product.php' || basename($_SERVER['PHP_SELF'])=='add-product.php' || basename($_SERVER['PHP_SELF'])=='manage-product.php' || basename($_SERVER['PHP_SELF'])=='upload-image.php' || basename($_SERVER['PHP_SELF'])=='excel-stock-upload.php' || basename($_SERVER['PHP_SELF'])=='featured-product.php' || basename($_SERVER['PHP_SELF'])=='track.php' || basename($_SERVER['PHP_SELF'])=='return_exchange.php' || basename($_SERVER['PHP_SELF'])=='credit_points.php' || basename($_SERVER['PHP_SELF'])=='another-product.php' || basename($_SERVER['PHP_SELF'])=='manage-colors.php' || basename($_SERVER['PHP_SELF'])=='low-stock-notify.php' || basename($_SERVER['PHP_SELF'])=='edit-manufacturers.php' || basename($_SERVER['PHP_SELF'])=='seller-cancellations.php' || basename($_SERVER['PHP_SELF'])=='wefind-notify.php' || basename($_SERVER['PHP_SELF'])=='walking_easy.php' || basename($_SERVER['PHP_SELF'])=='popular-product.php' || basename($_SERVER['PHP_SELF'])=='reverse-pickups.php'){ ?>class="active"<?php } else { ?>class="exp"<?php } ?>><span>Products</span></a>
            	<ul class="sub">
                	<!--<li><a href="add-category.php" title="">Add Category</a></li>-->
                    <li><a href="manage-category.php" title="">Manage Category</a></li>
                    <li><a href="add-sub-category.php" title="">Add Sub Category</a></li>
                    <li><a href="manage-sub-category.php" title="">Manage Sub Category</a></li>
                    <li><a href="add-manufacturers.php" title="">Add Brand</a></li>
                    <li><a href="manage-manufacturers.php" title="">Manage Brand(s)</a></li>
                    <li><a href="manage-colors.php" title="">Manage Colors</a></li>
                    <li><a href="product.php" title="">Create Product</a></li>
                    <li><a href="manage-product.php" title="">All Product</a></li>
                    <li><a href="popular-product.php" title="">Popular Product</a></li>
                    <li><a href="featured-product.php" title="">Featured Product</a></li>
                    <li><a href="track.php" title="">Track Order</a></li>
                    <li><a href="return_exchange.php" title="">Return/Exchange</a></li>
                    <li><a href="credit_points.php" title="">Credit/Points</a></li>
					<li><a href="walking_easy.php" title="">Walking Easy</a></li>
                    <li><a href="reverse-pickups.php" title="">Reverse Pickups</a></li>
                    <li><a href="low-stock-notify.php" title="">Low Stock Notification</a></li>
                    <li class="last"><a href="wefind-notify.php" title="">WeFind Notifications</a></li>
                </ul>
            </li>
            <?php } ?>
            
            <?php if($GetAllPermission['export'] == 'Y' || $GetAllPermission['export'] == '') { ?>
            <li class="dash"><a href="#" title="" <?php if(basename($_SERVER['PHP_SELF'])=='export-product.php' || basename($_SERVER['PHP_SELF'])=='export-order.php'){ ?>class="active"<?php } else { ?>class="exp"<?php } ?>><span>Export Data</span></a>
            	<ul class="sub">
                    <li><a href="export-product.php" title="">Export Products</a></li>
                    <li class="last"><a href="export-order.php" title="">Export Orders</a></li>
                    <!--<li><a href="#" title="">Export Products</a></li>
                    <li class="last"><a href="#" title="">Export Orders</a></li>-->
                </ul>
            </li>
            <?php } ?>
            
            <?php if($GetAllPermission['page'] == 'Y' || $GetAllPermission['page'] == '') { ?>
            <li class="dash"><a href="#" title="" <?php if(basename($_SERVER['PHP_SELF'])=='create-page.php' || basename($_SERVER['PHP_SELF'])=='manage-page.php' || basename($_SERVER['PHP_SELF'])=='edit-page.php'){ ?>class="active"<?php } else { ?>class="exp"<?php } ?>><span>Content Pages</span></a>
            	<ul class="sub">
                    <li><a href="create-page.php" title="">Create Page</a></li>
                    <li class="last"><a href="manage-page.php" title="">Manage Page</a></li>
                </ul>
            </li>
            <?php } ?>
            
            <?php if($GetAllPermission['report'] == 'Y' || $GetAllPermission['page'] == '') { ?>
            <li class="dash"><a href="#" title="" <?php if(basename($_SERVER['PHP_SELF'])=='stats_search_terms.php' || basename($_SERVER['PHP_SELF'])=='stats_daily_sales.php' || basename($_SERVER['PHP_SELF'])=='stats_daily_products_sales_report.php' || basename($_SERVER['PHP_SELF'])=='stats_manufacturers_sales.php' || basename($_SERVER['PHP_SELF'])=='stats_products_viewed.php' || basename($_SERVER['PHP_SELF'])=='stats_products_purchased.php' || basename($_SERVER['PHP_SELF'])=='stats_ordered.php' || basename($_SERVER['PHP_SELF'])=='stats_customer.php' || basename($_SERVER['PHP_SELF'])=='stats_category.php' || basename($_SERVER['PHP_SELF'])=='stats_daily_quotes.php' || basename($_SERVER['PHP_SELF'])=='stats_daily_products_quotes.php' || basename($_SERVER['PHP_SELF'])=='stats_manufacturers_quotes.php'){ ?>class="active"<?php } else { ?>class="exp"<?php } ?>><span>Reports</span></a>
            	<ul class="sub">
                    <li><a href="stats_search_terms.php" title="">Top Search Terms</a></li>
                    <li><a href="stats_daily_sales.php" title="">Daily Sales</a></li>
                    <li><a href="stats_daily_products_sales_report.php" title="">Daily Product Sales</a></li>
                    <li><a href="stats_manufacturers_sales.php" title="">Seller/Vendor Sales</a></li>
                    <li><a href="stats_products_viewed.php" title="">Products Viewed</a></li>
                    <li><a href="stats_products_purchased.php" title="">Products Purchased</a></li>
                    <li><a href="stats_ordered.php" title="">Ordered Products</a></li>
                    <li><a href="stats_customer.php" title="">Customer Stats</a></li>
                    <li><a href="stats_category.php" title="">Category Stats</a></li>
                    <li><a href="stats_daily_quotes.php" title="">Daily Quotes</a></li>
                    <li><a href="stats_daily_products_quotes.php" title="">Daily Product Quotes</a></li>
                    <li class="last"><a href="stats_manufacturers_quotes.php" title="">Seller/Vendor Quotes</a></li>
                </ul>
            </li>
            <?php } ?>
            
            <?php if($GetAllPermission['blog_management'] == 'Y' || $GetAllPermission['blog_management'] == '') { ?>
			<li class="dash"><a href="#" title="" <?php if(basename($_SERVER['PHP_SELF'])=='add-blog-category.php' || basename($_SERVER['PHP_SELF'])=='blog-category.php' || basename($_SERVER['PHP_SELF'])=='add-blog.php' || basename($_SERVER['PHP_SELF'])=='list_blog.php'){ ?>class="active"<?php } else { ?>class="exp"<?php } ?>><span>Blog Management</span></a>
            <ul class="sub">
                <li><a href="add-blog-category.php" title="">Add Category</a></li>
                <li><a href="blog-category.php" title="">Manage Category</a></li>
                <li><a href="add-blog.php" title="">Add Blog</a></li>
                <li class="last"><a href="list_blog.php" title="">Manage Blog</a></li>
            </ul>
        	</li><?php } ?>
            
            <?php if($GetAllPermission['invoice_management'] == 'Y' || $GetAllPermission['invoice_management'] == '') { ?>
            <li class="dash"><a href="#" title="" <?php if(basename($_SERVER['PHP_SELF'])=='search-invoice.php' || basename($_SERVER['PHP_SELF'])=='all-invoices.php'){ ?>class="active"<?php } else { ?>class="exp"<?php } ?>><span>Invoice Management</span></a>
            	<ul class="sub">
                    <li><a href="search-invoice.php" title="">Search Invoice</a></li>
                    <li class="last"><a href="all-invoices.php" title="">Display all invoices</a></li>
                </ul>
            </li>
			<?php } ?>
            
            <?php if($GetAllPermission['tool'] == 'Y' || $GetAllPermission['tool'] == '') { ?>
            <li class="dash"><a href="#" title="" <?php if(basename($_SERVER['PHP_SELF'])=='backup-database.php' || basename($_SERVER['PHP_SELF'])=='sendEmail.php' || basename($_SERVER['PHP_SELF'])=='support.php' || basename($_SERVER['PHP_SELF'])=='manage-contact.php' || basename($_SERVER['PHP_SELF'])=='add-contact.php'){ ?>class="active"<?php } else { ?>class="exp"<?php } ?>><span>Tools / Extras</span></a>
            	<ul class="sub">
                    <li><a href="backup-database.php" title="">Backup Database</a></li>
                    <li><a href="manage-contact.php" title="">Manage Contacts</a></li>
                    <li><a href="sendEmail.php" title="">Send Email</a></li>
                    <li class="last"><a href="support.php" title="">Contacts / Support</a></li>
                </ul>
            </li>
            <?php } ?>
        </ul>
    </div>