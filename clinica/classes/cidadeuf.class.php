<?php

class cudadeUf{
	public function selecionaUF(){		
		global $pdo;
		$uf = array();

		$sql = $pdo->query("SELECT * FROM estado");

		if($sql->rowCount() > 0){
			$uf = $sql->fetchAll();
			return $uf;
		}
		return $uf;
	}


	public function selecionaCidade($estado){
		global $pdo;
		$array = array();


		$sql = $pdo->prepare("SELECT * FROM cidade WHERE estado = :estado");
		$sql->bindValue(":estado", $estado);
		$sql->execute();

		if($sql->rowCount() > 0){

			$array = $sql->fetchAll();
			return $array;
		}
		
		return $array;


	}

}
