<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
?>
<?php $form = ActiveForm::begin(); ?>
<div class="box box-primary">
    <div class="box-header">
        <div class="pull-left">
            <h3 class="box-title"><?= t('app', 'URL Synchronization') ?></h3>
        </div>
    </div>
    <div class="box-body">
        <div class="callout callout-warning">
            <h4><i class="icon fa fa-warning"></i> Warning!</h4>
            <p>The url bellow is stored to be used from command line where it cannot be automatically generated.</p>
            <p>Sync the URL if they get out of sync with the current domain.</p>
        </div>
        <div class="url-sync-form">
            <div class="row">
                <div class="col-lg-4">
                    <?= $form->field($model, 'siteUrl')->textInput([
                        'maxlength' => true,
                        'readonly' => true
                    ]) ?>
                </div>
                <div class="col-lg-2">
                    <label><?= t('app','Action') ?></label><br />
                    <?= Html::submitButton(t('app', 'Sync URL'), ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end(); ?>

<?php $formCommon = ActiveForm::begin(); ?>
<div class="box box-primary">
    <div class="box-header">
        <div class="pull-left">
            <h3 class="box-title"><?= t('app', 'Global Settings') ?></h3>
        </div>
    </div>
    <div class="box-body">
        <div class="callout callout-success">
            <p>Please set the web server configuration (see the next section) before enabling the Pretty URL feature!</p>
        </div>
        <div class="global-form">
            <div class="row">
                <div class="col-lg-4">
                    <?= $formCommon->field($commonModel, 'prettyUrl')->dropDownList([1 => t('app','Yes, enable pretty url'), 0 => t('app','No, do not use pretty url') ],[
                        'data-content'      => t('app', 'Enabling this will remove the index.php part of your urls.'),
                        'data-container'    => 'body',
                        'data-toggle'       => 'popover',
                        'data-trigger'      => 'hover',
                        'data-placement'    => 'top'
                    ]) ?>
                </div>
            </div>
        </div>
        <hr>
        <div class="block">
            <div class="block-title">
                <div class="block-options pull-right">
                    <?php echo Html::a(t('app', 'Show configurations'), ['create'], ['class' => 'btn btn-sm btn-danger', 'onclick' => "$('#server-configurations').show(); $(this).hide(); return false;"]); ?>
                </div>
                <h4 class="box-title"><?= t('app', 'Web servers configuration examples for pretty urls') ?></h4>
            </div>
            <div id="server-configurations" style="display: none">
            <div class="clearfix"><!-- --></div>
            <ul class="nav nav-tabs navbar-collapse" style="border-bottom: 0px;">
                <li class="active">
                    <a href="#tab-apache" data-toggle="tab"><?php echo t('app', 'Apache web server');?></a>
                </li>
                <li>
                    <a href="#tab-nginx" data-toggle="tab"><?php echo t('app', 'Nginx web server');?></a>
                </li>
            </ul>
            <div class="clearfix"><!-- --></div>
            <div class="tab-content">
            <div class="tab-pane active" id="tab-apache">
                <div class="alert alert-warning" style="margin-top: 5px;">
                    <?php  echo t('app', 'You should place below contents in "{path}" then enable pretty urls.', [
                        'path' => get_alias('@webroot/.htaccess'),
                    ]);  ?>
                </div>
                <div class="form-group">
                    <textarea class="form-control" rows="30"><?php echo $this->context->renderPartial('urls-apache-config', [
                            'baseUrl' => $baseUrl,
                        ]);?></textarea>
                </div>
            </div>
            <div class="tab-pane" id="tab-nginx">
                <div class="alert alert-warning" style="margin-top: 5px;">
                    <?php echo t('app', 'Below is an example server block configuration for nginx. Enable pretty urls only after you have adjusted nginx.');?>
                </div>
                <div class="form-group">
                    <textarea class="form-control" rows="30"><?php echo $this->context->renderPartial('urls-nginx-config', [
                            'baseUrl' => $baseUrl,
                            'appHost' => IS_CLI ? '' : request()->getHostName()
                        ]);?></textarea>
                </div>
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

<!-- MODAL HTACCESS -->
<div class="modal fade" id="writeHtaccessModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        </div>
    </div>
</div>