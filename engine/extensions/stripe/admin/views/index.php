<?php
    use yii\helpers\Html;
    use app\extensions\stripe\models\Stripe;
    use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin(); ?>

<div class="box box-primary">
    <div class="box-header with-border">
        <h3 class="box-title"><?php echo html_encode(view_param('pageHeading'));?></h3>
    </div>
    <div class="box-body">
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <?= Html::activeLabel($model, 'secretKey');?>
                    <?= Html::textInput($model->formName().'[secretKey]', html_encode($model->secretKey), ['class' => 'form-control']); ?>
                    <?= Html::error($model, 'secretKey', ['class' => 'help-block']);?>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <?= Html::activeLabel($model, 'publishableKey');?>
                    <?= Html::textInput($model->formName().'[publishableKey]', html_encode($model->publishableKey), ['class' => 'form-control']); ?>
                    <?= Html::error($model, 'publishableKey', ['class' => 'help-block']);?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6">
                <div class="form-group">
                    <?= Html::activeLabel($model, 'mode');?>
                    <?= Html::dropDownList($model->formName().'[mode]', html_encode($model->mode), Stripe::getModeList() , ['class' => 'form-control']); ?>
                    <?= Html::error($model, 'mode', ['class' => 'help-block']);?>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="form-group">
                    <?= Html::activeLabel($model, 'status');?>
                    <?= Html::dropDownList($model->formName().'[status]', html_encode($model->status), Stripe::getStatusList() , ['class' => 'form-control']); ?>
                    <?= Html::error($model, 'status', ['class' => 'help-block']);?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="form-group">
                    <?= Html::activeLabel($model, 'description');?>
                    <?= Html::textarea($model->formName().'[description]', html_encode($model->description), [
                        'class' => 'form-control',
                        'rows'   => 5,
                        'cols'   => 50,
                        'data-content'      => t('app', 'This will be displayed when clients choose a payment gateway to pay ad posting'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]); ?>
                    <?= Html::error($model, 'description', ['class' => 'help-block']);?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="box box-primary">
    <div class="box-footer">
        <div class="pull-right">
            <?= Html::submitButton(t('app', 'Save Changes'), ['class' => 'btn btn-primary']) ?>
        </div>
        <div class="clearfix"><!-- --></div>
    </div>
</div>
<?php ActiveForm::end(); ?>