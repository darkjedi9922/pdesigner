<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

class User extends ActiveRecord implements IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'users';
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
        return self::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return self::findOne(['accessToken' => $token]);
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return self::findOne(['username' => $username]);
    }

    /**
     * @param string $password
     * @return string
     */
    public static function encodePassword($password)
    {
        return md5($password | md5('bg2eibugo42g82bvuo2b32v'));
    }

    /**
     * @param string $username
     * @param string $password
     * @return string
     */
    public static function generateAuthKey($username, $password)
    {
        return md5(($username . $password) | md5('authkey_1853984207'));
    }

    /**
     * @param string $username
     * @param string $password
     * @return string
     */
    public static function generateAccessToken($username, $password)
    {
        return md5(($username . $password) | md5('accessToken_t712923849586970'));
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->authKey;
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
     */
    public function validatePassword($password)
    {
        return $this->password === self::encodePassword($password);
    }
}