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

/**
 * Handles the creation for table `category_field_option`.
 */
class m161102_111931_create_category_field_option_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        $this->createTable('{{%category_field_option}}', [
            'option_id'       => $this->primaryKey(),
            'field_id'        => $this->integer()->notNull(),
            'name'            => $this->string(150)->notNull(),
            'value'           => $this->string(255),
            'created_at'      => $this->dateTime()->notNull(),
            'updated_at'      => $this->dateTime()->notNull(),
        ], $tableOptions);

        // add category data from SQL file
        $prefix = db()->tablePrefix;
        $query = \app\helpers\CommonHelper::getQueriesFromSqlFile(realpath(Yii::$app->basePath) . '/data/sql/category-field-option.sql', $prefix);
        foreach ($query as $q){
            db()->createCommand($q)->execute();
        }

        $this->addForeignKey('category_field_option_field_id_fk', '{{%category_field_option}}', 'field_id', '{{%category_field}}', 'field_id', 'CASCADE', 'NO ACTION');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->getDb()->createCommand('SET FOREIGN_KEY_CHECKS = 0')->execute();

        $this->dropTable('{{%category_field_option}}');

        $this->getDb()->createCommand('SET FOREIGN_KEY_CHECKS = 1')->execute();
    }
}
