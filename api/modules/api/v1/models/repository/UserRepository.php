<?php

namespace api\modules\api\v1\models\repository;

use yii\db\ActiveQuery;
use api\modules\api\v1\models\User;
use api\modules\api\v1\models\AccessToken;

/**
 * Class UserRepository
 *
 * @package api\modules\api\v1\models\repository
 */
class UserRepository extends ActiveQuery
{
    /**
     * Checks whether the user by provided username
     * and password exists in storage
     *
     * @param string $username
     * @param string $hash
     * @return array|null|User
     */
    public function findByUserCredentials($username, $hash)
    {
        return $this->where([
            'username' => $username,
            'password' => $hash
        ])->one();
    }
}
