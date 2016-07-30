<?php
$i = 0;
if (element('latest', $view)) 
{
    foreach (element('latest', $view) as $key => $value) 
    {
?>
    <div class="media margin-clear">
        <div class="media-left">
            <div class="overlay-container">
                <img class="media-object" src="<?php echo element('thumb_url', $value); ?>" alt="blog-thumb">
                <a href="<?php echo element('url', $value); ?>" class="overlay-link small"><i class="fa fa-link"></i></a>
            </div>
        </div>
        <div class="media-body">
            <h6 class="media-heading"><a href="<?php echo element('url', $value); ?>"><?php echo html_escape(element('title', $value)); ?></a></h6>
            <p class="small margin-clear"><i class="fa fa-calendar pr-10"></i><?php echo element('display_datetime', $value); ?></p>
        </div>
        <hr>
    </div>
<?php
        $i++;
    }
}
while ($i < element('latest_limit', $view)) {
?>



<?php
        $i++;
    }
?>

