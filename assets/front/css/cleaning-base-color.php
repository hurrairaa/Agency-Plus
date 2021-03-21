<?php
header ("Content-Type:text/css");
$color = $_GET['color']; // Change your Color Here

if (array_key_exists('color1', $_GET)) {
    $color1 = $_GET['color1']; // Change your Color Here
} else {
    $color1 = NULL;
}


function checkhexcolor($color) {
    return preg_match('/^#[a-f0-9]{6}$/i', $color);
}

if( isset( $_GET[ 'color' ] ) AND $_GET[ 'color' ] != '' ) {
    $color = "#".$_GET[ 'color' ];
}

if( isset( $_GET[ 'color1' ] ) AND $_GET[ 'color1' ] != '' ) {
    $color1 = "#".$_GET[ 'color1' ];
}

if( !$color OR !checkhexcolor( $color ) ) {
    $color = "#182456";
}

if( !$color1 OR !checkhexcolor( $color1 ) ) {
    $color1 = "<?php echo $color1; ?>";
}

?>


.single-blog::before {
    border-right: 2px solid <?php echo $color; ?>;
    border-bottom: 2px solid <?php echo $color; ?>;
}
.single-blog::after {
    border-top: 2px solid <?php echo $color; ?>;
    border-left: 2px solid <?php echo $color; ?>;
}
.blog-txt .date span {
    color: <?php echo $color; ?>;
}
.blog-txt .blog-title a:hover {
    color: <?php echo $color; ?>;
}
a.readmore-btn {
    background-color: <?php echo $color; ?>;
}
ul.breadcumb li a:hover {
    color: <?php echo $color; ?>;
}
.main-menu li a:hover {
    color: <?php echo $color; ?>;
}
.approach-icon-wrapper {
    border: 1px solid <?php echo $color; ?>;
}
.case-carousel button.owl-next:hover {
    border: 2px solid <?php echo $color; ?> !important;
}
.case-carousel button.owl-next:hover i {
    color: <?php echo $color; ?>;
}
.member-info small {
    color: <?php echo $color; ?>;
}
.single-team-member::before {
    border-top: 2px solid <?php echo $color; ?>;
    border-left: 2px solid <?php echo $color; ?>;
}
.single-team-member::after {
    border-bottom: 2px solid <?php echo $color; ?>;
    border-right: 2px solid <?php echo $color; ?>;
}
.loader {
    border: 4px solid <?php echo $color; ?>;
}
.loader-inner {
    background-color: <?php echo $color; ?>;
}
.single-service::before {
    border-right: 2px solid <?php echo $color; ?>;
    border-bottom: 2px solid <?php echo $color; ?>;
}
.single-service::after {
    border-top: 2px solid <?php echo $color; ?>;
    border-left: 2px solid <?php echo $color; ?>;
}
.pagination-nav li.page-item.active a {
    background-color: <?php echo $color; ?>;
    border: 2px solid <?php echo $color; ?>;
}
.category-lists ul li a::after {
    color: <?php echo $color; ?>;
}
.category-lists ul li a:hover {
    color: <?php echo $color; ?>;
}
.subscribe-section span {
    color: <?php echo $color; ?>;
}
.subscribe-section h3::after {
    background-color: <?php echo $color; ?>;
}
.subscribe-form input[type="submit"], .subscribe-form button[type="submit"] {
    background-color: <?php echo $color; ?>;
    border: 1px solid <?php echo $color; ?>;
}
.subscribe-form input[type="submit"]:hover, .subscribe-form button[type="submit"]:hover {
    border: 1px solid <?php echo $color; ?>;
    color: <?php echo $color; ?>;
}
.project-ss-carousel .owl-next {
    background-color: <?php echo $color; ?>;
    border: 1px solid <?php echo $color; ?>;
}
.project-ss-carousel .owl-next:hover {
    color: <?php echo $color; ?>;
}
.project-ss-carousel .owl-prev {
    background-color: <?php echo $color; ?>;
    border: 1px solid <?php echo $color; ?>;
}
.project-ss-carousel .owl-prev:hover {
    color: <?php echo $color; ?>;
}
.popular-post-txt h5 a:hover {
    color: <?php echo $color; ?>;
}
.single-contact-info i {
    color: <?php echo $color; ?>;
}
.support-bar-area ul.social-links li a:hover {
    color: <?php echo $color; ?>;
}
.main-menu li.dropdown:hover a {
    color: <?php echo $color; ?>;
}
.main-menu li.dropdown ul.dropdown-lists li a::before {
    background-color: <?php echo $color; ?>;
}
.main-menu li.dropdown ul.dropdown-lists li.active a {
    background-color: <?php echo $color; ?>;
}
.main-menu li.dropdown.active::after {
    color: <?php echo $color; ?>;
}
.single-category .text a.readmore {
    color: <?php echo $color; ?>;
}
.category-lists ul li.active a {
    color: <?php echo $color; ?>;
}
.case-types ul li a {
    border: 1px solid <?php echo $color; ?>;
}
.case-types ul li a:hover {
    background-color: <?php echo $color; ?>;
}
.case-types ul li.active a {
    background-color: <?php echo $color; ?>;
}
.main-menu li.dropdown:hover::after {
    color: <?php echo $color; ?>;
}
.faq-section .accordion .card .card-header .btn:hover {
    background-color: <?php echo $color; ?>;
}
.faq-section .accordion .card .card-header .btn[aria-expanded="true"] {
    background-color: <?php echo $color; ?>;
}
.blog-details-quote {
    border-left: 3px solid <?php echo $color; ?>;
}
.comment-lists h3::after {
    background-color: <?php echo $color; ?>;
}
.reply-form-section h3::after {
    background-color: <?php echo $color; ?>;
}
.error-txt a {
    background-color: <?php echo $color; ?>;
    border: 1px solid <?php echo $color; ?>;
}

