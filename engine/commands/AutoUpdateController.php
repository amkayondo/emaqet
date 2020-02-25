<?php

/**
 *
 * @package    EasyAds
 * @author     CodinBit <contact@codinbit.com>
 * @link       https://store.codinbit.com
 * @copyright  2017 EasyAds (https://store.codinbit.com)
 * @license    https://www.codinbit.com
 * @since      1.6
 */

namespace app\commands;

use app\helpers\CommonHelper;
use app\models\options\Common;
use app\models\options\License;
use app\models\User;
use yii\console\Controller;
use yii\console\ExitCode;
use twisted1919\helpers\FileHelper;

/**
 * Class AutoUpdateController
 * @package app\commands
 */
class AutoUpdateController extends Controller
{
    /**
     * @var array
     */
    protected $stdoutMessages = [];

    /**
     * @var bool
     */
    protected $canNotify = false;


    /**
     * The command entry point
     */
    public function actionIndex()
    {
        $this->stdout('Starting the Auto Update Process for the application!' . PHP_EOL);

        $this->stdout('Acquiring the mutex lock...' . PHP_EOL);

        $result   = ExitCode::OK;
        $mutexKey = sha1(__METHOD__);

        if (!app()->mutex->acquire($mutexKey, 5)) {
            $this->stdout('Unable to acquire the mutex lock!' . PHP_EOL);
            return $result;
        }

        try {

            $result = $this->process();

            if ($this->canNotify) {
                $this->sendNotifications();
            }

        } catch (\Exception $e) {

            log_error($e->getMessage());

            $result = ExitCode::UNSPECIFIED_ERROR;
        }

        $this->stdout('Release the mutex lock...' . PHP_EOL);
        app()->mutex->release($mutexKey);

        return $result;
    }

