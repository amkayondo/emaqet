<?php

/**
 *
 * @package    EasyAds
 * @author     CodinBit <contact@codinbit.com>
 * @link       https://store.codinbit.com
 * @copyright  2017 EasyAds (https://store.codinbit.com)
 * @license    https://www.codinbit.com
 * @since      1.5
 */

namespace app\models\options;

/**
 * Class Url
 * @package app\models\options
 */
class Url extends Base
{
    /**
     * @var string
     */
    public $siteUrl = '';

    /**
     * @var string
     */
    protected $categoryName = 'app.settings.urls';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'siteUrl' => t('app', 'Site URL'),
        ];
    }
}