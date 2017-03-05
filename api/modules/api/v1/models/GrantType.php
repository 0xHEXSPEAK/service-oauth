<?php

namespace api\modules\api\v1\models;

/**
 * Class GrantType
 * Defines the Grant Types presented by OAuth 2.0
 *
 * @package api\modules\api\v1\models
 */
class GrantType
{
    /**
     * Defines [client credentials] grant type
     *
     * @var string
     */
    const CLIENT_CREDENTIALS = 'client_credentials';

    /**
     * Defines [password] grant Type
     *
     * @var string
     */
    const PASSWORD = 'password';

    /**
     * Defines [refresh token] grant type
     *
     * @var string
     */
    const REFRESH_TOKEN = 'refresh_token';
}
