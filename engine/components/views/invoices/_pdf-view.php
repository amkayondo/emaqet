<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $invoice app\models\Invoice */
?>
<?php

    //Custom fields invoice templates.
    $businessName       = options()->get('app.settings.invoice.businessName', '');
    $vatId              = options()->get('app.settings.invoice.vatId', '');
    $companyNumber      = options()->get('app.settings.invoice.companyNumber', '');
    $companyAddress     = options()->get('app.settings.invoice.companyAddress', '');
    $phoneNumber        = options()->get('app.settings.invoice.phoneNumber', '');
    $email              = options()->get('app.settings.invoice.email', '');

?>
<div class="container">
    <div class="row">
        <?php if ($logo) { ?>
            <div class="col-xs-3">
                <img src="data:image/jpg;base64,<?= $logo ?>" />
            </div>
            <div class="col-xs-4 col-xs-offset-4">
        <?php } else { ?>
            <div class="col-xs-5 col-xs-offset-7">
        <?php } ?>
            <div class="row">
                <div class="col-xs-12">
                    <h2 class="text-uppercase text-right">
                        <strong><?=t('app','Invoice');?></strong>
                    </h2>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-5">
                    <strong class="text-uppercase"><?=t('app','reference');?>:</strong>
                </div>
                <div class="col-xs-4 text-right" style="margin-left: 10px; font-size: 12px">
                    <?= $invoice->getReference(); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-5">
                    <strong class="text-uppercase"><?=t('app','billing date');?>:</strong>
                </div>
                <div class="col-xs-4 text-right" style="margin-left: 10px; font-size: 12px">
                    <?= app()->formatter->asDate($invoice->created_at); ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-5">
                    <strong class="text-uppercase"><?=t('app','due date');?>:</strong>
                </div>
                <div class="col-xs-4 text-right" style="margin-left: 10px; font-size: 12px">
                    <?= app()->formatter->asDate($invoice->created_at); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row" style="margin-top:40px;">
        <div class="col-xs-5">
            <h4 class="text-uppercase heading">
                <strong><?=t('app','Our information');?></strong>
            </h4>
            <?php if ($businessName)     {echo $businessName . '<br>';} ?>
            <?php if ($vatId)            {echo $vatId . '<br>';} ?>
            <?php if ($companyNumber)    {echo $companyNumber . '<br>';} ?>
            <?php if ($companyAddress)   {echo $companyAddress . '<br>';} ?>
            <?php if ($phoneNumber)      {echo $phoneNumber . '<br>';} ?>
            <?php if ($email)            {echo $email . '<br>';} ?>

        </div>
        <div class="col-xs-5" style="margin-left: 51px">
            <h4 class="text-uppercase heading">
                <strong><?=t('app','Customer information');?></strong>
            </h4>
            <?php if (!empty($invoice->order->company_name)) { ?>
                <strong><?= strtoupper($invoice->order->company_name) ?></strong><br>
            <?php } ?>
            <strong><?= $invoice->order->getFullName() ?></strong><br>
            <?php if (!empty($invoice->order->company_name)) { ?>
                <?=t('app','Company No');?>: <?= $invoice->order->company_no ?><br>
                <?=t('app','VAT');?>: <?= $invoice->order->vat ?><br>
            <?php } ?>
            <?=t('app','Email');?>: <?= $invoice->order->email ?><br>
            <?= $invoice->order->city ?><br>
            <?= $invoice->order->zone->name ?><br>
            <?= $invoice->order->country->name ?>, <?= $invoice->order->zip ?>
        </div>
    </div>

    <div class="row" style="margin-top:40px;">
        <div class="col-xs-12">
            <table class="table" style="border-collapse: separate; empty-cells: hide;">
                <thead>
                <tr>
                    <th class="first"><?=t('app','Package');?></th>
                    <th><?=t('app','Quantity');?></th>
                    <th><?=t('app','Price');?></th>
                    <th><?=t('app','Total');?></th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td class="first"><?= $invoice->order->order_title ?></td>
                    <td>1</td>
                    <td><?= \app\helpers\CommonHelper::getPriceAsCurrency(options()->get('app.settings.common.siteCurrency', 'usd'), $invoice->order->subtotal);?></td>
                    <td><?= \app\helpers\CommonHelper::getPriceAsCurrency(options()->get('app.settings.common.siteCurrency', 'usd'), $invoice->order->total) ?></td>
                </tr>
                <tr class="summary">
                    <td></td>
                    <td></td>
                    <td class="text-left"><?=t('app','Subtotal');?></td>
                    <td><?= \app\helpers\CommonHelper::getPriceAsCurrency(options()->get('app.settings.common.siteCurrency', 'usd'), $invoice->order->subtotal) ?></td>
                </tr>
                <?php foreach ($invoice->order->tax as $tax) { ?>
                <tr class="summary">
                    <td></td>
                    <td></td>
                    <td class="text-left"><?=t('app','Tax');?> - <?=$tax->tax_name . ' (' . $tax->tax_percent . '%)';?></td>
                    <td><?= \app\helpers\CommonHelper::getPriceAsCurrency(options()->get('app.settings.common.siteCurrency', 'usd'), $tax->tax_price) ?></td>
                </tr>
                <?php } ?>
                <tr class="summary">
                    <td></td>
                    <td></td>
                    <td class="text-left"><?=t('app','Total');?></td>
                    <td><?= \app\helpers\CommonHelper::getPriceAsCurrency(options()->get('app.settings.common.siteCurrency', 'usd'), $invoice->order->total) ?></td>
                </tr>
                <tr class="summary">
                    <td></td>
                    <td></td>
                    <td class="text-left"><?=t('app','Total due');?></td>
                    <td><?= \app\helpers\CommonHelper::getPriceAsCurrency(options()->get('app.settings.common.siteCurrency', 'usd'), 0) ?></td>
                </tr>
                </tbody>

            </table>
            <caption><img width="200" src="data:image/jpg;base64,<?= $paidStamp ?>" style="float: left; margin: -120px 0 0 0px;" /></caption>
        </div>
    </div>

<?php if(options()->get('app.settings.invoice.notes', '')){ ?>
    <div class="row" style="margin-top:40px;">
        <div class="col-xs-12">
            <h4 class="text-uppercase heading">
                <strong><?=t('app','Information');?></strong>
            </h4>

            <div>
                <?= options()->get('app.settings.invoice.notes', '') ?>
            </div>
        </div>
    </div>
<?php } ?>
</div> <!-- /container -->