CREATE TABLE `auth_key_requests` (
	`user_id` INT(11) UNSIGNED NOT NULL,
	`sec_key` VARCHAR(40) NOT NULL,
	`requested` INT(11) UNSIGNED NOT NULL,
	`for_ip` INT(4) UNSIGNED NOT NULL,
	`active` ENUM('0','1') NOT NULL DEFAULT '0',
	PRIMARY KEY (`user_id`, `sec_key`)
)
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB;

CREATE TABLE `auth_sessions` (
	`session_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`user_id` INT(11) UNSIGNED NOT NULL,
	`ip_address` INT(4) UNSIGNED NOT NULL,
	`since` INT(11) UNSIGNED NOT NULL,
	`sec_key` VARCHAR(255) NOT NULL,
	PRIMARY KEY (`session_id`)
)
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB;

CREATE TABLE `auth_users` (
	`user_id` INT(11) UNSIGNED NOT NULL AUTO_INCREMENT,
	`username` VARCHAR(32) NOT NULL,
	`password` VARCHAR(250) NOT NULL COMMENT 'blowfish',
	`email` VARCHAR(250) NOT NULL,
	PRIMARY KEY (`user_id`)
)
COLLATE='latin1_swedish_ci'
ENGINE=InnoDB;