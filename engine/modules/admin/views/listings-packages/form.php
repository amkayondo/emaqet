<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use app\models\ListingPackage;
    $form = ActiveForm::begin();
?>
<div class="box box-primary listings-packages-<?= $action; ?>">
    <div class="box-header">
        <div class="pull-left">
            <h3 class="box-title"><?= html_encode(view_param('pageHeading')) ?></h3>
        </div>
    </div>
    <div class="box-body">
        <div class="listings-packages-form">
            <div class="row">
                <div class="col-lg-4">
                    <?= $form->field($model, 'title')->textInput([
                            'maxlength' => true,
                            'data-content'      => t('app', 'Package Title'),
                            'data-container'    => 'body',
                            'data-toggle'       => 'popover',
                            'data-trigger'      => 'hover',
                            'data-placement'    => 'top'
                    ]) ?>
                </div>
                <div class="col-lg-4">
                    <?= $form->field($model, 'price')->textInput([
                            'maxlength' => true,
                            'data-content'      => t('app', 'Package Price in {currency}', ['currency' => options()->get('app.settings.common.siteCurrency', 'usd')]),
                            'data-container'    => 'body',
                            'data-toggle'       => 'popover',
                            'data-trigger'      => 'hover',
                            'data-placement'    => 'top'
                    ]) ?>
                </div>
                <div class="col-lg-4">
                    <?= $form->field($model, 'recommended_sign')->dropDownList(
                        ListingPackage::getYesNoList(),[
                        'data-content'      => t('app', 'Add Recommended Label to package display in packages step'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top']) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <?= $form->field($model, 'listing_days')->textInput([
                            'maxlength' => true,
                            'data-content'      => t('app', 'Number of days before an ad expires'),
                            'data-container'    => 'body',
                            'data-toggle'       => 'popover',
                            'data-trigger'      => 'hover',
                            'data-placement'    => 'top'
                    ]) ?>
                </div>
                <div class="col-lg-4">
                    <?= $form->field($model, 'auto_renewal')->textInput([
                            'maxlength' => true,
                            'data-content'      => t('app', 'Number of times for an ad to auto renew itself in the listing after expiring'),
                            'data-container'    => 'body',
                            'data-toggle'       => 'popover',
                            'data-trigger'      => 'hover',
                            'data-placement'    => 'top'
                    ]) ?>
                </div>
            </div>
        </div>
    </div>
</div>

    <div class="box box-primary">
    <div class="box-header">
        <div class="pull-left">
            <h3 class="box-title"><?= t('app', 'Package Promoted Settings'); ?></h3>
        </div>
    </div>
    <div class="box-body">
        <div id="promoted">
            <div class="row">
                <div class="col-lg-3">
                    <?= $form->field($model, 'promo_sign')->dropDownList(
                        ListingPackage::getYesNoList(),[
                        'data-content'      => t('app', 'Add Promoted label to the ad image'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top']) ?>
                </div>
                <div class="col-lg-3">
                    <?= $form->field($model, 'promo_label_text')->textInput([
                        'maxlength' => true,
                        'data-content'      => t('app', 'Choose a text for the promoted label (e.g. Featured, Promoted ...)'),
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top',
                        'class'             => 'form-control'
                    ]) ?>
                </div>
                <div class="col-lg-3">
                    <?= $form->field($model, 'promo_label_text_color')->textInput([
                        'maxlength' => true,
                        'data-content'      => t('app', 'Pick a color for the promo text label'),
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top',
                        'class'             => 'form-control colorpicker-input'
                    ]) ?>
                </div>
                <div class="col-lg-3">
                    <?= $form->field($model, 'promo_label_background_color')->textInput([
                        'maxlength' => true,
                        'data-content'      => t('app', 'Pick a color for the promo background label'),
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top',
                        'class'             => 'form-control colorpicker-input'
                    ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <?= $form->field($model, 'promo_days')->textInput([
                        'maxlength' => true,
                        'data-content'      => t('app', 'Number of days before the promo feature expires, and the ad becomes regular'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
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