.error-txt a:hover {
    color: <?php echo $color; ?>;
}

.mega-dropdown .dropbtn::before {
    background-color: <?php echo $color; ?>;
}

.mega-dropdown .dropbtn::after {
    background-color: <?php echo $color; ?>;
}

.mega-dropdown-content .service-category a::before {
    color: <?php echo $color; ?>;
}

.mega-dropdown-content .service-category h3 {
    color: <?php echo $color; ?>;
}

.testimonial-carousel.owl-theme .owl-dots .owl-dot.active span {
    background: <?php echo $color; ?>;
}
.owl-carousel.common-carousel .owl-nav button.owl-next, .owl-carousel.common-carousel .owl-nav button.owl-prev {
    background: <?php echo $color; ?>;
    border: 1px solid <?php echo $color; ?>;
}

.owl-carousel.common-carousel .owl-nav button.owl-next:hover, .owl-carousel.common-carousel .owl-nav button.owl-prev:hover {
    color: <?php echo $color; ?>;
}

.mega-dropdown .service-category a.active {
    color: <?php echo $color; ?>;
}

.mega-dropdown .dropbtn.active {
    color: <?php echo $color; ?>;
}

.case-types ul li a {
    color: <?php echo $color; ?>;
}

.mega-dropdown:hover a.dropbtn {
    color: <?php echo $color; ?>;
}

.mega-dropdown .dropbtn::before {
    background-color: <?php echo $color; ?>;
}

.mega-dropdown .dropbtn::after {
    background-color: <?php echo $color; ?>;
}

.single-pic h4::after {
    background-color: <?php echo $color; ?>;
}

.video-play-button:before {
    background: <?php echo $color; ?>;
}

.video-play-button:after {
    background: <?php echo $color; ?>;
}

.project-ss-carousel.owl-theme .owl-dots .owl-dot.active span {
    background: <?php echo $color; ?>;
}

.pagination-nav li.page-item.active a, .pagination-nav li.page-item.active span {
    background-color: <?php echo $color; ?>;
    border: 2px solid <?php echo $color; ?>;
}

.statistics-section h5 i {
    color: <?php echo $color; ?>;
}

.hero2-carousel.owl-theme .owl-dots .owl-dot.active span {
    background-color: <?php echo $color; ?>;
}

button.cookie-consent__agree {
    background-color: <?php echo $color; ?>;
}

button.mfp-close:hover {
    background-color: <?php echo $color; ?>;
}

.single-pricing-table:hover a.pricing-btn {
    background-color: <?php echo $color; ?>;
}

.single-pricing-table a.pricing-btn:hover {
    background-color: #fff;
    color: <?php echo $color; ?>;
}

.single-pricing-table:hover {
    background-color: <?php echo $color; ?>;
    border: 2px solid <?php echo $color; ?>;
}

.single-pricing-table .price {
    color: <?php echo $color; ?>;
}

.package-order {
  background-color: <?php echo $color; ?>;
  border-color: <?php echo $color; ?>;
}

ul.language-dropdown li a::before {
    background: <?php echo $color; ?>;
}

a.language-btn:hover {
    color: <?php echo $color; ?>;
}
.single-job a.title {
    color: <?php echo $color; ?>;
}

