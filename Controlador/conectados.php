<?php
	require "../Modelo/connect.php";
	$data = $db->query("SELECT * FROM user");
	$users = array();
	while($object = mysqli_fetch_object($data)){
		$users[]=$object;
	}
	$string = "";
	foreach ($users as $user) {
		$string .= "<p>";
		$string .= $user->token;
		$string .= "/";
		$string .= $user->diaHora;
		$string .= "";
		$string .= "</p>";
	}
	//echo $string;
	echo json_encode($users);
?>