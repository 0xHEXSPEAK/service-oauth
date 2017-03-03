<?php

namespace api\modules\api\v1\models\repository;

use yii\db\ActiveQuery;
use api\modules\api\v1\models\ClientCredentials;

/**
 * Class ClientCredentialsQuery
 *
 * @package api\modules\api\v1\models\repository
 */
class ClientCredentialsRepository extends ActiveQuery
{
    /**
     * Checks whether the given client credentials
     * exists in storage
     *
     * @param string $id
     * @param string $secret
     * @return ClientCredentials|array|null|
     */
    public function isClientExist($id, $secret)
    {
        return $this->where([
            'client_id' => $id,
            'client_secret' => $secret
        ])->one();
    }
}
