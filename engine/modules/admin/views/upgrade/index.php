<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use twisted1919\helpers\Icon;

app\assets\AdminAsset::register($this);
?>
<?php $form = ActiveForm::begin([
    'enableClientValidation' => false,
]); ?>
    <div class="box box-default">
        <div class="box-header with-border">
            <h3 class="box-title"><?= html_encode($this->params['pageHeading']);?></h3>
        </div>
        <div class="box-body">
            <div class="callout callout-warning">
                <?php echo t('app', 'Your current application version is {version}', array('version' => '<span class="badge">'.$version.'</span>'));?><br />
                <?php echo t('app', 'The upgrade process will try to upgrade it to version {version}', array('version' => '<span class="badge">'.APP_VERSION.'</span>'));?><br />
                <?php echo t('app', 'Please backup all your data before proceeding and note that the upgrade process might take a while depending on your database size, just wait for it to finish.');?><br />
            </div>

            <?php
                // added the warning about changing minimum accepted PHP to 5.6
                if (version_compare($version,'1.4','=')){
            ?>
            <div class="callout callout-danger">
                <h4><i class="icon fa fa-warning"></i> <?= t('app', 'EXTREMELY IMPORTANT NOTE!');?></h4>
                <?php echo t('app', 'Starting with version {version} EasyAds requires PHP version 5.6 or higher', array('version' => '<span class="badge">'.APP_VERSION.'</span>'));?><br />
                <?php echo t('app', 'Please DO NOT upgrade unless you have the PHP version 5.6 or higher on your server FIRST!');?><br />
            </div>
            <?php } ?>

            <?php if ($migration->error) { ?>
                <div class="callout callout-danger">
                    <h4><?= t('app', 'The upgrade failed with following errors:');?></h4><br />
                    <?= $migration->error;?>
                    <hr />
                    <h4><?= t('app', 'Here is a transcript of the process:');?></h4><br />
                    <?= $migration->output;?>
                </div>
            <?php } ?>

        </div>
        <div class="box-footer">
            <div class="pull-right">
                <button type="submit" class="btn btn-primary btn-sm btn-flat btn-click-spin"><?= Icon::make('fa-arrow-circle-o-up') . ' ' . t('app', 'Start the upgrade process');?></button>
            </div>
        </div>
    </div>
<?php ActiveForm::end(); ?>