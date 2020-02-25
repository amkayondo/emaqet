<?php
    use yii\helpers\Html;
    use yii\widgets\DetailView;
?>
<div class="box box-primary pages-view">
    <div class="box-header">
        <div class="pull-left">
            <h3 class="box-title"><?= html_encode(view_param('pageHeading')) ?></h3>
        </div>
        <div class="pull-right">
            <?= Html::a(t('app', 'Update'), ['update', 'id' => $model->page_id], ['class' => 'btn btn-xs btn-success']) ?>
            <?= Html::a(t('app', 'Delete'), ['delete', 'id' => $model->page_id], [
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
                'page_id',
                'title',
                'slug',
                'external_url',
                'keywords',
                'description',
                'content:raw',
                [
                    'label' => 'Section',
                    'value' => $model->getSection(),
                ],
                'sort_order',
                'status',
                'created_at',
                'updated_at',
            ],
        ]) ?>
    </div>
</div>
