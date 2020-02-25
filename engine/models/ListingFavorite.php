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

/**
 * Class ListingFavorite
 * @package app\models
 */
class ListingFavorite extends \app\models\auto\ListingFavorite
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['customer_id', 'listing_id'], 'required'],
            [['customer_id', 'listing_id'], 'integer'],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAd()
    {
        return $this->hasOne(Listing::className(), ['listing_id' => 'listing_id']);
    }
}