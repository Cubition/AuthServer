<?php

/*
 * Cubition PHP Authentication API
* Released under the MIT Licence
* Copyright 2015 - Cubition Team
*/

namespace Cubition\Auth;
use \PDO, \PDOException;

require_once __DIR__ . '/global.php';

if (empty($_REQUEST['username']) || empty($_REQUEST['password']) ||
    empty($_REQUEST['email']) || usernameExists($_REQUEST['username']) ||
    strlen($_REQUEST['username']) > 16 || ! filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL) ||
    emailExists ($_REQUEST ['email'])
)
    exit('-1');

$db->prepare('INSERT INTO auth_users (username, password, email) VALUES (:username, :password, :email)')->execute(array(
    ':username' => $_REQUEST['username'],
    ':password' => crypt($_REQUEST['password'], '$2y$10$' . substr(base64_encode(openssl_random_pseudo_bytes(200)), 0, 22)),
    ':email' => $_REQUEST['email']
));

exit('1');