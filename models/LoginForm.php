<?php

namespace app\models;

use common\models\User;
use Yii;
use yii\base\ErrorException;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property User|null $user This property is read-only.
 *
 */
class LoginForm extends Model
{
    public $email;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['email'], 'required'],
            [['email'], 'email'],

        ];
    }

    public function login()
    {
        if ($this->validate()) {
            $user = User::findByEmail($this->email);

            // create user if not exists
            if (!$user) {
                $user = new User([
                    'username' => $this->email,
                    'email' => $this->email,
                    'balance' => 1000,
                    'status' => User::STATUS_NOT_ACTIVE
                ]);
                $user->generateAuthKey();
                if (!$user->save(false)) {
                    throw new ErrorException('Unhandled user creation error');
                }
            }

            $user->generateLoginToken();
            $user->save(false);

            // send email to user
            $this->sendAuthEmail($user);
            return true;

            //return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600*24*30 : 0);
        }
        return false;
    }

    /**
     * @param $user User
     * @return bool
     */
    public function sendAuthEmail($user)
    {
        $mailer = Yii::$app->mailer;
        return $mailer->compose('auth_link.php', ['token' => $user->login_token])
            ->setSubject('Authorization link')
            ->setFrom(Yii::$app->params['adminEmail'])
            ->setTo($user->email)->send();
    }

}
