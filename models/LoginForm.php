<?php

namespace models;

use config\DataBase;

class LoginForm extends DataBase
{
    public $email;
    public $password;
    private $_user;

    /**
     * Get label from model
     * @param $attr
     * @return mixed
     */
    public function getLabel($attr)
    {
        $labels = [
            'email' => 'E-mail',
            'password' => 'Senha'
        ];

        return $labels[$attr];
    }

    /**
     * @return bool
     */
    public function login()
    {
        $user = new User();
        $this->_user = $user->findUserByEmail($this->email);
        if (!empty($this->_user)) {
            if ($this->password == $this->_user->password) {
                unset($this->_user->password);
                $_SESSION['userLogged'] = $this->_user;
                return true;
            }
        }

        echo 'Usuário e/ou Senha inválidos.';
        return false;
    }

    /**
     * Get label from model
     * @return mixed
     * @internal param $attr
     */
    function getTableName()
    {
        return "user";
    }

    /**
     * Handles rules for the model attributes
     * @return array
     */
    function rules()
    {
        return [
            [['email', 'password'], 'required'],
            [['email', 'password'], 'string']
        ];
    }
}