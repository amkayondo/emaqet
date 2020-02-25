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

namespace app\commands;

use app\models\Listing;
use yii\console\Controller;
use yii\db\Expression;

/**
 * This command updates ads
 *
 * Class UpdateAdsController
 * @package app\commands
 */
class UpdateAdsController extends Controller
{
    public function actionIndex()
    {
        // update ads with auto renewal
        $autoRenewalAds = Listing::find()
            ->joinWith(['package'])
            ->where(['>', 'remaining_auto_renewal', 0])
            ->andWhere(['<=', 'DATE(listing_expire_at)', new Expression('CURDATE()')])
            ->andWhere(['status' => Listing::STATUS_ACTIVE])
            ->each(50);
        foreach ($autoRenewalAds as $ad) {
            $ad->updateCounters(['remaining_auto_renewal' => -1]);
            if ($ad->package) {
                $ad->listing_expire_at = new Expression('NOW() + INTERVAL ' . $ad->package->listing_days . ' DAY');
            }
            $ad->save(false);
        }

        // update status of ads expired
        $expiredAds = Listing::find()
            ->where(['=', 'remaining_auto_renewal', 0])
            ->andWhere(['<', 'DATE(listing_expire_at)', new Expression('CURDATE()')])
            ->andWhere(['status' => Listing::STATUS_ACTIVE])
            ->each(50);
        foreach ($expiredAds as $ad) {
            $ad->status = Listing::STATUS_EXPIRED;
            $ad->save(false);
        }
    }
}
