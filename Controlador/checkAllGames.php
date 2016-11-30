<?php
	require "../Modelo/connect.php";
	$data = $db->query("SELECT j.idjuego, u1.token as user1, u2.token as user2, j.updateAt, j.createdAt FROM juego as j INNER JOIN user as u1 ON j.user1 = u1.token LEFT JOIN user as u2 ON j.user2 = u2.token");
	$juegos = array();
	while($object = mysqli_fetch_object($data)){
		$juegos[]=$object;
	}
	foreach ($juegos as $juego) {
		$update = date_create($juego->updateAt);
		$create = date_create($juego->createdAt);
		$dif = date_diff($update,$create);
		if($dif->h > 0){
			if ($dif->i > 30) {
				 header("Location: terminarJuego.php?token=".$juego->user1);
			}
		}
	}
	var_dump($juegos);

	//echo json_encode($juegos);
?>