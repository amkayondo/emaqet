<?php
    use yii\helpers\Html;
    use yii\widgets\DetailView;
?>
<div class="box box-primary mail-account-view">
    <div class="box-header">
        <div class="pull-left">
            <h3 class="box-title"><?= html_encode(view_param('pageHeading')) ?></h3>
        </div>
        <div class="pull-right">
            <?= Html::a(t('app', 'Update'), ['update', 'id' => $model->account_id], ['class' => 'btn btn-primary']) ?>
            <?= Html::a(t('app', 'Delete'), ['delete', 'id' => $model->account_id], [
                'class' => 'btn btn-danger',
                'data' => [
                    'confirm' => t('app', 'Are you sure you want to delete this item?'),
                    'method' => 'post',
                ],
            ]) ?>
        </div>
    </div>
    <div class="box-body">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'account_name',
                'hostname',
                'username',
                'password',
                'port',
                'encryption',
                'timeout',
                'from',
                'reply_to',
                [
                    'label'     => 'Template types',
                    'format'    => 'ntext',
                    'attribute' => 'used_for',
                    'value'     => function ($model) {
                        return implode(', ', \app\components\mail\template\TemplateType::getTypesList($model->used_for));
                    },
                ],
                'created_at',
                'updated_at',
            ],
        ]) ?>
    </div>
</div>
