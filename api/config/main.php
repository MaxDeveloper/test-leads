<?php
$params = array_merge(
    require(__DIR__ . '/params.php'),
    require(__DIR__ . '/params-local.php')
);


return [
    'id' => 'app-api',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'controllerNamespace' => 'api\controllers',
    'components' => [
        'db' => [
            'class' => 'yii\db\Connection',

            'dsn' => 'mysql:host=localhost;dbname=test_leads',
            'username' => 'root',
            'password' => '',
            'charset' => 'utf8',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],

        'request' => [
            'cookieValidationKey' => '9E8F4h7khpeJfQ9YFaTvtyYWdID9AFuT',
            'parsers' => [
                'application/json' => 'yii\web\JsonParser',
            ]
        ],

        'response' => [
            'class' => 'yii\web\Response',
            'format' => yii\web\Response::FORMAT_JSON,
            'formatters' => [
                \yii\web\Response::FORMAT_JSON => [
                    'class' => 'yii\web\JsonResponseFormatter',
                    'prettyPrint' => YII_DEBUG, // use "pretty" output in debug mode
                    'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
                ],
            ],
            //'charset' => 'UTF-8'
            /*'on beforeSend' => function ($event) {
                api\controllers\BaseApiController::responseBeforeSend($event);
            },*/
        ],

        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => false,
        ],

        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,

        ],

    ],

    'params' => $params,
];
