<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
?>
<div class="box box-primary customers-<?= $action;?>">

    <div class="box-header">
        <div class="pull-left">
            <h3 class="box-title"><?= html_encode(view_param('pageHeading')) ?></h3>
        </div>
        <div class="pull-right">
            <?= Html::a(t('app', 'Cancel'), ['index'], ['class' => 'btn btn-xs btn-success']) ?>
        </div>
    </div>
    <div class="box-body">

        <?php $form = ActiveForm::begin(); ?>
        <div class="users-form">
            <div class="row">
                <div class="col-lg-6">
                    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-lg-6">
                    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <?= $form->field($model, 'email')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-lg-6">
                    <?= $form->field($model, 'status')->dropDownList([ $model::STATUS_ACTIVE => t('app','Active'), $model::STATUS_DEACTIVATED => t('app','Deactivated') ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <?= $form->field($model, 'password', [
                        'template'      => '{input} {error}',
                    ])->passwordInput(['placeholder' => t('app','Password'), 'class' => 'form-control with-addon'])->label(false); ?>
                </div>
                <div class="col-lg-6">
                    <?= $form->field($model, 'passwordConfirm', [
                        'template'      => '{input} {error}',
                    ])->passwordInput(['placeholder' => t('app','Retype Password'), 'class' => 'form-control with-addon'])->label(false); ?>
                </div>
            </div>
        </div>

        <div class="box-footer">
            <div class="pull-right">
                <?= Html::submitButton($model->isNewRecord ? t('app', 'Create') : t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
            </div>
            <div class="clearfix"><!-- --></div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>