<?php
use yii\helpers\Html;
use app\helpers\DateTimeHelper;
use app\extensions\stripe\StripeAsset;

StripeAsset::register($this);
?>
<div id="stripe-form-wrapper" data-pk="<?= options()->get('app.gateway.stripe.publishableKey', '');?>" style="display: none">
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="separator-text">
                <span><?=t('app','Card information');?></span>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6 col-lg-push-3 col-md-6 col-md-push-3 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <div id="card-element">
                            <!-- A Stripe Element will be inserted here. -->
                        </div>
                        <div id="card-errors" class="help-block help-block-error" role="alert"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>