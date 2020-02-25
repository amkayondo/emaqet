<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
?>

<div class="callout callout-warning">
    <h4><i class="icon fa fa-warning"></i> Warning!</h4>
    <p>Please be very careful when editing the license info, any wrong param will render your application unusable!</p>
</div>

<div class="callout callout-info">
    <h4><i class="icon fa fa-warning"></i> Privacy Notice!</h4>
    <p>
        Saving this form will make an external request to our API with this personal data from the form to validate your purchase code and domain in CodinBit's system!<br />
        If you have any question about this please feel free to read our privacy policy
        <a target="_blank" href="https://www.codinbit.com/privacy-policy">here</a> , terms and conditions
        <a target="_blank" href="https://www.codinbit.com/terms-and-conditions">here</a> or <a target="_blank" href="https://help.codinbit.com/support">submit a support ticket</a>
        and we answer all your questions.
    </p>
</div>

<?php $form = ActiveForm::begin(); ?>
<div class="box box-primary">
    <div class="box-header">
        <div class="pull-left">
            <h3 class="box-title"><?= html_encode(view_param('pageHeading')) ?></h3>
        </div>
    </div>
    <div class="box-body">
        <div class="license-settings-form">
            <div class="row">
                <div class="col-lg-6">
                    <?= $form->field($model, 'firstName')->textInput([
                        'data-content'      => t('app', 'Please provide your first name for license activation'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]); ?>
                </div>
                <div class="col-lg-6">
                    <?= $form->field($model, 'lastName')->textInput([
                        'data-content'      => t('app', 'Please provide your last name for license activation'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]); ?>
                </div>
            </div>

            <div class="row">
                <div class="col-lg-6">
                    <?= $form->field($model, 'email')->textInput([
                        'data-content'      => t('app', 'Please provide your email for license activation'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]); ?>
                </div>
                <div class="col-lg-6">
                    <?= $form->field($model, 'purchaseCode')->textInput([
                        'data-content'      => t('app', 'Please provide your purchase code for license activation'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <?= $form->field($model, 'acceptTerms')->checkbox(['label' => Yii::t('app', ' I Accept The <a target="_blank" href="https://www.codinbit.com/terms-and-conditions"> Terms and Conditions </a>')])->label(false); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <?= $form->field($model, 'marketing')->checkbox(['label' => Yii::t('app', ' I want to receive marketing emails and newsletters about CodinBit products')])->label(false); ?>
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