.single-job strong i {
    color: <?php echo $color; ?>;
}
.job-details h3 {
    color: <?php echo $color; ?>;
}
.service-txt .service-title a:hover {
    color: <?php echo $color; ?>;
}
.fc-button-primary {
    background-color: <?php echo $color; ?>;
    border-color: <?php echo $color; ?>;
}
.fc-button-primary:hover {
    background-color: <?php echo $color; ?>;
    border-color: <?php echo $color; ?>;
}
.fc-button-primary:not(:disabled).fc-button-active, .fc-button-primary:not(:disabled):active {
    background-color: <?php echo $color; ?>;
    border-color: <?php echo $color; ?>;
}
button.mfp-close:hover {
    background-color: transparent;
}

@media only screen and (max-width : 991px) {
    li.submenus ul {
        background: transparent;
    }
    .mean-container a.meanmenu-reveal {
        color: <?php echo $color; ?>;
    }
}
@media only screen and (max-width: 575px) {
  .case-types ul li a {
      background-color: #fff;
  }
}

















.top-header-area {
    background: <?php echo $color; ?>;
}
.top-header-social-links ul {
    border-right: 2px solid <?php echo $color; ?>1;
}
.main-menu ul li a {
    color: <?php echo $color; ?>;
}
h1, h2, h3, h4, h5, h6 {
    color: <?php echo $color; ?>;
}
.main-menu ul li ul.mega-menu li.mega-item > a {
    color: <?php echo $color; ?>;
}
.main-menu ul li:hover > a, .main-menu ul li.active a {
    background: <?php echo $color1; ?>1a;
}
.hero-content span {
    background: <?php echo $color1; ?>;
}
.main-btn {
    background: <?php echo $color1; ?>;
}
.main-btn:hover {
    border: 1px solid <?php echo $color1; ?>;
    color: <?php echo $color1; ?>;
}
.scroll-to-top {
    background: <?php echo $color1; ?>;
}
.bottom-header-area.sticky {
    border-bottom: 1px solid <?php echo $color1; ?>;
}
.single-service-bg span {
    background: <?php echo $color1; ?>;
}
.main-btn:hover {
    border: 1px solid <?php echo $color1; ?>;
    color: <?php echo $color1; ?>;
}
.main-btn {
    background: <?php echo $color1; ?>;
}
.main-btn:hover {
    border: 1px solid <?php echo $color1; ?>;
    color: <?php echo $color1; ?>;
}
.single-counter-item > span {
    color: <?php echo $color1; ?>;
}
.play-btn {
    border: 1px solid <?php echo $color1; ?>;
    color: <?php echo $color1; ?>;
}
.project-slider-active .slick-arrow {
    background: <?php echo $color1; ?>;
}
.service-carousel-active .slick-arrow {
    background: <?php echo $color1; ?>;
}
.hero-carousel-active .slick-arrow {
    background: <?php echo $color1; ?>;
}
.play-btn:hover {
    color: <?php echo $color1; ?>;
}
.team-carousel-active .slick-arrow {
    background: <?php echo $color1; ?>;
}
.price-carousel-active .slick-arrow {
    background: <?php echo $color1; ?>;
}
.blog-carousel-active .slick-arrow {
    background: <?php echo $color1; ?>;
}
.top-header-social-links ul li:hover a {
    color: <?php echo $color1; ?>;
}
.main-menu ul li ul.mega-menu li.mega-item:hover > a, .main-menu ul li ul.mega-menu li.mega-item ul li:hover > a {
    color: <?php echo $color1; ?>;
}
.single-service-link {
    background: <?php echo $color; ?>d1;
}
.project-link:before {
    background: <?php echo $color; ?>;
}
.team-social-links li:hover a {
    background: <?php echo $color; ?>;
}
.main-btn.price-btn {
    background: <?php echo $color; ?>1a;
}
.brand-container.brand-carousel-active .slick-dots li.slick-active {
    background: <?php echo $color; ?>5a;
}
.brand-container.brand-carousel-active .slick-dots li {
    background: <?php echo $color; ?>5a;
}
.testimonial-active .slick-dots li.slick-active {
    background: <?php echo $color; ?>5a;
}
.testimonial-active .slick-dots li {
    background: <?php echo $color; ?>5a;
}
.single-counter-item > span:before {
    background: <?php echo $color; ?>;
}
.main-menu ul li > ul.sub-menu {
    background: <?php echo $color; ?>;
}
li.submenus ul {
    background: <?php echo $color; ?>;
}
input[type="submit"], button[type="submit"] {
    background-color: <?php echo $color; ?>;
    border: 1px solid <?php echo $color; ?>;
}
input[type="submit"]:hover, button[type="submit"]:hover {
    color: <?php echo $color; ?>;
    border: 1px solid <?php echo $color; ?>;
}
.footer-social-links li:hover a {
    background: <?php echo $color; ?>;
}








