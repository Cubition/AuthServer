<?php

/*
* Cubition PHP Authentication API
* Released under the MIT Licence
* Copyright 2015 - Cubition Team
*/

## Make sure there is a configuration file.
(@include_once (__DIR__ .'/config.inc.php'))
|| exit ('<b>[Cubtion PHPAuth]</b> Error #1: Could not find configuraiton file <kbd>config.inc.php</kbd>. <a href="https://github.com/Cubition/AuthServer/wiki/Common-errors#error-1-configuration-file-not-found">Click here for more information.</a>');

## Make sure the MySQL driver for PDO is installed.
extension_loaded('pdo_mysql')
|| exit ('<b>[Cubtion PHPAuth]</b> Error #2: The PDO-MySQL extension has not been loaded. <a href="https://github.com/Cubition/AuthServer/wiki/Common-errors#error-2-pdo-mysql-driver-not-found">Click here for more information.</a>');

## Establish connection with the database
$db = @new PDO ('mysql:host='. $mysql_host .';dbname='. $mysql_database, $mysql_username, $mysql_password)
|| exit ('<b>[Cubition PHPAuth]</b> Error #3: Cubition PHPAuth could not connect to the configured MySQL server. Check your configuration in <kbd>config.inc.php</kbd>.');

## Define a constant for $mysql_table_prefix for easier and global use.
define ('TBL_PR', $mysql_table_prefix);

## Unset the MySQL server credentials, they are no longer needed.
unset ($mysql_host, $mysql_username, $mysql_password, $mysql_database, $mysql_table_prefix);

## Check whether the user table exists or not
$db->exec ("SHOW TABLES LIKE '".TBL_PR  ."users'") > 0
|| exit ('<b>[Cubition PHPAuth]</b> Error #3: There is no table called <kbd>'. TBL_PR .'users</kbd> found in your database. Have you not yet <a href="https://github.com/Cubition/AuthServer/wiki/Installation#step-3-upload-database">uploaded the database</a>?');
