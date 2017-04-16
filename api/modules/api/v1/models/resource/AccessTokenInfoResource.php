<?php

namespace api\modules\api\v1\models\resource;

use api\modules\api\v1\models\AccessToken;

/**
 * Class AccessTokenInfoResource.
 *
 * @package api\modules\api\v1\models\resource
 */
class AccessTokenInfoResource extends AccessToken
{
    /**
     * @inheritdoc
     */
    public function fields()
    {
        return [
            'type',
            'expires_in',
            'scope'
        ];
    }
}