<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use dosamigos\ckeditor\CKEditor;
?>
<div class="box box-primary">

    <div class="box-header">
        <div class="pull-left">
            <h3 class="box-title"><?= html_encode(view_param('pageHeading')) ?></h3>
        </div>
    </div>
    <div class="box-body">
        <?php $form = ActiveForm::begin([
            'id' => 'admin-contact-form'
        ]); ?>
        <div class="contact-form-settings-form">
            <div class="row">
                <div class="col-lg-6">
                    <?= $form->field($model, 'keywords')->textInput([
                        'maxlength' => true,
                        'data-content'      => t('app', 'Page Meta Keywords'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
                <div class="col-lg-6">
                    <?= $form->field($model, 'description')->textInput([
                        'maxlength' => true,
                        'data-content'      => t('app', 'Page Meta Description'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    =>  'top'
                    ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <?= $form->field($model, 'contactEmail')->textInput([
                        'maxlength' => true,
                        'data-content'      => t('app', 'Email account where contact messages will be send'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
                <div class="col-lg-6">
                    <?= $form->field($model, 'senderEmail')->dropdownList([0 => t('app', 'No'), 1 =>t('app', 'Yes')],[
                        'data-content'      => t('app', 'Choosing yes will send a copy of message to sender'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top',
                    ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <?= $form->field($model,'shortDescription')->widget(CKEditor::className(), [
                        'options' => ['rows' => 6],
                        'preset' => 'basic'
                    ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    <?= $form->field($model, 'enableMap')->dropDownList([0 => t('app', 'No, do not enable map'), 1 => t('app', 'Yes, enable map')],[
                        'data-content'      => t('app', 'Enabling this will display a map on your contact form.'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
            </div>
            <div class="row clear-address-options" style="<?php if ($model->enableMap != 1){?>display:none<?php }?>">
                <div class="col-lg-3">
                    <?= $form->field($model, 'country')->textInput([
                        'id'                => 'contact-country',
                        'maxlength'         => true,
                        'data-content'      => t('app', 'Country name'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
                <div class="col-lg-3">
                    <?= $form->field($model, 'zone')->textInput([
                        'id'                => 'contact-zone',
                        'maxlength'         => true,
                        'data-content'      => t('app', 'Zone name'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
                <div class="col-lg-3">
                    <?= $form->field($model, 'city')->textInput([
                        'id'                => 'contact-city',
                        'maxlength'         => true,
                        'data-content'      => t('app', 'City name'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
                <div class="col-lg-3">
                    <?= $form->field($model, 'zip')->textInput([
                        'id'                => 'contact-zip',
                        'data-content'      => t('app', 'Zip code'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
            </div>
            <div class="row clear-address-options" style="<?php if ($model->enableMap != 1){?>display:none<?php }?>">
                <script src="https://maps.googleapis.com/maps/api/js?key=<?=html_encode(options()->get('app.settings.common.siteGoogleMapsKey', ''));?>"></script>
                <div class="col-lg-12" id="map-msg" data-msg-error="<?= t('app', 'Address not found, please insert another location.')?>">
                    <h4 class="map-error"></h4>
                    <div id="map-content" style="height: 414px; background-color: #eeebe8; filter: blur(10px);
                                        -webkit-filter: blur(5px);
                                        -moz-filter: blur(5px);
                                        -o-filter: blur(5px);
                                        -ms-filter: blur(5px);"></div>

                </div>
            </div>
            <div class="row clear-address-options" style="<?php if ($model->enableMap != 1){?>display:none<?php }?>">
                <br>
                <div class="col-lg-3">
                    <?= $form->field($model, 'latitude')->textInput([
                        'id'                => 'latitude-address',
                        'maxlength'         => true,
                        'data-content'      => t('app', 'Latitude'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
                <div class="col-lg-3">
                    <?= $form->field($model, 'longitude')->textInput([
                        'id'                => 'longitude-address',
                        'maxlength'         => true,
                        'data-content'      => t('app','Longitude'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <?= $form->field($model,'section')->dropDownList(
                        \app\models\Page::getSectionsList(),
                        [
                            'prompt'            => t('app', 'Select selection'),
                            'data-content'      => t('app', 'The section where this contact should display in footer'),
                            'data-container'    => 'body',
                            'data-toggle'       => 'popover',
                            'data-trigger'      => 'hover',
                            'data-placement'    => 'top'
                        ]
                    ) ?>
                </div>
                <div class="col-lg-6">
                    <?= $form->field($model, 'sort_order')->dropDownList(
                        $model->section ? $pageModel->getListOfAvailablePositions($model->section) : [],
                        [
                            'prompt'       => t('app', 'Select position'),
                            'data-url'     => url(['pages/get-available-positions']),
                            'data-content'      => t('app', 'The order in footer section where this contact should be display'),
                            'data-container'    => 'body',
                            'data-toggle'       => 'popover',
                            'data-trigger'      => 'hover',
                            'data-placement'    => 'top'
                        ]
                    ) ?>
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