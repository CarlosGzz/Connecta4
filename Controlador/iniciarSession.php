<?php
   if (isset($_POST['nombreUser'])) {
      if(empty($_SESSION['token'])){
         if(trim($_POST['nombreUser'])==''){
            header('Location: ../index.php?error=1');
         }else{
            if (preg_match('/[\'^£$%&*()}{@#~?><>,|=_+¬-]/', trim($_POST['nombreUser']))){
               header('Location: ../index.php?error=2');
            }else{
               $nombreUser = $_POST['nombreUser'];
            }
         }
         session_start();
         require "../Modelo/connect.php";
         $_SESSION['nombreUser'] = $nombreUser;
         $_SESSION['token'] = 'user'.md5(uniqid(rand(), true));
         $token = $_SESSION['token'];
         $timestamp = date("Y-m-d h:i:sa");

         $sql = "INSERT INTO user (nombreUser,token,diaHora)
                  VALUES ('$nombreUser','$token','$timestamp')";
         if ($db->query($sql) === TRUE) {
            echo 'Nuevo Usuario creado';
         } else {
            session_unset();
            session_destroy();
            $sql = "DELETE FROM user WHERE token = $token" ;
            $db->query($sql);
            header('Location: ../index.php?error=3');
         }

         $data = $db->query("SELECT * FROM juego WHERE user2 IS NULL");
         $juegos = array();
         while($object = mysqli_fetch_object($data)){
            $juegos[]=$object;
         }

         if(mysqli_num_rows($data) == 0){
            $sql = "INSERT INTO juego (user1,turno,gameOver,ganador,tablero)
                  VALUES ('$token','1','0','0','')";
            if ($db->query($sql) === TRUE) {
               echo "Nuevo Juego Creado";
            } else {
               session_unset();
               session_destroy(); 
               $sql = "DELETE FROM user WHERE token = $token" ;
               $db->query($sql);
               header('Location: ../index.php?error=4');
            }
         }else{
            foreach ($juegos as $juego) {
               $idJuego = $juego->idjuego;
               $sql = "UPDATE juego
                     SET user2 = '$token'
                     WHERE idjuego = '$idJuego' ";
               if ($db->query($sql) === TRUE) {
                  echo "unido exitosamente a juego";
               } else {
                  echo "error". $sql . "<br>" . $db->error;
               }
            }
         }
         header('Location: ../Vista/index.php');
      }
   }else{
      header('Location: ../index.php?error=0');
   }
?>