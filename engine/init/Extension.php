<?php

/**
 *
 * @package    EasyAds
 * @author     CodinBit <contact@codinbit.com>
 * @link       https://store.codinbit.com
 * @copyright  2017 EasyAds (https://store.codinbit.com)
 * @license    https://www.codinbit.com
 * @since      1.3
 */

namespace app\init;

/**
 * Base class for each extension
 *
 * @package app\init\Extension
 */
abstract class Extension
{
    /**
     * Name of extension to display in app
     *
     * @var string
     */
    public $name = '';

    /**
     * Name of author of extension to display in app
     *
     * @var string
     */
    public $author = '';

    /**
     * Version of extension to display in app
     *
     * @var string
     */
    public $version = '';

    /**
     * Description of extension to display in app
     *
     * @var string
     */
    public $description = '';

    /**
     * Type of extension
     *
     * @var string
     */
    public $type = '';

    /**
     * The url to extension settings
     */
    public function getPageUrl()
    {
        return '';
    }

    abstract public function run();
}