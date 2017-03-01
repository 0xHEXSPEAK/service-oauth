<?php

namespace api\modules\api\v1\services;

use yii\web\Request;
use api\modules\api\v1\models\resource\AccessTokenResource;
use api\modules\api\v1\models\repository\AccessTokenRepository;
use api\modules\api\v1\models\repository\ClientCredentialsRepository;

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
     * @param Request $request
     * @param AccessTokenRepository $accessTokenRepository
     * @param ClientCredentialsRepository $clientCredentialsRepository
     * @return AccessTokenResource
     */
    public function createAccessToken(
        Request $request,
        AccessTokenRepository $accessTokenRepository,
        ClientCredentialsRepository $clientCredentialsRepository
    );
}
