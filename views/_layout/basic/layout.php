<!DOCTYPE html>
<html lang="ko">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo html_escape(element('page_title', $layout)); ?></title>
<?php if (element('meta_description', $layout)) { ?><meta name="description" content="<?php echo html_escape(element('meta_description', $layout)); ?>"><?php } ?>
<?php if (element('meta_keywords', $layout)) { ?><meta name="keywords" content="<?php echo html_escape(element('meta_keywords', $layout)); ?>"><?php } ?>
<?php if (element('meta_author', $layout)) { ?><meta name="author" content="<?php echo html_escape(element('meta_author', $layout)); ?>"><?php } ?>
<?php if (element('favicon', $layout)) { ?><link rel="shortcut icon" type="image/x-icon" href="<?php echo element('favicon', $layout); ?>" /><?php } ?>
<?php if (element('canonical', $view)) { ?><link rel="canonical" href="<?php echo element('canonical', $view); ?>" /><?php } ?>

<!-- Web Fonts -->
<link href='http://fonts.googleapis.com/css?family=Roboto:400,300,300italic,400italic,500,500italic,700,700italic' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Raleway:700,400,300' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Pacifico' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=PT+Serif' rel='stylesheet' type='text/css'>

<!-- Bootstrap core CSS -->
<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>" />

<!-- Font Awesome CSS -->
<link rel="stylesheet" type="text/css" href="<?php echo element('layout_skin_url', $layout); ?>/fonts/font-awesome/css/font-awesome.css" />

<!-- Fontello CSS -->
<link rel="stylesheet" type="text/css" href="<?php echo element('layout_skin_url', $layout); ?>/fonts/fontello/css/fontello.css" />

<!-- Plugins -->
<link rel="stylesheet" type="text/css" href="<?php echo element('layout_skin_url', $layout); ?>/plugins/magnific-popup/magnific-popup.css">
<link rel="stylesheet" type="text/css" href="<?php echo element('layout_skin_url', $layout); ?>/plugins/rs-plugin/css/settings.css">
<link rel="stylesheet" type="text/css" href="<?php echo element('layout_skin_url', $layout); ?>/css/animations.css">
<link rel="stylesheet" type="text/css" href="<?php echo element('layout_skin_url', $layout); ?>/plugins/owl-carousel/owl.carousel.css">
<link rel="stylesheet" type="text/css" href="<?php echo element('layout_skin_url', $layout); ?>/plugins/owl-carousel/owl.transitions.css">
<link rel="stylesheet" type="text/css" href="<?php echo element('layout_skin_url', $layout); ?>/plugins/hover/hover-min.css">

<!-- The Project core CSS file -->
<link rel="stylesheet" type="text/css" href="<?php echo element('layout_skin_url', $layout); ?>/css/style.css">
<!-- Color Scheme (In order to change the color scheme, replace the blue.css with the color scheme that you prefer)-->
<link rel="stylesheet" type="text/css" href="<?php echo element('layout_skin_url', $layout); ?>/css/skins/light_blue.css">

<!-- Custom css -->
<link rel="stylesheet" type="text/css" href="<?php echo element('layout_skin_url', $layout); ?>/css/custom.css">
<?php echo $this->managelayout->display_css(); ?>

<script type="text/javascript">
// 자바스크립트에서 사용하는 전역변수 선언
var cb_url = "<?php echo trim(site_url(), '/'); ?>";
var cb_cookie_domain = "<?php echo config_item('cookie_domain'); ?>";
var cb_charset = "<?php echo config_item('charset'); ?>";
var cb_time_ymd = "<?php echo cdate('Y-m-d'); ?>";
var cb_time_ymdhis = "<?php echo cdate('Y-m-d H:i:s'); ?>";
var layout_skin_path = "<?php echo element('layout_skin_path', $layout); ?>";
var view_skin_path = "<?php echo element('view_skin_path', $layout); ?>";
var is_member = "<?php echo $this->member->is_member() ? '1' : ''; ?>";
var is_admin = "<?php echo $this->member->is_admin(); ?>";
var cb_admin_url = <?php echo $this->member->is_admin() === 'super' ? 'cb_url + "/' . config_item('uri_segment_admin') . '"' : '""'; ?>;
var cb_board = "<?php echo isset($view) ? element('board_key', $view) : ''; ?>";
var cb_board_url = <?php echo ( isset($view) && element('board_key', $view)) ? 'cb_url + "/' . config_item('uri_segment_board') . '/' . element('board_key', $view) . '"' : '""'; ?>;
var cb_device_type = "<?php echo $this->cbconfig->get_device_type() === 'mobile' ? 'mobile' : 'desktop' ?>";
var cb_csrf_hash = "<?php echo $this->security->get_csrf_hash(); ?>";
var cookie_prefix = "<?php echo config_item('cookie_prefix'); ?>";
</script>
</head>
<body class="no-trans front-page transparent-header" <?php echo isset($view) ? element('body_script', $view) : ''; ?>>

