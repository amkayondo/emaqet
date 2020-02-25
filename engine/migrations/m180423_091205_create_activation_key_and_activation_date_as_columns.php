<?php

use yii\db\Migration;

/**
 * Class m180423_091205_create_activation_key_and_activation_date_as_columns
 */
class m180423_091205_create_activation_key_and_activation_date_as_columns extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('{{%customer}}', 'activation_key', $this->string(40)->after('password_reset_key'));
        $this->addColumn('{{%customer}}', 'activation_date', $this->dateTime()->after('activation_key'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('{{%customer}}', 'activation_key');
        $this->dropColumn('{{%customer}}', 'activation_date');
    }

}