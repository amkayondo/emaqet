<?php

/**
 *
 * @package    EasyAds
 * @author     CodinBit <contact@codinbit.com>
 * @link       https://store.codinbit.com
 * @copyright  2017 EasyAds (https://store.codinbit.com)
 * @license    https://www.codinbit.com
 * @since      1.0
 */

namespace app\models;

/**
 * Class OrderTax
 * @package app\models
 */
class OrderTax extends \app\models\auto\OrderTax
{
    /**
     * @inheritdoc
     * @return InvoiceQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new OrderTaxQuery(get_called_class());
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getOrder()
    {
        return $this->hasOne(Order::className(), ['order_id' => 'order_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getTax()
    {
        return $this->hasOne(Tax::className(), ['tax_id' => 'tax_id']);
    }
}
