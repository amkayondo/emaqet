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

namespace app\models\options;

/**
 * Class Common
 * @package app\models\options
 */
class Common extends Base
{
    /**
     * @var string
     */
    public $siteName = 'EasyAds';

    /**
     * @var string
     */
    public $siteEmail = 'contact@easyads.io';

    /**
     * @var
     */
    public $siteCurrency = 'USD';

    /**
     * @var
     */
    public $siteLanguage = 'en';

    /**
     * @var string
     */
    public $siteTimezone = 'UTC';

    /**
     * @var string
     */
    public $siteTitle = 'Home Page - {siteName}';

    /**
     * @var string
     */
    public $siteKeywords = 'Ads, Classified ads, sell, buy, trade, market';

    /**
     * @var string
     */
    public $siteDescription = 'EasyAds Classified Ads application';

    /**
     * @var int
     */
    public $siteStatus = 1;

    /**
     * @var string
     */
    public $siteOfflineMessage = 'Application is offline, please try again later!';

    /**
     * @var
     */
    public $googleAnalyticsCode;

    /**
     * @var string
     */
    public $siteFacebookId = '';

    /**
     * @var string
     */
    public $siteFacebookSecret = '';

    /**
     * @var string
     */
    public $siteGoogleMapsKey = '';

    /**
     * @var string
     */
    public $footerFirstPageSectionTitle = 'Help';

    /**
     * @var string
     */
    public $footerSecondPageSectionTitle = 'About';

    /**
     * @var int
     */
    public $prettyUrl = 0;

    /**
     * @var string
     */
    public $captchaSiteKey = '';

    /**
     * @var string
     */
    public $captchaSecretKey = '';

    /**
     * @var string
     */
    public $siteGoogleId = '';

    /**
     * @var string
     */
    public $siteGoogleSecret = '';

    /**
     * @var string
     */
    public $siteLinkedInId = '';

    /**
     * @var string
     */
    public $siteLinkedInSecret = '';

    /**
     * @var string
     */
    public $siteTwitterId = '';

    /**
     * @var string
     */
    public $siteTwitterSecret = '';

    /**
     * @var string
     */
    public $termsAndConditionsPage = 0;

    /**
     * @var int
     */
    public $confirmationEmail = 0;

    /**
     * @var int
     */
    public $expireActivationKey = 30;

    /**
     * @var int
     */
    public $allowedAge = 18;

    /**
     * @var int
     */
    public $cookieConsentStatus = 1;

    /**
     * @var string
     */
    public $siteCopyright = '&copy; EasyAds Application';

    /**
     * @var int
     */
    public $autoUpdate = 0;

    /**
     * @var string
     */
    public $joinTitle = 'Join - {siteName}';

    /**
     * @var string
     */
    public $joinKeywords = 'Ads, Classified ads, sell, buy, trade, market';

    /**
     * @var string
     */
    public $joinDescription = 'Join now';

    /**
     * @var string
     */
    public $loginTitle = 'Login - {siteName}';

    /**
     * @var string
     */
    public $loginKeywords = 'Ads, Classified ads, sell, buy, trade, market';

    /**
     * @var string
     */
    public $loginDescription = 'Login now';

    /**
     * @var string
     */
    public $forgotPasswordTitle = 'Forgot Password - {siteName}';

    /**
     * @var string
     */
    public $forgotPasswordKeywords = 'Ads, Classified ads, sell, buy, trade, market';

    /**
     * @var string
     */
    public $forgotPasswordDescription = 'Forgot Password, reset it now!';

    /**
     * @var string
     */
    public $postTitle = 'Post Ad - {siteName}';

    /**
     * @var string
     */
    public $postKeywords = 'Ads, Classified ads, sell, buy, trade, market';

    /**
     * @var string
     */
    public $postDescription = 'Post an Ad listing now';

    /**
     * @var int
     */
    public $guestContactSellers = 1;

