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

use app\helpers\CommonHelper;
use app\models\Listing;
use app\models\ListingImage;
use app\models\options\Common;
use yii\console\Controller;
use \app\yii\base\Event;
use yii\console\Exception;
use yii\console\ExitCode;
use yii\db\Expression;

/**
 * This command is for day cron
 *
 * Class DayController
 * @package app\commands
 */
class DayController extends Controller
{
    public function actionIndex()
    {
        $mutexKey = __METHOD__;

        // make sure we only allow a single access from now onwards /
        if (!app()->mutex->acquire($mutexKey)) {
            return ExitCode::UNSPECIFIED_ERROR;
        }

        app()->trigger('console.command.day.start', new Event([
            'params' => [
                'controller' => $this
            ]
        ]));

        $this->removeTempImages();

        $this->verifyLicense();

        app()->runAction('update-ads/index');

        $this->notificationExpiredAd();

        app()->trigger('console.command.day.end', new Event([
            'params' => [
                'controller' => $this
            ]
        ]));

        $this->runAutoUpdate();

        // release the mutex /
        app()->mutex->release($mutexKey);
        return ExitCode::OK;

    }

    protected function removeTempImages()
    {
        // remove temporary images
        $temporaryImages = ListingImage::find()
            ->where(['listing_id' => null])
            ->andWhere(['<=', 'DATE(created_at)', new Expression('CURDATE()') ])
            ->each(50);

        foreach ($temporaryImages as $image) {
            $image->delete();
        }
    }

    /**
     * @return $this
     */
    protected function verifyLicense()
    {
        try {
            //reset
            options()->set('app.settings.common.siteStatus', 1);
            options()->set('app.settings.license.message', '');

            $request = CommonHelper::verifyLicense();

            if ($request["status"] == "error" || empty($request["message"])) {
                return $this;
            }

            $request = json_decode($request['message'], true);
            if (empty($request) || empty($request['status'])) {
                return $this;
            }

            if ($request["status"] == "success") {
                return $this;
            }

            options()->set('app.settings.common.siteStatus', 0);
            options()->set('app.settings.license.message', $request['message']);
        } catch (Exception $e) {

        }

        return $this;
    }

    protected function notificationExpiredAd()
    {

        $expiredDays = options()->get('app.settings.common.expiredDays',0);
        $dailyNotificationCondition = new Expression('DATE(CURDATE() + INTERVAL '. $expiredDays .' DAY)');

        $dailyNotificationOperator = '=';
        if (options()->get('app.settings.common.dailyNotification', 0) == 1){
            $dailyNotificationOperator = '<=';
        }
        if ($expiredDays != 0) {

            $expiredListings = Listing::find()
                ->select('listing_id')
                ->where(['>=', 'DATE(listing_expire_at)', new Expression ('DATE(CURDATE())')])
                ->andWhere([$dailyNotificationOperator, 'DATE(listing_expire_at)', $dailyNotificationCondition])
                ->each(50);
            foreach ($expiredListings as $ads) {
                app()->mailSystem->add('ad-will-expire', ['listing_id' => $ads]);
            }
        }
    }

    /**
     * @return $this
     */
    public function runAutoUpdate()
    {
        $commonSettings = new Common();
        if (!$commonSettings->getIsSiteActive() || !$commonSettings->getIsAutoUpdateEnabled()) {
            return $this;
        }

        try {
            app()->runAction('auto-update/index');
        } catch (\Exception $e) {
            log_error($e->getMessage());
        }

        return $this;
    }
}
