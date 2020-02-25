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

use yii\helpers\ArrayHelper;

/**
 * Class ListingPackage
 * @package app\common\models
 */
class ListingPackage extends \app\models\auto\ListingPackage
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'price', 'listing_days'], 'required'],
            [['title', 'price', 'listing_days', 'promo_days', 'auto_renewal'], 'trim'],
            [['title'], 'unique', 'targetAttribute' => 'title'],
            [['price', 'listing_days', 'promo_days', 'auto_renewal'], 'integer'],
            [['promo_label_text'],'default', 'value'=> 'Promoted'],
            [['promo_label_text_color'],'default', 'value'=> 'rgba(255,255,255,1)'],
            [['promo_label_background_color'],'default', 'value'=> 'rgba(26,188,156,.95)'],
            [['price', 'promo_days', 'auto_renewal'],'default', 'value'=> 0],
            [['listing_days'],'default', 'value'=> 0],
            [['promo_sign','recommended_sign'], 'in', 'range' => array_keys(self::getYesNoValidationList())],
            [['title'], 'string', 'max' => 20],
            [['promo_label_background_color', 'promo_label_text_color', 'promo_label_text'], 'string', 'max' => 25]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return ArrayHelper::merge(parent::attributeLabels(), [
            'title'                         => t('app', 'Package title'),
            'price'                         => t('app', 'Package Price'),
            'listing_days'                  => t('app', 'Days ad expires'),
            'promo_days'                    => t('app', 'Days promo feature expires'),
            'promo_sign'                    => t('app', 'Ad Promo label'),
            'promo_label_background_color'  => t('app', 'Promo Label Background Color'),
            'promo_label_text_color'        => t('app', 'Promo Label Text Color'),
            'promo_label_text'              => t('app', 'Promo Label Text'),
            'recommended_sign'              => t('app', 'Package Recommended label'),
            'auto_renewal'                  => t('app', 'Auto renew'),
            'created_at'                    => t('app', 'Created At')
        ]);
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        // don't allow to change price of default free package
        if(options()->get('app.settings.common.defaultPackage',0) == $this->package_id && $this->price > 0) {
            options()->set('app.settings.common.skipPackages',0);
            options()->set('app.settings.common.defaultPackage',0);
            notify()->addError(t('app', 'Skip package option is disabled now because you modified price of default free package'));
        }


        return true;
    }

    /**
     * @return bool
     */
    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }

        if(options()->get('app.settings.common.defaultPackage',0) == $this->package_id) {
            options()->set('app.settings.common.skipPackages',0);
            options()->set('app.settings.common.defaultPackage',0);
            notify()->addError(t('app', 'Skip package option is disabled now because you removed default free package'));
        }

        return true;
    }

    /**
     * @return auto\ListingPackage[]|array
     */
    public static function getAllPackages()
    {
        return self::find()->all();
    }
}