<?php

namespace api\modules\api\v1\models\factories;

use yii;
use api\modules\api\v1\models\User;
use api\modules\api\v1\models\ClientCredentials;
use api\modules\api\v1\models\resource\AccessTokenResource;
use api\modules\api\v1\models\strategies\PasswordStrategy;
use api\modules\api\v1\models\strategies\ClientCredentialStrategy;

/**
 * Class GrantTypeFactory
 *
 * @package api\modules\api\v1\models\factories
 */
class GrantTypeFactory implements GrantTypeFactoryInterface
{
    /**
     * Returns the strategy for
     * the client credentials grant type
     *
     * @return ClientCredentialStrategy
     */
    public function getClientCredentials()
    {
        return new ClientCredentialStrategy(
            Yii::$app->getRequest(),
            AccessTokenResource::find(),
            ClientCredentials::find()
        );
    }

    /**
     * Returns the strategy for
     * the password grant type
     *
     * @return PasswordStrategy
     */
    public function getPassword()
    {
        return new PasswordStrategy(
            Yii::$app->getRequest(),
            AccessTokenResource::find(),
            User::find()
        );
    }
}
