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
?>

<div class="box box-primary security-reason-index">
    <div class="box-header">
        <div class="pull-left">
            <h3 class="box-title"><?php echo html_encode(view_param('pageHeading'));?></h3>
        </div>
        <div class="pull-right">
            <?= Html::a(Html::tag('i', '', ['class' => 'fa fa-plus fa-fw']) . t('app', 'Add Reason'), ['create', 'reasonType' => $reasonType], ['class' => 'btn btn-xs btn-success']) ?>
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
                'description',
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
                    'template' => '{update} {delete}',
                ],
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>
