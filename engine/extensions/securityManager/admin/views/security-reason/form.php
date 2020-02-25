<?php
    use yii\helpers\Html;
    use yii\bootstrap\ActiveForm;
    use app\extensions\securityManager\models\SecurityReason;
?>
<?php $form = ActiveForm::begin(); ?>
<div class="box box-primary security-reason-<?= $action; ?>">
    <div class="box-header">
        <div class="pull-left">
            <h3 class="box-title"><?php echo html_encode(view_param('pageHeading'));?></h3>
        </div>
        <div class="pull-right">
            <?= Html::a(t('app', 'Cancel'), SecurityReason::REASON_TYPE_BAN == $model->reason_type ? ['ban-reasons'] : ['inappropriate-report-reasons'], ['class' => 'btn btn-xs btn-success']) ?>
        </div>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-lg-12">
                <?= $form->field($model, 'description')->textArea() ?>
            </div>
        </div>
    </div>
</div>

<div class="box box-primary">
    <div class="box-footer">
        <div class="pull-right">
            <?= Html::submitButton($model->isNewRecord ? t('app', 'Create') : t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        </div>
        <div class="clearfix"><!-- --></div>
    </div>
</div>
<?php ActiveForm::end(); ?>