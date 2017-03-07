<?php

namespace common\migrations;

use yii\db\Migration;

/**
 * Class m170226_210133_bind_client_credentials_with_token
 */
class m170226_210133_bind_client_credentials_with_token extends Migration
{
    /**
     * @var string $tableName
     */
    private static $tableName = '{{%access_token}}';

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->addColumn(self::$tableName, 'client_id', $this->integer()->after('id'));
        $this->addForeignKey('fk_client_id', self::$tableName, 'client_id', '{{%client_credentials}}', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk_client_id', self::$tableName);
        $this->dropColumn(self::$tableName, 'client_id');
    }
}
