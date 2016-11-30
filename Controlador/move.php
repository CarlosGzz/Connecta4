<?php
	header("Access-Control-Allow-Origin: *");
	require "../Modelo/connect.php";
    session_start();
    $json = array('deleted' =>
    				['status' => false, 'msg' => ''],
    			  'active' =>
    			  	['status'=>false, 'msg' => ''],
    			  'lastMove' => -1,
    			  'moveStatus' => 
    			  	['status' => false, 'msg' => ''],
    			  'error' =>
    			  	['status' => true,'msg' => array()] );

    // CHECK IF SESSION IS STARTED TO SET THE TOKEN
    if(isset($_REQUEST['token'])){
    	if(isset($_REQUEST['move'])){

		    // GLOBAL VARIABLES 
		    $token = $_REQUEST['token'];
		    $game;
		    $turnoSig = 0;
		    $invalid  = false;
		    $gameStatus = 0;
		    $move = $_REQUEST['move'];
		    // GAME AND USER CREATION
		    if(userExists()){
		    	if(userHasGame()){
		    		$json['active']['status'] = true;
		    		$json['active']['msg'] = 'Game is currently active';
		    		if($game->gameStatus == 0){
		    			if(validarMovimiento($move)){
		    				$invalid  = false;
		    				if($game->turno == 1){
		    					$turnoSig = 2;
		    					if(!checkForWinner()){
		    						if(checkTie()){
		    							$gameStatus = 3;
		    						}
			    				}else{
			    					$gameStatus = 1;
			    				}
		    				}else{
		    					$turnoSig = 1;
		    					if(!checkForWinner()){
		    						if(checkTie()){
		    							$gameStatus = 3;
		    						}
			    				}else{
			    					$gameStatus = 2;
			    				}
		    				}
		    			}else{
		    				$invalid = true;
		    				if($game->turno == 1){
		    					$gameStatus = 2;
		    				}else{
		    					$gameStatus = 1;
		    				}
		    			}
		    			updateGame($turnoSig,$invalid,$gameStatus,$move);
		    		}else{
		    		}
		    	}else{
		    		//include "terminarSession.php";
		    	}
		    }else{
		    	//include "terminarSession.php";
		    }
		}else{
			$json['error']['status'] = true;
			$json['error']['msg'] = 'No se envio el movimiento';
		}
	}else{
		$json['error']['status'] = true;
		$json['error']['msg'] = 'No se envio el token';
	}

	// FUNCTION TO SEE IF THE USER ALREADY EXISTS
	function userExists(){
		global $db,$token;
		$data = $db->query("SELECT * FROM user WHERE token ='$token' ");
		if(mysqli_num_rows($data) == 0){
			return false;
		}else{
			return true;
		}
	}

	/// FUNCTION TO SEE IF THE USER ALREADY HAS A GAME EITHER AS PLAYER 1 OR 2
	function userHasGame(){
		global $db,$token,$player,$game;
		$data = $db->query("SELECT * FROM juego WHERE user1 ='$token' OR user2 = '$token' ");
		if(mysqli_num_rows($data) == 0){
			return false;
		}else{
			$userGame = array();
			$game = mysqli_fetch_object($data);
			return true;
		}
	}
	/// FUNCTION UPDATE THE GAME 
	function updateGame($turno,$invalidMove,$gameStatus,$move){
		global $game,$db;
		addMoveToTablero($move);
		$sql = "UPDATE juego
    			SET turno = '$turno', gameStatus = '$gameStatus', tablero = '$game->tablero', lastMove = '$move' 
    			WHERE idjuego = '$game->idjuego' ";
    	if ($db->query($sql) == TRUE) {
    		//echo "Update exitoso a juego";
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

	// FUNCTION TO CHECK IF THE MOVE WINS THE GAME 
	function checkForWinner(){
		global $game,$json;
		$turno = $game->turno;
		$tablero = unserialize($game->tablero);
		//Para victorias en Horizontal
		for($fila=0;$fila<6;$fila++){
			for($colum=0;$colum<4;$colum++){
				if($tablero[$fila][$colum]==$turno && $tablero[$fila][$colum+1]==$turno && $tablero[$fila][$colum+2]==$turno && $tablero[$fila][$colum+3]==$turno){
					$json['gameStatus']['msg'] = ' Victoria Horizontal';
					return true;
				}	
			}
		}
		//Para victorias en vertical
		for ($colum=0;$colum<7;$colum++){
			for ($fila=0;$fila<4;$fila++){
				if($tablero[$fila][$colum]==$turno && $tablero[$fila+1][$colum]==$turno && $tablero[$fila+2][$colum]==$turno && $tablero[$fila+3][$colum]==$turno){
					$json['gameStatus']['msg'] = ' Victoria Vertical';
					return true;
				}
			}
		}
		//Para victorias en diagonal de izquierda a derecha
		for($fila=3;$fila<6;$fila++){
			for ($colum=0;$colum<4;$colum++){
				if($tablero[$fila][$colum]==$turno && $tablero[$fila-1][$colum+1]==$turno && $tablero[$fila-2][$colum+2]==$turno && $tablero[$fila-3][$colum+3]==$turno){
					$json['gameStatus']['msg'] = ' Victoria Diagonal de Izquierda a Derecha';
					return true;
				}
			}
		}
		//Para victorias en diagonal de derecha a izquierda
		for($fila=3;$fila<6;$fila++){
			for($colum=6;$colum>2;$colum--){
				if($tablero[$fila][$colum]==$turno && $tablero[$fila-1][$colum-1]==$turno && $tablero[$fila-2][$colum-2]==$turno && $tablero[$fila-3][$colum-3]==$turno){
					$json['gameStatus']['msg'] = ' Victoria Diagonal de Derecha a Izquierda';
					return true;
				}
			}
		}	
	}

	// FUNCTION TO CHECK IF THE GAME ENDS IN A TIE
	function checkTie(){
		global $game;
		$tablero = unserialize($game->tablero);
		$empate=true;
		for($fila=0;$fila<5;$fila++){
			for($colum=0;$colum<6;$colum++){
				if($tablero[$fila][$colum]!=1 && $tablero[$fila][$colum]!=2){
					$empate=false;
				}	
			}
		}
		return $empate;	
	}

	// FUNCTION FOR VALIDATING IF THE COUMN PICKED IS VALID
	function validarMovimiento($move){
		global $json;
		if( 0 <= $move){
			if($move <=6){
				$json['moveStatus']['status'] = true;
				$json['moveStatus']['msg'] = 'Is valid';
				return true;
			}else{
				$json['moveStatus']['status'] = false;
				$json['moveStatus']['msg'] = 'Is not valid';
				return false;
			}
		}else{
			$json['moveStatus']['status'] = false;
			$json['moveStatus']['msg'] = 'Is not valid';
			return false;
		}
	}

	// FUNCTION TO ADD MOVE TO TABLERO
	function addMoveToTablero($move){
		global $game,$json;
		$tablero = unserialize($game->tablero);
		for($fila=0; $fila<=5; $fila++){
			if($tablero[$fila][$move] == 0){
				if($game->turno == 1){
					$tablero[$fila][$move] = 1;
					break;
				}else{
					$tablero[$fila][$move] = 2;
					break;
				}
			}
		}
		$json['lastMove'] = $move;
		$game->tablero = serialize($tablero);
	}

	// RETURN
	echo json_encode($json);
	//var_dump($json);
?>