/* 
* Funciones Basicas de Javascript, Jquery y Ajax para el manejo de cambios en la Base de datos
*/

/*
 Funcion para revisar si se agregaron nuevos usuarios a la plataforma 
*/
var cambiosEnUsuarios = setInterval(cambiosEnUsuarios, 1000);
var usuarios = 0;

function cambiosEnUsuarios() {
    $.ajax({
        url: '../Controlador/conectados.php',
        method: 'POST',
        success: function(users){
            var usersArray = jQuery.parseJSON(users);
            if(usuarios == usersArray.length){
            }else{
                $('#conectados').empty();
                $.each(usersArray,function(key,val){
                    $('#conectados').append("<p>"+(key+1)+".- "+val.nombreUser+"</p>")
                })
                usuarios = usersArray.length;
                cambioEnjuegos;
            }
        }
    });
}

/*
 Funcion para revisar si se crearon nuevos juegos o si se agrego el jugador al juego 
*/
var cambioEnjuegos = setInterval(cambioEnjuegos, 1000);
var juegos = 0;

function cambioEnjuegos() {
    $.ajax({
        url: '../Controlador/juegos.php',
        method: 'POST',
        success: function(games){
            var juegosArray = jQuery.parseJSON(games);
            $('#juegos').empty();
            $.each(juegosArray,function(key,val){
                if(val.user2 == null){
                    $('#juegos').append("<p>"+(key+1)+".- "+val.user1+" | esperando..</p>")
                }else{
                    $('#juegos').append("<p>"+(key+1)+".- "+val.user1+" | "+val.user2+"</p>")
                }
                
            })
                
        }
    });
}
