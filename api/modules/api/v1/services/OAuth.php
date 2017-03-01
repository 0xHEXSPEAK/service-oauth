<?php

namespace api\modules\api\v1\services;

use yii\web\Request;
use api\modules\api\v1\exceptions\ClientNotFound;
use api\modules\api\v1\models\GrantType;
use api\modules\api\v1\models\ClientCredentials;
use api\modules\api\v1\models\resource\AccessTokenResource;
use api\modules\api\v1\models\repository\AccessTokenRepository;
use api\modules\api\v1\models\repository\ClientCredentialsRepository;

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
        AccessTokenRepository $accessTokenRepository,
        ClientCredentialsRepository $clientCredentialsRepository
    ) {
        if ($this->isClient($request)) {
            $client = $clientCredentialsRepository->isClientExist(
                $request->getBodyParam('client_id'),
                $request->getBodyParam('client_secret')
            );

            $this->checkClientExistence($client);
            // TODO: Don't forget to change the array of scopes
            return new AccessTokenResource(
                $accessTokenRepository->generate($client->id, ['whole_world'])
            );
        }

        // TODO: Implement password grant type.
    }

    /**
     * Checks if caller has a client_credentials grant type
     *
     * @param Request $request
     * @return bool
     */
    private function isClient(Request $request)
    {
        return $request->getBodyParam('grant_type') === GrantType::CLIENT_CREDENTIALS;
    }

    /**
     * Checks whether the client is exists
     *
     * @param ClientCredentials|null $client
     * @return bool
     * @throws ClientNotFound
     */
    private function checkClientExistence($client)
    {
        if (isset($client)) {
            return true;
        }

        throw new ClientNotFound(
            "Client wasn't found. Check your client_id and/-or client_secret credentials."
        );
    }
}
