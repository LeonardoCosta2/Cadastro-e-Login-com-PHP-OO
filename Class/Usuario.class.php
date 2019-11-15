<?php 
	require_once "Crud.class.php";

	class Usuario extends Crud{
		protected $name;
		private $password;
		private $email;

		/* getters and setters */

	    public function getPassword(){
	        return $this->password;
	    }

	    public function setPassword($password){
	        $this->password = $password;
	    }

	    public function getEmail(){
	        return $this->email;
	    }

	    public function setEmail($email){
	        $this->email = $email;
	    }

	    public function getName(){
	        return $this->name;
	    }

	    public function setName($name){
	        $this->name = $name;
	    }

	    /* getters and setters */



	    // metodo para gerar uma senha criptografada
	    private function hashPassword($password){
	    	return password_hash($this->getPassword(), PASSWORD_DEFAULT, ['cost' => 14]); 
	    }

	    // metodo para comparar a senha digitada com a cadastrada no banco

	    private function verifyPassword($hash){
	    	return password_verify($this->getPassword(), $hash);
	    }

	    // função para verificar se ja existe o email informado no sistema 

	    public function find($param){
	    	$select = parent::select('email, senha', 'usuario', 'WHERE email = ?', 's', array($this->getEmail()));
	    	$result = $select->fetch_object();

	    	if($select->num_rows > 0){
	    		if($param == 'email'){
	    			return true;
	    		}else if($param == 'senha'){
	    			return $result->senha;
	    		}
	    	}else{
	    		return false;
	    	}
	    }

	    // função que insere um novo usuario ao banco de dados, primeiro verificando ja existe o email cadastrado. caso exista o email a função retorna uma mensagem ao usuario
	    // caso o email nao exista ela insere no banco

	    public function insertUsuario(){
	    	if($this->find('email')){
				echo 'Email já Cadastrado!';
	    	}else{
	    		$password = $this->hashPassword($this->getPassword());
	    		$insert = parent::insert('usuario(nome, email, senha)', '?,?,?', 'sss', array($this->getName(), $this->getEmail(), $password));
	    		if($insert){
					echo 'Usuario cadastrado com sucesso!';
	    		}else{
					echo 'Ocorreu um erro ao cadastrar';
	    		}
	    	}
	    }

	    // função para logar o usuario cadastro, nela pegamos o email e a senha do usuario e verificamos se os dados correspondem, se eles corresponderem iniciamos uma sessao com os dados desse usuario

	    public function logar(){
	    	$verifyPass = $this->find('senha');
	    	if($verifyPass){
				if($this->verifyPassword($verifyPass)){
					$consulta = parent::select('id', 'usuario', 'WHERE email = ?', 's', array($this->getEmail()));
					$result = $consulta->fetch_object();

					if($consulta->num_rows > 0){
						$_SESSION['idUser'] = $result->id;
		    			echo 'Login Efetuado com Sucesso!';
		    			sleep(3);
		    			header('location: ../logado.php');
					}else{
						echo 'Email ou Senha Incorretos!';
					}
				}else{
					echo 'Senha Incorreta!';
				}
			}else{
					echo 'Email não Existe!';
			}
	    }


}
?>