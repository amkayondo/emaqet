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

namespace app\extensions\securityManager;

use app\extensions\securityManager\components\mail\template\TemplateTypeSecurity;
use app\extensions\securityManager\models\SecurityInappropriateReport;
use app\extensions\securityManager\models\SecurityLog;
use yii\helpers\ArrayHelper;
use Yii;

/**
 * Class Securitylogs
 * @package app\extensions\securityManager
 */
class Securitymanager extends \app\init\Extension
{

    public $name = 'Security Manager';

    public $author = 'CodinBit Development Team';

    public $version = '1.1';

    public $description = 'Managing security of application';

    public $type = 'tools';

    public function run()
    {
        // add rule for frontend url manager
        app()->urlManager->addRules(['inappropriate-report' => 'security-manager/inappropriate-report']);

        // register frontend controller
        app()->controllerMap['security-manager'] = [
            'class' => 'app\extensions\securityManager\controllers\SecurityManagerController',
        ];

        // event handler that registers controllers and component
        app()->on('app.modules.admin.init', function ($event) {
            $event->params['module']->controllerMap['security-log'] = [
                'class' => 'app\extensions\securityManager\admin\controllers\SecurityLogController',
            ];

            $event->params['module']->controllerMap['security-blocked-access'] = [
                'class' => 'app\extensions\securityManager\admin\controllers\SecurityBlockedAccessController',
            ];

            $event->params['module']->controllerMap['security-reason'] = [
                'class' => 'app\extensions\securityManager\admin\controllers\SecurityReasonController',
            ];

            $event->params['module']->controllerMap['security-banned-customer'] = [
                'class' => 'app\extensions\securityManager\admin\controllers\SecurityBannedCustomerController',
            ];

            $event->params['module']->controllerMap['security-inappropriate-report'] = [
                'class' => 'app\extensions\securityManager\admin\controllers\SecurityInappropriateReportController',
            ];

            Yii::configure($event->params['module'], [
                'components' => ArrayHelper::merge($event->params['module']->components, [
                    'securityManager' => [
                        'class' => 'app\extensions\securityManager\components\SecurityManagerComponent',
                    ],
                ]),
            ]);
        });

        // event handler that adds addition block to the view of listing
        app()->on('app.controller.ad.init', function () {
            app()->on('app.ad.under.listingInfo', function ($event) {
                $ad = $event->params['ad'];
                echo app()->view->renderFile('@app/extensions/securityManager/views/inappropriate-reporting.php', [
                    'ad'    => $ad,
                    'model' => new SecurityInappropriateReport(),
                ]);
            });
        });

        // event handler that adds menu items in admin panel
        app()->on('app.admin.menu', function ($event) {
            $event->params['menu'][] = [
                'label' => 'Security Manager',
                'icon'  => 'shield',
                'url'   => '#',
                'items' => [
                    ['label' => 'Admin Failed logins', 'icon' => 'chevron-right', 'url' => ['/admin/security-log/admin-attempts']],
                    ['label' => 'Customers Failed logins', 'icon' => 'chevron-right', 'url' => ['/admin/security-log/customer-attempts']],
                    ['label' => 'Inappropriate reporting', 'icon' => 'chevron-right', 'url' => ['/admin/security-inappropriate-report']],
                    ['label' => 'Blocked IP Access', 'icon' => 'chevron-right', 'url' => ['/admin/security-blocked-access']],
                    ['label' => 'Ban Customers', 'icon' => 'chevron-right', 'url' => ['/admin/security-banned-customer']],
                    [
                        'label' => 'Settings',
                        'icon'  => 'cogs',
                        'url'   => '#',
                        'items' => [
                            ['label' => 'Ban reasons', 'icon' => 'chevron-right', 'url' => ['/admin/security-reason/ban-reasons']],
                            ['label' => 'Ads report reasons', 'icon' => 'chevron-right', 'url' => ['/admin/security-reason/inappropriate-report-reasons']],
                        ],
                    ],
                ],
            ];
        });

        // event handler that tracks failed login attempts of admin
        app()->on('app.models.userLoginForm.loginFailed', function ($event) {
            app()->getModule('admin')->securityManager->logFailedLogin($event->params['userLoginForm'], SecurityLog::LOG_TYPE_ADMIN_FAILED_LOGIN);
        });

        // event handler that tracks failed login attempts of customer
        app()->on('app.models.customerLoginForm.loginFailed', function ($event) {
            app()->getModule('admin')->securityManager->logFailedLogin($event->params['customerLoginForm'], SecurityLog::LOG_TYPE_CUSTOMER_FAILED_LOGIN);
        });

        // event handler that checks if admin is blocked by IP before provide ability to log in
        app()->on('admin.controllers.adminLogin.beforePerformAction', function ($event) {
            if (app()->getModule('admin')->securityManager->isBlocked()) {
                notify()->addError(t('app', "Your IP is blocked, as result you can't go to this page. Please contact the administrator of site."));

                app()->response->redirect(['/'])->send();
                app()->end();
            }
        });

        // event handler that checks if customer is blocked by IP before provide ability to log in
        app()->on('app.controllers.customerLogin.beforePerformAction', function ($event) {
            if (app()->getModule('admin')->securityManager->isBlocked()) {
                notify()->addError(t('app', "Your IP is blocked, as result you can't go to this page. Please contact the administrator of site."));

                app()->response->redirect(['/'])->send();
                app()->end();
            }
        });

        // templates gathering by mail template component
        app()->on('app.components.mailTemplate.templatesGathering', function ($event) {
            $event->params['templateTypes'][TemplateTypeSecurity::TEMPLATE_TYPE] = 'app\extensions\securityManager\components\mail\template\TemplateTypeSecurity';
        });

        // labels of templates gathering by mail template component
        app()->on('app.components.mailTemplate.templatesLabelsGathering', function ($event) {
            $event->params['templateTypesLabel'][TemplateTypeSecurity::TEMPLATE_TYPE] = t('app', 'Security');
        });

        // event handler that listens to cron job that executes every day
        app()->on('console.command.day.end', function ($event) {
            app()->getModule('admin')->securityManager->deactivateExpiredBlocks();
        });
    }
}