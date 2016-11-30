<?php
    require "../Modelo/connect.php";
    session_start();
    $json = array('token'=>'','player'=>0,'error'=>['status'=>false,'msg'=>array()]);

    // CHECK IF SESSION IS STARTED TO SET THE TOKEN
    if(isset($_SESSION['token'] )){
    	$json['error']['status'] = true;
    	array_push( $json['error']['msg'], ['Error la sesion ya esta iniciada con '.$_SESSION['token']] ) ;
    }else{
    	$_SESSION['token'] = 'user'.md5(uniqid(rand(), true));
    }

    // GLOBAL VARIABLES 
    $token = $_SESSION['token'];
    $player;
    $idJuego;

    // GAME AND USER CREATION
    if(userExists()){
    	$json['error']['status'] = true;
    	array_push( $json['error']['msg'], ['Error ya existe el usuario'] );
    	if(userHasGame()){
    		array_push( $json['error']['msg'], ['Error el usuario ya tiene juego'] );
    	}else{
    		if(player2IsNullInGame()){
    			insertUser2InGame();
    		}else{
    			createGame();
    		}
    	}
    }else{
    	createUser();
    }

    // PLAYER SET FOR JSON
	if($player == 1){
		$json['token'] = $token ;
		$json['player'] = 1;
	}else{
		if($player == 2){
			$json['token'] = $token ;
			$json['player'] = 2;
		}
	}	

	// FUNCTION TO SEE IF THE USER ALREADY EXISTS
	function userExists(){
		global $db,$token,$player;
		$data = $db->query("SELECT * FROM user WHERE token ='$token' ");
		if(mysqli_num_rows($data) == 0){
			return false;
		}else{
			return true;
		}
	}
	// FUNCTION TO SEE IF THERE IS A GAME IN WHICH THE PLAYER 2 IS NOT YET SET
	function player2IsNullInGame($value=''){
		global $db,$idJuego;
		$data = $db->query("SELECT * FROM juego WHERE user2 IS NULL");
		if(mysqli_num_rows($data) == 0){
			return false;
		}else{
			$juego = mysqli_fetch_assoc($data);
			$idJuego = $juego['idjuego'];
			return true;
		}
	}
	// FUNCTION TO SEE IF THE USER ALREADY HAS A GAME EITHER AS PLAYER 1 OR 2
	function userHasGame(){
		global $db,$token,$player;
		$data = $db->query("SELECT * FROM juego WHERE user1 ='$token' OR user2 = '$token' ");
		if(mysqli_num_rows($data) == 0){
			return false;
		}else{
			$userGame = array();
			while($object = mysqli_fetch_object($data)){
				$userGame[]=$object;
			}
			if($userGame[0]->user1 == $token){
				$player = 1;
			}else{
				if($userGame[0]->user2 == $token){
					$player = 2;
				}
			}
			return true;
		}
	}

	// FUNCTION TO CREATE USER
	function createUser(){
		global $db,$token;
		$timestamp = date("Y-m-d h:i:s");

		$sql = "INSERT INTO user (token,diaHora)
    			VALUES ('$token','$timestamp')";
    	if ($db->query($sql) === TRUE) {
    		if(player2IsNullInGame()){
    			insertUser2InGame();
		    }else{
		    	createGame();
		    }
    	} else {
    		jsonErrorPush($sql,$db->error);
    		if(userExists()){
    			deleteUser();
    		}
    	}
	}

	// FUNCTION TO DELETE USER
	function deleteUser(){
		global $db,$token;
		$sql = "DELETE FROM user WHERE token = '$token' " ;
    	if($db->query($sql) === TRUE){
    		//echo 'Usuario eliminado correctamente';
    	}else{
    		jsonErrorPush($sql,$db->error);
    		deleteGame();
    		session_unset();
    		session_destroy();
    	}
	}

	// FUNCTION TO CREATE GAME
	function createGame(){
		global $db,$token;
		$timestamp = date("Y-m-d h:i:s");
		$tableroNuevo = serialize([[0,0,0,0,0,0,0],[0,0,0,0,0,0,0],[0,0,0,0,0,0,0],[0,0,0,0,0,0,0],[0,0,0,0,0,0,0],[0,0,0,0,0,0,0]]);
		//var_dump($tableroNuevo);
		$sql = "INSERT INTO juego (user1,turno,invalidMove,gameStatus,tablero,lastMove,updateAt,createdAt)
    			VALUES ('$token','1','false','0','$tableroNuevo','-1','$timestamp','$timestamp')";
    	if ($db->query($sql) === TRUE) {
    		userHasGame();
    	} else {
    		jsonErrorPush($sql,$db->error);
    	}
	}

	// FUNCTION TO DELETE GAME
	function deleteGame(){
		global $db,$token;
		$sql = "DELETE FROM juego WHERE user1 = '$token' OR user2 = '$token' " ;
    	if($db->query($sql) === TRUE){
    		//echo 'Usuario eliminado correctamente';
    	}else{
    		jsonErrorPush($sql,$db->error);
    		deleteUser();
    	}
	}

	// FUNCTION TO INSERT USER IN GAME AS PLAYER 2
	function insertUser2InGame(){
		global $db,$token,$idJuego;
		$timestamp = date("Y-m-d h:i:s");
		$sql = "UPDATE juego
    			SET user2 = '$token'
    			WHERE idjuego = '$idJuego' ";
    	if ($db->query($sql) == TRUE) {
    		//echo "Unido exitosamente a juego";
    		userHasGame();
    	} else {
    		jsonErrorPush($sql,$db->error);
    	}
	}

	// FUNCTION TO ADD MSG ERRORS FROM QUERY ERRORS
	function jsonErrorPush($sql, $error){
		global $json;
		$json['status'] = true;
		array_push( $json['error']['msg'], ['Error'.$sql.'<br>'.$error] );
	}

	// RETURN
	$_SESSION['player'] = $player;
	echo json_encode($json);
	//var_dump($json);
?>