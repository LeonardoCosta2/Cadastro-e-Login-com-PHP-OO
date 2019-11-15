<?php 
	abstract class Banco{
		protected function conectar(){
			try{
				$mysqli = new mysqli('localhost', 'root', '', 'login');
				return $mysqli;
			}catch(Exception $Erro){
				return $Erro->getMessage();
			}
		}

	}
?>