<?php

/**
 *
 * @package    EasyAds
 * @author     CodinBit <contact@codinbit.com>
 * @link       https://store.codinbit.com
 * @copyright  2017 EasyAds (https://store.codinbit.com)
 * @license    https://www.codinbit.com
 * @since      1.3
 */

    use yii\helpers\Html;
    use yii\grid\GridView;
    use yii\widgets\Pjax;
    use \app\extensions\securityManager\models\SecurityInappropriateReport;
?>
<div class="box box-primary security-inappropriate-report-index">
    <div class="box-header">
        <div class="pull-left">
            <h3 class="box-title"><?php echo html_encode(view_param('pageHeading'));?></h3>
        </div>
        <div class="pull-right">
            <?= Html::a(Html::tag('i', '', ['class' => 'fa fa-refresh fa-fw']) . t('app', 'Refresh'), ['index'], ['class' => 'btn btn-xs btn-success']) ?>
        </div>
    </div>

    <div class="box-body">
        <?php Pjax::begin([
            'enablePushState' => true,
        ]); ?>
        <?= GridView::widget([
            'options'      => ['class' => 'table-responsive grid-view'],
            'dataProvider' => $dataProvider,
            'filterModel'  => $searchModel,
            'columns'      => [
                [
                    'format'    => 'ntext',
                    'attribute' => 'listing_id',
                    'value'     => function ($model) {
                        return ($model->ad) ? $model->ad->title : t('app', 'Ad was deleted!');
                    },
                ],
                [
                    'attribute'      => 'status',
                    'filter'         => Html::activeDropDownList(
                        $searchModel,
                        'status',
                        SecurityInappropriateReport::getStatusesList(),
                        ['class' => 'form-control', 'prompt' => t('app', 'All')]
                    ),
                    'value'          => function ($model) {
                        return SecurityInappropriateReport::getStatusesList($model->status);
                    },
                    'contentOptions' => function ($model) {
                        return ['class' => SecurityInappropriateReport::getStatusToColorClassAccordance($model->status)];
                    },
                ],
                'updated_by',
                [
                    'attribute' => 'created_at',
                    'filter'    => yii\jui\DatePicker::widget([
                        'model'      => $searchModel,
                        'attribute'  => 'created_at',
                        'options'    => [
                            'class' => 'form-control',
                        ],
                        'dateFormat' => 'yyyy-MM-dd',
                    ]),
                ],
                [
                    'attribute' => 'updated_at',
                    'filter'    => yii\jui\DatePicker::widget([
                        'model'      => $searchModel,
                        'attribute'  => 'updated_at',
                        'options'    => [
                            'class' => 'form-control',
                        ],
                        'dateFormat' => 'yyyy-MM-dd',
                    ]),
                ],
                [
                    'class'    => 'yii\grid\ActionColumn',
                    'template' => '{view} {update} {editListing}',
                    'buttons'  => [
                        'editListing' => function ($url, $model) {
                            return Html::a(
                                '<i class="fa fa-tags"></i>',
                                url(['/admin/listings/update', 'id' => $model->listing_id]),
                                [
                                    'target'         => '_blank',
                                    'data-content'   => t('app', 'Edit Listing'),
                                    'data-container' => 'body',
                                    'data-toggle'    => 'popover',
                                    'data-trigger'   => 'hover',
                                    'data-placement' => 'top',
                                    'data-pjax'      => '0',

                                ]
                            );
                        },
                    ],
                ],
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>