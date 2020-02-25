<?php
    use yii\helpers\Html;
    use yii\widgets\DetailView;
?>
<div class="box box-primary order-transactions-view">
    <div class="box-header">
        <div class="pull-left">
                <h3 class="box-title"><?= html_encode(view_param('pageHeading')) ?></h3>
        </div>
        <div class="pull-right">
        </div>
    </div>
    <div class="box-body">
        <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                'transaction_id',
                'transaction_reference',
                [
                    'attribute' => 'order_id',
                    'value' => ($model->order_id) ? Html::a($model->order->order_id, ['/admin/orders/view', 'id' => $model->order_id]) : t('app', 'Not set'),
                    'format' => 'raw',
                ],
                'gateway',
                [
                    'attribute'=>'type',
                    'value'=> function($model){
                        return ucfirst(html_encode($model->type));
                    }
                ],
                'created_at',
                'updated_at',
                [
                'attribute' => 'gateway_response',
                'value' => $model->gateway_response,
                'contentOptions' => ['style' => 'word-break:break-word']
                ],
            ],
        ]) ?>
    </div>

</div>
