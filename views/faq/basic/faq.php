<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>
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
<h3><?php echo element('fgr_title', element('faqgroup', $view)); ?></h3>
<form class="search_box text-center mb20" action="<?php echo current_url(); ?>" onSubmit="return faqSearch(this)">
    <input type="text" name="skeyword" value="<?php echo html_escape($this->input->get('skeyword')); ?>" class="input" placeholder="Search" />
    <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i></button>
</form>
<script type="text/javascript">
//<![CDATA[
function faqSearch(f) {
    var skeyword = f.skeyword.value.replace(/(^\s*)|(\s*$)/g,'');
    if (skeyword.length < 2) {
        alert('2글자 이상으로 검색해 주세요');
        f.skeyword.focus();
        return false;
    }
    return true;
}
//]]>
</script>
<?php

$i = 0;
if (element('list', element('data', $view))) {
    foreach (element('list', element('data', $view)) as $result) {
?>
    <div class="table-box">
        <div class="table-heading" id="heading_<?php echo $i; ?>" onclick="return faq_open(this);">
            <?php echo element('title', $result); ?>
        </div>
        <div class="table-answer answer" id="answer_<?php echo $i; ?>">
            <?php echo element('content', $result); ?>
        </div>
    </div>
<?php
        $i++;
    }
}
if ( ! element('list', element('data', $view))) {
?>
    <div class="table-answer nopost">내용이 없습니다</div>
<?php
}
?>
    <nav><?php echo element('paging', $view); ?></nav>
<?php
if ($this->member->is_admin() === 'super') {
?>
    <div class="text-center mb20">
        <a href="<?php echo admin_url('page/faq'); ?>?fgr_id=<?php echo element('fgr_id', element('faqgroup', $view)); ?>" class="btn btn-black btn-sm" target="_blank" title="FAQ 수정">FAQ 수정</a>
    </div>
<?php
}
?>
<script type="text/javascript">
//<![CDATA[
function faq_open(el)
{
    var $con = $(el).closest('.table-box').find('.answer');

    if ($con.is(':visible')) {
        $con.slideUp();
    } else {
        $('.answer:visible').css('display', 'none');
        $con.slideDown();

    }
    return false;
}
//]]>
</script>
