<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use app\extensions\securityManager\models\SecurityReason;

?>

<a href="#" class="btn-as inappropriate-reporting-button" data-toggle="modal" data-target="#modal-report-inappropriate"
   data-listing-id="<?= (int)$ad->listing_id; ?>" data-favorite-url="<?= url(['/listing/toggle-favorite']); ?>">
    <i class="fa fa-exclamation-circle" aria-hidden="true"></i> <span><?= t('app', 'Report inappropriate'); ?></span>
</a>

<div class="modal fade" id="modal-report-inappropriate" tabindex="-1" role="dialog" aria-labelledby=""
     aria-hidden="true">
    <div class="modal-dialog modal-report-inappropriate" role="document">
        <?php $form = ActiveForm::begin([
            'action'                 => ['security-manager/inappropriate-report'],
            'enableClientValidation' => true,
        ]); ?>
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title"><?= t('app', 'Report Inappropriate'); ?></h1>
                <a href="javascript:;" class="x-close" data-dismiss="modal"><i class="fa fa-times"
                                                                               aria-hidden="true"></i></a>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <?= $form->field($model, 'report_reason')->dropDownList(ArrayHelper::map(SecurityReason::getReasonsList(SecurityReason::REASON_TYPE_INAPPROPRIATE_REPORT), 'description', 'description'), ['prompt' => t('app', 'Select Reason')])->label(false); ?>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <?= $form->field($model, 'report_notes')->textarea([
                            'class'       => 'form-control',
                            'placeholder' => t('app', 'Please clarify details of violation to be able to move on as soon as possible.'),
                        ])->label(false) ?>
                        <?= $form->field($model, 'listing_id')->hiddenInput(['value' => $ad->listing_id])->label(false); ?>
                    </div>
                    <?php if ($captchaSiteKey = options()->get('app.settings.common.captchaSiteKey', '')) { ?>
                        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="transform:scale(0.77);-webkit-transform:scale(0.77);transform-origin:0 0;-webkit-transform-origin:0 0;">
                            <?= $form->field($model, 'reCaptcha')->widget(
                                \himiklab\yii2\recaptcha\ReCaptcha::className(),
                                ['siteKey' => html_encode($captchaSiteKey)]
                            )->label(false); ?>
                        </div>
                    <?php } ?>
                </div>
            </div>
            <div class="modal-footer">
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <?= Html::submitButton(t('app', 'Report'), ['class' => 'btn-as']) ?>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
                        <?= Html::button(t('app', 'Close'), ['class' => 'btn-as black pull-right', 'data-dismiss' => 'modal']); ?>
                    </div>
                </div>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>