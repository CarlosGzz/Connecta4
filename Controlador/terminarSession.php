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
        //echo "es jugador 1";
    	foreach ($juegos as $juego ) {
    		if(empty($juego->user2)){
                //echo "no tiene jugador 2 el juego";
            	borrarJuegoPorUser($juego->idjuego,1,$success,$error);
    		}else{
                //echo "Si tiene jugador 2 el juego";
    			borrarJuegoPorUser($juego->idjuego,1,$success,$error);
            	crearJuego($juego->user2,$success,$error);
    		}
    	}
    }else{
        //echo "es jugador 2";
    	$data = $db->query("SELECT * FROM juego WHERE user2 = '$token'");
    	if(mysqli_num_rows($data) != 0){
    		while($object = mysqli_fetch_object($data)){
		    	$juegos[]=$object;
		    }
		    foreach ($juegos as $juego) {
                //echo "hola";
		    	borrarJuegoPorUser($juego->idjuego,2,$success,$error);
		    	crearJuego($juego->user1,$success,$error);
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
        //echo "deberia haber salido bien ";
    	header('Location: ../Vista/index.php');
    }else{
        //echo $error;
        header('Location: ../Vista/index.php?error=$error');
    }

    function borrarJuegoPorUser($id,$user,$success,$error){
    	require "../Modelo/connect.php";
    	$sql = "DELETE FROM juego WHERE idjuego = '$id'" ;
    	if ($db->query($sql) === TRUE) {
    		$success++;
            //echo "si se pudo borrar el juego para".$id;
    	}else{
    		$error .= 'no se pudo borrar el juego ';
            //echo "error no se pudo borrar el juego para".$id;
    	}
    }

    function crearJuego($id,$success,$error){
    	require "../Modelo/connect.php";
    	$sql = "INSERT INTO juego (user1,turno,gameOver,ganador,tablero)
                VALUES ('$id','1','0','0','')";
    	if ($db->query($sql) === TRUE) {
    		$success++;
            //echo "se creo el juego para el jugardor ".$id;
    	}else{
    		$error .= 'no se pudo crear un juego nuevo';
            //echo "error no se pudo crear el juego para el jugador".$id;
    	}
    }
?>