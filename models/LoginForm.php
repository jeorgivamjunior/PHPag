<?php

namespace models;

use config\DataBase;

class LoginForm extends DataBase
{
    public $email;
    public $password;
    private $_user;

    public function getLabel($attr)
    {
        $labels = [
            'email' => 'E-mail',
            'password' => 'Senha'
        ];

        return $labels[$attr];
    }

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

    function getTableName()
    {
        return "user";
    }

    function rules()
    {
        return [
            [['email', 'password'], 'string']
        ];
    }
}