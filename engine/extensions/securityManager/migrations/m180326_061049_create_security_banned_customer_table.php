<?php

use yii\db\Migration;

/**
 * Handles the creation of table `security_banned_customer`.
 */
class m180326_061049_create_security_banned_customer_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('{{%security_banned_customer}}', [
            'banned_customer_id' => $this->primaryKey(),
            'customer_email'     => $this->string(150)->notNull()->unique(),
            'ban_reason'         => $this->string(130)->notNull(),
            'created_at'         => $this->dateTime()->notNull(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%security_banned_customer}}');
    }
}
