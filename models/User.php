<?php

namespace models;

use config\DataBase;

class User extends DataBase
{
    public $name;
    public $email;
    public $password;

    public function getLabel($attr)
    {
        $labels = [
            'name' => 'Nome',
            'email' => 'E-mail',
            'password' => 'Senha'
        ];

        return $labels[$attr];
    }

    public function findUserByEmail($email)
    {
        $user = static::findOne(['email' => $email]);

        return $user;
    }

    function getTableName()
    {
        return 'user';
    }

    function rules()
    {
        return [
            [['name', 'email', 'password'], 'string']
        ];
    }
}