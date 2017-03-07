<?php

namespace common\migrations;

use yii\db\Migration;

/**
 * Class m170307_128887_refresh_token
 */
class m170307_128887_refresh_token extends Migration
{
    /**
     * @var string $table
     */
    private static $table = '{{%refresh_tokens}}';

    /**
     * @var string $charset
     */
    private static $charset = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';

    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable(self::$table, [
            'id' => $this->primaryKey(),
            'token' => $this->string()->notNull(),
            'expires_in' => $this->bigInteger()->notNull(),
        ], self::$charset);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable(self::$table);
    }
}
