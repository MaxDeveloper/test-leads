<?php

namespace app\controllers;

use app\models\ContactForm;
use app\models\LoginForm;
use common\models\User;
use Yii;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'account'],
                'rules' => [
                    [
                        'actions' => ['logout', 'account'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect('/site/login');
        } else {
            return $this->redirect('/site/account');
        }
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Please check your email to follow auth link and confirm your registration'));
            return $this->redirect('index');
        }

        return $this->render('login_form', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Authorization process by token
     * @param $token string login token
     * @throws NotFoundHttpException
     */
    public function actionAuth($token)
    {
        $user = User::findByLoginToken($token);
        if (!$user) {
            throw new NotFoundHttpException('Your auth token does not exists');
        }

        // update user status
        if ($user->status == User::STATUS_NOT_ACTIVE) {
            $user->status = User::STATUS_ACTIVE;
            $user->save(false);
        }

        Yii::$app->user->login($user);
        $this->redirect('/site/account');
    }

    public function actionAccount()
    {
        $model = Yii::$app->user->identity;
        $model->scenario = User::SCENARIO_EDIT_NAME;

        if ($model->load(Yii::$app->request->post())) {
            if ($model->save()) {
                Yii::$app->getSession()->setFlash('success', Yii::t('app', 'Your username has been changed'));
                return $this->redirect('/site/account');
            } else {
                Yii::$app->getSession()->setFlash('error', Yii::t('app', 'Username update error'));
            }
        }

        return $this->render('user_profile',[
            'model' => $model
        ]);
    }

}
