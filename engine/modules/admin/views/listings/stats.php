<?php
    use yii\widgets\DetailView;
?>
<div class="box box-primary listings-stats-view">
    <div class="box-header">
        <div class="pull-left">
            <h3 class="box-title"><?php echo html_encode(view_param('pageHeading'));?></h3>
        </div>
    </div>
    <div class="box-body">
        <?= DetailView::widget([
            'model' => $model,
            'formatter' => ['class' => 'yii\i18n\Formatter','nullDisplay' => 0],
            'attributes' => [
                'total_views',
                'facebook_shares',
                'twitter_shares',
                'mail_shares',
                'favorite',
                'show_phone',
                'show_mail',
            ],
        ]) ?>
    </div>
</div>
