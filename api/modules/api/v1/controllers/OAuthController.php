<?php

namespace api\modules\api\v1\controllers;

use yii\base\Module;
use yii\web\Request;
use api\modules\api\v1\models\AccessToken;
use api\modules\api\v1\models\ClientCredentials;
use api\modules\api\v1\models\resource\AccessTokenResource;
use api\modules\api\v1\services\OAuthInterface;

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
     * @return AccessToken
     */
    public function actionToken()
    {
        $request = \Yii::$app->getRequest();
        if ($this->isClient($request)) {
            $client = ClientCredentials::find()->isClientExist(
                $request->getBodyParam('client_id'),
                $request->getBodyParam('client_secret')
            );

            if ($this->isExists($client)) {
                return new AccessTokenResource(
                    AccessToken::find()->generate($client->id, ['whole_world'])
                );
            }
        }

        // TODO: password grant_type
    }

    /**
     * @param Request $request
     * @return bool
     */
    private function isClient(Request $request)
    {
        return $request->getBodyParam('grant_type') === ClientCredentials::CRED_CLIENT;
    }

    /**
     * Checks whether the client is exists
     *
     * @param ClientCredentials $client
     * @return bool
     */
    private function isExists(ClientCredentials $client)
    {
        return isset($client);
    }
}
