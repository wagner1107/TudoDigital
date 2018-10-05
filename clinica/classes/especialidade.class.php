<?php
Class Especialidade{

	public function getEspecialidades(){

		global $pdo;
		$espec = array();
		
		$sql = $pdo->query("SELECT * FROM ESPECIALIDADES");
		if($sql->rowCOunt() > 0){
			$espec = $sql->fetchAll();
			return $espec;
		}
			return $espec;
	}

}