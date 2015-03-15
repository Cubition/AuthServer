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
if (empty($_REQUEST['username']) || empty($_REQUEST['password']) || strlen($_REQUEST['username']) > 16)
    exit('-1');

// # Prepare & Execute the is-there-such-a-user query
$query = $db->prepare('SELECT user_id FROM auth_users WHERE username = :username AND password = :password LIMIT 1');
$query->execute(array(
    ':username' => $_REQUEST['username'],
    ':password' => crypt($_REQUEST['password'], userPassHash($_REQUEST['username']))
));

// # If there is no such user, #ragequit
if ($query->rowCount() == 0)
       exit ('-1');

// # Get the user ID
$result = $query->fetch (PDO::FETCH_NUM);
$id = $result[0];

// # Select the key from the auth_key_requests table
$query = $db->prepare ('SELECT sec_key FROM auth_key_requests WHERE user_id = :user_id AND for_ip = :for_ip LIMIT 1');
$query->execute (array (
    ':user_id' => $id,
    ':for_ip' => ip2long ($_SERVER ['REMOTE_ADDR'])
));

// # If there is no key set by any server
if ($query->rowCount () == 0)
    exit ('-2');

// # Output the key
$result = $query->fetch (PDO::FETCH_NUM);
$key = $result[0];

// # Remove the key from the aut_key_requests table
$db->prepare('DELETE FROM auth_key_requests WHERE sec_key = :key')
   ->execute(array (
       ':key' => $key
   ));

exit ($key);