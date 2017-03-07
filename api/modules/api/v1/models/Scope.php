<?php

namespace api\modules\api\v1\models;

use yii\db\ActiveRecord;
use api\modules\api\v1\models\repository\ScopeRepository;

/**
 * Class ClientCredentials
 *
 * @package api\modules\api\v1\models
 */
class Scope extends ActiveRecord
{
    const STATUS_CUSTOM = 0;

    const STATUS_DEFAULT = 1;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%scopes}}';
    }

    /**
     * Returns the scope repository
     *
     * @return ScopeRepository
     */
    public static function find()
    {
        return new ScopeRepository(get_called_class());
    }
}
