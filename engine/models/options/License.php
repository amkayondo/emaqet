<?php

/**
 *
 * @package    EasyAds
 * @author     CodinBit <contact@codinbit.com>
 * @link       https://store.codinbit.com
 * @copyright  2017 EasyAds (https://store.codinbit.com)
 * @license    https://www.codinbit.com
 * @since      1.3
 */

namespace app\models\options;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * Class License
 * @package app\models\options
 */
class License extends Base
{
    /**
     * @var
     */
    public $firstName;
    
    /**
     * @var
     */
    public $lastName;
    
    /**
     * @var
     */
    public $email;
    
    /**
     * @var
     */
    public $purchaseCode;

    /**
     * @var
     */
    public $acceptTerms;

    /**
     * @var
     */
    public $marketing;

    protected $categoryName = 'app.settings.license';

    public function rules()
    {
        return
        [
            [['marketing'], 'safe'],
            [['firstName', 'lastName', 'email', 'purchaseCode'], 'required'],
            [['acceptTerms'], 'required', 'requiredValue' => 1, 'message' => '{attribute} is required'],
            [['firstName', 'lastName', 'email', 'purchaseCode'], 'string', 'max' => 255],
            ['email', 'email'],
        ];

    }

    /**
     * @return array
     */
    public function attributeLabels()
    {
        $labels = array(
            'firstName'     => t('app', 'First name'),
            'lastName'      => t('app', 'Last name'),
            'email'         => t('app', 'Email'),
            'purchaseCode'  => t('app', 'Purchase code'),
        );

        return ArrayHelper::merge($labels, parent::attributeLabels());
    }

    /**
     * @return array
     */
    public function attributeHelpTexts()
    {
        return [
            'purchaseCode'=> t('app', 'Please supply the purchase code for license activation'),
        ];
    }
}
