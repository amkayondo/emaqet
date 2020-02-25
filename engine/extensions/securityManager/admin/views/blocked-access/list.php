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
    use yii\bootstrap\ActiveForm;
?>
<div class="box box-primary blocked-access-index">
    <div class="box-header">
        <div class="pull-left">
            <h3 class="box-title"><?php echo html_encode(view_param('pageHeading'));?></h3>
        </div>
        <div class="pull-right">
            <?= Html::a(Html::tag('i', '', ['class' => 'fa fa-refresh fa-fw']) . t('app', 'Refresh'), ['index'], ['class' => 'btn btn-xs btn-success']) ?>
        </div>
    </div>

    <div class="box-body">
        <?php $form = ActiveForm::begin([
            'action'                 => ['/admin/security-blocked-access/block-access'],
            'id'                     => 'form-block-access',
            'enableClientValidation' => false,
            'enableAjaxValidation'   => true,
            'validationUrl'          => ['/admin/security-blocked-access/validate-block-access'],
            'validateOnChange'       => false,
            'validateOnBlur'         => false,
        ]); ?>
        <div class="box-body">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                    <?= $form->field($model, 'ip_address', ['errorOptions' => ['class' => 'help-block', 'encode' => false]])->textInput([
                        'maxlength'      => true,
                        'data-content'   => t('app', 'Particular IP address(IPv4 or IPv6) or IP address with CIDR Notation(subnet mask), e.g. 192.1.1.1/24'),
                        'data-container' => 'body',
                        'data-toggle'    => 'popover',
                        'data-trigger'   => 'hover',
                        'data-placement' => 'top',
                    ]) ?>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                    <?= $form->field($model, 'expiredPeriod')->textInput([
                        'data-content'   => t('app', 'Count of days through which block expires'),
                        'data-container' => 'body',
                        'data-toggle'    => 'popover',
                        'data-trigger'   => 'hover',
                        'data-placement' => 'top',
                    ]) ?>
                </div>
            </div>
        </div>

        <div class="box-footer">
            <div class="pull-right">
                <?= Html::submitButton(t('app', 'Block Access'), [
                    'class' => 'btn btn-success',
                    'data'  => [
                        'confirm' => t('app', 'Are you sure you want to block access for that ip?'),
                    ],
                ]) ?>
            </div>
            <div class="clearfix"><!-- --></div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

<div class="box box-primary blocked-access-index">
    <div class="box-header">
        <div class="pull-left">
            <h3 class="box-title"><?= html_encode(t('app', 'List Blocked Access')) ?></h3>
        </div>
        <div class="pull-right">
            <?= Html::a(Html::tag('i', '', ['class' => 'fa fa-trash fa-fw']) . t('app', 'Clear blocks'), ['clear'], [
                'class'          => 'btn btn-xs btn-danger',
                'data'           => [
                    'confirm' => t('app', 'Are you sure you want to delete all blocked access?'),
                ],
                'data-content'   => t('app', 'This action will delete all records permanently'),
                'data-container' => 'body',
                'data-toggle'    => 'popover',
                'data-trigger'   => 'hover',
                'data-placement' => 'top',
            ]) ?>
        </div>
    </div>

    <div class="box-body">
        <?php Pjax::begin([
            'id' => 'blocked-access-grid-container',
        ]); ?>
        <?= GridView::widget([
            'options'      => ['class' => 'table-responsive grid-view'],
            'dataProvider' => $dataProvider,
            'filterModel'  => $searchModel,
            'columns'      => [
                'ip_address',
                [
                    'attribute' => 'is_active',
                    'filter'    => Html::activeDropDownList(
                        $searchModel,
                        'is_active',
                        ['0' => t('app', 'Inactive'), '1' => t('app', 'Active')],
                        ['class' => 'form-control', 'prompt' => t('app', 'All')]
                    ),
                    'value'     => function ($model) {
                        return $model->is_active ? t('app', 'Active') : t('app', 'Inactive');
                    },
                ],
                [
                    'attribute' => 'expire',
                    'filter'    => yii\jui\DatePicker::widget([
                        'model'      => $searchModel,
                        'attribute'  => 'expire',
                        'options'    => [
                            'class' => 'form-control',
                        ],
                        'dateFormat' => 'yyyy-MM-dd',
                    ]),
                ],
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
                    'template' => '{delete}',
                ],
            ],
        ]); ?>
        <?php Pjax::end(); ?>
    </div>
</div>
<?php $this->registerJs('
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
                $.pjax.reload({container: "#blocked-access-grid-container", timeout: false});
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
