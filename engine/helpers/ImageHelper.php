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

use Yii;
use app\yii\base\Event;
use yii\imagine\BaseImage;

/**
 * Class ImageHelper
 * @package app\helpers
 */
class ImageHelper extends BaseImage
{
    public static function resize($imagePath, $width = null, $height = null, $keepAspectRatio = true, $allowUpscaling = false, array $options = [])
    {
        static $_cache = [];

        $key = sha1(serialize(func_get_args()));
        if (array_key_exists($key, $_cache)) {
            return $_cache[$key];
        }

        $width  = (int)$width;
        $height = (int)$height;

        if(empty($width) && empty($height)) {
            return $_cache[$key] = null;
        }

        $mode = \Imagine\Image\ManipulatorInterface::THUMBNAIL_OUTBOUND;
        $defaults = [
            'mode'    => \Imagine\Image\ManipulatorInterface::THUMBNAIL_OUTBOUND,
            'quality' =>  90,
        ];

        $options = array_merge($defaults, $options);
        if (isset($options['mode'])) {
            $mode = $options['mode'];
            unset($options['mode']);
        }

        $imagePath   = '/' . ltrim($imagePath, '/');
        $targetPath  = Yii::getAlias('@webroot' . $imagePath);


        //event to set the prefix for the name of ad images
        $event = new \app\yii\base\Event();
        $event->params = [
            'watermarkPrefix' => null,
        ];
        app()->trigger('app.extensions.admin.watermarkPrefix', $event);

        $prefix = $event->params['watermarkPrefix'];

        if (!is_file($targetPath) || !($imageInfo = getimagesize($targetPath))) {
            return $_cache[$key] = null;
        }

        list($originalWidth, $originalHeight) = $imageInfo;
        if(empty($width)) {
            $width = floor($originalWidth * $height / $originalHeight);
        } elseif(empty($height)) {
            $height = floor($originalHeight * $width / $originalWidth);
        }

        $relativePath    = '/uploads/images/listings/' . (int)$width . 'x' . (int)$height;
        $basePath        = Yii::getAlias('@webroot' . $relativePath);

        $imageName = preg_replace('/\s+/', '', basename($imagePath));

        $destinationPath = $basePath . '/' . $prefix  . $imageName;
        if (is_file($destinationPath)) {
            return $_cache[$key] = Yii::getAlias('@web' . $relativePath . '/' . $prefix . $imageName);
        }

        if (!file_exists($basePath)) {
            if (!@mkdir($basePath, 0777, true)) {
                return $_cache[$key] = null;
            }
        }

        //delete the old resized images
        $oldImageName = basename($imagePath);
        $oldImagePath = glob("$basePath/*$oldImageName");
        if ($oldImagePath) {
            foreach ($oldImagePath as $file) {
                if (file_exists($file)) {
                    unlink($file);
                }
            }
        }

        $resized    = self::thumbnail($targetPath, $width, $height, $mode)->save($destinationPath, ['quality' => $options['quality']]);
        $metaData   = $resized->metadata()->toArray();

        if (!$resized) {
            return $_cache[$key] = null;
        }

        //event to apply the watermark on ad images
        app()->trigger('app.extensions.admin.watermarkImage' , new Event(['params' => [
            'basePath'  => $basePath,
            'imageName' => $imageName
        ]]));

        $_cache[$key] = Yii::getAlias('@web' . $relativePath . '/' . $prefix . $imageName);
        $_cache[$key] = static::imageFixOrientation($_cache[$key], $metaData);

        return $_cache[$key];
    }

    /**
     * @param $fileName
     * @param $metaData
     * @return mixed
     */
    public static function imageFixOrientation($fileName, $metaData) {
        if (empty($metaData)) {
            return $fileName;
        }

        if (!empty($metaData['ifd0.Orientation'])) {
            // create the resource for imagerotate
            $ImageResource = imagecreatefromjpeg(\Yii::getAlias('@webroot' . $fileName));

            $image = null;
            // hard code solution rotate for EXIF problem
            // https://stackoverflow.com/questions/7489742/php-read-exif-data-and-adjust-orientation/13963783#13963783
            switch ($metaData['ifd0.Orientation']) {
                case 3:
                    $image = imagerotate($ImageResource, 180, 0);
                    break;
                case 6:
                    $image = imagerotate($ImageResource, -90, 0);
                    break;
                case 8:
                    $image = imagerotate($ImageResource, 90, 0);
                    break;
            }

            // overwrite the image with the new rotated image
            if ($image) {
                imagejpeg($image, Yii::getAlias('@webroot' . $fileName));
            }
        }

        // return the new rotated image
        return $fileName;
    }
}
