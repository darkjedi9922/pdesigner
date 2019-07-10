<?php

namespace app\models;

use yii\base\Model;

class SignupForm extends Model
{
    public $username;
    public $password;

    /**
     * @return array
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required']
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
        $user->password = $this->password;
        $user->authKey = User::generateAuthKey($this->username, $this->password);
        $user->accessToken = User::generateAccessToken(
            $this->username, 
            $this->password
        );
        return $user->insert();
    }
}