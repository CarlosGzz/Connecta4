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
     <style>

      /*NO QUITAR, ESTILO PARA AGRANDAR RADIOBUTTON*/
      input[type='radio'] {
        -webkit-appearance:none;
        width:4em;
        height:4em;
        border:1px solid darkgray;
        border-radius:50%;
        outline:none;
        box-shadow:0 0 5px 0px gray inset;
      }


      input[type='radio']:hover {
        box-shadow:0 0 5px 0px orange inset;
      }

      input[type='radio']:before {
        content:'';
        display:block;
        width:60%;
        height:60%;
        margin: 20% auto;    
        border-radius:50%;    
      }

      /* Aqui se modifica el color  */
      input[type='radio']:checked:before {

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
           <li><a href="Controlador/terminarSession.php" ><span class="glyphicon glyphicon-log-in"></span>logout</a></li>
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
            <div class="col-sm-8">
              <div class="row">
                <div class="col-sm-6 text-left">
                  <h1 id="player">You are player</h1>
                </div>
                <div class="col-sm-6 text-left">
                  <h3 id="stats"></h3>
                </div>
              </div>
              <section>
                <form action="">
                  <input type="radio" name="5x0" value="male" id="5,0" onclick="movimiento('0')">
                  <input type="radio" name="5x1" value="female" id="5,1" onclick="movimiento('1')">
                  <input type="radio" name="5X2" value="other" id="5,2"  onclick="movimiento('2')">
                  <input type="radio" name="5x3" value="male" id="5,3"  onclick="movimiento('3')">
                  <input type="radio" name="5x4" value="female" id="5,4" onclick="movimiento('4')">
                  <input type="radio" name="5X5" value="other" id="5,5"  onclick="movimiento('5')">
                  <input type="radio" name="5X6" value="other"  id="5,6" onclick="movimiento('6')">
                  <br>


                  <input type="radio" name="4x0" value="male" id="4,0" onclick="movimiento('0')">
                  <input type="radio" name="4x1" value="female" id="4,1" onclick="movimiento('1')">
                  <input type="radio" name="4X2" value="other" id="4,2" onclick="movimiento('2')">
                  <input type="radio" name="4x3" value="male" id="4,3" onclick="movimiento('3')">
                  <input type="radio" name="4x4" value="female" id="4,4" onclick="movimiento('4')">
                  <input type="radio" name="4X5" value="other" id="4,5" onclick="movimiento('5')">
                  <input type="radio" name="4X6" value="male" id="4,6" onclick="movimiento('6')">
                  <br>
                  <input type="radio" name="3x0" value="male" id="3,0" onclick="movimiento('0')">
                  <input type="radio" name="3x1" value="female" id="3,1" onclick="movimiento('1')">
                  <input type="radio" name="3X2" value="other" id="3,2" onclick="movimiento('2')">
                  <input type="radio" name="3x3" value="male" id="3,3" onclick="movimiento('3')">
                  <input type="radio" name="3x4" value="female" id="3,4" onclick="movimiento('4')">
                  <input type="radio" name="3X5" value="other" id="3,5" onclick="movimiento('5')">
                  <input type="radio" name="3X6" value="male" id="3,6" onclick="movimiento('6')">
                  <br>

                  <input type="radio" name="2x0" value="male" id="2,0" onclick="movimiento('0')">
                  <input type="radio" name="2x1" value="female" id="2,1" onclick="movimiento('1')">
                  <input type="radio" name="2X2" value="other" id="2,2" onclick="movimiento('2')">
                  <input type="radio" name="2x3" value="male" id="2,3" onclick="movimiento('3')">
                  <input type="radio" name="2x4" value="female" id="2,4" onclick="movimiento('4')">
                  <input type="radio" name="2X5" value="other" id="2,5" onclick="movimiento('5')">
                  <input type="radio" name="2X6" value="male" id="2,6" onclick="movimiento('6')">
                  <br>

                  <input type="radio" name="1x0" value="male" id="1,0" onclick="movimiento('0')">
                  <input type="radio" name="1x1" value="female" id="1,1" onclick="movimiento('1')">
                  <input type="radio" name="1X2" value="other" id="1,2" onclick="movimiento('2')">
                  <input type="radio" name="1x3" value="male" id="1,3" onclick="movimiento('3')">
                  <input type="radio" name="1x4" value="female" id="1,4" onclick="movimiento('4')">
                  <input type="radio" name="1X5" value="other" id="1,5" onclick="movimiento('5')">
                  <input type="radio" name="1X6" value="male" id="1,6" onclick="movimiento('6')">
                  <br>
                  <input type="radio" name="0x0" value="male" id="0,0" onclick="movimiento('0')">
                  <input type="radio" name="0x1" value="female" id="0,1" onclick="movimiento('1')">
                  <input type="radio" name="0X2" value="other" id="0,2" onclick="movimiento('2')">
                  <input type="radio" name="0x3" value="male" id="0,3" onclick="movimiento('3')">
                  <input type="radio" name="0x4" value="female" id="0,4" onclick="movimiento('4')">
                  <input type="radio" name="0X5" value="other" id="0,5" onclick="movimiento('5')">
                  <input type="radio" name="0X6" value="male" id="0,6" onclick="movimiento('6')">

                </form>
              <br>  
              <br>

              </section>
              <div id="moves" class="col-sm-12 text-left"></div>
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
   <script type="text/javascript" src="Controlador/funcionesBasicas.js"></script>
   <script type="text/javascript" src="Controlador/juego3.js"></script>

   </body>
</html>