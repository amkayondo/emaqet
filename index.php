<?php

// Check if EasyAds installed
define('APP_INSTALLED_DB', is_file(__DIR__ . '/engine/config/db.php'));
define('APP_INSTALLED_REQUEST', is_file(__DIR__ . '/engine/config/request.php'));


/* if the app has been installed already, redirect to install */
if (!APP_INSTALLED_DB || !APP_INSTALLED_REQUEST) {
    require(__DIR__ . '/engine/helpers/CommonHelper.php');
    $url = app\helpers\CommonHelper::getEntryScriptUrl();
    $installUrl=str_replace("index.php","install",$url);
    header('location: ' . $installUrl);
    exit;
}

require(__DIR__ . '/engine/config/constants.php');
require(__DIR__ . '/engine/vendor/autoload.php');
require(__DIR__ . '/engine/vendor/yiisoft/yii2/Yii.php');

$config = require(__DIR__ . '/engine/config/web.php');

(new yii\web\Application($config))->run();
