<?php

/*
 * Cubition PHP Authentication API
* Released under the MIT Licence
* Copyright 2015 - Cubition Team
*/

namespace Cubition\Auth;
use \PDO, \PDOException;

require_once __DIR__ . '/global.php';

// # Validate user input
if (empty($_GET['username']) || empty($_GET['ip']) || empty($_GET['key']) || ! usernameExists($_GET['username']) || strlen($_GET['key']) !== 40 || ! ctype_alnum($_GET['key']))
    exit('-1');

## Try to insert the key into the auth_key_requests table
try 
{
    $db->prepare('INSERT INTO auth_key_requests (user_id, sec_key, requested, for_ip) VALUES (:user_id, :key, :requested, :for_ip)')
       ->execute(array(
        ':user_id' => userID($_GET['username']),
        ':key' => $_GET['key'],
        ':requested' => time(),
        ':for_ip' => ip2long($_GET['ip'])
    ));
    exit('1');
}
catch (PDOException $ex)
{
    exit('-2');
}