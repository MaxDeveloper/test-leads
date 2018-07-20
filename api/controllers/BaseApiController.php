<?php
namespace api\controllers;

use Yii;
use yii\filters\auth\QueryParamAuth;
use yii\rest\Controller;
use yii\web\Response;

class BaseApiController extends Controller
{
    const STATUS_SUCCESS = 'success';
    const STATUS_ERROR = 'error';

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['authenticator'] = [
            'class' => QueryParamAuth::className(),
        ];
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;
        $behaviors['contentNegotiator']['formats']['application/json'] = Response::FORMAT_JSON;
        return $behaviors;
    }

    public function beforeAction($action)
    {
        Yii::$app->request->parsers = ['application/json' => 'yii\web\JsonParser'];

        Yii::$app->response->format = Response::FORMAT_JSON;
        Yii::$app->response->formatters = [
            \yii\web\Response::FORMAT_JSON => [
                'class' => 'yii\web\JsonResponseFormatter',
                'prettyPrint' => YII_DEBUG, // use "pretty" output in debug mode
                'encodeOptions' => JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE,
            ],
        ];
        return parent::beforeAction($action);
    }


}