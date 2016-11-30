<?php
   if (session_status() == PHP_SESSION_NONE) {
?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <title>Login Conecta 4</title>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
      <link rel="icon" href="Vista/IMG/gamepad.png">
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
      <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
      <style>
         /* Center */
         .centered {
            position: fixed;
            top: 50%;
            left: 50%;
            /* bring your own prefixes */
            transform: translate(-50%, -50%);
         }
         body {
           padding-top: 40px;
           padding-bottom: 40px;
           background-color: #eee;
         }
         .form-signin {
           margin: 0 auto;
         }
         .form-signin .form-control {
           position: relative;
           height: auto;
           -webkit-box-sizing: border-box;
              -moz-box-sizing: border-box;
                   box-sizing: border-box;
           padding: 10px;
           font-size: 16px;
         }
         .form-signin .form-control:focus {
           z-index: 2;
         }
         .panel-default > .panel-heading{
            background-color: #212121;
            color: #ffffff;
         }
         .btn{
            background-color: #d80027;
            color: #ffffff;
         }
      </style>
   </head>
  <body>
    <div class="container-fluid text-center">
      <div class="row">
        <img src="Vista/IMG/gamepad.png" style="margin:10px;width:80px;height:80px;">
        <h1>Conecta 4</h1>
      </div>
      <div class="col-md-6 centered">
         <div class="panel panel-default ">
            <div class="panel-heading">
               <h2 class="form-signin-heading panel-title">Login</h2>
            </div>
            <?php
               if(isset($_GET['error'])){
                  $error = '<div id="error" class="alert alert-danger">';
                  if($_GET['error']==0){
                     $error .= 'Error: No se ha iniciado sesión </div>';
                  }
                  if($_GET['error']==1){
                     $error .= 'Error: Nombre vacio </div>';
                  }
                  if($_GET['error']==2){
                     $error .= 'Error: No se permiten caracteres especiales </div>';
                  }
                  if($_GET['error']==3){
                     $error .= 'Error: al crear el usuario </div>';
                  }
                  if($_GET['error']==4){
                     $error .= 'Error: al crear el juego del usuario </div>';
                  }
                  if($_GET['error']==5){
                     $error .= 'Error: el nombre de usuario ya existe </div>';
                  }
                  echo $error;
               }
            ?>
            <form class="form-signin" action="Controlador/iniciarSession.php" method="POST">
               <div class="panel-body">
                  <label for="inputEmail" class="sr-only">Nombre De Usuario</label>
                  <input type="text" name="nombreUser" id="nombreUser" class="form-control" placeholder="Nombre de Usuario" required autofocus>
                  <p class="help-block" id="help"></p>
               </div>
               <div class="panel-footer">
                  <button class="btn btn-lg btn-block" type="submit">Sign in</button>
               </div>
            </form>
         </div>
      </div>

    </div> <!-- /container -->
    <footer class="container-fluid text-center">
      <p>Made with love and code by Carlos, Luis & Juan</p>
    </footer>
    <script type="text/javascript">
    var userName = setInterval(userName, 1000);
    var igual = 0;

    function userName() {
      var nombreUser = $("#nombreUser").val();
        $.ajax({
            url: 'Controlador/userName.php',
            method: 'POST',
            data: {nombreUser:nombreUser},
            success: function(msg){
                if(msg == 1){
                  $('#help').html("El nombre de usuario ya esta ocupado")
                }else{
                  $('#help').empty()
                }
            }
        });
    }
    </script>

  </body>
</html>
<?php
   }else{
      header('Location: Vista/index.php');
   }
?>