    /**
     * @return int
     * @throws \yii\base\ErrorException
     */
    protected function process()
    {
        $this->stdout('Checking the system for all functions and binaries...' . PHP_EOL);
        foreach (['exec'] as $func) {
            if (!CommonHelper::functionExists($func)) {
                $this->stdout('Following function is required but is disabled in the PHP config: ' . $func . PHP_EOL);
                return ExitCode::UNSPECIFIED_ERROR;
            }
        }

        foreach (['curl', 'unzip', 'cp'] as $bin) {
            $command  = sprintf('if command -v %s >/dev/null; then echo 1; else echo 0; fi', $bin);
            $lastLine = exec($command, $output, $status);
            if ((int)$status !== 0 || (int)$lastLine !== 1) {
                $this->stdout('Following binary is required but was not found: ' . $bin . PHP_EOL);
                return ExitCode::UNSPECIFIED_ERROR;
            }
        }
        unset($output);
        $this->stdout('All functions and binaries are in place, we can continue...' . PHP_EOL);

        $this->stdout('Fetching latest version number...' . PHP_EOL);
        $headers = '"-H Accept: application/json" -H "Content-Type: application/json"';
        $url     = 'https://api.codinbit.com/v1/products/1';
        $command = sprintf('curl -s %s %s', $headers, $url);
        exec($command, $output, $status);
        if ((int)$status !== 0 || empty($output)) {
            $this->stdout('Cannot use curl to fetch version information from the api!' . PHP_EOL);
            return ExitCode::UNSPECIFIED_ERROR;
        }
        $json = array_shift($output);
        unset($output);

        $data = json_decode($json);
        if (empty($data->published_version)) {
            $this->stdout('Cannot decode latest version info...' . PHP_EOL);
            return ExitCode::UNSPECIFIED_ERROR;
        }

        $commonSettings = new Common();
        $licenseKey    = (new License())->purchaseCode;
        $dbVersion     = options()->get('app.data.version', '1.0');
        $latestVersion = $data->published_version;

        if (!version_compare($latestVersion, $dbVersion, '>')) {
            $this->stdout('Already at the latest version, nothing to do.' . PHP_EOL);
            return ExitCode::OK;
        }

        /* put a flag for latest version number */
        define('APP_AUTOUPDATE_VERSION', $latestVersion);

        /* from this point onwards we can notify */
        $this->canNotify = true;

        $storage = get_alias('@app/runtime/auto-update');
        if (!file_exists($storage) && !mkdir($storage, 0777)) {
            $this->stdout('Cannot create the storage dir: ' . $storage . PHP_EOL);
            return ExitCode::UNSPECIFIED_ERROR;
        }

        $updateFile = $storage . '/easyads-' . $latestVersion . '.zip';
        if (is_file($updateFile)) {
            $this->stdout('Unlinking existing update file...' . PHP_EOL);
            unlink($updateFile);
        }

        if (is_file($updateFile)) {
            $this->stdout('Unable to unlink existing update file!' . PHP_EOL);
            return 1;
        }

        $updateFolder = $storage . '/easyads-' . $latestVersion;
        if (file_exists($updateFolder) && is_dir($updateFolder)) {
            FileHelper::removeDirectory($updateFolder);
        }

        /* try to backup the app before downloading a huge update. */
        $this->tryToBackup();

        $this->stdout('Fetching the file signature...' . PHP_EOL);
        $headers = '"-H Accept: application/json" -H "Content-Type: application/json"';
        $url     = 'https://api.codinbit.com/v1/download/easyads/' . $latestVersion . '/signature';
        $command = sprintf('curl -s %s %s', $headers, $url);
        exec($command, $output, $status);
        if ((int)$status !== 0 || empty($output)) {
            $this->stdout('Cannot use curl to fetch version signature from the api!' . PHP_EOL);
            return ExitCode::UNSPECIFIED_ERROR;
        }
        $json = array_shift($output);
        unset($output);

        $data = json_decode($json);
        if (empty($data->signature)) {
            $this->stdout('Cannot decode latest version signature...' . PHP_EOL);
            return ExitCode::UNSPECIFIED_ERROR;
        }
        $updateSignature = $data->signature;
        if (strlen($updateSignature) !== 40) {
            $this->stdout('The latest version signature seems to be invalid!' . PHP_EOL);
            return ExitCode::UNSPECIFIED_ERROR;
        }
        $this->stdout('The file signature is ' . $updateSignature . PHP_EOL);
        $this->stdout('Downloading the update file, this might take a while...' . PHP_EOL);

        /* close the database connection */
        db()->close();

        $headers  = ' -H "Accept: application/zip" -H "Content-Type: application/zip"';
        $headers .= sprintf(' -H "X-LICENSEKEY: %s"', $licenseKey);
        $url      = 'https://api.codinbit.com/v1/download/easyads/' . $latestVersion;

        $command  = sprintf('curl -s -o %s %s %s', $updateFile, $headers, $url);
        exec($command, $output, $status);

        if ((int)$status !== 0) {
            $this->stdout('Cannot use curl to fetch the update version!' . PHP_EOL);
            return ExitCode::UNSPECIFIED_ERROR;
        }

        if (!is_file($updateFile)) {
            $this->stdout('Unable to download the update file!' . PHP_EOL);
            return ExitCode::UNSPECIFIED_ERROR;
        }

        $this->stdout('Download complete, checking the signature...' . PHP_EOL);
        if (sha1_file($updateFile) !== $updateSignature) {
            unlink($updateFile);
            $this->stdout('The signature does not match!' . PHP_EOL);
            return ExitCode::UNSPECIFIED_ERROR;
        }

        $this->stdout('Server response is correct, unzipping the file...' . PHP_EOL);
        $command  = 'unzip -o %s -d %s >/dev/null';
        $command  = sprintf($command, $updateFile, $storage . '/');
        exec($command, $output, $status);

        if ((int)$status !== 0) {
            $this->stdout('Unable to unzip the archive!' . PHP_EOL);
            return ExitCode::UNSPECIFIED_ERROR;
        }

        /* put the app offline now */
        $this->setAppOnline(false);

        $this->stdout('The archive has been unzipped successfully, trying to copy the files over...' . PHP_EOL);
        $command  = 'cp -Rf %s %s >/dev/null';
        $command  = sprintf($command, $updateFolder . '/update/*', get_alias('@webroot') . '/');
        exec($command, $output, $status);

        if ((int)$status !== 0) {
            $this->stdout('Unable to copy the files in the right location!' . PHP_EOL);
            return ExitCode::UNSPECIFIED_ERROR;
        }
        $this->stdout('The files where copied successfully!' . PHP_EOL);

        $this->stdout('Starting the update process...' . PHP_EOL);
        $updateSuccess = ($this->runUpdateCommand() === 0);
        if (!$updateSuccess) {
            $this->stdout('The update process has failed!' . PHP_EOL);
        } else {
            $this->stdout('The update process finished successfully!' . PHP_EOL);
        }

        $this->stdout('Removing the existing update files...' . PHP_EOL);
        if (is_file($updateFile)) {
            unlink($updateFile);
        }

        $this->stdout('Removing the existing update folder...' . PHP_EOL);
        if (file_exists($updateFolder) && is_dir($updateFolder)) {
            FileHelper::removeDirectory($updateFolder);
        }

        /* put the app online/offline depending on the update result */
        $this->setAppOnline($updateSuccess);

        $this->stdout('Done!' . PHP_EOL);

        return ExitCode::OK;
    }

