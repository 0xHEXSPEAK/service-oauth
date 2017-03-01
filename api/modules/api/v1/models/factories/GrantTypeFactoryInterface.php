<?php

namespace api\modules\api\v1\models\factories;

use api\modules\api\v1\strategies\ClientCredentialStategy;
use api\modules\api\v1\strategies\PasswordStrategy;

interface GrantTypeFactoryInterface
{
    /**
     * @return ClientCredentialStategy
     */
    public function getClientCredentials();

    /**
     * @return PasswordStrategy
     */
    public function getPassword();
}