var token;
var jugador;
var turno = 1;
var tablero = [[0,0,0,0,0,0,0],[0,0,0,0,0,0,0],[0,0,0,0,0,0,0],[0,0,0,0,0,0,0],[0,0,0,0,0,0,0],[0,0,0,0,0,0,0]];
var juego = 0;
var status;

// Crear nuevo Juego
window.onload = function newGame(){
	$.ajax({
        // url: 'Controlador/newGame.php',
        url: 'http://172.30.137.23/peliculas/odata/Juego',
        method: 'POST',
        success: function(json){
            /* Mi metodo
            var newGame = jQuery.parseJSON(json);
            token = newGame.token;
            token = newGame.id;
            */
            /* Integracion de Edgar */
            var newGame = JSON.parse(json.value);
            token = newGame.id;
            juego = newGame.juego;
            /* Integracion de Edgar */
            console.log(newGame);
            jugador = newGame.player;
            if (jugador == 1){
            	$('#player').append("<font color='blue'> "+jugador+"</font>");
            }else{
            	$('#player').append("<font color='red'> "+jugador+"</font>");
            }
            turno == 1;
        }
    });
}

// Checar el estatus del juego
/* Mi integracion
var checkGame = setInterval(checkGame, 1000);
function checkGame(){
	$.ajax({
        url: 'Controlador/checkGame.php',
        method: 'POST',
        success: function(json){
            var game = jQuery.parseJSON(json);
            //console.log(game);
            if(!game.deleted.status){
            	if(game.active.status){
            		$('#stats').empty();
            		tablero = game.gameBoard;
            		//console.log(game.gameStatus.status);
            		switch(parseInt(game.gameStatus.status)) {
					    case 0:
					    	if(game.turn){
					    		setTimeout(time(),10000);
				            	movimiento();
				            }else{
				            	//espero
				            }
					        $('#stats').append(game.gameStatus.msg);
					        break;
					    case 1:
					        $('#stats').append(game.gameStatus.msg);
					        setTimeout(time(),10000);
					        alertEnd(game.gameStatus.msg);
					        break;
					    case 2:
					        $('#stats').append(game.gameStatus.msg);
					        setTimeout(time(),10000);
					        alertEnd(game.gameStatus.msg);
					        break;
					    case 3:
					        $('#stats').append(game.gameStatus.msg);
					        setTimeout(time(),10000);
					        alertEnd(game.gameStatus.msg);
					        break;
					    default:
					        $('#stats').append('Error');
					}
            	}
            }
        }
    });
}*/

/* Integracion de Edgar en checkGame*/
var checkGame = setInterval(checkGame, 6000);
function checkGame(){
	$.ajax({
		url: 'http://172.30.137.23/peliculas/odata/Juego('+juego+')',
		method: 'GET',
		success: function(json){
			var game = jQuery.parseJSON(json.value);
            console.log(game.status);
            status = game.status;
            $('#stats').empty();
            switch(parseInt(game.status)) {
            	case 1:
            		if(game.turn){
            			//setTimeout(time(),10000);
            			movimiento();
            		}else{
				            	//espero
				        agregarMovimientoATablero(game.lastMove);
		            }
		            $('#stats').append(game.status.msg);
		            break;
	           	case 2:
	            	$('#stats').append(game.status.msg);
	            	setTimeout(time(),10000);
	            	alertEnd(game.status.msg);
	            	break;
	            case 3:
	            	$('#stats').append(game.status.msg);
	            	setTimeout(time(),10000);
	            	alertEnd(game.status.msg);
	            	beak;
	            case 4:
	            	$('#stats').append(game.status.msg);
	            	setTimeout(time(),10000);
	            	alertEnd(game.status.msg);
	            	break;
	            default:
	            	$('#stats').append('Error');
		        }
		    }
	});
}
function movimiento(){
	var fila=0;
	var num=0;
	//alert(token);
	var columna = chooseColumn();
	turno++;
	/// UNA VEZ QUE DECIDAS LA COLUMNA HACES EL AJAX 
	$.ajax({
		url: 'http://172.30.137.23/peliculas/odata/Juego',
		method: 'PUT',
		data: {status:status, turno:turno, lastMove:columna},
		success: function(json){
			var move = jQuery.parseJSON(json.value);
			console.log(move);
			if(!move.deleted.status){
				if(move.active.status){
					if(move.moveStatus.status){
						if (turno == 1){
							$('#moves').append("<p>jugador 1 coloco ficha en "+(parseInt(move.lastMove)+1)+"</p>");
						}else{
							$('#moves').append("<p>jugador 2 coloco ficha en "+(parseInt(move.lastMove)+1)+"</p>");
						}
		            	colorearTablero();
		            }else{
		            	alert(move.moveStatus.msg);
		            }
		        }
		    }
		    if(turno == 1){
				turno++;
				console.log(turno);
			}else{
				turno--;
				console.log(turno);
			}
		}
	});
};
/* Integracion de Edgar en checkGame*/

