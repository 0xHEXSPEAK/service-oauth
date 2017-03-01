<?php

namespace api\modules\api\v1\models\strategies;

use api\modules\api\v1\exceptions\ClientNotFound;
use api\modules\api\v1\models\repository\UserRepository;

class PasswordStrategy extends AbstractStrategy
{
    /** @var  UserRepository */
    protected $userRepository;

    public function __construct($request, $accessTokenRepository, $userRepository)
    {
        $this->userRepository = $userRepository;
        parent::__construct($request, $accessTokenRepository);
    }

    public function generate()
    {
        $user = $this->userRepository->findByUsernameWithPassword(
            $this->request->getBodyParam('username'),
            $this->request->getBodyParam('password')
        );

        if (!isset($user)) {
            throw new ClientNotFound(
                "Client wasn't found. Check your client_id and/-or client_secret credentials."
            );
        }

        // TODO: Don't forget to change the array of scopes
        return $this->accessTokenRepository->generate(null, $user->id, ['whole_world'], 'password');
    }
}