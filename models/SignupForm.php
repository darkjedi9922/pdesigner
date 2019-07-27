<?php

namespace app\models;

use yii\base\Model;

class SignupForm extends Model
{
    const USERNAME_ALREADY_EXISTS = 'The username already exists.';

    public $username;
    public $password;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['username', 'validateUsername']
        ];
    }

    /**
     * @return bool whether the user is signed up successfuly.
     */
    public function signup()
    {
        if (!$this->validate()) return false;

        $user = new User;
        $user->username = $this->username;
        $user->password = User::encodePassword($this->password);
        $user->authKey = User::generateAuthKey($this->username, $this->password);
        $user->accessToken = User::generateAccessToken(
            $this->username, 
            $this->password
        );
        return $user->insert();
    }

    /**
     * @param string $attribute
     */
    public function validateUsername($attribute)
    {
        $user = User::findByUsername($this->username);
        if ($user) $this->addError($attribute, self::USERNAME_ALREADY_EXISTS);
    }
}