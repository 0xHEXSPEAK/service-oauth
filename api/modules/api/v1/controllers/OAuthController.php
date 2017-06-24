<?php

namespace api\modules\api\v1\controllers;

use api\modules\api\v1\models\User;
use yii;
use yii\base\Module;
use yii\base\InvalidCallException;
use yii\base\InvalidValueException;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use api\modules\api\v1\services\OAuthInterface;
use api\modules\api\v1\exceptions\UserNotFound;
use api\modules\api\v1\exceptions\ClientNotFound;
use api\modules\api\v1\exceptions\TokenInfoNotFound;
use api\modules\api\v1\models\Scope;
use api\modules\api\v1\models\AccessToken;
use api\modules\api\v1\models\resource\AccessTokenResource;
use api\modules\api\v1\models\resource\AccessTokenInfoResource;
use api\modules\api\v1\models\factories\GrantTypeFactory;
use Oxhexspeak\OauthFilter\Controllers\RestController;

/**
 * Class OAuthController
 *
 * @package api\modules\api\v1\controllers
 */
class OAuthController extends RestController
{
    /**
     * Defines an access token model class
     *
     * @var string $modelClass
     */
    public $modelClass = 'api\modules\api\v1\models\AccessToken';

    /**
     * Defines the service that access an oauth functionality
     *
     * @var OAuthInterface $oauthService
     */
    protected $oauthService;


    public function behaviors()
    {
        $behaviors = parent::behaviors();
        unset($behaviors['access']);
        return $behaviors;
    }

    /**
     * InstanceController constructor.
     *
     * @param string $id
     * @param Module $module
     * @param OAuthInterface $oauthService
     * @param array $config
     */
    public function __construct(
        $id,
        Module $module,
        OAuthInterface $oauthService,
        array $config = []
    ) {
        $this->oauthService = $oauthService;
        parent::__construct($id, $module, $config);
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [];
    }

    /**
     * Generates an access token for provided
     * client_id and client_secret keys
     *
     * @return AccessTokenResource
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     */
    public function actionToken()
    {
        try {
            return new AccessTokenResource(
                $this->oauthService->createAccessToken(
                    Yii::$app->getRequest(),
                    new GrantTypeFactory(),
                    Scope::find()
                )
            );
        } catch (ClientNotFound $e) {
            throw new NotFoundHttpException($e->getMessage());
        } catch (UserNotFound $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
    }

    /**
     * Endpoint for registering new users.
     */
    public function actionRegister()
    {
        try {
            Yii::$app->getResponse()->setStatusCode(201);
            return $this->oauthService->registerUserCredentials(
                AccessTokenInfoResource::find(),
                new User(),
                Yii::$app->getRequest()
            );
        } catch (InvalidValueException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
    }

    /**
     * Returns relative information from an access token.
     *
     * @return mixed
     * @throws BadRequestHttpException
     * @throws NotFoundHttpException
     */
    public function actionTokeninfo()
    {
        try {
            return $this->oauthService->retrieveTokenInfo(
                Yii::$app->getRequest(),
                AccessTokenInfoResource::find()
            );
        } catch (InvalidCallException $e) {
            throw new BadRequestHttpException($e->getMessage());
        } catch (TokenInfoNotFound $e) {
            throw new NotFoundHttpException($e->getMessage());
        }
    }
}
