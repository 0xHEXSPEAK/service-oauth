<?php

use yii\db\Migration;

/**
 * Class m170301_210133_users
 */
class m170301_210133_users extends Migration
{
    /**
     * @var string $tableName
     */
    private static $tableName = '{{%users}}';

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable(self::$tableName, [
            'id' => $this->primaryKey(),
            'username' => $this->string(254)->notNull(),
            'password' => $this->string(64)->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable(self::$tableName);
    }
}
