SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO"; 

CREATE TABLE IF NOT EXISTS `cub_sessions` (
  `session_id` bigint(11) unsigned NOT NULL AUTO_INCREMENT,
  `uuid` varchar(255) NOT NULL,
  `sec_key` varchar(255) NOT NULL,
  `ip_address` varchar(20) NOT NULL,
  `logged_in` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`session_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;

CREATE TABLE IF NOT EXISTS `cub_users` (
  `uuid` varchar(255) NOT NULL,
  `password_hash` varchar(255) NOT NULL,
  `email_address` varchar(255) NOT NULL,
  `last_login` int(11) NOT NULL,
  UNIQUE KEY `uuid` (`uuid`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;
