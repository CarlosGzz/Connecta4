<?php
	if(isset($_REQUEST['nombreUser'])){
		require "../Modelo/connect.php";
		$nombreUser = trim($_REQUEST['nombreUser']);
		$data = $db->query("SELECT * FROM user WHERE nombreUser = '$nombreUser'");
		if(mysqli_num_rows($data) != 0){
			echo 1;
		}else{
			echo 0;
		}
	}else{
		echo 0;
	}
?>