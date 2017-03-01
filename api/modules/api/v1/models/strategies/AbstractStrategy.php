<?php

namespace api\modules\api\v1\models\strategies;

use api\modules\api\v1\models\repository\AccessTokenRepository;
use yii\web\Request;

abstract class AbstractStrategy
{
    /** @var  Request */
    protected $request;

    /** @var  AccessTokenRepository */
    protected $accessTokenRepository;

    public function __construct($request, $accessTokenRepository)
    {
        $this->request = $request;
        $this->accessTokenRepository = $accessTokenRepository;
    }

    public abstract function generate();
}