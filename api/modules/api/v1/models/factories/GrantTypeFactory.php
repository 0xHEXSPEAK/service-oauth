<?php

namespace api\modules\api\v1\models\factories;

use yii;
use api\modules\api\v1\models\User;
use api\modules\api\v1\models\strategies\PasswordStrategy;
use api\modules\api\v1\models\resource\AccessTokenResource;
use api\modules\api\v1\models\ClientCredentials;
use api\modules\api\v1\models\strategies\ClientCredentialStategy;

class GrantTypeFactory implements GrantTypeFactoryInterface
{
    public function getClientCredentials()
    {
        return new ClientCredentialStategy(
            Yii::$app->getRequest(),
            AccessTokenResource::find(),
            ClientCredentials::find()
        );
    }

    public function getPassword()
    {
        return new PasswordStrategy(
            Yii::$app->getRequest(),
            AccessTokenResource::find(),
            User::find()
        );
    }
}