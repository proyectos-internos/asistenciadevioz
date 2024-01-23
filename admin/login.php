<?php
	session_start();
	include 'includes/conn.php';

	if(isset($_POST['login'])){
		$username = $_POST['username'];
		$password = $_POST['password'];
		$ip = $_SERVER['REMOTE_ADDR'];
		$captcha = $_POST['g-recaptcha-response'];
		$secretkey = "6Lc8b0gpAAAAAOo1B1NIeuBId2vaC_K9fLb4DeKN";

		// Verificar el captcha
		$respuesta = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secretkey&response=$captcha&remoteip=$ip");
		$atributos = json_decode($respuesta, true);

		if(!$atributos['success']){
			$_SESSION['error'] = 'Verificar Captcha';
			header('location: index.php');
			exit;
		}

		// Consultar la base de datos para el usuario
		$sql = "SELECT * FROM admin WHERE usuario = '$username'";
		$query = $conn->query($sql);

		if($query->num_rows < 1){
			$_SESSION['error'] = 'No se puede encontrar la cuenta con el nombre de usuario proporcionado';
		} else {
			$row = $query->fetch_assoc();
			if(password_verify($password, $row['clave'])){
				$_SESSION['admin'] = $row['id'];
			} else {
				$_SESSION['error'] = 'Contraseña incorrecta';
			}
		}
		
	} else {
		$_SESSION['error'] = 'Ingrese las credenciales de administrador primero';
	}

	header('location: index.php');
	exit;
?>
