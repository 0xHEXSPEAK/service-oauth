<?php

namespace api\modules\api\v1\models\resource;

use api\modules\api\v1\models\AccessToken;

/**
 * Class AccessTokenResource
 *
 * @package api\modules\api\v1\models\resource
 */
class AccessTokenResource extends AccessToken
{
    /**
     * @inheritdoc
     */
    public function fields()
    {
        return [
            'token',
            'refresh_token' => function() {
                $this->refresh_token->token;
            },
            'expires_in'
        ];
    }
}