function movimiento(){
	var fila=0;
	var num=0;
	//alert(token);
	var columna = chooseColumn();
	/// UNA VEZ QUE DECIDAS LA COLUMNA HACES EL AJAX 
	$.ajax({
		url: 'Controlador/move.php',
		method: 'GET',
		data: {token:token, move:columna},
		success: function(json){
			var move = jQuery.parseJSON(json);
			//console.log(move);
			if(!move.deleted.status){
				if(move.active.status){
					if(move.moveStatus.status){
						if (turno == 1){
							$('#moves').append("<p>jugador 1 coloco ficha en "+(parseInt(move.lastMove)+1)+"</p>");
						}else{
							$('#moves').append("<p>jugador 2 coloco ficha en "+(parseInt(move.lastMove)+1)+"</p>");
						}
		            	colorearTablero();
		            }else{
		            	alert(move.moveStatus.msg);
		            }
		        }
		    }
		    if(turno == 1){
				turno++;
			}else{
				turno--;
			}
		}
	});
};
var colorGame = setInterval(colorearTablero, 1000);
function colorearTablero(){
	var fila = 0;
	var columna = 0;
	for(fila=0; fila<6; fila++){
		for(columna=0; columna<7; columna++){
			if(tablero[fila][columna] == 1 ){
				document.getElementById(fila+","+columna).style.backgroundColor = "blue";
			}
			if(tablero[fila][columna] == 2 ){
				document.getElementById(fila+","+columna).style.backgroundColor = "red";
			}
		}
	}
}

function getRandomInt(min, max) {
	min = Math.ceil(min);
	max = Math.floor(max);
	return Math.floor(Math.random() * (max - min)) + min;
}


function chooseColumn(){
	var conteo=0;

	columna = getRandomInt(0,7);

	for(fila=0;fila<6;fila++){
		if(tablero[fila][columna]==0){
			return columna;
		}
		else{
			conteo++;
			if(conteo==6){
				chooseColumn();
			}
		}
	}
}

function time(){
	var contador=0;
	for (var i =0; i < 100000000; i++) {
		if (contador == 0)
			contador++;
		else
			contador--;
	}
}
function alertEnd(mensaje){
	setTimeout(time(), 5000);
	var respuesta = confirm("Juego terminado\n"+mensaje);
	if (respuesta == true) {
		restartGame();
	} else {
		quitGame();
	}

}
function restartGame(){
	location.href = 'Controlador/terminarSession.php';
}
function quitGame(){
	location.href = 'waiting.php';
}


/* Integracion con lo de Edgar*/
function agregarMovimientoATablero(move){
	for(var fila=0; fila<=5; fila++){
		if(tablero[fila][move] == 0){
			if(turno == 1){
				tablero[fila][move] = 1;
				break;
			}else{
				tablero[fila][move] = 2;
				break;
			}
		}
	}
}