<?php
use yii\helpers\Html;
use yii\widgets\DetailView;
?>
<div class="box box-primary admin-action-log-view">
    <div class="box-header">
        <div class="pull-left">
            <h3 class="box-title"><?php echo html_encode(view_param('pageHeading'));?></h3>
        </div>
    </div>
    <div class="box-body">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'element',
                [
                    'attribute' => 'controller_name',
                ],
                [
                    'attribute' => 'action_name',
                ],
                'changed_model',
                'changed_data:ntext',
                [
                    'format'    => 'ntext',
                    'attribute' => 'changed_by',
                    'value'     => function ($model) {
                        return ($model->changedBy != null) ? $model->changedBy->getFullName() : t('app', 'Visitor');
                    },
                ],
                'created_at',
            ],
        ]) ?>
    </div>
</div>