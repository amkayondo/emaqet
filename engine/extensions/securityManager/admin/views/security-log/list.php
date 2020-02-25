<?php

/**
 *
 * @package    EasyAds
 * @author     CodinBit <contact@codinbit.com>
 * @link       https://store.codinbit.com
 * @copyright  2017 EasyAds (https://store.codinbit.com)
 * @license    https://www.codinbit.com
 * @since      1.3
 */

    use yii\helpers\Html;
    use yii\grid\GridView;
    use yii\widgets\Pjax;
    use app\extensions\securityManager\models\SecurityLog;
    use yii\bootstrap\Modal;
    use yii\bootstrap\ActiveForm;
    use yii\web\JsExpression;
?>
<div class="box box-primary security-log-index">

    <div class="box-header">
        <div class="pull-left">
            <h3 class="box-title"><?php echo html_encode(view_param('pageHeading'));?></h3>
        </div>
        <div class="pull-right">
            <?php $refresh = (SecurityLog::LOG_TYPE_ADMIN_FAILED_LOGIN == $logType) ? 'admin-attempts' : 'customer-attempts'; ?>
            <?= Html::a(Html::tag('i', '', ['class' => 'fa fa-refresh fa-fw']) . t('app', 'Refresh'), [$refresh], ['class' => 'btn btn-xs btn-success']) ?>
            <?= Html::a(Html::tag('i', '', ['class' => 'fa fa-trash fa-fw']) . t('app', 'Clear logs'), ['clear', 'logType' => $logType], [
                'class'          => 'btn btn-xs btn-danger',
                'data'           => [
                    'confirm' => t('app', 'Are you sure you want to delete all logs?'),
                ],
                'data-content'   => t('app', 'This action will delete all the logs permanently'),
                'data-container' => 'body',
                'data-toggle'    => 'popover',
                'data-trigger'   => 'hover',
                'data-placement' => 'top',
            ]) ?>
        </div>
    </div>

    <div class="box-body">
        <?php Pjax::begin(); ?>
        <?= GridView::widget([
            'options'      => ['class' => 'table-responsive grid-view'],
            'dataProvider' => $dataProvider,
            'filterModel'  => $searchModel,
            'columns'      => [
                'ip_address',
                'username',
                'password',
                'country',
                'city',
                [
                    'attribute' => 'created_at',
                    'filter'    => yii\jui\DatePicker::widget([
                        'model'      => $searchModel,
                        'attribute'  => 'created_at',
                        'options'    => [
                            'class' => 'form-control',
                        ],
                        'dateFormat' => 'yyyy-MM-dd',
                    ]),
                ],
                [
                    'class'    => 'yii\grid\ActionColumn',
                    'template' => '{view} {block}',
                    'buttons'  => [
                        'block' => function ($url, $model, $key) {
                            return Html::a('<i class="fa fa-ban"></i>', '#', [
                                'class'       => 'block-action',
                                'title'       => t('app', 'Block IP'),
                                'data-toggle' => 'modal',
                                'data-target' => '#block-ip-modal',
                                'data-pjax'   => '0',
                                'data-ip'     => $model->ip_address,

                            ]);
                        },
                    ],
                ],
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>
<?php Modal::begin([
    'id'           => 'block-ip-modal',
    'header'       => '<h4 class="modal-title">' . t('app', 'Block IP') . '</h4>',
    'clientEvents' => [
        'hidden.bs.modal' => new JsExpression('function(){
            $("#form-block-access").trigger("reset")
        }'),
    ],
]); ?>
<?php $form = ActiveForm::begin([
    'id'                     => 'form-block-access',
    'action'                 => ['/admin/security-blocked-access/block-access'],
    'enableClientValidation' => false,
    'enableAjaxValidation'   => true,
    'validationUrl'          => ['/admin/security-blocked-access/validate-block-access'],
    'validateOnChange'       => false,
    'validateOnBlur'         => false,
]); ?>

<div class="row">
    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
        <?= $form->field($blockedAccessModel, 'ip_address', ['errorOptions' => ['class' => 'help-block', 'encode' => false]])->textInput(['readonly' => true]) ?>
    </div>
    <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
        <?= $form->field($blockedAccessModel, 'expiredPeriod')->textInput([
            'data-content'   => t('app', 'Count of days through which block expires'),
            'data-container' => 'body',
            'data-toggle'    => 'popover',
            'data-trigger'   => 'hover',
            'data-placement' => 'top',
        ]) ?>
    </div>
</div>

<div class="modal-footer">
    <?= Html::submitButton(t('app', 'Block Access'), [
        'class' => 'btn btn-success',
        'data'  => [
            'confirm' => t('app', 'Are you sure you want to block access for that ip?'),
        ],
    ]) ?>
    <?= Html::a(t('app', 'Close'), '#', ['class' => 'btn btn-primary', 'data-dismiss' => 'modal']) ?>
</div>
<?php ActiveForm::end(); ?>
<?php Modal::end(); ?>

<?php $this->registerJs('
$(".block-action").on("click", function(e) {
    var data = $(this).data();
    $("#securityblockedaccess-ip_address").val(data.ip);
});
$("#form-block-access").on("beforeSubmit", function(e) {
    var form = $(this);
    // return false if form still have some validation errors
    if (form.find(".has-error").length) {
      return false;
    }
    var formData = form.serialize();
    
    var notifyContainer = notify.getOption("container");
    notify.remove();
    notify.setOption("container", ".notify-wrapper");
    
    $.ajax({
        url: form.attr("action"),
        type: form.attr("method"),
        data: formData,
        success: function (data) {
            if (data.isSuccess) {
                form.trigger("reset");
                $("#block-ip-modal").modal("hide");
                notify.addSuccess(data.message);
            } else {
                notify.addError(data.message);
            }
            
            notify.show();
            notify.setOption("container", notifyContainer);
        },
        error: function () {
            notify.addError("' . t("app", "Something went wrong") . '");
            notify.show();
            notify.setOption("container", notifyContainer);
        }
    });
}).on("submit", function(e){
    e.preventDefault();
});
') ?>