    /**
     * @return bool
     */
    protected function tryToBackup()
    {
        $this->stdout('Trying to backup the app before the update...' . PHP_EOL);
        if ((options()->get('app.extensions.backupManager.status', 'disabled')) == 'disabled') {
            $this->stdout('The backup manager extension is missing or is disabled, no backup can be made!' . PHP_EOL);
            return false;
        }

        $this->stdout('Starting the backup process...' . PHP_EOL);

        app()->getModule('admin')->backup->create();

        $this->stdout('Finished the backup process' . PHP_EOL);

        return ExitCode::OK;
    }

    /**
     * @return int
     */
    public function runUpdateCommand()
    {
        try {
            $run = (int)app()->runAction('upgrade/index', ['interactive' => 0]);
        } catch (\Exception $e) {
            log_error($e->getMessage());
            $run = ExitCode::UNSPECIFIED_ERROR;
        }

        return $run;
    }

    /**
     * @param bool $online
     */
    public function setAppOnline($online = true)
    {
        /* @var \common\models\settings\Common */
        $commonSettings = new Common();

        if ($online) {
            $commonSettings->siteStatus = 1;
        } else {
            $commonSettings->siteStatus = 0;

        }

        $commonSettings->save();
    }

    /**
     * @return void
     */
    public function sendNotifications()
    {
        $users = User::findAll([
            'status' => 'active',
            'group_id' => 1,
        ]);

        foreach ($users as $user) {
            app()->mailSystem->add('mass-message', [
                'sender_first_name'     => options()->get('app.settings.common.siteName', 'EasyAds'),
                'sender_last_name'      => 'System',
                'sender_full_name'      => options()->get('app.settings.common.siteName', 'EasyAds') . ' System',
                'sender_email'          => options()->get('app.settings.common.siteEmail', ''),
                'receiver_first_name'   => $user->first_name,
                'receiver_last_name'    => $user->last_name,
                'receiver_full_name'    => $user->first_name . ' ' . $user->last_name,
                'receiver_email'        => $user->email,
                'message'               => implode('<br /><br />',$this->stdoutMessages),
            ]);

        }
    }

    /**
     * @inheritdoc
     */
    public function stdout($message)
    {
        $this->stdoutMessages[] = sprintf('[%s] - %s', app()->formatter->asDatetime(time()), $message);
        return parent::stdout($message);
    }
}
