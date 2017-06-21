<?php

namespace api\modules\api\v1\models;

use yii\db\ActiveRecord;
use api\modules\api\v1\models\repository\UserRepository;

/**
 * Class ClientCredentials
 *
 * @package api\modules\api\v1\models
 */
class User extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%users}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['username'], 'string', 'length' => [5, 254]],
            [['password'], 'string', 'length' => [5, 64]],
        ];
    }

    /**
     * Returns the user repository
     *
     * @return UserRepository
     */
    public static function find()
    {
        return new UserRepository(get_called_class());
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            $this->password = \Yii::$app->getSecurity()->generatePasswordHash($this->password);
            return true;
        }
        return false;
    }
}
