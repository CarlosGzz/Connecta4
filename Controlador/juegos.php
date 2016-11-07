<?php
	require "Modelo/connect.php";
	$data = $db->query("SELECT * FROM juego");
	$juegos = array();
	while($object = mysqli_fetch_object($data)){
		$juegos[]=$object;
	}
	$string = "";
	foreach ($juegos as $juego) {
		$string .= "<p>";
		$string .= $juego->user1;
		$string .= "/";
		$string .= $juego->user2;
		$string .= "</p>";
	}
	echo $string;
	//echo count($users);
?>