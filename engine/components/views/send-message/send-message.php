<?php
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;
?>

<section id="send-message-widget" class="send-message-widget">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="separator-text">
                    <span><?= t('app', 'Send message')?></span>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                <?php $form = ActiveForm::begin([
                    'id'        => 'send-message-form',
                    'method'    => 'post',
                    'action'    => ['listing/send-message'],
                ]); ?>
                <?php if (app()->customer->isGuest) { ?>
                    <div class="row">
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <?= $form->field($sendMessageForm, 'fullName', [
                                'template'      => '{input} {error}',
                            ])->textInput([ 'placeholder' => t('app','Full Name'), 'class' => 'form-control'])->label(false); ?>
                        </div>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <?= $form->field($sendMessageForm, 'email', [
                                'template'      => '{input} {error}',
                            ])->textInput([ 'placeholder' => t('app','Email'), 'class' => 'form-control'])->label(false); ?>
                        </div>
                    </div>
                <?php } ?>
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <?= $form->field($sendMessageForm, 'message', [
                            'template'      => '{input} {error}',
                        ])->textarea([ 'placeholder' => t('app','Message'), 'class' => 'form-control'])->label(false); ?>
                    </div>
                </div>
                <div class="row">
                    <?= $form->field($sendMessageForm, 'slug')->hiddenInput(['value' => $slug])->label(false); ?>
                    <?php if ($captchaSiteKey = options()->get('app.settings.common.captchaSiteKey', '')) { ?>
                        <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12">
                            <?= $form->field($sendMessageForm, 'reCaptcha')->widget(
                                \himiklab\yii2\recaptcha\ReCaptcha::className(),
                                ['siteKey' => html_encode($captchaSiteKey)]
                            )->label(false); ?>
                        </div>
                    <?php } ?>
                    <div class="col-lg-6 col-md-6 col-sm-12 col-xs-12 <?= $captchaSiteKey ? 'text-right' : '' ?>">
                        <button type="submit" class="btn-as" value="Submit"><?=t('app','Submit');?></button>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>
</section>