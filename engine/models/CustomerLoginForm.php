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

use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use \app\yii\base\Event;

/**
 * LoginForm is the model behind the login form.
 *
 * @property customer|null $customer This property is read-only.
 *
 */
class CustomerLoginForm extends Model
{
    /**
     * @var string
     */
    public $email = '';

    /**
     * @var string
     */
    public $password = '';

    /**
     * @var bool
     */
    public $rememberMe = true;

    /**
     * @var bool
     */
    private $_customer = false;

    /**
     * @var string
     */
    public $reCaptcha = '';


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        $rules =  [
            // email and password are both required
            [['email', 'password'], 'required'],
            // rememberMe must be a boolean value
            ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];

        if ($captchaSecretKey = options()->get('app.settings.common.captchaSecretKey', '')) {
            $rules[] = [
                ['reCaptcha'],
                \himiklab\yii2\recaptcha\ReCaptchaValidator::className(),
                'secret' => $captchaSecretKey
            ];
        }


        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'rememberMe' => t('app', 'Remember me'),
        ]);
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $customer = $this->getCustomer();

            if (!$customer || !$customer->validatePassword($this->password)) {
                $this->addError($attribute, t('app', 'Incorrect email or password.'));
            }
        }
    }

    /**
     * Logs in a customer using the provided customer and password.
     * @return boolean whether the customer is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {

            $confirmationEmailOptions = options()->get('app.settings.common.confirmationEmail', 0);
            $customer = $this->getCustomer();

            if ($customer->status === Customer::STATUS_DEACTIVATED) {
                notify()->addWarning(t('app', 'Your account was deactivated, for more details please contact us.'));
                return false;
            }

            if ($customer->status === Customer::STATUS_INACTIVE) {

                if ($confirmationEmailOptions != 0) {

                    if ($customer->getActivationKeyStatus($customer->activation_date) && $customer->activation_key != null) {

                        $customer->pendingAccountActivation();
                        notify()->addWarning(t('app', 'Your activation key has expired. We just sent you now a new activation email.'));

                        return false;

                    } else {
                        notify()->addWarning(t('app','Your account is inactive. Please activate your account using the activation link from email.'));
                        return false;
                    }
                } else {

                    notify()->addWarning(t('app','Your account is inactive, please contact us for more details.'));
                    return false;
                }

            }

            return app()->customer->login($customer, $this->rememberMe ? 3600 * 24 * 30 : 0);
        }

        $event = new Event();
        $event->params = [
            'customerLoginForm' => $this,
        ];
        app()->trigger('app.models.customerLoginForm.loginFailed', $event);

        return false;
    }

    /**
     * Finds customer by [[email]]
     *
     * @return customer|null
     */
    public function getCustomer()
    {
        if ($this->_customer === false) {
            $this->_customer = Customer::findByEmail($this->email);
        }

        return $this->_customer;
    }
}
