<?php

namespace api\modules\api\v1\services;

use yii\web\Request;
use yii\web\BadRequestHttpException;
use yii\base\InvalidCallException;
use api\modules\api\v1\exceptions\TokenInfoNotFound;
use api\modules\api\v1\models\GrantType;
use api\modules\api\v1\models\AccessToken;
use api\modules\api\v1\models\factories\GrantTypeFactory;
use api\modules\api\v1\models\repository\ScopeRepository;
use api\modules\api\v1\models\repository\AccessTokenRepository;

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
        $scopes = $scopeRepository->collect($scopes);

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

        throw new BadRequestHttpException('Wrong grant_type');
    }

    /**
     * @inheritdoc
     */
    public function retrieveTokenInfo(
        Request $request,
        AccessTokenRepository $accessTokenRepository
    ) {
        $this->checkRequestParam($request, 'access_token');

        return $this->isModelSet(
            $accessTokenRepository->extractInfo($request->get('access_token')),
            "No info were found. Check your 'access_token' param."
        );
    }

    /**
     * Checks whether model is set.
     *
     * @param AccessToken $record
     * @param string $msg
     * @return AccessToken
     * @throws TokenInfoNotFound
     */
    protected function isModelSet($record, $msg)
    {
        if ( ! isset($record)) {
            throw new TokenInfoNotFound($msg);
        }

        return $record;
    }

    /**
     * Checks whether request has proper param
     *
     * @param Request $request
     * @return bool
     * @throws InvalidCallException
     */
    protected function checkRequestParam(Request $request, $name)
    {
        if ( ! $request->getQueryParam($name)) {
            throw new InvalidCallException("Missed query param. Check your '$name' param.");
        }

        return true;
    }
}
