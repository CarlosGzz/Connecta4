<?php
	require "../Modelo/connect.php";
    session_start();
    $json = array('deleted' =>
    				['status' => false, 'msg' => ''],
    			  'active' =>
    			  	['status'=>false, 'msg' => ''],
    			  'invalidMove' => false,
    			  'gameStatus' => 
    			  	['status' => 0, 'msg' => ''],
    			  'gameBoard'=> array(),
    			  'turn' =>
    			  	['status'=>false,'msg' => ''],
    			  'lastMove' => -1,
    			  'error' =>
    			  	['status' => false,'msg' => array()] );


    // CHECK IF SESSION IS STARTED TO SET THE TOKEN
    if(isset($_SESSION['token'] )){

	    // GLOBAL VARIABLES 
	    $token = $_SESSION['token'];
	    $player = $_SESSION['player'];
	    $game;

	    // GAME AND USER CREATION
	    if(userExists()){
	    	if(userHasGame()){
	    		$json['active']['status'] = true;
	    		$json['active']['msg'] = 'Game is currently active';
	    		if(!empty($game->invalidMove)){
	    			$json['invalidMove'] = true;
	    		}
	    		gameStatusMsg($game->gameStatus);
	    		//var_dump(unserialize($game->tablero));
	    		$json['gameBoard'] = unserialize($game->tablero);
	    		if($game->turno == $player){
	    			$json['turn']['status'] = true;
	    			$json['turn']['msg'] = 'Es tu Turno';
	    		}else{
	    			$json['turn']['status'] = false;
	    			$json['turn']['msg'] = 'No es tu Turno';
	    		}
	    		$json['lastMove'] = $game->lastMove;
	    	}else{
	    		$json['active']['status'] = false;
	    		$json['active']['msg'] = 'Waiting for player2';
	    	}
	    }else{
	    	$json['deleted']['status'] = true;
	    	$json['deleted']['msg'] = 'Error user no longer exists';
	    }
	}else{
		array_push( $json['error']['msg'], ['Error no existe sesion con token del usuario'] );
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

	// FUNCTION TO SEE IF THE USER ALREADY HAS A GAME EITHER AS PLAYER 1 OR 2
	function userHasGame(){
		global $db,$token,$player,$game;
		$data = $db->query("SELECT * FROM juego WHERE user1 ='$token' AND user2 != '' OR user2 = '$token' AND user2 != '' ");
		if(mysqli_num_rows($data) == 0){
			return false;
		}else{
			$userGame = array();
			$game = mysqli_fetch_object($data);
			return true;
		}
	}

	// FUNCTION TO SET THE GAME STATUS AND MESSAGE
	function gameStatusMsg($status){
		global $json;
		$json['gameStatus']['status'] = $status;
		switch ($status) {
			case 0:
				$json['gameStatus']['msg'] = 'El juego Sigue';
				break;
			case 1:
				$json['gameStatus']['msg'] = 'Jugador 1 ganó';
				break;
			case 2:
				$json['gameStatus']['msg'] = 'Jugador 2 ganó';
				break;
			case 3:
				$json['gameStatus']['msg'] = 'Empate';
				break;
			default:
				$json['gameStatus']['msg'] = 'Error de estatus';
				break;
		}
	}

	// RETURN
	echo json_encode($json);
	//var_dump($json);
?>