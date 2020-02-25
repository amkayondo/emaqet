<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin(); ?>
<div class="box box-primary adBanners-head-scripts">
    <div class="box-header with-border">
        <h3 class="box-title"><?=t('app', htmlspecialchars('<head> scripts for online advertisers networks'));?></h3>
    </div>
    <div class="box-body">

        <div class="groups-form">
            <div class="row">
                <div class="col-lg-12">
                    <div class="alert alert-block alert-warning">
                        <ul>
                            <li><?=t('app','Important: Please be careful what scripts you include in the head area of the application!');?></li>
                        </ul>
                    </div>
                    <br />
                    <?= $form->field($model, 'headScripts')->textarea([
                        'class'             => 'form-control',
                        'rows'              => 5,
                        'cols'              => 50,
                        'data-content'      => t('app', 'Paste head/verification script code e.g. Google AdSense head code'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ])->label(false) ?>
                    <p>
                        <?= t('app', 'Note: The above textarea supports multiple advertising networks like Google Adsense, Amazon associates .. etc.'); ?>
                        <br />
                        <?= t('app', 'For multiple networks just paste the head/verification code one after another in the textarea.'); ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="box box-primary adBanners">

    <div class="box-header with-border">
        <h3 class="box-title"><?=t('app', 'AdBanners Locations');?></h3>
    </div>

    <div class="box-body">
        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
            <?php
            $i = 0;
            foreach ($properties as $property) { ?>
                <?php if($i==0){ ?>
            <div class="row mb20">
                <?php } ?>
                <div class="col-lg-6">
                    <label><?=html_encode($property['label']);?></label><br />
                    <?= Html::textarea($model->formName() . '[locations][' . $property['optionKey'] . ']', options()->get('app.extensions.adBanners.' . $property['optionKey'], ''), [
                        'class'             => 'form-control',
                        'rows'              => 7,
                        'cols'              => 50,
                        'data-content'      => t('app', 'Paste advertising script code like Google AdSense, partner banner via HTML code or Any HTML code.'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]);
                    ?>
                    <p>
                        <?=html_encode($property['help']);?>
                    </p>
                </div>
                <?php if($i==1){ ?>
            </div>
                <?php } ?>
            <?php
                $i++;
                if($i>1) $i=0;
             }
             ?>
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