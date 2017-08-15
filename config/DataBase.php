<?php

namespace config;

use mysqli;

/**
 * Class DataBase
 * @package config
 * Core for every connection in the database
 */
abstract class DataBase
{
    protected $link;
    private $config;

    /**
     * DataBase constructor.
     * Import config file
     */
    public function __construct()
    {
        $this->config = include("main.php");
        $this->link = new mysqli($this->config['db']['host'], $this->config['db']['user'], $this->config['db']['password'], $this->config['db']['database']);

        if ($this->link->connect_errno > 0) {
            die('Unable to connect to database [' . $this->link->connect_error . ']');
        }
    }

    /**
     * Load the model attributes based on the rules role
     * @param array $from
     * @return bool
     */
    public function load($from = [])
    {
        $post = $_POST;
        if (!empty($from))
            $post = $from;

        $continue = true;
        $required = $this->getSpecifyRule('required');
        foreach ($this->attributes() as $attribute) {
            if (isset($post[$attribute])) {
                $this->$attribute = $post[$attribute];

                if (in_array($attribute, $required) && $post[$attribute] == '')
                    $continue = false;
            } else {
                if (in_array($attribute, $required))
                    $continue = false;
            }
        }

        return $continue;
    }

    /**
     * Auxiliary function to get a specific rule
     * @param $name
     * @return array
     */
    private function getSpecifyRule($name)
    {
        $fields = [];
        foreach ($this->rules() as $rule) {
            if ($rule[1] == $name) {
                $fields = $rule['0'];
            }
        }
        return $fields;
    }

    /**
     * Get all the model attributes
     * @param bool $toSave
     * @return array
     */
    private function attributes($toSave = false)
    {
        $class = new \ReflectionClass($this);
        $names = [];
        $relation = $this->getSpecifyRule('relation');
        foreach ($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
            if (!$property->isStatic() && !$property->isProtected()) {
                if ($toSave && (in_array($property->getName(), $relation) || $property->getValue($this) === ''))
                    continue;

                $names[] = $property->getName();
            }
        }

        return $names;
    }

    /**
     * Check each rule for each the model attribute
     * @param $attribute
     * @return string
     */
    private function validate($attribute)
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

    /**
     * Get values according the model attributes
     * @param $attributes
     * @return array
     */
    private function valuesOf($attributes)
    {
        $values = [];
        foreach ($attributes as $attribute) {
            $values[] = $this->validate($attribute);
        }

        return $values;
    }

    /**
     * Auxiliary function to build query for update event
     * @return string
     */
    private function formatAttributesToUpdateQuery()
    {
        $query = [];
        $attributes = $this->attributes(true);
        $values = $this->valuesOf($attributes);
        $index = 0;
        foreach ($attributes as $attribute) {
            $query[] = "$attribute = " . $values[$index];
            $index++;
        }

        return implode(",", $query);
    }

    /**
     * Save the model
     * @param null $attributes
     * @return DataBase|null
     */
    public function save($attributes = null)
    {
        $this->beforeSave();

        if (is_null($attributes)) {
            $attributes = $this->attributes(true);
        }
        $querySQL = "INSERT INTO " . $this->getTableName() . " (" . implode(",", $attributes) . ") VALUES (" . implode(",", $this->valuesOf($attributes)) . ")";
        $query = $this->link->query($querySQL);


        if (DEBUG)
            var_dump($querySQL);

        if ($this->link->error)
            echo $this->link->error . PHP_EOL . $querySQL;

        if ($query) {
            $model = static::findOne($this->link->insert_id);
            if (method_exists($this, 'afterSave')) {
                call_user_func_array(array($this, 'afterSave'), [true]);
            } else {
                $this->afterSave(true);
            }

            return $model;
        }

        return null;
    }

    /**
     * Update the model
     * @return DataBase|null
     */
    public function update()
    {
        $this->beforeSave();

        $querySQL = "UPDATE " . $this->getTableName() . " SET " . $this->formatAttributesToUpdateQuery() . " WHERE id=$this->id";

        $query = $this->link->query($querySQL);

        if (DEBUG)
            var_dump($querySQL);

        if ($this->link->error)
            echo $this->link->error . PHP_EOL . $querySQL;

        if ($query) {
            $model = static::findOne($this->id);

            if (method_exists($this, 'afterSave')) {
                call_user_func_array(array($this, 'afterSave'), [false]);
            } else {
                $this->afterSave(false);
            }

            return $model;
        }

        return null;
    }

    /**
     * Find all models based on the conditions
     * @param null $condition
     * @param bool $isManuelQuery
     * @return array
     */
    public function findAll($condition = null, $isManuelQuery = false)
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

        if ($isManuelQuery)
            $querySQL .= $condition;

        $query = $this->link->query($querySQL);

        if (DEBUG)
            var_dump($querySQL);

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

    /**
     * Find one model based on the conditions
     * @param $condition
     * @param bool $isManuelQuery
     * @return $this|null
     */
    public function findOne($condition, $isManuelQuery = false)
    {
        $querySQL = "SELECT * FROM " . $this->getTableName();

        if (is_array($condition)) {
            $querySQL .= " WHERE";
            $count = count($condition);
            foreach ($condition as $index => $value) {
                $querySQL .= " $index = '$value'";

                if ($count > 1)
                    $querySQL .= " AND";

                $count--;
            }
        } elseif (is_numeric($condition)) {
            $querySQL .= " WHERE id = $condition";
        }

        if ($isManuelQuery)
            $querySQL .= $condition;

        $query = $this->link->query($querySQL);

        if (DEBUG)
            var_dump($querySQL);

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

    /**
     * Find all models based on the conditions using query
     * @param $querySQL
     * @return array
     */
    public function findAllBySql($querySQL)
    {
        $query = $this->link->query($querySQL);

        if (DEBUG)
            var_dump($querySQL);

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

    /**
     * Find one model based on the conditions using query
     * @param $querySQL
     * @param bool $isManuelQuery
     * @return $this|null
     */
    public function findOneBySql($querySQL, $isManuelQuery = false)
    {
        $query = $this->link->query($querySQL);

        if (DEBUG)
            var_dump($querySQL);

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

    /**
     * Delete model selected
     * @return bool
     */
    public function delete()
    {
        $querySQL = "DELETE FROM " . $this->getTableName() . " WHERE id= $this->id";
        $query = $this->link->query($querySQL);

        if (DEBUG)
            var_dump($querySQL);

        if ($this->link->error)
            echo $this->link->error . PHP_EOL . $querySQL;

        return (!empty($query));
    }

    /**
     * Handles model before the save event
     */
    public function beforeSave()
    {
    }

    /**
     * Handles model after the save event
     * @param $insert
     */
    public function afterSave($insert)
    {
    }

    /**
     * Get the table name from the model
     * @return mixed
     */
    abstract function getTableName();

    /**
     * Get the model rules
     * @return mixed
     */
    abstract function rules();
}