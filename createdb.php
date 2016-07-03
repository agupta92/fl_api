<?php
include ('database.php');

////////////////QUERY 1////////////////
$sql_user_details = "CREATE TABLE IF NOT EXISTS `user_details` (
  `user_id` int(10) unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `user_name` varchar(100) DEFAULT NULL,
  `user_email` varchar(100) NOT NULL,
  `user_skype_id` varchar(100) DEFAULT NULL,
  `user_contact_no` int(10) unsigned DEFAULT NULL,
  `user_password` varchar(100) NOT NULL,
  `user_linkedin` varchar(255) DEFAULT NULL,
  `user_github` varchar(255) DEFAULT NULL,
  `user_stackoverflow` varchar(255) DEFAULT NULL,
  `user_degree` varchar(100) DEFAULT NULL,
  `user_college` varchar(100) NOT NULL,
  `user_type` enum('employee','employer') NOT NULL,
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
";
$query = $mysqli->query($sql_user_details);
var_dump($query);
$sql_session_table = "CREATE TABLE IF NOT EXISTS `user_session` (
  `user_session_id` int(10) unsigned NOT NULL PRIMARY KEY AUTO_INCREMENT,
  `user_id` int(10) unsigned NOT NULL,
  `user_session` varchar(100) NOT NULL,
  `is_active` enum('Yes','No') NOT NULL DEFAULT 'Yes',
  `created_at` datetime NOT NULL,
  `updated_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8";
$query = $mysqli->query($sql_session_table);
var_dump($query);exit;
?>