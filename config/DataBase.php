<?php

namespace config;

use mysqli;

abstract class DataBase
{
    protected $link;
    private $config;

    public function __construct()
    {
        $this->config = include("main.php");
        $this->link = new mysqli($this->config['db']['host'], $this->config['db']['user'], $this->config['db']['password'], $this->config['db']['database']);

        if ($this->link->connect_errno > 0) {
            die('Unable to connect to database [' . $this->link->connect_error . ']');
        }
    }

    public function load()
    {
        $post = $_POST;

        foreach ($this->attributes() as $attribute) {
            if (!empty($post[$attribute])) {
                $this->$attribute = $post[$attribute];
            } else {
                return false;
            }
        }

        return true;
    }

    public function attributes()
    {
        $class = new \ReflectionClass($this);
        $names = [];
        foreach ($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
            if (!$property->isStatic() && !$property->isProtected()) {
                $names[] = $property->getName();
            }
        }

        return $names;
    }

    public function validate($attribute)
    {
        $name = $attribute;
        foreach ($this->rules() as $rule) {
            if (in_array($attribute, $rule[0])) {
                if ($rule[1] == 'string') {
                    $name = "'" . $this->$attribute . "'";
                } else {
                    $name = $this->$attribute;
                }
            }
        }

        return $name;
    }

    public function valuesOf($attributes)
    {
        $values = [];
        foreach ($attributes as $attribute) {
            $values[] = $this->validate($attribute);
        }

        return $values;
    }

    public function formatAttributesToUpdateQuery()
    {
        $query = [];
        $attributes = $this->attributes();
        $values = $this->valuesOf($attributes);
        $index = 0;
        foreach ($attributes as $attribute) {
            $query[] = "$attribute = " . $values[$index];
            $index++;
        }

        return implode(",", $query);
    }

    /**
     * @param array $attributes
     * @return bool|DataBase
     */
    public function save($attributes = null)
    {
        if (is_null($attributes)) {
            $attributes = $this->attributes();
        }
        $querySQL = "INSERT INTO " . $this->getTableName() . " (" . implode(",", $attributes) . ") VALUES (" . implode(",", $this->valuesOf($attributes)) . ")";
        $query = $this->link->query($querySQL);

        if ($this->link->error)
            echo $this->link->error . PHP_EOL . $querySQL;

        if ($query) {
            return static::findOne($this->link->insert_id);
        }

        return null;
    }


    public function update()
    {
        $querySQL = "UPDATE " . $this->getTableName() . " SET " . $this->formatAttributesToUpdateQuery() . " WHERE id=$this->id";

        $query = $this->link->query($querySQL);
        if ($this->link->error)
            echo $this->link->error . PHP_EOL . $querySQL;

        if ($query) {
            return static::findOne($this->id);
        }

        return null;
    }


    public function findAll($condition = null)
    {
        $querySQL = "SELECT * FROM " . $this->getTableName();

        if (is_array($condition)) {
            $querySQL .= " WHERE";
            foreach ($condition as $index => $value) {
                $querySQL .= " $index = '$value'";
            }
        } elseif (is_numeric($condition)) {
            $querySQL .= " WHERE id = $condition";
        }

        $query = $this->link->query($querySQL);

        if ($this->link->error)
            echo $this->link->error . PHP_EOL . $querySQL;

        $response = [];
        if ($query->num_rows > 0) {
            while ($record = $query->fetch_assoc()) {
                foreach ($record as $key => $value) {
                    $this->$key = $value;
                }
                $response[] = clone $this;
            }
        }

        return $response;
    }

    public function findOne($condition)
    {
        $querySQL = "SELECT * FROM " . $this->getTableName();

        if (is_array($condition)) {
            $querySQL .= " WHERE";
            foreach ($condition as $index => $value) {
                $querySQL .= " $index = '$value'";
            }
        } elseif (is_numeric($condition)) {
            $querySQL .= " WHERE id = $condition";
        }

        $query = $this->link->query($querySQL);

        if ($this->link->error)
            echo $this->link->error . PHP_EOL . $querySQL;

        if ($query->num_rows > 0) {
            foreach ($query->fetch_assoc() as $key => $value) {
                $this->$key = $value;
            }

            return $this;
        }

        return null;
    }

    public function delete()
    {
        $querySQL = "DELETE FROM " . $this->getTableName() . " WHERE id= $this->id";
        $query = $this->link->query($querySQL);

        if ($this->link->error)
            echo $this->link->error . PHP_EOL . $querySQL;

        return (!empty($query));
    }

    abstract function getTableName();

    abstract function rules();
}