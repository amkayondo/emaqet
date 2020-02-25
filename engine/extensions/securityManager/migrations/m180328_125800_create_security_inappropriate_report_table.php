<?php

use yii\db\Migration;

/**
 * Handles the creation of table `security_inappropriate_report`.
 */
class m180328_125800_create_security_inappropriate_report_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('{{%security_inappropriate_report}}', [
            'inappropriate_report_id' => $this->primaryKey(),
            'listing_id'              => $this->integer()->notNull(),
            'status'                  => $this->smallInteger(5)->unsigned()->notNull(),
            'report_reason'           => $this->string(130)->notNull(),
            'report_notes'            => $this->text(),
            'updated_by'              => $this->string(),
            'created_at'              => $this->dateTime()->notNull(),
            'updated_at'              => $this->dateTime()->notNull(),
        ], $tableOptions);
    }

    /**
     * {@inheritdoc}
     */
    public function down()
    {
        $this->dropTable('{{%security_inappropriate_report}}');
    }
}
