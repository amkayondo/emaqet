<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\web\JsExpression;
?>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-lg-push-2 col-md-12 col-sm-12 col-xs-12">
                <?php $form = ActiveForm::begin([
                    'method'      => 'get',
                    'fieldConfig' => ['options' => ['class' => 'input-group']],
                    'action'      => ['site/search'],
                    'options'     => [
                        'class' => 'search-form'
                    ]
                ]); ?>
                <div class="row">
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <?= $form->field($searchModel, 'searchPhrase', [
                            'template' => "{label}\n<i class='fa fa-search' aria-hidden='true'></i>\n{input}\n{hint}\n{error}"
                        ])->textInput(['placeholder' => t('app', 'Keywords...')])->label(false) ?>
                    </div>
                    <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                        <div class="input-group">
                            <?= $form->field($searchModel, 'location')->widget(Select2::classname(), [
                                'options'       => ['placeholder' => t('app', 'Location')],
                                'pluginOptions' => [
                                    'language'           => [
                                            'inputTooShort'=> new JsExpression('function () { return "'. t('app', 'Please enter more characters...') .'" }'),
                                            'noResults'=> new JsExpression('function () { return "'. t('app', 'No results found') .'" }'),
                                            'searching'=> new JsExpression('function () { return "'. t('app', 'Searching...') .'" }')
                                    ],
                                    'allowClear'         => true,
                                    'minimumInputLength' => 3,
                                    'ajax'               => [
                                        'url'      => url(['category/location'], true),
                                        'dataType' => 'json',
                                        'data'     => new JsExpression('function(params) { return {term:params.term}; }'),
                                        'delay'    => 250,
                                    ],
                                    'theme'              => Select2::THEME_DEFAULT,
                                ],
                            ])->label(false); ?>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                        <?= Html::submitButton(t('app', 'Search'), ['class' => 'btn-as']) ?>
                    </div>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    </div>