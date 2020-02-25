<?php

use yii\db\Migration;

/**
 * Class m180423_125634_add_activation_email_template
 */
class m180423_125634_add_activation_email_template extends Migration
{
    public function up()
    {
        $template                   = new \app\models\MailTemplate();
        $template->template_type    = \app\components\mail\template\TemplateTypeCustomer::TEMPLATE_TYPE;
        $template->name             = 'Activation Email';
        $template->subject          = 'Activation Email';
        $template->content          = '<h1>Activation Email</h1>
                                       <font face="Open Sans, sans-serif" style="font-size:14px;" color="#000000">Hello there, {{customer_first_name}}    <br /><br />
                                       It\'s a pleasure to meet you!   Please activate your account.</font><br /><br />
                                       <a href="{{activation_url}}" style="display: inline-block; padding: 5px 25px; background-color: #c06014; color: #ffffff; font-family: \'Oswald\', sans-serif; text-decoration: none">Activate Account</a><br /><br /><br /><br />
                                       <font face="Open Sans, sans-serif" style="font-size:14px;" color="#000000">This email was sent to {{customer_email}}.</font>';
        $template->save();
    }

    public function down()
    {
        return \app\models\MailTemplate::deleteAll(['slug' => ['activation-email']]);
    }
}
