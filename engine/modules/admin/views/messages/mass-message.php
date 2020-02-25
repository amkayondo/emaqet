<?php
    use yii\helpers\Html;
    use yii\widgets\ActiveForm;
    use dosamigos\ckeditor\CKEditor;
?>
<div class="callout callout-warning">
    <h4><i class="icon fa fa-warning"></i> <?= t('app', 'Warning!');?></h4>
    <p><?= t('app', 'Please be very careful when you create this mass message because it will be sent as an email to all the customers you have!'); ?></p>
</div>

<div class="box box-primary mass-message">

    <div class="box-header">
        <div class="pull-left">
            <h3 class="box-title"><?= html_encode(view_param('pageHeading')) ?></h3>
        </div>
        <div class="pull-right">
            <?= Html::a(t('app', 'Cancel'), ['index'], ['class' => 'btn btn-xs btn-success']) ?>
        </div>
    </div>
    <div class="box-body">
        <?php $form = ActiveForm::begin(); ?>
        <div class="mass-message-form">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-12">
                            <?= CKEditor::widget([
                                'name' => 'mass-message[message]',
                                'options' => ['rows' => 6],
                                'preset' => 'basic',
                            ]); ;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="box-footer">
            <div class="pull-right">
                <?= Html::submitButton(t('app', 'Send Mass Message'), ['class' => 'btn btn-primary']) ?>
            </div>
            <div class="clearfix"><!-- --></div>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
