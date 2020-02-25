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

namespace app\models\options;

use app\models\Customer;
use app\models\CustomerStore;

/**
 * Class Common
 * @package app\models\options
 */
class Listings extends Base
{
    /**
     * @var string
     */
    public $relatedAds = 'yes';

    /**
     * @var int
     */
    public $homePromotedNumber = 8;

    /**
     * @var int
     */
    public $homeNewNumber = 8;

    /**
     * @var int
     */
    public $adminApprovalAds = 0;

    /**
     * @var int
     */
    public $adHideZip = 0;

    /**
     * @var int
     */
    public $disableMap = 0;

    /**
     * @var int
     */
    public $freeAdsLimit = 9999;
    /**
     * @var int
     */
    public $adsImagesLimit = 4;

    /**
     * @var int
     */
    public $imgMaxSize = 0;

    /**
     * @var string
     */
    public $expiredDays = 0;

    /**
     * @var string
     */
    public $dailyNotification = 0;

    /**
     * @var int
     */
    public $skipPackages = 0;

    /**
     * @var int
     */
    public $defaultPackage = 0;

    /**
     * @var int
     */
    public $disableStore = 0;

    /**
     * @var string
     */
    protected $categoryName = 'app.settings.common';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[
                'adminApprovalAds',
                'relatedAds',
                'homePromotedNumber',
                'homeNewNumber',
                'adHideZip',
                'disableMap',
                'skipPackages',
                'defaultPackage',
                'expiredDays',
                'dailyNotification',
                'disableStore',
            ], 'safe'],
            [['adsImagesLimit'], 'required'],
            [['disableMap', 'skipPackages', 'freeAdsLimit', 'adsImagesLimit', 'expiredDays', 'dailyNotification'], 'integer'],
            [['imgMaxSize'], 'integer', 'min' => 0],
            [['defaultPackage'], 'integer', 'min' => 1, 'tooSmall' => t('app', 'Please select a default package!'),
                'when' => function ($model) {return $model->skipPackages == 1;}
                ],
            [['homePromotedNumber' , 'homeNewNumber'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'relatedAds'                    => t('app', 'Show Related Ads'),
            'homePromotedNumber'            => t('app', 'Nr. Promoted ads homepage'),
            'homeNewNumber'                 => t('app', 'Nr. New ads homepage'),
            'adminApprovalAds'              => t('app', 'Admin should approve ads'),
            'adHideZip'                     => t('app', 'Hide ZIP field'),
            'disableMap'                    => t('app', 'Hide Google Maps'),
            'freeAdsLimit'                  => t('app', 'Free ads limit'),
            'adsImagesLimit'                => t('app', 'Ad Images limit'),
            'imgMaxSize'                    => t('app', 'Max. image size allowed in kb'),
            'expiredDays'                   => t('app', 'Nr. days for daily notifications'),
            'dailyNotification'             => t('app', 'Send daily notification'),
            'skipPackages'                  => t('app', 'Skip Packages'),
            'defaultPackage'                => t('app', 'Default free package'),
            'disableStore'                  => t('app' ,'Disable Stores'),
        ];
    }


    /**
     * @return bool
     */
    public function afterValidate()
    {
        parent::afterValidate();

        if ($this->disableStore == 1) {

            $stores = CustomerStore::findAll(['status' => CustomerStore::STATUS_ACTIVE]);
            foreach ($stores as $store) {
                $store->deactivate();
            }

            $customers = Customer::findAll(['group_id' => 2]);
            foreach ($customers as $customer) {
                $customer->setGroupId(1);
            }
        }
    }

}