<?php

namespace models;

use config\DataBase;

/**
 * Class User
 * @package models
 */
class User extends DataBase
{
    public $name;
    public $email;
    public $password;

    /**
     * Get label from model
     * @param $attr
     * @return mixed
     */
    public function getLabel($attr)
    {
        $labels = [
            'name' => 'Nome',
            'email' => 'E-mail',
            'password' => 'Senha'
        ];

        return $labels[$attr];
    }

    /**
     * @param $email
     * @return $this|null
     */
    public function findUserByEmail($email)
    {
        $user = static::findOne(['email' => $email]);

        return $user;
    }

    /**
     * Get the table name
     * @return string
     */
    function getTableName()
    {
        return 'user';
    }

    /**
     * Handles rules for the model attributes
     * @return array
     */
    function rules()
    {
        return [
            [['name', 'email', 'password'], 'required'],
            [['name', 'email', 'password'], 'string']
        ];
    }
}