<!-- scrollToTop -->
<div class="scrollToTop circle"><i class="icon-up-open-big"></i></div>
<!-- //scrollToTop -->

<div class="page-wrapper">


    <!-- header-container start -->
    <div class="header-container">
        <!-- header start -->
        <!-- classes:  -->
        <!-- "fixed": enables fixed navigation mode (sticky menu) e.g. class="header fixed clearfix" -->
        <!-- "dark": dark version of header e.g. class="header dark clearfix" -->
        <!-- "full-width": mandatory class for the full-width menu layout -->
        <!-- "centered": mandatory class for the centered logo layout -->
        <!-- ================ -->
        <header class="header fixed clearfix">

            <div class="container">
                <div class="row" style="display:none">
                    <ul class="header-top-menu">
                        <?php if ($this->member->is_admin() === 'super') { ?>
                            <li><i class="fa fa-cog"></i><a href="<?php echo site_url(config_item('uri_segment_admin')); ?>" title="관리자 페이지로 이동">관리자</a></li>
                        <?php } ?>
                        <?php
                        if ($this->member->is_member()) {
                            if ($this->cbconfig->item('use_notification')) {
                        ?>
                            <li class="notifications"><i class="fa fa-bell-o"></i>알림 <span class="badge notification_num"><?php echo number_format(element('notification_num', $layout) + 0); ?></span>
                                <div class="notifications-menu"></div>
                            </li>
                        <?php
                            }
                        ?>
                            <li><i class="fa fa-sign-out"></i><a href="<?php echo site_url('login/logout?url=' . urlencode(current_full_url())); ?>" title="로그아웃">로그아웃</a></li>
                            <li><i class="fa fa-user"></i><a href="<?php echo site_url('mypage'); ?>" title="마이페이지">마이페이지</a></li>
                        <?php } else { ?>
                            <li><i class="fa fa-sign-in"></i><a href="<?php echo site_url('login?url=' . urlencode(current_full_url())); ?>" title="로그인">로그인</a></li>
                            <li><i class="fa fa-user"></i><a href="<?php echo site_url('register'); ?>" title="회원가입">회원가입</a></li>
                        <?php } ?>
                        <?php if ($this->cbconfig->item('open_currentvisitor')) { ?>
                            <li><i class="fa fa-link"></i><a href="<?php echo site_url('currentvisitor'); ?>" title="현재접속자">현재접속자</a> <span class="badge"><?php echo element('current_visitor_num', $layout); ?></span></li>
                        <?php } ?>
                    </ul>
                </div>

                <div class="row">
                    <div class="col-md-3 ">
                        <!-- header-left start -->
                        <!-- ================ -->
                        <div class="header-left clearfix">
                            <!-- logo -->
                            <div id="logo" class="logo">
                                <a href="<?php echo site_url(); ?>" title="<?php echo html_escape($this->cbconfig->item('site_title'));?>"><img src="<?php echo $this->cbconfig->item('site_logo'); ?>" /></a>
                            </div>
                        </div>
                        <!-- header-left end -->

                    </div>
                    <div class="col-md-9">

                        <!-- header-right start -->
                        <!-- ================ -->
                        <div class="header-right clearfix">

                        <!-- main-navigation start -->
                        <!-- classes: -->
                        <!-- "onclick": Makes the dropdowns open on click, this the default bootstrap behavior e.g. class="main-navigation onclick" -->
                        <!-- "animated": Enables animations on dropdowns opening e.g. class="main-navigation animated" -->
                        <!-- "with-dropdown-buttons": Mandatory class that adds extra space, to the main navigation, for the search and cart dropdowns -->
                        <!-- ================ -->
                            <div class="main-navigation animated">

                                <!-- navbar start -->
                                <!-- ================ -->
                                <nav class="navbar navbar-default" role="navigation">
                                    <div class="container-fluid">

                                        <!-- Toggle get grouped for better mobile display -->
                                        <div class="navbar-header">
                                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#navbar-collapse-1">
                                                <span class="sr-only">Toggle navigation</span>
                                                <span class="icon-bar"></span>
                                                <span class="icon-bar"></span>
                                                <span class="icon-bar"></span>
                                            </button>
                                        </div>

                                        <!-- Collect the nav links, forms, and other content for toggling -->
                                        <div class="collapse navbar-collapse scrollspy smooth-scroll" id="navbar-collapse-1">
                                            <ul class="nav navbar-nav navbar-right">

                                                <?php
                                                $menuhtml = '';
                                                if (element('menu', $layout)) {
                                                    $menu = element('menu', $layout);
                                                    if (element(0, $menu)) {
                                                        foreach (element(0, $menu) as $mkey => $mval) {
                                                            if (element(element('men_id', $mval), $menu)) {
                                                                $mlink = element('men_link', $mval) ? element('men_link', $mval) : 'javascript:;';
                                                                $menuhtml .= '<li class="dropdown">
                                                                <a href="' . $mlink . '" ' . element('men_custom', $mval);
                                                                if (element('men_target', $mval)) {
                                                                    $menuhtml .= ' target="' . element('men_target', $mval) . '"';
                                                                }
                                                                $menuhtml .= ' title="' . html_escape(element('men_name', $mval)) . '">' . html_escape(element('men_name', $mval)) . '</a>
                                                                <ul class="dropdown-menu">';

                                                                foreach (element(element('men_id', $mval), $menu) as $skey => $sval) {
                                                                    $slink = element('men_link', $sval) ? element('men_link', $sval) : 'javascript:;';
                                                                    $menuhtml .= '<li><a href="' . $slink . '" ' . element('men_custom', $sval);
                                                                    if (element('men_target', $sval)) {
                                                                        $menuhtml .= ' target="' . element('men_target', $sval) . '"';
                                                                    }
                                                                    $menuhtml .= ' title="' . html_escape(element('men_name', $sval)) . '">' . html_escape(element('men_name', $sval)) . '</a></li>';
                                                                }
                                                                $menuhtml .= '</ul></li>';

                                                            } else {
                                                                $mlink = element('men_link', $mval) ? element('men_link', $mval) : 'javascript:;';
                                                                $menuhtml .= '<li><a href="' . $mlink . '" ' . element('men_custom', $mval);
                                                                if (element('men_target', $mval)) {
                                                                    $menuhtml .= ' target="' . element('men_target', $mval) . '"';
                                                                }
                                                                $menuhtml .= ' title="' . html_escape(element('men_name', $mval)) . '">' . html_escape(element('men_name', $mval)) . '</a></li>';
                                                            }
                                                        }
                                                    }
                                                }
                                                echo $menuhtml;
                                                ?>




                                            </ul>
                                        </div>

                                    </div>
                                </nav>
                                <!-- navbar end -->

                            </div>
                        <!-- main-navigation end -->
                        </div>
                        <!-- header-right end -->

                    </div>
                </div>
            </div>

        </header>
        <!-- header end -->
    </div>
    <!-- header-container end -->





    <!-- main start -->
    <div class="main">
        <?php if (element('use_sidebar', $layout)) {?>
            <div class="left">
        <?php } ?>

        <!-- 본문 시작 -->
        <?php if (isset($yield))echo $yield; ?>
        <!-- 본문 끝 -->

        <?php if (element('use_sidebar', $layout)) {?>

            </div>
            <div class="sidebar">
                <?php $this->load->view(element('layout_skin_path', $layout) . '/sidebar'); ?>
            </div>

        <?php } ?>
    </div>
    <!-- main end -->
    <!-- footer start (Add "dark" class to #footer in order to enable dark footer) -->
    <!-- ================ -->
    <footer id="footer" class="clearfix dark">

        <div class="footer">
            <div class="container">
                <div class="footer-inner">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="footer-content">
                                <div class="logo-footer"><img id="logo-footer" src="images/img_logo.png" alt=""></div>
                                <p>㈜가온앤은 ‘세상의 중심’ 그리고 and, 세상의 중심에서 무한한 발전을 실현 하고자 합니다. <br>
                                    생명의 시작부터 노년기까지,인류의 건강한 삶을  위하여 열심히 달리겠습니다.</p>
                                <div class="separator-2"></div>
                                <nav>
                                    <ul class="nav nav-pills nav-stacked">
                                        <li><a target="_blank" href="http://htmlcoder.me/support">GAONN</a></li>
                                        <li><a href="#">LABOVO</a></li>
                                        <li><a href="#">PRODUCT</a></li>
                                        <li><a href="page-about.html">NOTICE</a></li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="footer-content">
                                <h2 class="title">Latest News</h2>
                                <div class="separator-2"></div>
                                <div class="media margin-clear">
                                    <div class="media-left">
                                        <div class="overlay-container">
                                            <img class="media-object" src="images/blog-thumb-1.jpg" alt="blog-thumb">
                                            <a href="blog-post.html" class="overlay-link small"><i class="fa fa-link"></i></a>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <h6 class="media-heading"><a href="blog-post.html">Lorem ipsum dolor sit amet...</a></h6>
                                        <p class="small margin-clear"><i class="fa fa-calendar pr-10"></i>Mar 23, 2016</p>
                                    </div>
                                    <hr>
                                </div>
                                <div class="media margin-clear">
                                    <div class="media-left">
                                        <div class="overlay-container">
                                            <img class="media-object" src="images/blog-thumb-2.jpg" alt="blog-thumb">
                                            <a href="blog-post.html" class="overlay-link small"><i class="fa fa-link"></i></a>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <h6 class="media-heading"><a href="blog-post.html">Lorem ipsum dolor sit amet...</a></h6>
                                        <p class="small margin-clear"><i class="fa fa-calendar pr-10"></i>Mar 22, 2016</p>
                                    </div>
                                    <hr>
                                </div>
                                <div class="media margin-clear">
                                    <div class="media-left">
                                        <div class="overlay-container">
                                            <img class="media-object" src="images/blog-thumb-3.jpg" alt="blog-thumb">
                                            <a href="blog-post.html" class="overlay-link small"><i class="fa fa-link"></i></a>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <h6 class="media-heading"><a href="blog-post.html">Lorem ipsum dolor sit amet...</a></h6>
                                        <p class="small margin-clear"><i class="fa fa-calendar pr-10"></i>Mar 21, 2016</p>
                                    </div>
                                    <hr>
                                </div>
                                <div class="media margin-clear">
                                    <div class="media-left">
                                        <div class="overlay-container">
                                            <img class="media-object" src="images/blog-thumb-4.jpg" alt="blog-thumb">
                                            <a href="blog-post.html" class="overlay-link small"><i class="fa fa-link"></i></a>
                                        </div>
                                    </div>
                                    <div class="media-body">
                                        <h6 class="media-heading"><a href="blog-post.html">Lorem ipsum dolor sit amet...</a></h6>
                                        <p class="small margin-clear"><i class="fa fa-calendar pr-10"></i>Mar 21, 2016</p>
                                    </div>
                                </div>
                                <div class="text-right space-top">
                                    <a href="blog-large-image-right-sidebar.html" class="link-dark"><i class="fa fa-plus-circle pl-5 pr-5"></i>More</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="footer-content">
                                <h2 class="title">Contact Us</h2>
                                <div class="separator-2"></div>
                                <p>서울특별시 강남구 봉은사로 129, <br> 논현동 거평타운 B1 102호</p>
                                <ul class="social-links circle animated-effect-1">
                                    <li class="facebook"><a target="_blank" href="http://www.facebook.com"><i class="fa fa-facebook"></i></a></li>
                                    <li class="twitter"><a target="_blank" href="http://www.twitter.com"><i class="fa fa-twitter"></i></a></li>
                                    <li class="googleplus"><a target="_blank" href="http://plus.google.com"><i class="fa fa-google-plus"></i></a></li>
                                    <li class="linkedin"><a target="_blank" href="http://www.linkedin.com"><i class="fa fa-linkedin"></i></a></li>
                                    <li class="xing"><a target="_blank" href="http://www.xing.com"><i class="fa fa-xing"></i></a></li>
                                </ul>
                                <div class="separator-2"></div>
                                <ul class="list-icons">
                                    <li><i class="fa fa-phone pr-10 text-default"></i> 02.3444.1958</li>
                                    <li><i class="fa fa-fax pr-10 text-default"></i> 02.780.8808</li>
                                    <li><a href="mailto:korea@gaonn.net"><i class="fa fa-envelope-o pr-10"></i>korea@gaonn.net</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- .subfooter start -->
        <!-- ================ -->
        <div class="subfooter">
            <div class="container">
                <div class="subfooter-inner">
                    <div class="row">
                        <div class="col-md-12">
                            <p class="text-center">© 2016 <a href="#">GAONN</a> Co. Ltd. All Rights Reserved</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- .subfooter end -->
    </footer>
    <!-- footer end -->

</div>


<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.12.2/jquery.min.js"></script>
<script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo element('layout_skin_url', $layout); ?>/plugins/modernizr.js"></script>
<script type="text/javascript" src="<?php echo element('layout_skin_url', $layout); ?>/plugins/rs-plugin/js/jquery.themepunch.tools.min.js"></script>
<script type="text/javascript" src="<?php echo element('layout_skin_url', $layout); ?>/plugins/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
<script type="text/javascript" src="<?php echo element('layout_skin_url', $layout); ?>/plugins/isotope/isotope.pkgd.min.js"></script>
<script type="text/javascript" src="<?php echo element('layout_skin_url', $layout); ?>/plugins/magnific-popup/jquery.magnific-popup.min.js"></script>
<script type="text/javascript" src="<?php echo element('layout_skin_url', $layout); ?>/plugins/waypoints/jquery.waypoints.min.js"></script>
<script type="text/javascript" src="<?php echo element('layout_skin_url', $layout); ?>/plugins/jquery.countTo.js"></script>
<script type="text/javascript" src="<?php echo element('layout_skin_url', $layout); ?>/plugins/jquery.parallax-1.1.3.js"></script>
<script type="text/javascript" src="<?php echo element('layout_skin_url', $layout); ?>/plugins/jquery.validate.js"></script>
<script type="text/javascript" src="<?php echo element('layout_skin_url', $layout); ?>/plugins/vide/jquery.vide.js"></script>
<script type="text/javascript" src="<?php echo element('layout_skin_url', $layout); ?>/plugins/owl-carousel/owl.carousel.js"></script>
<script type="text/javascript" src="<?php echo element('layout_skin_url', $layout); ?>/plugins/jquery.browser.js"></script>
<script type="text/javascript" src="<?php echo element('layout_skin_url', $layout); ?>/plugins/SmoothScroll.js"></script>
<script type="text/javascript" src="<?php echo element('layout_skin_url', $layout); ?>/js/template.js"></script>
<script type="text/javascript" src="<?php echo element('layout_skin_url', $layout); ?>/js/custom.js"></script>
<!--<script type="text/javascript" src="<?php echo base_url('assets/js/common.js'); ?>"></script>-->
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.min.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/jquery.validate.extension.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/sideview.js'); ?>"></script>
<script type="text/javascript" src="<?php echo base_url('assets/js/js.cookie.js'); ?>"></script>
<?php echo $this->managelayout->display_js(); ?>

<script type="text/javascript">
$(document).on('click', '.viewpcversion', function(){
    Cookies.set('device_view_type', 'desktop', { expires: 1 });
});
$(document).on('click', '.viewmobileversion', function(){
    Cookies.set('device_view_type', 'mobile', { expires: 1 });
});
</script>
<?php echo element('popup', $layout); ?>
<?php echo $this->cbconfig->item('footer_script'); ?>

<!--
Layout Directory : <?php echo element('layout_skin_path', $layout); ?>,
Layout URL : <?php echo element('layout_skin_url', $layout); ?>,
Skin Directory : <?php echo element('view_skin_path', $layout); ?>,
Skin URL : <?php echo element('view_skin_url', $layout); ?>,
-->

</body>
</html>
