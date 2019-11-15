<?php
	
	/* primeiramente verificamos se existe algum $_POST dos respectivos nomes, depois armazenamos esses dados do post em variaveis filtrando e limpando caracteres indeviduos para evitar SQL INJECTION e por fim setamos as funções com as variaveis e chamamos o funcão de insertUsuario */

	if(isset($_POST['nome']) && isset($_POST['email']) && isset($_POST['password'])){
		require_once "../Class/Usuario.class.php";

		$usuario = new Usuario();

		$email = addslashes(strip_tags(trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL))));
		$nome = addslashes(strip_tags(trim($_POST['nome'])));
		$pass = addslashes(strip_tags(trim($_POST['password'])));

		if(empty($nome) || empty($email) || empty($pass)){
			echo 'preencha corretamente o formulario';
		}else{
			$usuario->setName($nome);
			$usuario->setEmail($email);
			$usuario->setPassword($pass);

			$usuario->insertUsuario();
		}

	}else{
		echo 'voce nao informou os dados corretamente';
	} 


?>