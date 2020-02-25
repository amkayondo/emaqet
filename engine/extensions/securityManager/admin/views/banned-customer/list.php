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
    use app\extensions\securityManager\models\SecurityReason;
    use yii\helpers\ArrayHelper;
    use kartik\select2\Select2;
    use yii\web\JsExpression;
?>
<div class="box box-primary security-banned-customers-index">
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
            'id'                     => 'form-ban-customer',
            'enableClientValidation' => false,
            'enableAjaxValidation'   => true,
            'action'                 => ['/admin/security-banned-customer/ban-customer'],
            'validationUrl'          => ['/admin/security-banned-customer/validate-ban-customer'],
            'validateOnChange'       => false,
            'validateOnBlur'         => false,
        ]); ?>
        <div class="box-body">
            <div class="row">
                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                    <?= $form->field($model, 'customer_email')->widget(Select2::classname(), [
                        'options'       => ['placeholder' => t('app', 'Select Customer')],
                        'pluginOptions' => [
                            'language'           => [
                                'inputTooShort' => new JsExpression('function () { return "' . t('app', 'Please enter more characters...') . '" }'),
                            ],
                            'allowClear'         => true,
                            'minimumInputLength' => 3,
                            'ajax'               => [
                                'url'      => url(['/admin/security-banned-customer/customer'], true),
                                'dataType' => 'json',
                                'data'     => new JsExpression('function(params) { return {term:params.term}; }'),
                                'delay'    => 250,
                            ],
                            'theme'              => Select2::THEME_DEFAULT,
                        ],
                    ])->label(false); ?>
                </div>
                <div class="col-lg-6 col-md-12 col-sm-12 col-xs-12">
                    <?= $form->field($model, 'ban_reason')->dropDownList(ArrayHelper::map(SecurityReason::getReasonsList(SecurityReason::REASON_TYPE_BAN), 'description', 'description'), ['prompt' => t('app', 'Select Reason')])->label(false); ?>
                </div>
            </div>
        </div>

        <div class="box-footer">
            <div class="pull-right">
                <?= Html::submitButton(t('app', 'Ban Customer'), [
                    'class' => 'btn btn-success',
                    'data'  => [
                        'confirm' => t('app', 'IMPORTANT: Banning this user will deactivate his account permanently and set all his listings to deactivated, are you sure you want to do that?'),
                    ],
                ]) ?>
            </div>
            <div class="clearfix"><!-- --></div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>

<div class="box box-primary security-banned-customers-index">
    <div class="box-header">
        <div class="pull-left">
            <h3 class="box-title"><?= html_encode(t('app', 'Banned Customers')) ?></h3>
        </div>
    </div>

    <div class="box-body">
        <?php Pjax::begin([
            'id' => 'banned-customers-grid-container',
        ]); ?>
        <?= GridView::widget([
            'options'      => ['class' => 'table-responsive grid-view'],
            'dataProvider' => $dataProvider,
            'filterModel'  => $searchModel,
            'columns'      => [
                'customer_email',
                'ban_reason',
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
$("#form-ban-customer").on("beforeSubmit", function(e) {
    var form = $(this);
    // return false if form still have some validation errors
    if (form.find(".has-error").length) {
      return false;
    }
    var formData = form.serialize();
    
    $.ajax({
        url: form.attr("action"),
        type: form.attr("method"),
        data: formData,
        success: function (data) {
            if (data.isSuccess) {
                form.trigger("reset");
                $.pjax.reload({container: "#banned-customers-grid-container", timeout: false});
                notify.addSuccess(data.message);
            } else {
                notify.addError(data.message);
            }
        },
        error: function () {
            notify.addError("' . t("app", "Something went wrong") . '");
        }
    });
}).on("submit", function(e){
    e.preventDefault();
});
') ?>