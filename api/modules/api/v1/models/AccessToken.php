<?php

namespace api\modules\api\v1\models;

use yii\db\ActiveRecord;
use api\modules\api\v1\models\repository\AccessTokenRepository;

/**
 * Class AccessToken
 *
 * @package api\modules\api\v1\models
 */
class AccessToken extends ActiveRecord
{
    const TOKEN_BYTES = 8;

    const CRYPT_ALGORITHM = 'sha256';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%access_token}}';
    }

    /**
     * @inheritdoc
     */
    public static function primaryKey()
    {
        return ['id'];
    }

    /**
     * Returns access token repository
     *
     * @return AccessTokenRepository
     */
    public static function find()
    {
        return new AccessTokenRepository(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'token', 'expires_in', 'scope'], 'required'],
            [['type', 'token', 'scope'], 'string'],
            [['expires_in'], 'integer']
        ];
    }
}
