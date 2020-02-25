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

namespace app\modules\admin\components;

use app\models\Listing;
use yii\base\Widget;

/**
 * Class LatestAdsWidget
 * @package app\modules\admin\components
 */
class LatestAdsWidget extends Widget
{
    /**
     * @var string title of LatestBoxWidget
     */
    public $title;
    /**
     * @var
     */
    public $allLink;

    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();

        if ($this->allLink === null) {
            $this->allLink = '#';
        }
    }

    /**
     * @return string
     */
    public function run()
    {
        $query = Listing::find()
            ->with(['mainImage'])
            ->where(['status' => Listing::STATUS_ACTIVE])
            ->orderBy(['listing_id' => SORT_DESC])
            ->limit(8)
            ->all();

        return $this->render('latest-ads/latest-ads', [
            'data'      => $query,
            'title'     => $this->title,
            'link'      => $this->allLink,
        ]);
    }
}