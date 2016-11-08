<?php
	session_start();
	require "../Modelo/connect.php";
	$token = $_SESSION['token'];

	$data = $db->query("SELECT * FROM juego WHERE user1 = '$token'");
    $juegos = array();
    while($object = mysqli_fetch_object($data)){
   		$juegos[]=$object;
    }
    $error="";
    $success = 0;

    if(mysqli_num_rows($data) != 0){
    	foreach ($juegos as $juego ) {
    		if(empty($juego->user2)){
            	borrarJuegoPorUser($token,1);
    		}else{
    			borrarJuegoPorUser($token,1);
            	crearJuego($juego->user2);
    		}
    	}
    }else{
    	$data = $db->query("SELECT * FROM juego WHERE user2 = '$token'");
    	if(mysqli_num_rows($data) != 0){
    		while($object = mysqli_fetch_object($data)){
		    	$juegos[]=$object;
		    }
		    foreach ($juegos as $juego) {
		    	borrarJuegoPorUser($token,2);
		    	crearJuego($juego->user1);
		    }
    	}
    }

	$sql = "DELETE FROM user WHERE token = '$token'" ;
	if ($db->query($sql) === TRUE) {
		// remove all session variables
		session_unset(); 
		// destroy the session 
		session_destroy(); 

		$success++;
    } else {
    	$error .= "error al borrar el usuario";
    }

    if($error = ''){
    	header('Location: ../Vista/index.php');
    }else{
    	header('Location: ../Vista/index.php?error=$error');
    }

    function borrarJuegoPorUser($id,$user){
    	require "../Modelo/connect.php";
    	if($user = 1){
    		$sql = "DELETE FROM juego WHERE user1 = '$id'" ;
    	}else{
    		$sql = "DELETE FROM juego WHERE user2 = '$id'" ;
    	}
    	if ($db->query($sql) === TRUE) {
    		$success++;
    	}else{
    		$error .= 'no se pudo borrar el juego ';
    	}
    }

    function crearJuego($id){
    	require "../Modelo/connect.php";
    	$sql = "INSERT INTO juego (user1,turno,gameOver,ganador,tablero)
                VALUES ('$id','1','0','0','')";
    	if ($db->query($sql) === TRUE) {
    		$success++;
    	}else{
    		$error .= 'no se pudo crear un juego nuevo';
    	}
    }
?>