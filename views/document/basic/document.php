<link rel="stylesheet" type="text/css" href="/plugin/contentbuilder/contentBuilder.css" />
<?php
//print_r($layout);
//print_r($view);
?>
<?php echo element('content', element('data', $view)); ?>
<?php if ($this->member->is_admin() === 'super') { ?>
    <div class="pull-right">
        <a href="<?php echo admin_url('page/document/write/' . element('doc_id', element('data', $view))); ?>" class="btn btn-danger btn-sm" target="_blank">내용수정</a>
    </div>
<?php } ?>
