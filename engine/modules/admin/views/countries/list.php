<?php
    use yii\helpers\Html;
    use yii\grid\GridView;
    use yii\widgets\Pjax;
    use yii\jui\DatePicker;
?>
<div class="box box-primary countries-index">

    <div class="box-header">
        <div class="pull-left">
            <h3 class="box-title"><?= html_encode(view_param('pageHeading')) ?></h3>
        </div>
        <div class="pull-right">
            <?= Html::a(Html::tag('i', '', ['class' => 'fa fa-check fa-fw']) .t('app', 'Activate All'), ['activate-all'], ['class' => 'btn btn-xs btn-primary']) ?>
            <?= Html::a(Html::tag('i', '', ['class' => 'fa fa-times fa-fw']) .t('app', 'Deactivate All'), ['deactivate-all'], ['class' => 'btn btn-xs btn-danger', 'id' => 'deactivate-all-countries']) ?>
            <?= Html::a(Html::tag('i', '', ['class' => 'fa fa-plus fa-fw']) .t('app', 'Create Country'), ['create'], ['class' => 'btn btn-xs btn-success']) ?>
            <?= Html::a(Html::tag('i', '', ['class' => 'fa fa-refresh fa-fw']) . t('app', 'Refresh'), ['index'], ['class' => 'btn btn-xs btn-success']) ?>

        </div>
    </div>

    <div class="box-body">
        <?php Pjax::begin([
                'enablePushState'   => true,
            ]); ?>
            <?= GridView::widget([
                'id' => 'countries',
                'tableOptions' => [
                    'class' => 'table table-bordered table-hover table-striped',
                ],
                'options'          => ['class' => 'table-responsive grid-view'],
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => [
                    'name',
                     'code',
                    [
                     'attribute'=>'created_at',
                     'filter'=>  DatePicker::widget([
                                                        'model' => $searchModel,
                                                        'attribute' => 'created_at',
                                                        'options'=>[
                                                            'class'=>'form-control',
                                                            ],
                                                        'dateFormat' => 'yyyy-MM-dd',
                                                    ])
                    ],
                    [
                     'attribute'=>'status',
                     'value'=> function($model){
                        return t('app',ucfirst(html_encode($model->status)));
                     },
                     'filter' => Html::activeDropDownList($searchModel, 'status', [ 'active' => t('app','Active'), 'inactive' => t('app','Inactive'), ],['class'=>'form-control','prompt' => 'All'])
                    ],
                    [
                        'class' => 'yii\grid\ActionColumn',
                        'contentOptions' => [
                            'style'=>'width:130px',
                            'class'=>'table-actions'
                        ],
                        'template' => '{activate} {deactivate} {view} {update} {delete}',
                        'buttons'  => [
                            'activate' => function ($url, $model) {
                                return $model->status === \app\models\Country::STATUS_INACTIVE ? Html::a(
                                    '<span class="fa fa-check"></span>',
                                    url(['/admin/countries/activate', 'id' => $model->country_id, 'page' => request()->get('page')]),
                                    [
                                        'data-content'      => t('app', 'Set active'),
                                        'data-container'    => 'body',
                                        'data-toggle'       => 'popover',
                                        'data-trigger'      => 'hover',
                                        'data-placement'    => 'top',
                                        'data-confirm'      => t('app', 'Are you sure you want to activate this item?'),
                                        'style'             => 'margin-right: 6px'
                                    ]
                                ) : '';
                            },
                            'deactivate' => function ($url, $model) {
                                return $model->status === \app\models\Country::STATUS_ACTIVE ? Html::a(
                                    '<span class="fa fa-times"></span>',
                                    url(['/admin/countries/deactivate', 'id' => $model->country_id, 'page' => request()->get('page')]),
                                    [
                                        'data-content'      => t('app', 'Set inactive'),
                                        'data-container'    => 'body',
                                        'data-toggle'       => 'popover',
                                        'data-trigger'      => 'hover',
                                        'data-placement'    => 'top',
                                        'data-confirm'      => t('app', 'Are you sure you want to deactivate this item?'),
                                        'style'             => 'margin-right: 9px'
                                    ]
                                ) : '';
                            },
                        ],
                    ],
                ],
            ]); ?>
        <?php Pjax::end(); ?>
    </div>

</div>
