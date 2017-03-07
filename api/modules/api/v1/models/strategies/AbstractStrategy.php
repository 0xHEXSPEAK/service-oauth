<?php

namespace api\modules\api\v1\models\strategies;

use yii\web\Request;
use api\modules\api\v1\exceptions\ClientNotFound;
use api\modules\api\v1\models\repository\AccessTokenRepository;

/**
 * Class AbstractStrategy
 *
 * @package api\modules\api\v1\models\strategies
 */
abstract class AbstractStrategy
{
    /**
     * Defines yii web request variable
     *
     * @var Request $request
     */
    protected $request;

    /**
     * Defines an access token repository
     *
     * @var AccessTokenRepository $accessTokenRepository
     */
    protected $accessTokenRepository;

    /**
     * AbstractStrategy constructor.
     *
     * @param Request $request
     * @param $accessTokenRepository
     */
    public function __construct(
        Request $request,
        $accessTokenRepository
    ) {
        $this->request = $request;
        $this->accessTokenRepository = $accessTokenRepository;
    }

    /**
     * Generates and access token
     * by provided credentials and grant type
     *
     *
     * @param array $scopes
     * @return string
     * @throws ClientNotFound
     */
    public abstract function generate(array $scopes);
}