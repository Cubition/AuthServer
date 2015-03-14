<?php

/*
 * Cubition PHP Authentication API
 * Released under the MIT Licence
 * Copyright 2015 - Cubition Team
 */

namespace Cubition\Auth;
use \PDO, PDOException;

// # Set the Content-type header to plaintext
header ('Content-type: text/plain; charset=utf-8');

define('BASEDIR', realpath(__DIR__));

## REGION functions ##
{
    // # Error Function
    function printError($text, $code = -1)
    {
        exit('[Cubition PHPAuth] Error' . ($code > - 1 ? ' #' . $code : '') . ':'. PHP_EOL . $text . PHP_EOL);
    }
    
    function usernameExists($username)
    {
        global $db;
        $query = $db->prepare('SELECT 0 FROM auth_users WHERE username = :username LIMIT 1');
        $query->execute(array(
            ':username' => $username
        ));
        return $query->rowCount() == 1;
    }
    
    function userID($username)
    {
        global $db;
        $query = $db->prepare('SELECT user_id FROM auth_users WHERE username = :username LIMIT 1');
        $query->execute(array(
            ':username' => $username
        ));
        $result = $query->fetch(\PDO::FETCH_NUM);
        return $result == null ? null : $result[0];
    }
    
    function userPassHash($username)
    {
        global $db;
        $query = $db->prepare('SELECT password FROM auth_users WHERE username = :username LIMIT 1');
        $query->execute(array(
            ':username' => $username
        ));
        $result = $query->fetch(\PDO::FETCH_NUM);
        return $result == null ? null : $result[0];
    }
}

## REGION connection ##
{
    // # Load the configuration file
    (@include_once BASEDIR . '/config.php')
    || printError ('The configuration file config.php> appears to be missing.', 1);
    
    // # Check if pdo_mysql is installed
    extension_loaded('pdo_mysql')
    || printError ('The pdo_mysql extension, which is required for Cubition PHPAuth to run, appears missing. Please check your PHP.ini.', 2);
    
    // # Set up the MySQL connection using PDO
    try {
        $db = new PDO('mysql:host=' . $mysqlHost . ';dbname=' . $mysqlDB, $mysqlUser, $mysqlPass);
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $ex) {
        printError('Cannot connect to the specified MySQL host (<kbd>' . $mysqlHost . '</kbd>)', 3);
    }
    
    // # Destroy the MySQL login credentials
    unset ($mysqlHost, $mysqlDB, $mysqlUser, $mysqlPass);
}