<?php
   if (isset($_POST['nombreUser'])) {
      header('Location: ../index.php?error=0');
   }else{
      session_start();
      if(empty($_SESSION['token'])){
         header('Location: ../index.php?error=0');
      }else{
?>

<!DOCTYPE html>
<html lang="en">
   <head>
     <title>Conecta 4</title>
     <meta charset="utf-8">
     <meta name="viewport" content="width=device-width, initial-scale=1">
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
     <link rel="icon" href="Vista/IMG/gamepad.png">
     <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
     <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
     <style>
       /* Remove the navbar's default margin-bottom and rounded borders */
       .navbar {
         margin-bottom: 0;
         border-radius: 0;
       }
       
       /* Set height of the grid so .sidenav can be 100% (adjust as needed) */
       .row.content {
         height: 600px;
      }
       
       /* Set gray background color and 100% height */
       .sidenav {
         padding-top: 20px;
         background-color: #f1f1f1;
         height: 100%;
       }
       
       /* Set black background color, white text and some padding */
       footer {
         background-color: #555;
         color: white;
         padding: 15px;
       }
       
       /* On small screens, set height to 'auto' for sidenav and grid */
       @media screen and (max-width: 767px) {
         .sidenav {
           height: auto;
           padding: 15px;
         }
         .row.content {height:auto;}
       }
       .content{
         height: 100%;
         overflow: auto;
       }
     </style>
   </head>
   <body>

   <nav class="navbar navbar-inverse">
     <div class="container-fluid">
       <div class="navbar-header">
         <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
           <span class="icon-bar"></span>
           <span class="icon-bar"></span>
           <span class="icon-bar"></span>
         </button>
         <a class="navbar-brand" href="#">Conecta 4</a>
       </div>
       <div class="collapse navbar-collapse" id="myNavbar">
         <ul class="nav navbar-nav navbar-right">
           <li><a href="../Controlador/terminarSession.php" ><span class="glyphicon glyphicon-log-in"></span> <?php echo $_SESSION['nombreUser'];?> logout</a></li>
         </ul>
       </div>
     </div>
   </nav>
   <div class="content">
      <div class="container-fluid text-center">
         <div class="row content">
            <div class="col-sm-2 sidenav">
               <label> Usuarios Conectados</label>
               <div id="conectados"></div>
            </div>
            <div class="col-sm-8 text-left">
            </div>
            <div class="col-sm-2 sidenav">
               <label> Juegos Corrientes</label>
               <div id="juegos"></div>
            </div>
         </div>
      </div>
   </div>
   <footer class="container-fluid text-center">
     <p>Made with love and code by Carlos, Luis & Juan</p>
   </footer>
   <script type="text/javascript" src="../Controlador/funcionesBasicas.js"></script>

   </body>
</html>
<?php
      }
   }
?>