<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin(); ?>
<div class="box box-primary">
    <div class="box-header">
        <div class="pull-left">
            <h3 class="box-title"><?= t('app', 'Admin Theme Settings');?></h3>
        </div>
    </div>
    <div class="box-body">
        <div class="social-settings-form">
            <div class="row">
                <div class="col-lg-4">
                    <?= $form->field($model, 'adminSkin')->dropDownList($model->getSkinsList());?>
                </div>
                <div class="col-lg-4">
                    <?= $form->field($model, 'adminLayout')->dropDownList($model->getLayoutsList());?>
                </div>
                <div class="col-lg-4">
                    <?= $form->field($model, 'adminSidebar')->dropDownList($model->getSidebarsList());?>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="box box-primary">
    <div class="box-header">
        <div class="pull-left">
            <h3 class="box-title"><?= t('app', 'Site Theme Settings');?></h3>
        </div>
    </div>
    <div class="box-body">
        <div class="social-settings-form">
            <div class="row">
                <div class="col-lg-6">
                    <?php $logo = \Yii::getAlias('@web') . options()->get('app.settings.theme.siteLogo', \Yii::getAlias('/assets/site/img/logo.png'));?>
                    <?= $form->field($model, 'siteLogoUpload')->widget(\kartik\file\FileInput::classname(), [
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
                            'defaultPreviewContent'=> '<img src="'.$logo.'" alt="Your Avatar" style="width:100px">',
                            'layoutTemplates'=> ['main2'=> '{preview} {remove} {browse}'],
                            'allowedFileExtensions' => ['png','jpg','jpeg'],
                        ]
                    ])->label();
                    ?>
                </div>
            </div>
            <div class="callout callout-warning">
                <h4><i class="icon fa fa-warning"></i> Warning!</h4>
                <p>Important: Please be careful what code you include below, this could affect application's security!</p>
            </div>
            <div class="row">
                <div class="col-lg-6">
                    <?= $form->field($model, 'customCss')->textarea([
                        'class'             => 'form-control',
                        'rows'              => 10,
                        'cols'              => 50,
                        'data-content'      => t('app', 'Custom CSS for your website'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ])->label() ?>
                    <p>
                        <?= t('app', 'Note: The above code should be wrapped within &ltstyle&gt tag!'); ?>
                    </p>
                </div>
                <div class="col-lg-6">
                    <?= $form->field($model, 'customJs')->textarea([
                        'class'             => 'form-control',
                        'rows'              => 10,
                        'cols'              => 50,
                        'data-content'      => t('app', 'Custom JS for your site'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ])->label() ?>
                    <p>
                        <?= t('app', 'Note: The above code should be wrapped within &ltscript&gt tag!'); ?>
                    </p>
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