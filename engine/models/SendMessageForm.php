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

/**
 * SendMessage is the model behind the send message form.
 */
class SendMessageForm extends Model
{
    /**
     * @var string
     */
    public $email = '';

    /**
     * @var string
     */
    public $fullName = '';

    /**
     * @var string
     */
    public $message = '';

    /**
     * @var string
     */
    public $reCaptcha = '';

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        $rules = [
            [['email', 'fullName', 'message'], 'required'],
            ['email', 'email'],
            ['message', 'string', 'max' => 1000],
            [['email', 'fullName'], 'string', 'max' => 100],
            [['slug'], 'string', 'max' => 110],
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
        return [
            'email'    => t('app', 'Email'),
            'fullName' => t('app', 'Full Name'),
            'message'  => t('app', 'Message'),
        ];
    }
}
