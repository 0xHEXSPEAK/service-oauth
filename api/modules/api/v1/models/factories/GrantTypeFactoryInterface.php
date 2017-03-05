<?php

namespace api\modules\api\v1\models\factories;

use api\modules\api\v1\models\strategies\PasswordStrategy;
use api\modules\api\v1\models\strategies\ClientCredentialStrategy;

/**
 * Interface GrantTypeFactoryInterface
 *
 * @package api\modules\api\v1\models\factories
 */
interface GrantTypeFactoryInterface
{
    /**
     * @return ClientCredentialStrategy
     */
    public function getClientCredentials();

    /**
     * @return PasswordStrategy
     */
    public function getPassword();
}
