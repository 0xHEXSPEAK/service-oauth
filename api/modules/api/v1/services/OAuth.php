<?php

namespace api\modules\api\v1\services;

use yii\web\Request;
use yii\base\Exception;
use api\modules\api\v1\models\GrantType;
use api\modules\api\v1\models\factories\GrantTypeFactory;

/**
 * Class OAuth
 *
 * @package api\modules\api\v1\services
 */
class OAuth implements OAuthInterface
{
    /**
     * @inheritdoc
     */
    public function createAccessToken(
        GrantTypeFactory $factory,
        Request $request
    ) {
        switch ($request->getBodyParam('grant_type')) {
            case GrantType::CLIENT_CREDENTIALS:
                return $factory->getClientCredentials()->generate();
                break;
            case GrantType::PASSWORD:
                return $factory->getClientCredentials()->generate();
                break;
            default:
                // TODO: Implement default case.
                break;
        }

        throw new Exception('Wrong grant_type');
    }
}
