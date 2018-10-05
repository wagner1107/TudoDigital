<?php
include 'pages/header.php';
include 'classes/medicos.class.php';
include 'classes/especialidade.class.php';
include 'classes/cidadeuf.class.php';

$cid_uf = new cudadeUf();
$uf = $cid_uf->selecionaUF();

$medico = new Medicos();
$e = new Especialidade();

$espec = $e->getEspecialidades();

if(isset($_POST['nome']) && !empty($_POST['nome'])){
	$nome = addslashes($_POST['nome']);
	$estado = addslashes($_POST['estado']);
	$cidade = addslashes($_POST['cidade']);
	$telefone = addslashes($_POST['telefone']);
	$id = addslashes($_POST['id']);

	$especialidade = ($_POST['especialidade']); 

	if(count($especialidade) >= 2){
		$especialidade = implode(", ", $especialidade);
		if ($medico->editarMedico($nome, $estado, $cidade, $telefone, $especialidade, $id)){
			?>
			<div class=" container alert alert-success" role="alert">
			  Medico <a href="#" class="alert-link">EDITADO</a> com sucesso.
			</div>	
			<script type="text/javascript">window.location.href="add-medico.php";</script>
			<?php 
			exit;
		}
	}
	?>
		<div class=" container alert alert-success" role="alert">
		  Selecione <a href="#" class="alert-link">2 ou mais </a> Especialidades.
		</div>

	<?php
}


	if(isset($_GET['id']) && !empty($_GET['id'])){
		$info = $medico->getMedico($_GET['id']);
	} else {
		?>
		<script type="text/javascript">window.location.href="add-medico.php";</script>
		<?php 
		exit;
	}


?>

<div class="container" style="margin-top: 10px;">
  <h1>Tudo Digital <span class="badge badge-info">Medicos</span></h1>
  <p class="h5">Todos os Médicos em um único lugar </p>

	<form method="POST">
	  <div class="form-row">
	    <div class="form-group col-md-6">
	      <label for="nome">Nome</label>
	      <input name="id" type="hidden" class="form-control" id="id" required value="<?php echo $info['id']; ?>">

	      <input name="nome" type="text" class="form-control" id="nome" required value="<?php echo $info['nome']; ?>">
	    </div>
	    <div class="form-group col-md-6">
	      <label for="CRM">CRM</label>
	      <input name="crm" type="text" class="form-control" id="CRM" disabled value="<?php echo $info['crm']; ?>">
	    </div>
	  </div>
	  <div class="form-row">
		  <div class="form-group col-md-6">
	    <label for="estado">Estado</label>
	    	<select name="estado" class="form-control" id="estado" required onchange="pegarCidade(this)">
	    		<option></option>
	    		<?php foreach ($uf as $u) :?> 
	    			<option value="<?php echo utf8_encode($u['id']); ?>"><?php echo utf8_encode($u['nome']); ?></option>
	    		<?php endforeach; ?>
			</select>
	  </div>
	  <div class="form-group col-md-6">
	    <label for="Cidade">Cidade</label>
	    <select name="cidade" class="form-control" id="cidade" required ">>
				
		</select>
	  </div>
	</div>
	  <div class="form-row">
	    <div class="form-group col-md-3">
	      <label for="telefone">Telefone</label>
	      <input name="telefone" type="text" class="form-control" id="telefone" required value="<?php echo $info['telefone']; ?>">
	    </div>
		
		<div class="form-group col-md-6">
		<label>Especialidade</label>
	    	<select name="especialidade[]" class="custom-select" required multiple>
	    		<?php foreach ($espec as $item) :?> 
	    			<option> <?php echo utf8_encode($item['especialidade']); ?> </option>
	    		<?php endforeach; ?>
			</select>
	    </div>
	</div>
	  <button type="submit" class="btn btn-success">Editar</button>
	<a href="add-medico.php" class="btn btn-primary">Voltar</a>
</form>
</div>

<?php
require 'pages/footer.php';
?>