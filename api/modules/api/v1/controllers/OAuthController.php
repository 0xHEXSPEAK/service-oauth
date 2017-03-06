<?php

namespace api\modules\api\v1\controllers;

use yii;
use yii\base\Module;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use api\modules\api\v1\exceptions\UserNotFound;
use api\modules\api\v1\exceptions\ClientNotFound;
use api\modules\api\v1\services\OAuthInterface;
use api\modules\api\v1\models\Scope;
use api\modules\api\v1\models\resource\AccessTokenResource;
use api\modules\api\v1\models\factories\GrantTypeFactory;

/**
 * Class OAuthController
 *
 * @package api\modules\api\v1\controllers
 */
class OAuthController extends BaseController
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
        return [
            /**
             * Contains no actions because of custom method usage
             */
        ];
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
}
