<?php
	echo $_SERVER['REMOTE_ADDR'];
	$ipAddress = $_SERVER['REMOTE_ADDR'];
	$timestamp =date("Y-m-d h:i:sa");
	echo $timestamp;
/*
	include ("Modelo/connect.php");
	$sql = "INSERT INTO user (ipAddress,timestamp)
			VALUES ('$ipAdress')";
	if ($db->query($sql) === TRUE) {
		echo "1";
	} else {
		echo "<script>alert('Error:  ". $sql . "<br>" . $db->error."')</script>";
	}*/
	?>