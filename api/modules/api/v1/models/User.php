<?php

namespace api\modules\api\v1\models;

use api\modules\api\v1\models\repository\UserRepository;
use yii\db\ActiveRecord;
use api\modules\api\v1\models\repository\ClientCredentialsRepository;

/**
 * Class ClientCredentials
 *
 * @package api\modules\api\v1\models
 */
class User extends ActiveRecord
{
    const CRYPT_ALGORITHM = 'sha256';

    public static function tableName()
    {
        return '{{%users}}';
    }

    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['username'], 'string', 'length' => ['5', '254']],
            [['password'], 'string', 'length' => ['64', '64']],
        ];
    }

    public static function find()
    {
        return new UserRepository(get_called_class());
    }
}