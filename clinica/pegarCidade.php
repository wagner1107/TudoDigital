<?php
require 'classes/cidadeuf.class.php';
require 'config.php';

global $pdo;

		$id_estado = $_POST['estado'];


		$cd_uf = new cudadeUf();

		$array = $cd_uf->selecionaCidade($id_estado);
		print_r($array);
		echo json_encode($array);
		exit;
