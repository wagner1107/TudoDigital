<?php
require 'config.php';

require 'classes/medicos.class.php';
$m = new Medicos();
	
if(isset($_GET['id']) && !empty($_GET['id'])){
	$m->excluirMedico($_GET['id']);
}

header("Location: add-medico.php");