<?php
// Api url rules
return [
    'class' => 'yii\web\UrlManager',
    'enablePrettyUrl' => true,
    'showScriptName' => false,
    'rules' => [
        [
            'class' => 'yii\rest\UrlRule',
            'controller' => ['v1/oauth' => 'api/v1/o-auth'],
            'extraPatterns' => [
                'POST token'    => 'token',
                'GET tokeninfo' => 'tokeninfo'
            ],
        ]
    ]
];
