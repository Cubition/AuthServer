<?php

/*
 * Cubition PHP Authentication API
* Released under the MIT Licence
* Copyright 2015 - Cubition Team
*/

namespace Cubition\Auth;
use \PDO, \PDOException;

require_once __DIR__ . '/global.php';

if (empty($_POST['username']) || empty($_POST['password']) ||
    empty($_POST['email']) || usernameExists($_POST['username']) ||
    strlen($_POST['username']) > 16 || ! filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) ||
    emailExists ($_POST ['email'])
)
    exit('-1');

$db->prepare('INSERT INTO auth_users (username, password, email) VALUES (:username, :password, :email)')->execute(array(
    ':username' => $_POST['username'],
    ':password' => crypt($_POST['password'], '$2y$10$' . substr(base64_encode(openssl_random_pseudo_bytes(200)), 0, 22)),
    ':email' => $_POST['email']
));

exit('1');