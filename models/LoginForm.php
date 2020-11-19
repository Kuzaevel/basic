<?php

namespace app\models;

use yii\base\Model;

/**
 * Login form
 */
class LoginForm extends Model
{
    public $username;
    public $password;

    private $_user;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password'], 'required'],
            // password is validated by validatePassword()
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param $password
     * @return bool
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
//            $hash = $user->setPassword($this->password);
            if (!$user || !$user->validatePassword($this->password)) {
          //if (!$user || !$user->validatePasswordNoHash($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }

    }


    /**
     * @return Token|null
     */
    public function auth()
    {
        if ($this->validate()) {
            $token = new Token();
            $token->user_id = $this->getUser()->id;
            $token->generateToken(time() + 3600 * 24);
            return $token->save() ? $token : null;
        } else {
            return null;
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByUsername($this->username);
        }

        return $this->_user;
    }
}
