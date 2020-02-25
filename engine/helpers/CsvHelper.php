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

namespace app\helpers;

/**
 * Class CsvHelper
 * @package app\helpers
 */
class CsvHelper
{
    /**
     * @param $downloadFileName
     * @param $exportData
     * @return $this|void
     * @throws \yii\base\Exception
     * @throws \yii\web\RangeNotSatisfiableHttpException
     */
    public static function exportCsv($downloadFileName, $exportData)
    {
        $delimiter = ',';

        $fileName = security()->generateRandomString(8) . '.csv';
        $fileName = get_alias('@app/runtime/' . $fileName);

        if (!($fp = @fopen($fileName, 'w'))) {
            return;
        }

        fputcsv($fp, array_keys($exportData[0]), $delimiter);

        foreach ($exportData as $array) {
            fputcsv($fp, $array, $delimiter);
        }

        fclose($fp);

        // Make sure we remove the created file
        app()->on(\yii\web\Application::EVENT_AFTER_REQUEST, function() use ($fileName) {
            if (is_file($fileName)) {
                unlink($fileName);
            }
        });

        return response()->sendStreamAsFile(fopen($fileName, 'r'), $downloadFileName);
    }

}