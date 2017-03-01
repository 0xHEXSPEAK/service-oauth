<?php

namespace api\modules\api\v1\models\strategies;

use api\modules\api\v1\exceptions\ClientNotFound;
use api\modules\api\v1\models\ClientCredentials;
use api\modules\api\v1\models\GrantType;
use api\modules\api\v1\models\repository\ClientCredentialsRepository;
use yii\web\Request;

class ClientCredentialStategy extends AbstractStrategy
{
    /** @var  ClientCredentialsRepository */
    protected $clientCredentialsRepository;

    public function __construct($request, $accessTokenRepository, $clientCredentialsRepository)
    {
        $this->clientCredentialsRepository = $clientCredentialsRepository;
        parent::__construct($request, $accessTokenRepository);
    }

    public function generate()
    {
        $client = $this->clientCredentialsRepository->isClientExist(
            $this->request->getBodyParam('client_id'),
            $this->request->getBodyParam('client_secret')
        );

        if (!isset($client)) {
            throw new ClientNotFound(
                "Client wasn't found. Check your client_id and/-or client_secret credentials."
            );
        }

        // TODO: Don't forget to change the array of scopes
        return $this->accessTokenRepository->generate($client->id, null, ['whole_world']);
    }

}