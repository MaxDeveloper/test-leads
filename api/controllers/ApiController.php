<?php

namespace api\controllers;

use Yii;
use yii\base\InvalidCallException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * Class ApiController
 *
 * REST API controller
 * @package app\controllers
 */
class ApiController extends BaseApiController
{
    public function behaviors()
    {
        $behaviors = parent::behaviors();

        $behaviors = ArrayHelper::merge([
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'withdraw' => ['POST']
                ],
            ]
        ], $behaviors);

        return $behaviors;
    }

    /**
     * Withdraw money from user account
     * @return array
     */
    public function actionWithdraw()
    {
        $sum = Yii::$app->request->post('sum');

        if ($sum == null) {
            throw new InvalidCallException('sum param is not defined');
        }
        if ($sum <= 0) {
            throw new InvalidCallException('sum param should be more than 0');
        }

        $user = Yii::$app->user->identity;
        if ($user->balance < $sum) {
            throw new InvalidCallException('user balance is not enough');
        }

        $user->balance -= $sum;
        $user->save();

        return ['sum' => $sum, 'balance' => $user->balance];
    }

}