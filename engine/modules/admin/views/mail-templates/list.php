<?php
    use yii\helpers\Html;
    use yii\grid\GridView;
    use yii\widgets\Pjax;
?>
<div class="box box-primary mail-template-index">

    <div class="box-header">
        <div class="pull-left">
            <h3 class="box-title"><?= html_encode(view_param('pageHeading')) ?></h3>
        </div>
    </div>

    <div class="box-body">
        <?php Pjax::begin([
            'enablePushState' => true,
        ]); ?>
        <?= GridView::widget([
            'options'          => ['class' => 'table-responsive grid-view'],
            'dataProvider' => $dataProvider,
            'filterModel'  => $searchModel,
            'columns'      => [
                'template_id',
                [
                    'format'    => 'ntext',
                    'attribute' => 'template_type',
                    'filter'    => Html::activeDropDownList($searchModel, 'template_type', \app\components\mail\template\TemplateType::getTypesList(), ['class' => 'form-control', 'prompt' => 'All']),
                    'value'     => function ($model) {
                        return implode(', ', \app\components\mail\template\TemplateType::getTypesList($model->template_type));
                    },
                ],
                'name',
                [
                    'format'    => 'ntext',
                    'attribute' => 'slug',
                    'filter'    => false,
                ],
                'subject',
                // 'isPlainContent',
                // 'content:ntext',

                [
                    'class'    => 'yii\grid\ActionColumn',
                    'template' => '{update}',
                ],
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>
