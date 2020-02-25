<?php

use yii\db\Migration;

/**
 * Handles the creation of table `security_log`.
 */
class m180320_211309_create_security_log_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('{{%security_log}}', [
            'log_id'     => $this->primaryKey(),
            'log_type'   => $this->smallInteger(5)->unsigned()->notNull(),
            'ip_address' => $this->string(20),
            'user_agent' => $this->string(),
            'username'   => $this->string(150)->notNull(),
            'password'   => $this->string(64)->notNull(),
            'country'    => $this->string(150),
            'city'       => $this->string(150),
            'created_at' => $this->dateTime()->notNull(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%security_log}}');
    }
}
