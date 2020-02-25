<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin(); ?>
<div class="box box-primary">
    <div class="box-header">
        <div class="pull-left">
            <h3 class="box-title"><?= html_encode(view_param('pageHeading')) ?></h3>
        </div>
    </div>
    <div class="box-body">
        <div class="invoice-settings-form">
            <div class="row">
                <div class="col-lg-4">
                    <?= $form->field($model, 'disableInvoices')->dropDownList([1 => t('app','Yes'), 0 => t('app','No') ],[
                        'data-content'      => t('app', 'If it\'s set to yes then invoices section will be hidden'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3">
                    <?= $form->field($model,'businessName')->textInput([
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
                <div class="col-lg-3">
                    <?= $form->field($model,'vatId')->textInput([
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
                <div class="col-lg-3">
                    <?= $form->field($model,'companyNumber')->textInput([
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
                <div class="col-lg-3">
                    <?= $form->field($model, 'prefix')->textInput([
                        'maxlength' => true,
                        'data-content'      => t('app', 'Prefix to be used in all PDF invoices'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <?= $form->field($model,'companyAddress')->textInput([
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
                <div class="col-lg-3">
                    <?= $form->field($model,'phoneNumber')->textInput([
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
                <div class="col-lg-3">
                    <?= $form->field($model,'email')->textInput([
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <?php $logo = \Yii::getAlias('@web') . options()->get('app.settings.invoice.logo', \Yii::getAlias('/assets/site/img/logo.png'));?>
                    <?= $form->field($model, 'logoUpload')->widget(\kartik\file\FileInput::classname(), [
                        'options' => [
                            'class'=>'image-upload',
                            'data-image'=>$logo,
                        ],
                        'pluginOptions' => [
                            'language' => options()->get('app.settings.common.siteLanguage', 'en'),
                            'overwriteInitial'=> true,
                            'showClose'=> false,
                            'showRemove' => false,
                            'showCaption'=> false,
                            'showBrowse'=> true,
                            'browseOnZoneClick'=> true,
                            'removeLabel'=> '',
                            'removeIcon'=> '<i class="glyphicon glyphicon-remove"></i>',
                            'removeTitle'=> 'Cancel or reset changes',
                            'elErrorContainer'=> '.image-upload-error',
                            'msgErrorClass'=> 'alert alert-block alert-danger',
                            'defaultPreviewContent'=> '<img src="'.$logo.'" alt="Your logo" style="width:100px">',
                            'layoutTemplates'=> ['main2'=> '{preview} {remove} {browse}'],
                            'allowedFileExtensions' => ['png','jpg','jpeg'],
                        ]
                    ])->label();
                    ?>
                </div>
                <div class="col-lg-6">
                    <?= $form->field($model, 'notes')->textArea([
                        'rows' => '7',
                        'data-content'      => t('app', 'Notes to be displayed at the end of PDF invoice'),
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
            <?= Html::submitButton(t('app', 'Save Changes'), ['class' => 'btn btn-primary']) ?>
        </div>
        <div class="clearfix"><!-- --></div>
    </div>
</div>
<?php ActiveForm::end(); ?>