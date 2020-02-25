<?php
    use yii\helpers\Html;
    use yii\widgets\DetailView;
    use yii\bootstrap\ActiveForm;
    use \app\extensions\securityManager\models\SecurityInappropriateReport;
?>
<div class="box box-primary security-log-view">
    <div class="box-header">
        <div class="pull-left">
            <h3 class="box-title"><?php echo html_encode(view_param('pageHeading'));?></h3>
        </div>
        <div class="pull-right">
            <?= Html::a(t('app', 'Back'), ['index'], ['class' => 'btn btn-xs btn-success']) ?>
        </div>
    </div>
    <div class="box-body">
        <?= DetailView::widget([
            'model'      => $model,
            'attributes' => [
                [
                    'format'    => 'ntext',
                    'attribute' => 'listing_id',
                    'value'     => function ($model) {
                        return ($model->ad) ? $model->ad->title : t('app', 'Ad was deleted!');
                    },
                ],
                [
                    'attribute' => 'status',
                    'value'     => function ($model) {
                        return \app\extensions\securityManager\models\SecurityInappropriateReport::getStatusesList($model->status);
                    },
                    'visible'   => ($action == 'update') ? false : true,
                ],
                'report_reason',
                'report_notes',
                'updated_by',
                'created_at',
                'updated_at',
            ],
        ]) ?>
        <?php if ($action == 'update') { ?>
            <?php $form = ActiveForm::begin(); ?>
            <div class="row">
                <div class="col-lg-12">
                    <?= $form->field($model, 'status')->dropDownList(SecurityInappropriateReport::getStatusesList(), ['prompt' => t('app', 'Select Status')])->label(false); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="pull-right">
                        <?= Html::submitButton(t('app', 'Update'), ['class' => 'btn btn-primary']) ?>
                    </div>
                    <div class="clearfix"><!-- --></div>
                </div>
            </div>
            <?php ActiveForm::end(); ?>
        <?php } ?>
    </div>
</div>