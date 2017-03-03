<?php

use yii\db\Migration;

/**
 * Class m170301_220177_bind_user_id_with_token
 */
class m170301_220177_bind_user_id_with_token extends Migration
{
    /**
     * @var string $tableName
     */
    private static $tokenTable = '{{%access_tokens}}';

    private static $userTable = '{{%users%}}';

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->renameTable('{{%access_token}}', self::$tokenTable);

        $this->addColumn(self::$tokenTable, 'user_id', $this->integer()->after('client_id'));

        $this->addForeignKey('fk_user_id', self::$tokenTable, 'user_id', self::$userTable, 'id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk_user_id', self::$tokenTable);
        $this->dropColumn(self::$tokenTable, 'user_id');
        $this->renameTable(self::$tokenTable, '{{%access_token}}');
    }
}
