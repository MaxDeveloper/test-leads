<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * Class User
 * @property integer $id
 * @property string $username
 * @property string $auth_key
 * @property string $login_token
 * @property string $email
 * @property int $status
 * @property double $balance
 *
 */
class User extends ActiveRecord implements IdentityInterface
{
    const STATUS_NOT_ACTIVE = 0;
    const STATUS_ACTIVE = 1;

    const SCENARIO_EDIT_NAME = 'edit_name';

    public function rules()
    {
        return [
            [['username'], 'string', 'max' => 127, 'min' => 2, 'on' => self::SCENARIO_EDIT_NAME]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'auth_key' => Yii::t('app', 'API Key'),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return static::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['auth_key' => $token]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by email
     *
     * @param $email
     * @return null|static
     */
    public static function findByEmail($email)
    {
        return static::findOne(['email' => $email]);
    }


    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->authKey === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     * @throws NotSupportedException
     */
    public function validatePassword($password)
    {
        throw new NotSupportedException('"validatePassword" is not implemented.');
        //return $this->password === $password;
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->getSecurity()->generateRandomString();
    }

    public function generateLoginToken()
    {
        $this->login_token = Yii::$app->getSecurity()->generateRandomString();
    }

    /**
     * Find user by token
     * @param $token string auth token
     * @return null|static
     */
    public static function findByToken($token)
    {
        return static::findOne(['auth_key' => $token]);
    }

    /**
     * Find by login token
     * @param $token string token
     * @return null|static
     */
    public static function findByLoginToken($token)
    {
        return static::findOne(['login_token' => $token]);
    }
}
