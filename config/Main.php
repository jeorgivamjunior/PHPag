<?php

namespace config;

/**
 * Class Main
 * @package config
 * Handles system settings
 */
class Main
{
    /**
     * Database information
     */
    public static $db = [
        'user' => 'root',
        'password' => 'root',
        'host' => 'localhost',
        'database' => 'PHPag'
    ];
    /**
     * System information
     */
    public static $general = [
        /**
         * Use it to redirect the user to right directory
         * Fill in the name of the project directory
         */
        'dirBase' => 'PHPag',
        /**
         * Enable it to display erros and executed queries
         */
        'debug' => true
    ];
}