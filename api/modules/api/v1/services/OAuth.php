<?php

namespace api\modules\api\v1\services;

use yii\web\Request;
use yii\base\Exception;
use api\modules\api\v1\models\GrantType;
use api\modules\api\v1\models\factories\GrantTypeFactory;
use api\modules\api\v1\models\repository\ScopeRepository;

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
        Request $request,
        GrantTypeFactory $factory,
        ScopeRepository $scopeRepository
    ) {
        $scopes = $scopeRepository->findAllowed($request->getBodyParam('scope'));

        switch ($request->getBodyParam('grant_type')) {
            case GrantType::CLIENT_CREDENTIALS:
                return $factory->getClientCredentials()->generate($scopes);
                break;
            case GrantType::PASSWORD:
                return $factory->getPassword()->generate($scopes);
                break;
            default:
                // TODO: Implement default case.
                break;
        }

        throw new Exception('Wrong grant_type');
    }
}
