<?php
    use yii\helpers\Html;
    use yii\widgets\DetailView;
    use app\extensions\securityManager\models\SecurityLog;
?>
<div class="box box-primary security-log-view">
    <div class="box-header">
        <div class="pull-left">
            <h3 class="box-title"><?php echo html_encode(view_param('pageHeading'));?></h3>
        </div>
        <div class="pull-right">
            <?= Html::a(t('app', 'Back'), (SecurityLog::LOG_TYPE_ADMIN_FAILED_LOGIN == $model->log_type) ? ['admin-attempts'] : ['customer-attempts'], ['class' => 'btn btn-xs btn-success']) ?>
        </div>
    </div>
    <div class="box-body">
        <?= DetailView::widget([
            'model'      => $model,
            'attributes' => [
                'ip_address',
                'username',
                'password',
                'country',
                'city',
                'user_agent',
                'created_at',
            ],
        ]) ?>
    </div>
</div>