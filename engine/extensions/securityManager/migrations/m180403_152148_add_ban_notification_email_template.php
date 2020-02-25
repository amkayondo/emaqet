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

use yii\db\Migration;
use \app\extensions\securityManager\components\mail\template\TemplateTypeSecurity;

/**
 * Class m180403_152148_add_ban_notification_email_template
 */
class m180403_152148_add_ban_notification_email_template extends Migration
{
    public function up()
    {
        $template                = new \app\models\MailTemplate();
        $template->name          = 'Ban Notification';
        $template->template_type = TemplateTypeSecurity::TEMPLATE_TYPE;
        $template->subject       = 'Your account was banned';
        $template->content       = '<h1>Your account was banned.</h1><font face="Open Sans, sans-serif" style="font-size:14px;" color="#000000">We are sorry to inform you that your account was banned. Please look through the reason of ban and contact us to solve this issue:</font><br /><br /><br />{{ban_reason}}<br /><br /><br /><br /><font face="Open Sans, sans-serif" style="font-size:14px;" color="#000000">This email was sent to {{recipient_email}}.</font>';
        $template->save();
    }

    public function down()
    {
        return \app\models\MailTemplate::deleteAll(['slug' => ['ban-notification']]);
    }
}
