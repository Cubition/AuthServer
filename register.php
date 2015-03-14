<?php

/*
 * Cubition PHP Authentication API
* Released under the MIT Licence
* Copyright 2015 - Cubition Team
*/

namespace Cubition\Auth;
use \PDO, \PDOException;

require_once __DIR__ . '/global.php';

if (empty($_GET['username']) || empty($_GET['password']) || empty($_GET['email']) || usernameExists($_GET['username']) || strlen($_GET['username']) > 16 || ! filter_var($_GET['email'], FILTER_VALIDATE_EMAIL))
    exit('-1');

$db->prepare('INSERT INTO auth_users (username, password, email) VALUES (:username, :password, :email)')->execute(array(
    ':username' => $_GET['username'],
    ':password' => crypt($_GET['password'], '$2y$10$' . substr(base64_encode(openssl_random_pseudo_bytes(200)), 0, 22)),
    ':email' => $_GET['email']
));

exit('1');