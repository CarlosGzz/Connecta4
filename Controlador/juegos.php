<?php
	require "../Modelo/connect.php";
	$data = $db->query("SELECT j.idjuego, u1.nombreUser as user1, u2.nombreUser as user2, j.turno, j.gameOver, j.ganador, j.tablero  FROM juego as j INNER JOIN user as u1 ON j.user1 = u1.token LEFT JOIN user as u2 ON j.user2 = u2.token");
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
	//echo $string;
	echo json_encode($juegos);
?>