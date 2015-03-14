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
if (empty($_POST['username']) || empty($_POST['ip']) || empty($_POST['key']) || ! usernameExists($_POST['username']) || strlen($_POST['key']) !== 40 || ! ctype_alnum($_POST['key']))
    exit('-1');

## Try to insert the key into the auth_key_requests table
try 
{
    $db->prepare('INSERT INTO auth_key_requests (user_id, sec_key, requested, for_ip) VALUES (:user_id, :key, :requested, :for_ip)')
       ->execute(array(
        ':user_id' => userID($_POST['username']),
        ':key' => $_POST['key'],
        ':requested' => time(),
        ':for_ip' => ip2long($_POST['ip'])
    ));
    exit('1');
}
catch (PDOException $ex)
{
    exit('-2');
}