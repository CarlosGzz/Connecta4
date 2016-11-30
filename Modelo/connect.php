<?php
	$servername = "us-cdbr-iron-east-04.cleardb.net";
	$username = "b1ac66f5ee860f";
	$password = "d32eb0ea";
	$dbname = "heroku_1f1d4a73d7ba315";

	/*$servername = "localhost";
	$username = "root";
	$password = "kobyjzt";
	$dbname = "conecta4";*/

	// Create connection
	$db = new mysqli($servername, $username, $password, $dbname);
	// Check connection
	if ($db->connect_error) {
		die("Connección fallida: Lo sentimos estamos teniendo problemas" . $db->connect_error);
	}
?>
