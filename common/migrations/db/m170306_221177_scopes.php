<?php

use yii\db\Migration;

/**
 * Class m170301_220177_bind_user_id_with_token
 */
class m170306_221177_scopes extends Migration
{
    /**
     * @var string $table
     */
    private static $table = '{{%scopes}}';

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable(self::$table, [
            'id' => $this->primaryKey(),
            'name' => $this->string(254),
            'is_default' => $this->boolean()
        ]);

        $this->createIndex('idx_name', self::$table, ['name', 'is_default']);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropIndex('idx_name', self::$table);
        $this->dropTable(self::$table);
    }
}
