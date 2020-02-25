<?php
    use yii\helpers\Html;
    use yii\helpers\ArrayHelper;
    use yii\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin(); ?>
<div class="box box-primary">
    <div class="box-header">
        <div class="pull-left">
            <h3 class="box-title"><?= t('app', 'Global Listings Settings'); ?></h3>
        </div>
    </div>
    <div class="box-body">
        <div id="listings">
            <div class="row">
                <div class="col-lg-4">
                    <?= $form->field($model, 'relatedAds')->dropDownList(['yes' => t('app','Yes'), 'no' => t('app','No') ],[
                        'data-content'      => t('app', 'If it\'s set to yes then on every ad page will show a widget of related ads to that specific ad page.'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
                <div class="col-lg-4">
                    <?= $form->field($model, 'disableMap')->dropDownList([ 1 => t('app','Yes'), 0 => t('app','No') ],[
                        'data-content'      => t('app', 'If it\'s set to yes then map will be hidden, otherwise you need to provide Google Maps API KEY in API Keys section!'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
                <div class="col-lg-4">
                    <?= $form->field($model, 'freeAdsLimit')->textInput([
                        'data-content'      => t('app', 'Maximum number of free ads per user.'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top',
                    ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <?= $form->field($model, 'expiredDays')->textInput([
                        'data-content'      => t('app', 'Number of days for customer to be notified before the ad expires. If it\'s set to 0, then the notification will be disabled.'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top',
                    ]) ?>
                </div>
                <div class="col-lg-4">
                    <?= $form->field($model, 'dailyNotification')->dropDownList([ 1 => t('app','Yes'), 0 => t('app','No') ],[
                        'data-content'      => t('app','Send the notifications for expiration of the ads daily.'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
                <div class="col-lg-4">
                    <?= $form->field($model, 'disableStore')->dropDownList([ 1 => t('app','Yes'), 0 => t('app','No') ],[
                        'data-content'      => t('app','If it\'s set to yes then the upgrade to store option will be disabled!'),
                        'data-container'    => 'body',
                        'data-message'      => t('app', 'Are you sure you want to disable the option to upgrade to stores? All stores will be changed to normal accounts'),
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <?= $form->field($model, 'homePromotedNumber')->textInput([
                        'data-content'      => t('app', 'Number of promoted ads to display in the promoted ads section (e.g. 4, 8, 12...)'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
                <div class="col-lg-4">
                    <?= $form->field($model, 'homeNewNumber')->textInput([
                        'data-content'      => t('app', 'Number of new ads to display in the new ads section (e.g. 4, 8, 12...)'),
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
            <h3 class="box-title"><?= t('app', 'Post Listings Settings'); ?></h3>
        </div>
    </div>
    <div class="box-body">
        <div id="listings">
            <div class="row">
                <div class="col-lg-3">
                    <?= $form->field($model, 'adminApprovalAds')->dropDownList([ 1 => t('app','Yes'), 0 => t('app','No') ],[
                        'data-content'      => t('app', 'If it\'s set to yes then all ads will have "Pending Approval" status until an admin activates them, otherwise ads will be active immediately.'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
                <div class="col-lg-3">
                    <?= $form->field($model, 'adHideZip')->dropDownList([ 1 => t('app','Yes'), 0 => t('app','No') ],[
                        'data-content'      => t('app', 'If it\'s set to yes then zip code will be hidden, this should be set to no for most accurate position on google maps'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
                <div class="col-lg-3">
                    <?= $form->field($model, 'adsImagesLimit')->textInput([
                        'data-content'      => t('app', 'Maxim number of images per ad.'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top',
                    ]) ?>
                </div>
                <div class="col-lg-3">
                    <?= $form->field($model, 'imgMaxSize')->textInput([
                        'data-content'      => t('app','Maximum size in Kilobytes for ad images. If it\'s set to 0 then no restriction will be applied. (e.g. 1024 Kilobytes = 1 Megabyte)'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <?= $form->field($model, 'skipPackages')->dropDownList([ 1 => t('app','Yes'), 0 => t('app','No') ],[
                        'data-content'      => t('app','If it\'s set to yes then the default package will be auto selected to clients!'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
                <div class="col-lg-4" id="show-default-package" style="<?php if ($model->skipPackages != 1){?>display:none<?php }?>">
                    <?= $form->field($model, 'defaultPackage')->dropDownList(ArrayHelper::map(\app\models\ListingPackage::find()->where(['price' => 0])->all(), 'package_id', 'title'),[
                        'data-content'      => t('app','Choose default free package.'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]); ?>
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