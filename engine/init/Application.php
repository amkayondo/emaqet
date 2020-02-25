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

namespace app\init;

use app\helpers\FileSystemHelper;
use yii\helpers\Url;
use app\yii\base\Event;
use app\yii\web\Controller;

/**
 * Class Application
 * @package app\init
 */
class Application
{
    /**
     * @param $event
     */
    public static function webBeforeRequest($event)
    {
        // normalize server for HTTPS requests issues
        self::normalizeServer();

        self::fixRemoteAddress();

        /* stored site url */
        $storedSiteUrl  = $event->sender->options->get('app.settings.urls.siteUrl');

        /* current site url */
        $currentSiteUrl = Url::home(true);

        /* auto detect host change */
        $currentHash    = sha1(__FILE__);
        $storedHash     = $event->sender->options->get('app.settings.urls.currentHash', $currentHash);

        /* store the current site url */
        if (empty($storedSiteUrl) || ($currentHash != $storedHash)) {
            $event->sender->options->set('app.settings.urls.siteUrl', $currentSiteUrl);
            $event->sender->options->set('app.settings.urls.currentHash', $currentHash);
        }

        if (options()->get('app.settings.common.prettyUrl', 0) == 1) {
            app()->urlManager->showScriptName = false;
        }

        // set display language
        $event->sender->language = options()->get('app.settings.common.siteLanguage', 'en');
        // set source code language
        $event->sender->sourceLanguage = options()->get('app.settings.common.siteLanguage', 'en');

        /* check if we need to run the update */
        Event::on(Controller::className(), Controller::EVENT_BEFORE_ACTION, function ($event) {
            /* if it is the upgrade/admin controller, stop */
            if (in_array($event->sender->id, ['upgrade', 'admin'])) {
                return;
            }

            /* if already at latest version, stop */
            $version = options()->get('app.data.version', '1.0');
            if (version_compare($version, APP_VERSION, '>=')) {
                return;
            }

            /* redirect to the update controller */
            $event->handled = true;
            return $event->sender->redirect(['/admin/upgrade/index']);
        });

        // extensions parser
        $extensions = FileSystemHelper::getDirectoryNames(\Yii::getAlias('@app/extensions'));
        foreach ($extensions as $extension){
            $className = 'app\extensions\\' . $extension . '\\' . ucfirst(strtolower($extension));
            if (class_exists($className)) {
                $instance = new $className();
                if (options()->get('app.extensions.' . $extension . '.status', 'disabled') === 'enabled') {
                    /* if already at latest version, stop */
                    $extensionVersion = options()->get('app.extensions.' . $extension . '.version', '1.0');
                    if (version_compare($instance->version, $extensionVersion, '>')) {
                        continue;
                    }
                    $type = $instance->run();
                }
            }
        }
    }

    public static function consoleBeforeRequest($event)
    {
        // set language
        $event->sender->language = options()->get('app.settings.common.siteLanguage', 'en');
        $event->sender->sourceLanguage = options()->get('app.settings.common.siteLanguage', 'en');

        // extensions parser
        $extensions = FileSystemHelper::getDirectoryNames(\Yii::getAlias('@app/extensions'));
        foreach ($extensions as $extension) {
            $className = 'app\extensions\\' . $extension . '\\' . ucfirst(strtolower($extension));
            if (class_exists($className)) {
                $instance = new $className();
                if (options()->get('app.extensions.' . $extension . '.status', 'disabled') === 'enabled') {
                    $type = $instance->run();
                }
            }
        }

        // set rules for url management for CMD
        app()->urlManager->scriptUrl = $event->sender->options->get('app.settings.urls.siteUrl');
        app()->urlManager->showScriptName = true;
        app()->urlManager->enableStrictParsing = false;
    }


    protected static function normalizeServer()
    {
        // normalize https request for some special cases like cloud flare
        if (!empty($_SERVER['HTTP_CF_VISITOR'])) {
            $props = json_decode($_SERVER['HTTP_CF_VISITOR']);

            if(!empty($props->scheme) && $props->scheme == 'https') {
                $_SERVER['HTTPS'] = 'on';
                $_SERVER['REQUEST_SCHEME'] = 'https';
            }
        }
    }

    public static function fixRemoteAddress()
    {
        static $hasRan = false;
        if ($hasRan) {
            return;
        }
        $hasRan = true;

        // keep a reference
        $_SERVER['ORIGINAL_REMOTE_ADDR'] = $_SERVER['REMOTE_ADDR'];

        $keys = array(
            'HTTP_CF_CONNECTING_IP', 'HTTP_CLIENT_IP', 'HTTP_X_REAL_IP', 'HTTP_X_FORWARDED_FOR',
            'HTTP_X_FORWARDED', 'HTTP_X_CLUSTER_CLIENT_IP', 'HTTP_FORWARDED_FOR', 'HTTP_FORWARDED'
        );

        foreach ($keys as $key) {
            if (empty($_SERVER[$key])) {
                continue;
            }
            $ips = explode(',', $_SERVER[$key]);
            $ips = array_map('trim', $ips);
            foreach ($ips as $ip) {
                if (filter_var($ip, FILTER_VALIDATE_IP)) {
                    return $_SERVER['REMOTE_ADDR'] = $ip;
                }
            }
        }
    }

}