<?php 
	session_start();
	if(isset($_POST['email']) && isset($_POST['password'])){
		require_once "../Class/Usuario.class.php";

		$usuario = new Usuario();

		$pass = addslashes(strip_tags(trim($_POST['password'])));
		$email = addslashes(strip_tags(trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL))));

		if(empty($pass) || empty($email)){
			echo 'preencha corretamente o formulario';
		}else{
			$usuario->setPassword($pass);
			$usuario->setEmail($email);

			echo $usuario->logar();
		}
	}
?>