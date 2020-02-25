<?php
    use yii\helpers\Html;
    use yii\widgets\DetailView;
?>
<div class="box box-primary listings-packages-view">
    <div class="box-header">
        <div class="pull-left">
            <h3 class="box-title"><?php echo html_encode(view_param('pageHeading'));?></h3>
        </div>
        <div class="pull-right">
            <?= Html::a(t('app', 'Update'), ['update', 'id' => $model->package_id], ['class' => 'btn btn-xs btn-success']) ?>
            <?= Html::a(t('app', 'Delete'), ['delete', 'id' => $model->package_id], [
                'class' => 'btn btn-xs btn-danger',
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
                'title',
                'price',
                'listing_days',
                'promo_days',
                'promo_sign',
                'promo_label_text',
                'promo_label_text_color',
                'promo_label_background_color',
                'recommended_sign',
                'auto_renewal',
                'created_at',
                'updated_at',
            ],
        ]) ?>
    </div>
</div>
