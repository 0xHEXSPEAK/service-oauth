<?php

namespace api\modules\api\v1\models\repository;

use api\modules\api\v1\models\RefreshToken;
use yii\db\ActiveQuery;
use cheatsheet\Time;

/**
 * Class RefreshTokenRepository
 *
 * @package api\modules\api\v1\models\repository
 */
class RefreshTokenRepository extends ActiveQuery
{
    /**
     * Generates refresh token token by given user id
     *
     * @param integer $clientId
     * @param string|null $userId
     * @param array $scopes
     * @return RefreshToken
     */
    public function generate($userId   = null)
    {
        $bytes = openssl_random_pseudo_bytes(RefreshToken::TOKEN_BYTES);
        $token = hash(RefreshToken::CRYPT_ALGORITHM, uniqid($bytes, true));

        $model = new RefreshToken([
            'user_id'    => $userId,
            'token'      => $token,
            'expires_in' => time() + Time::SECONDS_IN_A_YEAR * 999,
        ]);

        $model->save();

        return $model;
    }
}
