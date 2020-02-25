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

namespace app\components\mail\template;

use app\models\Customer;

class TemplateTypeCustomer implements TemplateTypeInterface
{
    const TEMPLATE_TYPE = 4;

    /**
     * @var array list of variables of template
     */
    protected $varsList = [
        'customer_first_name' => 'Customer First Name',
        'customer_email'      => 'Customer Email',
        'confirmation_url'    => 'Confirmation url',
        'login_url'           => 'Login url',
        'activation_url'      => 'Activation url',
    ];

    protected $customerEmail;

    public function __construct(array $data)
    {
        if (!empty($data)) {
            $this->customerEmail = $data['customer_email'];
        }
    }

    public function populate()
    {
        /**
         * @var Customer $customerModel
         */
        $customerModel      = Customer::findByEmail($this->customerEmail);
        $this->recipient    = $customerModel->email;
        $confirmationUrl    = url(['account/reset_password', 'key' => $customerModel->password_reset_key], true);
        $activationUrl      = options()->get('app.settings.urls.siteUrl', '') . '/account/activation_email?key=' . $customerModel->activation_key;
        $loginUrl           = options()->get('app.settings.urls.siteUrl', '') . '/account/login';

        return [
            'customer_first_name' => $customerModel->first_name,
            'customer_email'      => $customerModel->email,
            'confirmation_url'    => $confirmationUrl,
            'login_url'           => $loginUrl,
            'activation_url'      => $activationUrl,
        ];
    }

    public function getRecipient()
    {
        return $this->recipient;
    }

    /**
     * @return array
     */
    public function getVarsList()
    {
        return $this->varsList;
    }
}