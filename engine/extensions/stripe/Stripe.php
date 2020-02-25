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

namespace app\extensions\stripe;

use app\models\Order;
use Omnipay\Omnipay;

/**
 * Class Stripe
 * @package app\extensions\stripe
 */
class Stripe extends \app\init\Extension
{

    public $name = 'Stripe';

    public $author = 'CodinBit Development Team';

    public $version = '2.3';

    public $description = 'Stripe payment gateway for promo packages';

    public $type = 'payments';

    public function run()
    {
        // register controller
        app()->on('app.modules.admin.init', function($event) {
            $event->params['module']->controllerMap['stripe'] = [
                'class' => 'app\extensions\stripe\admin\controllers\StripeController'
            ];
        });

        app()->on('app.controller.ad.init', function(){
            if(options()->get('app.gateway.stripe.status', 'inactive') != 'active'){
                return;
            }

            app()->on('app.ad.gateways.option', function($event){
                echo app()->view->renderFile('@app/extensions/stripe/views/gateway-frontend-option.php',[
                    'description' => options()->get('app.gateway.stripe.description', ''),
                ]);
            });

            app()->on('app.ad.gateways.form', function($event){
                echo app()->view->renderFile('@app/extensions/stripe/views/gateway-frontend-form.php');
            });

            app()->on('app.controller.ad.package.handlePayment',['app\extensions\stripe\Stripe', 'handlePayment']);
        });

    }

    /**
     * @param $event
     * @throws \Exception
     */
    public static function handlePayment($event){
        if('stripe' != request()->post('paymentGateway')){
            return;
        }

        $cartTotal = $event->params['cartTotal'];

        if(empty($cartTotal)){
            return;
        }

        $stripeToken = request()->post('stripeToken');

        $price = round($cartTotal,2);
        $currency = options()->get('app.settings.common.siteCurrency', 'usd');

        // Create a gateway for the Stripe Gateway
        $gateway = Omnipay::create('Stripe');
        $mode = (options()->get('app.gateway.stripe.mode', 'sandbox') == 'sandbox') ? true : false;

        // Initialise the gateway
        $gateway->initialize(array(
            'apiKey'        => options()->get('app.gateway.stripe.secretKey', ''),
            'testMode'              => $mode,
        ));

        // Do a purchase transaction on the gateway
        $transaction = $gateway->purchase([
            'amount'              => $price,
            'currency'            => $currency,
            'token'               => $stripeToken,
            'description'         => 'Purchase Package',
        ]);

        $response = $transaction->send();
        $gatewayResponse = $response->getRequest()->getResponse()->getData();

        $transactionReference = '';
        $error = false;

        if ($response->isSuccessful()) {
           $transactionReference = $response->getTransactionReference();
        } else {
            $error = true;
            if(isset($gatewayResponse['error'], $gatewayResponse['error']['message'])) {
                throw new \Exception($gatewayResponse['error']['message']);
            } else {
                throw new \Exception(t('app','Something went wrong, please try again later.'));
            }
        }

        if($error == true){
            return;
        }

        $orderTransaction = $event->params['transaction'];
        $order = $event->params['order'];

        //update order status
        $order->status = Order::STATUS_PAID;
        $order->save(false);

        //update order transaction data
        $orderTransaction->gateway                  = 'Stripe';
        $orderTransaction->type                     = 'purchase';
        $orderTransaction->transaction_reference    = $transactionReference;
        $orderTransaction->gateway_response         = json_encode($gatewayResponse);
        $orderTransaction->save(false);
        return;
    }

    /**
     * @inheritdoc
     */
    public function getPageUrl()
    {
        return url(['/admin/stripe']);
    }

}