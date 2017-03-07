<?php

namespace common\migrations;

use yii\db\Migration;

/**
 * Class m170226_154156_access_token
 */
class m170226_154156_access_token extends Migration
{
    /**
     * @var string $tableName
     */
    private static $tableName = '{{%access_token}}';

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
            'type' => $this->string()->notNull(),
            'token' => $this->string()->notNull(),
            'expires_in' => $this->bigInteger()->notNull(),
            'scope' => $this->text()->notNull()
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
