<?php

namespace api\modules\api\v1\models\repository;

use yii\db\ActiveQuery;
use api\modules\api\v1\models\User;

/**
 * Class UserQuery
 *
 * @package api\modules\api\v1\models\repository
 */
class UserRepository extends ActiveQuery
{
    /**
     * @param $username
     * @param $password
     * @return array|null|User
     */
    public function findByUsernameWithPassword($username, $password)
    {
        return $this->where([
            'username' => $username,
            'password' => hash(User::CRYPT_ALGORITHM, $password)
        ])->one();
    }
}
