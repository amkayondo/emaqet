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

namespace app\yii\base;

use yii\base\Event as BaseEvent;

/**
* Class Event
* @package app\yii\base
*/
class Event extends BaseEvent
{
    public $params = [];
}