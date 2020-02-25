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

use yii\db\Migration;

class m171101_152444_add_contact_form_email_templeate extends Migration
{
    public function up()
    {
        $template                   = new \app\models\MailTemplate();
        $template->template_type    = \app\components\mail\template\TemplateTypeContact::TEMPLATE_TYPE;
        $template->name             = 'Contact Form Message';
        $template->subject          = 'New message from contact form';
        $template->content          = '<p>Contact Form Message!</p><br /></br /><p>Full name: {{sender_full_name}}</p><p>Email: {{sender_email}}</p><p>Phone: {{sender_phone}}</p><p>Message:</p>{{sender_message}}';
        $template->save();
    }

    public function down()
    {
        return \app\models\MailTemplate::deleteAll(['slug' => ['contact-form-message']]);
    }

}
