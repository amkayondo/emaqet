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

/**
 * Class m180307_120707_add_the_expired_notification_email_templates
 */
class m180509_082335_add_mass_message_template extends Migration
{
    public function up()
    {
        $template                   = new \app\models\MailTemplate();
        $template->name             = 'Mass Message';
        $template->template_type    = \app\components\mail\template\TemplateTypeGeneral::TEMPLATE_TYPE;
        $template->subject          = 'Message from Admin';
        $template->content          = '<h1>Message from Admin</h1>
                                      <font face="Open Sans, sans-serif" style="font-size:14px;" color="#000000">Hello {{receiver_first_name}},<br /><br />
                                      {{message|raw}}<br /><br />
                                      ';
        $template->save();
    }

    public function down()
    {
        return \app\models\MailTemplate::deleteAll(['slug' => ['mass-message']]);
    }
}
