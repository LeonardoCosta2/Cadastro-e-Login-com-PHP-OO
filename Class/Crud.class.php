<?php
	require_once "Banco.class.php"; 
	class Crud extends Banco{

		private $crud;
		private $contador;
		private $resultado;

		/* prepara o statment */
		private function prepareStatement($query, $tipos, $parametros){
			$this->countParametros($parametros);

			$con = $this->conectar();
			$this->crud = $con->prepare($query);

			if($this->contador > 0){
				$callParametros = array();
				
				foreach($parametros as $key => $parametro){
					$callParametros[$key] = &$parametros[$key];
				}

				array_unshift($callParametros, $tipos);
				call_user_func_array(array($this->crud, 'bind_param'), $callParametros);
			}

			$this->crud->execute();
			$this->resultado = $this->crud->get_result();
			mysqli_close($con);
		}

		/* contador de parametros */
		private function countParametros($parametros){
			$this->contador = count($parametros);
		}

		/* metodo de inserção*/

		public function insert($tabela, $condicao, $tipos, $parametros){
			$this->prepareStatement("INSERT INTO {$tabela} VALUES({$condicao})", $tipos, $parametros);
			return $this->crud;
		}

		/* metodo de seleção*/

		public function select($campos, $tabela, $condicao, $tipos, $parametros){
			$this->prepareStatement("SELECT {$campos} FROM {$tabela} {$condicao}", $tipos, $parametros);
			return $this->resultado;
		}

		/* metodo deletar */

		public function deletar($tabela, $condicao, $tipos, $parametros){
			$this->prepareStatement("DELETE FROM {$tabela} WHERE {$condicao}", $tipos, $parametros);
			return $this->crud;
		}

		/* metodo Editar */

		public function editar($tabela, $set, $condicao, $tipos, $parametros){
			$this->prepareStatement("UPDATE {$tabela} SET {$set} WHERE {$condicao}", $tipos, $parametros);
			return $this->crud;
		}
	}

?>