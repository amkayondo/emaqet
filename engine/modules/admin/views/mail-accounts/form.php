<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use app\components\mail\template\TemplateType;
?>
<div class="box box-primary mail-accounts-<?= $action; ?>">

    <div class="box-header">
        <div class="pull-left">
            <h3 class="box-title"><?= html_encode(view_param('pageHeading')) ?></h3>
        </div>
        <div class="pull-right">
        </div>
    </div>

    <div class="box-body">
        <?php $form = ActiveForm::begin(); ?>
        <div class="email-settings-form">
            <div class="row">
                <div class="col-lg-12">
                    <?= $form->field($model, 'account_name')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <?= $form->field($model, 'hostname')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-lg-4">
                    <?= $form->field($model, 'username')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-lg-4">
                    <?= $form->field($model, 'password')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4">
                    <?= $form->field($model, 'port')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-lg-4">
                    <?= $form->field($model, 'encryption')->dropDownList($model->getEncryptionsList()); ?>
                </div>
                <div class="col-lg-4">
                    <?= $form->field($model, 'timeout')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4">
                    <?= $form->field($model, 'from')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-lg-4">
                    <?= $form->field($model, 'reply_to')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-lg-4">
                    <?= $form->field($model, 'used_for')->dropDownList(TemplateType::getTypesList(), [
                        'multiple' => 'multiple',
                        'options' => $model::getListOfUsedTemplateTypes($model->account_id),
                        'size'      => count(TemplateType::getTypesList()) + 3,
                        'data-content'      => t('app', 'Handles on which email template should this account be used, you can select multiple options.'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]); ?>
                </div>
            </div>
        </div>

        <div class="box-footer">
            <div class="pull-right">
                <?= Html::submitButton(t('app', 'Save Changes'), ['class' => 'btn btn-primary']) ?>
            </div>
            <div class="clearfix"><!-- --></div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>