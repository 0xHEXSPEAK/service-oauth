<?php

namespace api\modules\api\v1\models\strategies;

use api\modules\api\v1\exceptions\UserNotFound;
use api\modules\api\v1\models\repository\UserRepository;
use yii\base\Security;

/**
 * Class PasswordStrategy
 *
 * @package api\modules\api\v1\models\strategies
 */
class PasswordStrategy extends AbstractStrategy
{
    /**
     * Defines the repository for accessing user data
     *
     * @var UserRepository $userRepository
     */
    protected $userRepository;

    /**
     * @var Security
     */
    protected $userSecurity;

    /**
     * PasswordStrategy constructor.
     *
     * @param $request
     * @param $accessTokenRepository
     * @param $userRepository
     * @param $security
     */
    public function __construct(
        $request,
        $accessTokenRepository,
        $userRepository,
        Security $security
    ) {
        $this->userRepository = $userRepository;
        $this->userSecurity = $security;
        parent::__construct($request, $accessTokenRepository);
    }

    /**
     * Generates an access token for provided
     * username and password keys
     *
     * @param array $scopes
     * @return \api\modules\api\v1\models\AccessToken
     * @throws UserNotFound
     */
    public function generate(array $scopes)
    {
        $user = $this->userRepository->findByUserCredentials(
            $this->request->getBodyParam('username'),
            $this->userSecurity->generatePasswordHash($this->request->getBodyParam('password'))
        );

        if ( ! isset($user)) {
            throw new UserNotFound(
                "User wasn't found. Check your username and/-or password credentials."
            );
        }

        // TODO: Don't forget to change the array of scopes
        return $this->accessTokenRepository->generate(null, $user->id, $scopes, 'password');
    }
}
