<?php

/**
 *
 * @package    EasyAds
 * @author     CodinBit <contact@codinbit.com>
 * @link       https://store.codinbit.com
 * @copyright  2017 EasyAds (https://store.codinbit.com)
 * @license    https://www.codinbit.com
 * @since      1.6
 */

use yii\db\Migration;

/**
 * Class m181208_082009_add_external_url_page_table
 */
class m181208_082009_add_external_url_page_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn('{{%page}}', 'external_url', $this->string(255)->defaultValue(Null)->after('slug'));
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropColumn('{{%page}}', 'external_url');
    }
}
