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
 * This is the ActiveQuery class for [[Order]].
 *
 * @see Order
 */
class OrderQuery extends \app\models\auto\OrderQuery
{
    /**
     * Filter orders by status paid
     *
     * @inheritdoc
     * @return Order[]|array
     */
    public function paid()
    {
        return $this->andWhere(['status' => Order::STATUS_PAID]);
    }
}
