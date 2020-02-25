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

namespace app\extensions\manual;

use app\models\Order;

/**
 * Class Manual
 * @package app\extensions\manual
 */
class Manual extends \app\init\Extension
{

    public $name = 'Manual Payment';

    public $author = 'CodinBit Development Team';

    public $version = '1.1';

    public $description = 'Manual payment gateway for promo packages';

    public $type = 'payments';

    public function run()
    {
        // register controller
        app()->on('app.modules.admin.init', function($event) {
            $event->params['module']->controllerMap['manual'] = [
                'class' => 'app\extensions\manual\admin\controllers\ManualController'
            ];
        });

        // event init
        app()->on('app.controller.ad.init', function(){
            if(options()->get('app.gateway.manual.status', 'inactive') != 'active'){
                return;
            }

            app()->on('app.ad.gateways.option', function($event){
                echo app()->view->renderFile('@app/extensions/manual/views/gateway-frontend-option.php',[
                    'description' => options()->get('app.gateway.manual.description', 'EasyAds'),
                ]);
            });

            app()->on('app.ad.gateways.form', function($event){
                echo app()->view->renderFile('@app/extensions/manual/views/gateway-frontend-form.php');
            });

            app()->on('app.controller.ad.package.handlePayment',['app\extensions\manual\Manual', 'handlePayment']);
        });
    }

    /**
     * @param $event
     * @throws \Exception
     */
    public static function handlePayment($event)
    {
        if('manual' != request()->post('paymentGateway')){
            return;
        }
        $cartTotal = $event->params['cartTotal'];

        if(empty($cartTotal)){
            return;
        }

        $manualData = request()->post('Manual');

        $price = round($cartTotal,2);
        $currency = options()->get('app.settings.common.siteCurrency', 'usd');

        $orderTransaction = $event->params['transaction'];
        $order = $event->params['order'];

        //update order status
        $order->status = Order::STATUS_PENDING;
        if(!$order->save(false)){
            throw new \Exception('Something went wrong, please try again later.');
            return;
        }

        //update order transaction data
        $orderTransaction->gateway                  = 'Manual Payment';
        $orderTransaction->type                     = 'purchase';
        $orderTransaction->transaction_reference    = $manualData['ref'];
        if(!$orderTransaction->save(false)){
            throw new \Exception('Something went wrong, please try again later.');
            return;
        }

        //go to paypal
        $event->params['error'] = '';
        $event->params['manual'] = true;
    }

    /**
     * @inheritdoc
     */
    public function getPageUrl()
    {
        return url(['/admin/manual']);
    }
}