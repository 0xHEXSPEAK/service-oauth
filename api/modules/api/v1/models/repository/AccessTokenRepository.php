<?php

namespace api\modules\api\v1\models\repository;

use yii\db\ActiveQuery;
use api\modules\api\v1\models\GrantType;
use api\modules\api\v1\models\AccessToken;
use cheatsheet\Time;

/**
 * Class AccessTokenRepository
 *
 * @package api\modules\api\v1\models\repository
 */
class AccessTokenRepository extends ActiveQuery
{
    /**
     * Generates access token by given client credentials
     *
     * @param integer $clientId
     * @param array $scopes
     * @param string $type
     * @return AccessToken
     */
    public function generate(
        $clientId = null,
        $userId = null,
        $scopes = [],
        $type   = GrantType::CLIENT_CREDENTIALS
    ) {
        $bytes = openssl_random_pseudo_bytes(AccessToken::TOKEN_BYTES);
        $token = hash(AccessToken::CRYPT_ALGORITHM, uniqid($bytes, true));

        $model = new AccessToken([
            'client_id' => $clientId,
            'user_id' => $userId,
            'type' => $type,
            'token' => $token,
            'expires_in' => time() + Time::SECONDS_IN_A_WEEK * 2,
            'scope' => implode(' ', $scopes)
        ]);

        $model->save();

        return $model;
    }
}
