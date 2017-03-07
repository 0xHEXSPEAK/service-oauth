<?php

namespace api\modules\api\v1\models;

use yii\db\ActiveRecord;
use api\modules\api\v1\models\repository\RefreshTokenRepository;

/**
 * Class AccessToken
 *
 * @package api\modules\api\v1\models
 */
class RefreshToken extends ActiveRecord
{
    /**
     * Defines the number of bytes used by openssl_random_pseudo_bytes
     * while generating an access_token hash
     *
     * @var string
     */
    const TOKEN_BYTES = 8;

    /**
     * Defines the crypt algorithm used by hash function
     * while generating a hash value (message digest)
     *
     * @var string
     */
    const CRYPT_ALGORITHM = 'sha256';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%refresh_tokens}}';
    }

    /**
     * @inheritdoc
     */
    public static function primaryKey()
    {
        return ['id'];
    }

    /**
     * Returns an access token repository
     *
     * @return RefreshTokenRepository
     */
    public static function find()
    {
        return new RefreshTokenRepository(get_called_class());
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['expires_in'], 'integer']
        ];
    }
}
