<?php
    use yii\helpers\Html;
    use yii\helpers\ArrayHelper;
    use yii\widgets\ActiveForm;
    use app\models\Currency;
    use app\models\Language;
    use kartik\datecontrol\DateControl;
    $form = ActiveForm::begin();
?>
<div class="box box-primary">
    <div class="box-header">
        <div class="pull-left">
            <h3 class="box-title"><?php echo html_encode(view_param('pageHeading'));?></h3>
        </div>
    </div>
    <div class="box-body">
        <div id="global">
            <div class="row">
                <div class="col-lg-6">
                    <?= $form->field($model, 'siteName')->textInput([
                        'maxlength'         => true,
                        'data-content'      => t('app', 'Represents the site in invoices and sets the title of home page'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
                <div class="col-lg-6">
                    <?= $form->field($model, 'siteEmail')->textInput([
                        'maxlength'         => true,
                        'data-content'      => t('app', 'Email of the site in all the invoices'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    <?= $form->field($model, 'siteCurrency')->dropDownList(ArrayHelper::map(Currency::getActiveCurrencies(), 'code', 'name'),[
                        'class'             =>'form-control',
                        'prompt'            => t('app','Please select'),
                        'data-content'      => t('app', 'Currency used to do payments for packages'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]);?>
                </div>
                <div class="col-lg-3">
                    <?= $form->field($model, 'siteLanguage')->dropDownList(ArrayHelper::map(Language::find()->all(),
                        function($model, $defaultValue) {
                            return (!empty($model->region_code)) ? $model->language_code . '-' . $model->region_code : $model->language_code;
                        },
                        'name'),[
                        'class'             => 'form-control',
                        'prompt'            => t('app','Please select'),
                        'data-content'      => t('app', 'Represents the site Language'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]);?>
                </div>
                <div class="col-lg-3">
                    <?= $form->field($model, 'siteTimezone')->dropDownList(\app\helpers\DateTimeHelper::getSystemInternalTimeZones(),[
                        'class'             => 'form-control',
                        'prompt'            => t('app','Please select'),
                        'data-content'      => t('app', 'Timezone used for the application'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]);?>
                </div>
                <div class="col-lg-3">
                    <?= $form->field($model,'cookieConsentStatus')->dropDownList($model->getCookieConsentStatusList(),[
                        'class'             => 'form-control',
                        'data-content'      => t('app', 'If enabled, the customer will see cookie consent.'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]);?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    <?= $form->field($model, 'googleAnalyticsCode')->textInput([
                        'maxlength' => true,
                        'data-content'      => t('app', 'Google analytics code should look like this UA-0000000-0.'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
                <div class="col-lg-3">
                    <?= $form->field($model, 'siteGoogleMapsKey')->textInput([
                        'maxlength' => true,
                        'data-content'      => t('app', 'API Key from Google app used for maps all over the site'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
                <div class="col-lg-3">
                    <?= $form->field($model, 'captchaSiteKey')->textInput([
                        'maxlength' => true,
                        'data-content'      => t('app', 'If none filled, the option will be disabled by default'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
                <div class="col-lg-3">
                    <?= $form->field($model, 'captchaSecretKey')->textInput([
                        'maxlength' => true,
                        'data-content'      => t('app', 'If none filled, the option will be disabled by default'),
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
            <h3 class="box-title"><?= t('app', 'Meta Settings'); ?></h3>
        </div>
    </div>
    <div class="box-body">
        <div id="meta">
            <div class="row">
                <div class="col-lg-4">
                    <?= $form->field($model, 'siteTitle')->textInput([
                        'maxlength'         => true,
                        'data-content'      => t('app', 'Represents the page title and you can use variable {siteName}'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
                <div class="col-lg-4">
                    <?= $form->field($model, 'siteKeywords')->textInput([
                        'maxlength' => true,
                        'data-content'      => t('app', 'Represents the meta keywords of the page'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
                <div class="col-lg-4">
                    <?= $form->field($model, 'siteDescription')->textInput([
                        'maxlength' => true,
                        'data-content'      => t('app', 'Represents the meta description of the page'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <?= $form->field($model, 'joinTitle')->textInput([
                        'maxlength'         => true,
                        'data-content'      => t('app', 'Represents the page title and you can use variable {siteName}'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
                <div class="col-lg-4">
                    <?= $form->field($model, 'joinKeywords')->textInput([
                        'maxlength' => true,
                        'data-content'      => t('app', 'Represents the meta keywords of the page'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
                <div class="col-lg-4">
                    <?= $form->field($model, 'joinDescription')->textInput([
                        'maxlength' => true,
                        'data-content'      => t('app', 'Represents the meta description of the page'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <?= $form->field($model, 'loginTitle')->textInput([
                        'maxlength'         => true,
                        'data-content'      => t('app', 'Represents the page title and you can use variable {siteName}'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
                <div class="col-lg-4">
                    <?= $form->field($model, 'loginKeywords')->textInput([
                        'maxlength' => true,
                        'data-content'      => t('app', 'Represents the meta keywords of the page'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
                <div class="col-lg-4">
                    <?= $form->field($model, 'loginDescription')->textInput([
                        'maxlength' => true,
                        'data-content'      => t('app', 'Represents the meta description of the page'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <?= $form->field($model, 'forgotPasswordTitle')->textInput([
                        'maxlength'         => true,
                        'data-content'      => t('app', 'Represents the page title and you can use variable {siteName}'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
                <div class="col-lg-4">
                    <?= $form->field($model, 'forgotPasswordKeywords')->textInput([
                        'maxlength' => true,
                        'data-content'      => t('app', 'Represents the meta keywords of the page'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
                <div class="col-lg-4">
                    <?= $form->field($model, 'forgotPasswordDescription')->textInput([
                        'maxlength' => true,
                        'data-content'      => t('app', 'Represents the meta description of the page'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <?= $form->field($model, 'postTitle')->textInput([
                        'maxlength'         => true,
                        'data-content'      => t('app', 'Represents the page title and you can use variable {siteName}'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
                <div class="col-lg-4">
                    <?= $form->field($model, 'postKeywords')->textInput([
                        'maxlength' => true,
                        'data-content'      => t('app', 'Represents the meta keywords of the page'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
                <div class="col-lg-4">
                    <?= $form->field($model, 'postDescription')->textInput([
                        'maxlength' => true,
                        'data-content'      => t('app', 'Represents the meta description of the page'),
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
            <h3 class="box-title"><?= t('app', 'Registration Settings'); ?></h3>
        </div>
    </div>
    <div class="box-body">
        <div id="registration">
            <div class="row">
                <div class="col-lg-3">
                    <?= $form->field($model,'confirmationEmail')->dropDownList([1 => t('app','Yes, customer must activate account'), 0 => t('app','No') ],[
                        'class'             => 'form-control',
                        'data-content'      => t('app', 'If enabled, the customer will received a activation email in order to activate account.'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]);?>
                </div>
                <div class="col-lg-3" id="expire-confirmation-key" style="<?php if ($model->confirmationEmail != 1){?>display:none<?php }?>">
                    <?= $form->field($model,'expireActivationKey')->textInput([
                        'maxlength'         => true,
                        'data-content'      => t('app', 'Number of days until the account activation link expires'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    <?= $form->field($model, 'allowedAge')->textInput([
                        'maxlength'         => true,
                        'data-content'      => t('app', 'Represents the minimum allowed age for a user to join'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
                <div class="col-lg-3">
                    <?= $form->field($model, 'termsAndConditionsPage')->dropDownList(
                        ArrayHelper::map(\app\models\Page::getAllPages(), 'page_id', 'title'),[
                        'class'             => 'form-control',
                        'prompt'            => t('app','Please select'),
                        'data-content'      => t('app', 'Terms and conditions page'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]);?>
                </div>
                <div class="col-lg-3">
                    <?= $form->field($model, 'guestContactSellers')->dropDownList([1 => t('app','Yes'), 0 => t('app','No') ]
                        ,[
                        'class'             => 'form-control',
                        'prompt'            => t('app','Please select'),
                        'data-content'      => t('app', 'if set to yes, will show seller contact information and contact form for guests'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]);?>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="box box-primary">
    <div class="box-header">
        <div class="pull-left">
            <h3 class="box-title"><?= t('app', 'Social Registration/Login Settings'); ?></h3>
        </div>
    </div>
    <div class="box-body">
        <div id="social">
            <div class="row">
                <div class="col-lg-6">
                    <?= $form->field($model, 'siteFacebookId')->textInput([
                        'maxlength' => true,
                        'data-content'      => t('app', 'ID from Facebook app used for Social Login'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
                <div class="col-lg-6">
                    <?= $form->field($model, 'siteFacebookSecret')->textInput([
                        'maxlength' => true,
                        'data-content'      => t('app', 'API Secret key from Facebook app used for Social Login'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <?= $form->field($model, 'siteGoogleId')->textInput([
                        'maxlength' => true,
                        'data-content'      => t('app', 'ID from Google app used for Social Login'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
                <div class="col-lg-6">
                    <?= $form->field($model, 'siteGoogleSecret')->textInput([
                        'maxlength' => true,
                        'data-content'      => t('app', 'API Secret key from Google app used for Social Login'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <?= $form->field($model, 'siteLinkedInId')->textInput([
                        'maxlength' => true,
                        'data-content'      => t('app', 'ID from LinkedIn app used for Social Login'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
                <div class="col-lg-6">
                    <?= $form->field($model, 'siteLinkedInSecret')->textInput([
                        'maxlength' => true,
                        'data-content'      => t('app', 'API Secret key from LinkedIn app used for Social Login'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <?= $form->field($model, 'siteTwitterId')->textInput([
                        'maxlength' => true,
                        'data-content'      => t('app', 'ID from Twitter app used for Social Login'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
                <div class="col-lg-6">
                    <?= $form->field($model, 'siteTwitterSecret')->textInput([
                        'maxlength' => true,
                        'data-content'      => t('app', 'API Secret key from Twitter app used for Social Login'),
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
            <h3 class="box-title"><?= t('app', 'Footer Settings'); ?></h3>
        </div>
    </div>
    <div class="box-body">
        <div id="footer">
            <div class="row">
                <div class="col-lg-4">
                    <?= $form->field($model, 'siteCopyright')->textInput([
                        'maxlength'         => true,
                        'data-content'      => t('app', 'Represents the copyright of the site in the footer'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
                <div class="col-lg-4">
                    <?= $form->field($model, 'footerFirstPageSectionTitle')->textInput([
                        'maxlength' => true,
                        'data-content'      => t('app', 'Title of the first middle widget in the footer'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
                <div class="col-lg-4">
                    <?= $form->field($model, 'footerSecondPageSectionTitle')->textInput([
                        'maxlength' => true,
                        'data-content'      => t('app', 'Title of the second middle widget in the footer'),
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
            <h3 class="box-title"><?= t('app', 'Maintenance Settings'); ?></h3>
        </div>
    </div>
    <div class="box-body">
        <div id="maintenance">
            <div class="row">
                <div class="col-lg-6">
                    <?= $form->field($model, 'siteStatus')->dropDownList([1 => 'Online', 0 => 'Offline' ],[
                        'data-content'      => t('app', 'If set to offline, application will be locked for all frontend customers, admin will have access everywhere.'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
                <div class="col-lg-6">
                    <?= $form->field($model, 'siteOfflineMessage')->textInput([
                        'maxlength' => true,
                        'data-content'      => t('app', 'Message to display when site status is offline.'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="form-group">
                        <?= Html::activeLabel($model, 'expired_ads_maintenance', ['label' => t('app','Remove expired Listings before a date')]);?>
                        <?= DateControl::widget([
                            'name'=>'kartik-date-3',
                            'type'=>DateControl::FORMAT_DATE,
                            'displayFormat' => app()->formatter->dateFormat,
                            'widgetOptions' => [
                                'pluginOptions' => [
                                    'autoclose' => true
                                ]
                            ]
                        ]);?>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="form-group">
                        <label><?= t('app','Action') ?></label><br />
                        <a data-input-success="<?= t('app','You will delete all ads expired before ') ?>"
                           data-input-error="<?= t('app','Please select a date before which the expired ads will be deleted!') ?>"
                           data-msg-success="<?= t('app',' expired ads were deleted.')?>"
                           data-url="<?= url(['settings/delete-expired-ads'])?>"
                           id="expiredAdsId" class="btn btn-primary btn-flat"><?php echo t('app', 'Delete')?></a>
                    </div>
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