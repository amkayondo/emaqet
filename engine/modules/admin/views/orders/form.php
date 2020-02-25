<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
?>
<div class="box box-primary orders-<?= $action;?>">

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
        <div class="orders-form">
            <div class="row">
                <div class="col-lg-4">
                    <?= $form->field($model, 'order_title')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-lg-4">
                    <?= $form->field($model, 'first_name')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-lg-4">
                    <?= $form->field($model, 'last_name')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-4">
                    <?= $form->field($model, 'company_name')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-lg-4">
                    <?= $form->field($model, 'company_no')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-lg-4">
                    <?= $form->field($model, 'vat')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <?= $form->field($model, 'phone')->textInput(['maxlength' => true]) ?>
                </div>
                <div class="col-lg-6">
                    <?= $form->field($model, 'status')->dropDownList(\app\models\Order::getOrderStatusesList()) ?>
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