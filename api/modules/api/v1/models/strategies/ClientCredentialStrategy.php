<?php

namespace api\modules\api\v1\models\strategies;

use api\modules\api\v1\exceptions\ClientNotFound;
use api\modules\api\v1\models\repository\ClientCredentialsRepository;

/**
 * Class ClientCredentialStrategy
 *
 * @package api\modules\api\v1\models\strategies
 */
class ClientCredentialStrategy extends AbstractStrategy
{
    /**
     * Defines the repository for accessing client credentials
     *
     * @var ClientCredentialsRepository $clientCredentialsRepository
     */
    protected $clientCredentialsRepository;

    /**
     * ClientCredentialStrategy constructor.
     *
     * @param $request
     * @param $accessTokenRepository
     * @param $clientCredentialsRepository
     */
    public function __construct(
        $request,
        $accessTokenRepository,
        $clientCredentialsRepository
    ) {
        $this->clientCredentialsRepository = $clientCredentialsRepository;
        parent::__construct($request, $accessTokenRepository);
    }

    /**
     * Generates an access token for provided
     * client_id and client_secret keys
     *
     * @return \api\modules\api\v1\models\AccessToken
     * @throws ClientNotFound
     */
    public function generate(array $scopes)
    {
        $client = $this->clientCredentialsRepository->findByClientCredentials(
            $this->request->getBodyParam('client_id'),
            $this->request->getBodyParam('client_secret')
        );

        if ( ! isset($client)) {
            throw new ClientNotFound(
                "Client wasn't found. Check your client_id and/-or client_secret credentials."
            );
        }

        // TODO: Don't forget to change the array of scopes
        return $this->accessTokenRepository->generate($client->id, null, $scopes);
    }
}
