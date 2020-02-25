<div class="callout callout-danger">
    <h4><i class="icon fa fa-warning"></i> IMPORTANT!</h4>
    <p><i class="fa fa-star"></i> It's Critical to add this cron jobs to your server in order for the application to work properly!</p>
    <p><i class="fa fa-star"></i> To ensure that your cron jobs run without any errors make sure that the PHP command line interface (PHP CLI) executing those cron jobs has the same version as PHP required for EasyAds to run.</p>
    <p><i class="fa fa-star"></i> Some of the hosting companies have different version for PHP and PHP command line!</p>
</div>

<div class="box box-default">
    <div class="box-header with-border">
        <h3 class="box-title">Cron Jobs - You need to add the following cron jobs to your server</h3>
    </div>
    <div class="box-body">
<pre>

<?php foreach (app\helpers\CommonHelper::getCronJobsList() as $cronJobData) { ?>
# <?php echo $cronJobData['description'];?>

<?php echo $cronJobData['cronjob'];?>


<?php } ?>
</pre>
        <div class="clearfix"><!-- --></div>
    </div>
</div>