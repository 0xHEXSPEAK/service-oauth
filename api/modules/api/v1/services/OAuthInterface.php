<?php

namespace api\modules\api\v1\services;

use yii\web\Request;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use api\modules\api\v1\models\AccessToken;
use api\modules\api\v1\models\resource\AccessTokenResource;
use api\modules\api\v1\models\factories\GrantTypeFactory;
use api\modules\api\v1\models\repository\ScopeRepository;
use api\modules\api\v1\models\repository\AccessTokenRepository;

/**
 * Interface OAuthInterface.
 *
 * @package api\modules\api\v1\services
 */
interface OAuthInterface
{
    /**
     * Creates an access token based on provided
     * client_id and client_secret keys.
     *
     * @param Request $request
     * @param GrantTypeFactory $factory
     * @param ScopeRepository $scopeRepository
     * @return AccessTokenResource
     * @throws BadRequestHttpException
     */
    public function createAccessToken(
        Request $request,
        GrantTypeFactory $factory,
        ScopeRepository $scopeRepository
    );

    /**
     * Retrieves token info from an access token.
     *
     * @param Request $request
     * @param AccessTokenRepository $accessTokenRepository
     * @return AccessToken|bool
     * @throws NotFoundHttpException
     */
    public function retrieveTokenInfo(
        Request $request,
        AccessTokenRepository $accessTokenRepository
    );
}