.product-area .shop-search i {
    color: <?php echo $color; ?>;
}
.product-area .shop-sidebar .shop-box .sidebar-title .title::before {
    background: <?php echo $color; ?>;
}
.product-area .shop-sidebar .shop-box .sidebar-title .title::after {
    background: <?php echo $color; ?>;
}
.product-area .shop-tag .tag-item ul li a:hover {
    background: <?php echo $color; ?>;
}
.product-area .shop-tag .tag-item ul li.active-search a {
    background: <?php echo $color; ?>;
}
.ui-slider-horizontal .ui-slider-range {
    background: <?php echo $color; ?>;
}
.ui-state-default, .ui-widget-content .ui-state-default, .ui-widget-header .ui-state-default {
    border: 1px solid <?php echo $color; ?>;
    background: <?php echo $color; ?>;
}
button.filter-button {
    background-color: <?php echo $color; ?>;
}
.product-area .shop-item .shop-thumb::before {
    background-color: <?php echo $color; ?>8a;
}
li.active-search a {
    color: <?php echo $color; ?> !important;
}
.product-area .shop-item .shop-thumb ul li a {
    color: <?php echo $color; ?>;
}
.product-area .shop-item .shop-content span {
    color: <?php echo $color; ?>;
}
.product-area .shop-item .shop-content a:hover {
    color: <?php echo $color; ?>;
}
.product-details-area .product-item-slide .slick-arrow {
    background: <?php echo $color; ?>;
}
.actions .main-btn {
    background: <?php echo $color; ?>;
}
.product-details-area .product-details-content .product-details-tags ul li {
    color: <?php echo $color; ?>;
}
.shop-tab-area .nav .nav-item .nav-link.active {
    color: <?php echo $color; ?>;
}
.shop-review-area .shop-review-form .input-box ul li a {
    color: <?php echo $color; ?>;
}
.shop-review-area .shop-review-form .input-btn button {
    background: <?php echo $color; ?>;
    border-color: <?php echo $color; ?>;
}
.shop-review-area .shop-review-form .input-btn button:hover {
    color: <?php echo $color; ?>;
}
.product-items .shop-item .shop-thumb::before {
    background-color: <?php echo $color; ?>8a;
}
.product-items .shop-item .shop-thumb ul li a {
    color: <?php echo $color; ?>;
}
.product-items .shop-item .shop-content span {
    color: <?php echo $color; ?>;
}
.shop-tab-area .nav .nav-item .nav-link::before {
    background: <?php echo $color; ?>;
}
.product-details-area .product-details-slide-item .slick-arrow {
    background: <?php echo $color; ?>;
}
.cart-area .cart-table tbody .available-info .icon {
    background: <?php echo $color; ?>;
}
.cart-middle .update-cart button {
    border: 1px solid <?php echo $color; ?>;
    background: <?php echo $color; ?>;
}
.cart-middle .update-cart button:hover {
    color: <?php echo $color; ?>;
}
a.proceed-checkout-btn {
    border: 1px solid <?php echo $color; ?>;
    color: <?php echo $color; ?>;
}
a.proceed-checkout-btn:hover {
    background-color: <?php echo $color; ?>;
}
.cart-area .cart-table tbody tr td .remove span:hover {
    color: <?php echo $color; ?>;
}
.login-area .login-content .input-btn button {
    background: <?php echo $color; ?>;
    border-color: <?php echo $color; ?>;
}
.login-area .login-content .input-btn button:hover {
    color: <?php echo $color; ?>;
}
.login-area .login-content .input-btn a {
    color: <?php echo $color; ?>;
}
.user-sidebar .links li a.active {
    color: <?php echo $color; ?>;
}
.user-sidebar .links li:hover>a {
    color: <?php echo $color; ?>;
}
.main-table .dataTables_wrapper td a.btn {
    border: 1px solid <?php echo $color; ?>;
}
.main-table .dataTables_wrapper td a.btn:hover {
    background: <?php echo $color; ?>;
}
.paginate_button.active .page-link {
    background-color: <?php echo $color; ?> !important;
}
.progress-steps li.active .icon {
    background: <?php echo $color; ?>;
}
.order-info-area .prinit .btn {
    background: <?php echo $color; ?>;
}
.file-upload-area .upload-file span {
    background: <?php echo $color; ?>;
}
.actions .checkout-btn {
    border: 1px solid <?php echo $color; ?>;
}

.actions .checkout-btn:hover {
    background: <?php echo $color; ?>;
}

.product-items .shop-item .shop-content a:hover {
    color: <?php echo $color; ?>;
}
