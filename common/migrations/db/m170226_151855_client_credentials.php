<?php

namespace common\migrations;

use yii\db\Migration;

/**
 * Class m170226_151855_client_credentials
 */
class m170226_151855_client_credentials extends Migration
{
    /**
     * @var string $tableName
     */
    private static $tableName = '{{%client_credentials}}';

    /**
     * @var string $charset
     */
    private static $charset = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable(self::$tableName, [
            'id' => $this->primaryKey(),
            'client_id' => $this->string()->notNull(),
            'client_secret' => $this->string()->notNull()
        ], self::$charset);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable(self::$tableName);
    }
}