    /**
     * @var string
     */
    protected $categoryName = 'app.settings.common';

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[
                'siteTitle',
                'siteKeywords',
                'siteDescription',
                'joinTitle',
                'joinKeywords',
                'joinDescription',
                'loginTitle',
                'loginKeywords',
                'loginDescription',
                'forgotPasswordTitle',
                'forgotPasswordKeywords',
                'forgotPasswordDescription',
                'postTitle',
                'postKeywords',
                'postDescription',
                'siteStatus',
                'siteOfflineMessage',
                'siteFacebookId',
                'siteFacebookSecret',
                'siteGoogleMapsKey',
                'prettyUrl',
                'captchaSiteKey',
                'captchaSecretKey',
                'siteGoogleId',
                'siteGoogleSecret',
                'siteLinkedInId',
                'siteLinkedInSecret',
                'siteTwitterId',
                'siteTwitterSecret',
                'termsAndConditionsPage',
                'confirmationEmail',
                'allowedAge',
                'siteCopyright',
                'autoUpdate',
                'guestContactSellers',
            ], 'safe'],
            [['siteLanguage', 'siteCurrency', 'siteTimezone', 'siteName','siteEmail', 'footerFirstPageSectionTitle', 'footerSecondPageSectionTitle'], 'required'],

            [['siteName','siteOfflineMessage', 'googleAnalyticsCode'], 'string', 'max' => 255],
            [['siteEmail'], 'string', 'max' => 100],
            [['expireActivationKey'], 'integer'],
            [['allowedAge'], 'integer', 'min' => 0],
            [['footerFirstPageSectionTitle', 'footerSecondPageSectionTitle'], 'string', 'max' => 25],
            [['cookieConsentStatus'], 'in', 'range' => array_keys($this->getCookieConsentStatusList())]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'siteName'                      => t('app', 'Application name'),
            'siteEmail'                     => t('app', 'Application Email'),
            'siteCurrency'                  => t('app', 'Application Currency'),
            'siteLanguage'                  => t('app', 'Application Language'),
            'siteTimezone'                  => t('app', 'Application Timezone'),
            'siteFacebookId'                => t('app', 'Facebook app id'),
            'siteFacebookSecret'            => t('app', 'Facebook app secret'),
            'siteGoogleId'                  => t('app', 'Google app id'),
            'siteGoogleSecret'              => t('app', 'Google app secret'),
            'siteLinkedInId'                => t('app', 'LinkedIn app id'),
            'siteLinkedInSecret'            => t('app', 'LinkedIn app secret'),
            'siteTwitterId'                 => t('app', 'Twitter app id'),
            'siteTwitterSecret'             => t('app', 'Twitter app secret'),
            'siteGoogleMapsKey'             => t('app', 'Google maps API key'),
            'footerFirstPageSectionTitle'   => t('app', 'First Section Title'),
            'footerSecondPageSectionTitle'  => t('app', 'Second Section Title'),
            'googleAnalyticsCode'           => t('app', 'Google Analytics code'),
            'captchaSiteKey'                => t('app', 'reCAPTCHA Site key'),
            'captchaSecretKey'              => t('app', 'reCAPTCHA Secret key'),
            'siteTitle'                     => t('app', 'Home title'),
            'siteKeywords'                  => t('app', 'Home keywords'),
            'siteDescription'               => t('app', 'Home description'),
            'joinTitle'                     => t('app', 'Join page title'),
            'joinKeywords'                  => t('app', 'Join page keywords'),
            'joinDescription'               => t('app', 'Join page description'),
            'loginTitle'                    => t('app', 'Login page title'),
            'loginKeywords'                 => t('app', 'Login page keywords'),
            'loginDescription'              => t('app', 'Login page description'),
            'forgotPasswordTitle'           => t('app', 'Forgot password page title'),
            'forgotPasswordKeywords'        => t('app', 'Forgot password page keywords'),
            'forgotPasswordDescription'     => t('app', 'Forgot password page description'),
            'postTitle'                     => t('app', 'Post page title'),
            'postKeywords'                  => t('app', 'Post page keywords'),
            'postDescription'               => t('app', 'Post page description'),
            'siteStatus'                    => t('app', 'Site status'),
            'siteOfflineMessage'            => t('app', 'Site offline message'),
            'prettyUrl'                     => t('app', 'Pretty URL'),
            'confirmationEmail'             => t('app', 'Account activation by email'),
            'expireActivationKey'           => t('app', 'Days before activation key expires'),
            'allowedAge'                    => t('app', 'Minimum allowed age'),
            'cookieConsentStatus'           => t('app', 'Cookie consent'),
            'autoUpdate'                    => t('app', 'Application Auto Update'),
            'guestContactSellers'           => t('app', 'Allow Guests to contact Sellers')
        ];
    }

    /**
     * @return array
     */
    public function getCookieConsentStatusList()
    {
        return [
            0   => t('app', 'Disabled'),
            1   => t('app', 'Enabled'),
        ];
    }

    /**
     * @return bool
     */
    public function getShowCookieConsent()
    {
        return (int)$this->cookieConsentStatus === 1;
    }

    /**
     * @return bool
     */
    public function getIsSiteActive()
    {
        return (int)$this->siteStatus === 1;
    }

    /**
     * @return bool
     */
    public function getIsAutoUpdateEnabled()
    {
        return (int)$this->autoUpdate === 1;
    }


}