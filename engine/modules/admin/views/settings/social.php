<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin(); ?>
<div class="box box-primary">
    <div class="box-header">
        <div class="pull-left">
            <h3 class="box-title"><?= html_encode(view_param('pageHeading')) ?></h3>
        </div>
    </div>
    <div class="box-body">
        <div class="social-settings-form">
            <div class="row">
                <div class="col-lg-4">
                    <?= $form->field($model, 'facebook')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-lg-4">
                    <?= $form->field($model, 'instagram')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-lg-4">
                    <?= $form->field($model, 'twitter')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <?= $form->field($model, 'googlePlus')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-lg-4">
                    <?= $form->field($model, 'pinterest')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-lg-4">
                    <?= $form->field($model, 'linkedin')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <?= $form->field($model, 'vkontakte')->textInput(['maxlength' => true]) ?>
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