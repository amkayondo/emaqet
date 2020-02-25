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

use yii\base\Model;
use yii\helpers\ArrayHelper;
use \app\yii\base\Event;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class UserLoginForm extends Model
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
     * @var string
     */
    public $reCaptcha = '';

    /**
     * @var bool
     */
    private $_user = false;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        $rules = [
            // username and password are both required
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
            'rememberMe' => t('app', 'Remember me!'),
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
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, t('app', 'Incorrect username or password.'));
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return app()->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
        }

        $event = new Event();
        $event->params = [
            'userLoginForm' => $this,
        ];
        app()->trigger('app.models.userLoginForm.loginFailed', $event);

        return false;
    }

    /**
     * Finds user by [[email]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = User::findByEmail($this->email);
        }

        return $this->_user;
    }
}
