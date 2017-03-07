<?php

namespace api\modules\api\v1\services;

use yii\web\Request;
use api\modules\api\v1\models\repository\ScopeRepository;
use api\modules\api\v1\models\factories\GrantTypeFactory;
use api\modules\api\v1\models\resource\AccessTokenResource;

/**
 * Interface OAuthInterface
 *
 * @package api\modules\api\v1\services
 */
interface OAuthInterface
{
    /**
     * Creates an access token for provided
     * client_id and client_secret keys
     *
     * @param GrantTypeFactory $factory
     * @param Request $request
     * @return AccessTokenResource
     */
    public function createAccessToken(
        Request $request,
        GrantTypeFactory $factory,
        ScopeRepository $scopeRepository
    );
}
