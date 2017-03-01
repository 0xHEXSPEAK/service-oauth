<?php

namespace api\modules\api\v1\controllers;

use yii;
use yii\base\Module;
use yii\base\Exception;
use yii\web\BadRequestHttpException;
use yii\web\NotFoundHttpException;
use api\modules\api\v1\exceptions\ClientNotFound;
use api\modules\api\v1\models\resource\AccessTokenResource;
use api\modules\api\v1\services\OAuthInterface;
use api\modules\api\v1\models\factories\GrantTypeFactory;

/**
 * Class OAuthController
 *
 * @package api\modules\api\v1\controllers
 */
class OAuthController extends BaseController
{
    /**
     * @var string
     */
    public $modelClass = 'api\modules\api\v1\models\AccessToken';

    /**
     * @var OAuthInterface
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
     * @return AccessTokenResource
     * @throws NotFoundHttpException
     */
    public function actionToken()
    {
        try {
            return $this->oauthService->createAccessToken(
                new GrantTypeFactory(),
                Yii::$app->getRequest()
            );
        } catch (ClientNotFound $e) {
            throw new NotFoundHttpException($e->getMessage(), 404);
        } catch (Exception $e) {
            throw new yii\web\BadRequestHttpException($e->getMessage());
        }
    }
}
