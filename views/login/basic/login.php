<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>


<div class="main-container dark-translucent-bg" style="background-image:url('<?php echo element('layout_skin_url', $layout); ?>/images/background-img-6.jpg');">
    
    <div class="container">
        <div class="row">
            <!-- main start -->
            <!-- ================ -->
            <div class="main object-non-visible animated object-visible fadeInUpSmall" data-animation-effect="fadeInUpSmall" data-effect-delay="100">
                <div class="form-block center-block p-30 light-gray-bg border-clear">
                    <h2 class="title">로그인</h2>
                    <?php
                        echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
                        echo show_alert_message(element('message', $view), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
                        echo show_alert_message($this->session->flashdata('message'), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
                        $attributes = array('class' => 'form-horizontal', 'name' => 'flogin', 'id' => 'flogin');
                        echo form_open(current_full_url(), $attributes);
                    ?>
                        <div class="form-group has-feedback">
                            <label for="inputUserName" class="col-sm-3 control-label"><?php echo element('userid_label_text', $view);?></label>
                            <div class="col-sm-8">
                                <input type="text" id="inputUserName" name="mem_userid" class="form-control" value="<?php echo set_value('mem_userid'); ?>" accesskey="L" />
                                <i class="fa fa-user form-control-feedback"></i>
                            </div>
                        </div>
                        <div class="form-group has-feedback">
                            <label for="inputPassword" class="col-sm-3 control-label">비밀번호</label>
                            <div class="col-sm-8">
                                <input type="password" name="mem_password" class="form-control" id="inputPassword">
                                <i class="fa fa-lock form-control-feedback"></i>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-3 col-sm-8">                                											
                                <button type="submit" class="btn btn-group btn-default btn-animated">로그인 <i class="fa fa-user"></i></button>
                                <div class="checkbox" style="display:inline-block;margin-left:10px;vertical-align:top;position:relative;top:10px">
                                    <label for="autologin">
                                        <input type="checkbox" name="autologin" id="autologin" value="1" /> 자동로그인
                                    </label>
                                </div>
                                <ul class="space-top">
                                    <!--<li><a href="<?php echo site_url('register'); ?>">회원가입</a></li>-->
                                    <li><a href="<?php echo site_url('findaccount'); ?>">아이디 / 비밀번호를 잃어 버렸습니까?</a></li>
                                </ul>
                            </div>
                        </div>
                    <?php echo form_close(); ?>
                </div>
            </div>
            <!-- main end -->
        </div>
    </div>
    
</div>
<!--
<div class="access">
    <div class="table-box">
        <div class="table-heading">로그인</div>
        <div class="table-body">
            <?php
            echo validation_errors('<div class="alert alert-warning" role="alert">', '</div>');
            echo show_alert_message(element('message', $view), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
            echo show_alert_message($this->session->flashdata('message'), '<div class="alert alert-auto-close alert-dismissible alert-info"><button type="button" class="close alertclose" >&times;</button>', '</div>');
            $attributes = array('class' => 'form-horizontal', 'name' => 'flogin', 'id' => 'flogin');
            echo form_open(current_full_url(), $attributes);
            ?>
                <input type="hidden" name="url" value="<?php echo html_escape($this->input->get_post('url')); ?>" />
                <ol class="loginform">
                    <li>
                        <span><?php echo element('userid_label_text', $view);?></span>
                        <input type="text" name="mem_userid" class="input" value="<?php echo set_value('mem_userid'); ?>" accesskey="L" />
                    </li>
                    <li>
                        <span>비밀번호</span>
                        <input type="password" class="input" name="mem_password" />
                    </li>
                    <li>
                        <span></span>
                        <button type="submit" class="btn btn-primary btn-sm">로그인</button>
                        <label for="autologin">
                            <input type="checkbox" name="autologin" id="autologin" value="1" /> 자동로그인
                        </label>
                    </li>
                </ol>
                <div class="alert alert-dismissible alert-info autologinalert" style="display:none;">
                    자동로그인 기능을 사용하시면, 브라우저를 닫더라도 로그인이 계속 유지될 수 있습니다. 자동로그이 기능을 사용할 경우 다음 접속부터는 로그인할 필요가 없습니다. 단, 공공장소에서 이용 시 개인정보가 유출될 수 있으니 꼭 로그아웃을 해주세요.
                </div>
            <?php echo form_close(); ?>
        </div>
        <div class="table-footer">
            <a href="<?php echo site_url('register'); ?>" class="btn btn-success btn-sm" title="회원가입">회원가입</a>
            <a href="<?php echo site_url('findaccount'); ?>" class="btn btn-default btn-sm" title="아이디 패스워드 찾기">아이디 패스워드 찾기</a>
        </div>
    </div>
</div>
-->
<script type="text/javascript">
//<![CDATA[
$(function() {
    $('#flogin').validate({
        rules: {
            mem_userid : { required:true, minlength:3 },
            mem_password : { required:true, minlength:4 }
        }
    });
});
$(document).on('change', "input:checkbox[name='autologin']", function() {
    if (this.checked) {
        $('.autologinalert').show(300);
    } else {
        $('.autologinalert').hide(300);
    }
});
//]]>
</script>
