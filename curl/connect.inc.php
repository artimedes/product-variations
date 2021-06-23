<?php
$CONFIG_database_mysqli	= "";
$CONFIG_host_mysqli	 	= "localhost";
$CONFIG_username_mysqli = "";
$CONFIG_password_mysqli = "";

$mysqli = new mysqli($CONFIG_host_mysqli, $CONFIG_username_mysqli, $CONFIG_password_mysqli, $CONFIG_database_mysqli);
$mysqli->set_charset("utf8");

if (mysqli_connect_errno()) {
	printf("Connect failed: %s\n", mysqli_connect_error());
	exit();
}
?>