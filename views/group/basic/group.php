<div class="banner dark-translucent-bg" style="background-image:url('http://dev.gaon.co.kr/views/_layout/basic/images/page-about-banner-1.jpg'); background-position: 50% 27%;">
    <!-- breadcrumb start -->
    <!-- ================ -->
    <div class="breadcrumb-container">
        <div class="container">
            <ol class="breadcrumb">
                <li><i class="fa fa-home pr-10"></i><a class="link-dark" href="<?php echo site_url(); ?>">Home</a></li>
                <?php echo get_location_menu(element('menu', $layout)) ?>                
            </ol>
        </div>
    </div>
    <!-- breadcrumb end -->
    <div class="container">
        <div class="row">
            <div class="col-md-8 text-center col-md-offset-2 pv-20">
                <h1 class="title logo-font object-non-visible animated object-visible fadeIn" data-animation-effect="fadeIn" data-effect-delay="100"><?php echo html_escape(element('page_title', $layout)); ?></h1>
            </div>
        </div>
    </div>
</div>
<div class="container">
<?php
$k = 0;
$is_open = false;
if (element('board_list', $view)) {
    foreach (element('board_list', $view) as $key => $board) {
        $config = array(
            'skin' => 'basic',
            'brd_id' => element('brd_id', $board),
            'limit' => 5,
            'length' => 25,
            'is_gallery' => '',
            'image_width' => '',
            'image_height' => '',
            'cache_minute' => 1,
        );
        if ($k % 2 === 0) {
            echo '<div>';
            $is_open = true;
        }
        echo $this->board->latest($config);
        if ($k % 2 === 1) {
            echo '</div>';
            $is_open = false;
        }
        $k++;
    }
}
if ($is_open) {
    echo '</div>';
    $is_open = false;
}
?>
</div>