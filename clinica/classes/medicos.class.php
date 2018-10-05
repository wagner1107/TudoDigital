<?php

Class Medicos{


	//construtor insere um médico novo, se o crm do médico já estiver cadastrado ele não irá inserir um medico novo
	public function cadastraMedico($nome, $crm, $estado, $cidade, $telefone, $especialidade){
		global $pdo;

		if($this->crm($crm)){

			$sql = $pdo->prepare("INSERT INTO medicos SET nome = :nome, crm = :crm, estado = :estado, cidade = :cidade, telefone = :telefone, especialidade = :especialidade");
			$sql->bindValue(":nome", $nome);
			$sql->bindValue(":crm", $crm);
			$sql->bindValue(":estado", $estado);
			$sql->bindValue(":cidade",$cidade);
			$sql->bindValue(":telefone",$telefone);
			$sql->bindValue(":especialidade",$especialidade);

			$sql->execute();

			if($sql->rowCount() > 0){
				return true;
			}
				return false;
		}
	}

	//edita os dados do médico só não altera o CRM
	public function editarMedico($nome, $estado, $cidade, $telefone, $especialidade,  $id){
		global $pdo;

		$sql = $pdo->prepare("UPDATE medicos SET nome = :nome, estado = :estado, cidade = :cidade, telefone = :telefone, especialidade = :especialidade WHERE id = :id");
		$sql->bindValue(":nome", $nome);
		$sql->bindValue(":estado", $estado);
		$sql->bindvalue(":cidade", $cidade);
		$sql->bindValue(":telefone", $telefone);
		$sql->bindValue(":especialidade", $especialidade);
		$sql->bindValue(":id", $id);

		$sql->execute();

		if($sql->rowCount() > 0){
			return true;
		}

		return false;

	}

	//Exclui o medico selecionado
	public function excluirMedico($id){
		global $pdo;

		$sql = $pdo->prepare("DELETE FROM medicos WHERE id = :id");
		$sql->bindValue(":id", $id);

		$sql->execute();

		if($sql->rowCount() > 0){
			return true;
		}

		return false;
	}


	//lista todos os médicos e devolve um array de medicos
	public function listarMedicos(){
		global $pdo;
		$medicos = array();

		$sql = $pdo->query("SELECT * FROM medicos ORDER BY id DESC");

		if($sql->rowCount() > 0){
			$medicos = $sql->fetchAll();
			return $medicos;
		}
		return $medicos;
	}

	//retorna um médico pesquisado pelo campo CRM ou NOME
	public function pesquisaMedico($campo){
		global $pdo;
		$medico = array();

		$sql = $pdo->prepare("SELECT * FROM medicos WHERE crm LIKE :crm OR nome LIKE :nome");
		$sql->bindValue(":crm", "%".$campo."%");
		$sql->bindValue(":nome", "%".$campo."%");

		$sql->execute();

		if($sql->rowCount() > 0 ){
			$medico = $sql->fetchAll();
			return $medico;
		}

		return $medico;

	}

	//Pesquisa o médico pelo campo ID para recuperar dados via URL
		public function getMedico($id){
		global $pdo;
		$medico = array();

		$sql = $pdo->prepare("SELECT * FROM medicos WHERE id = :id");
		$sql->bindValue(":id", $id);

		$sql->execute();

		if($sql->rowCount() > 0 ){
			$medico = $sql->fetch();
			return $medico;
		}

		return $medico;

	}




	//Verifica se o CRM já foi Cadastrado
	private function crm($crm){
		global $pdo;
		
		$sql = $pdo->prepare("SELECT id FROM medicos WHERE crm = :crm");
		$sql->bindValue(":crm",$crm);
		$sql->execute();

		if($sql->rowCount() == 0){
			return true;
		}
			return false;

	}

}

