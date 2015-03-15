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
if (empty($_REQUEST['username']) || empty($_REQUEST['ip']) || empty($_REQUEST['key']) || ! usernameExists($_REQUEST['username']) || strlen($_REQUEST['key']) !== 40 || ! ctype_alnum($_REQUEST['key']))
    exit('-1');

## Try to insert the key into the auth_key_requests table
try 
{
    $db->prepare('INSERT INTO auth_key_requests (user_id, sec_key, requested, for_ip) VALUES (:user_id, :key, :requested, :for_ip)')
       ->execute(array(
        ':user_id' => userID($_REQUEST['username']),
        ':key' => $_REQUEST['key'],
        ':requested' => time(),
        ':for_ip' => ip2long($_REQUEST['ip'])
    ));
    exit('1');
}
catch (PDOException $ex)
{
    exit('-2');
}