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

namespace app\commands;

use yii\console\Controller;
use app\models\Order;
use app\models\Invoice;

/**
 * This command generate invoices for orders with status 'paid'
 *
 * Class GenerateInvoicesController
 * @package app\commands
 */
class GenerateInvoicesController extends Controller
{
    /**
     * This command generate invoices for orders with status 'paid'
     * that haven't generated before
     */
    public function actionIndex()
    {
        $orders = Order::find()->paid()->joinWith([
            'invoice' => function (\yii\db\ActiveQuery $query) {
                $query->andWhere(['invoice_id' => null]);
            }
        ], false)->all();

        foreach ($orders as $order) {
            $invoice = new Invoice();
            $invoice->order_id = $order->order_id;

            if ($invoice->save(false)) {
                // needs to be with consoleRunner to be in parallel on high volume
                app()->consoleRunner->run('send-invoice/index', [$invoice->invoice_id]);
            }
        }
    }

}
