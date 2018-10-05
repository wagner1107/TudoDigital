<?php
include 'pages/header.php';
include 'classes/medicos.class.php';
include 'classes/especialidade.class.php';
include 'classes/cidadeuf.class.php';

$e = new Especialidade();
$espec = $e->getEspecialidades();

$cid_uf = new cudadeUf();
$uf = $cid_uf->selecionaUF();

$medico = new Medicos();
if(isset($_POST['nome']) && !empty($_POST['nome'])){
	$nome = addslashes($_POST['nome']);
	$crm = addslashes($_POST['crm']);
	$estado = addslashes($_POST['estado']);
	$cidade = addslashes($_POST['cidade']);
	$telefone = addslashes($_POST['telefone']);

	$especialidade = ($_POST['especialidade']); 

	if(count($especialidade) >= 2){
		$especialidade = implode(", ", $especialidade);
		if ($medico->cadastraMedico($nome, $crm, $estado, $cidade, $telefone, $especialidade)){

			?>
			<div class=" container alert alert-success" role="alert">
			  Medico <a href="#" class="alert-link">Cadatrado</a>. com sucesso.
			</div>
			<?php

		} else {

			?>
			<div class="container alert alert-warning" role="alert">
			  CRM <a href="#" class="alert-link"> Já Cadatrado</a>. no sistema.
			</div>
			<?php

		}


	} else {
		?>
		<div class="container alert alert-primary" role="alert">
  			Selecione <a href="#" class="alert-link">2 ou mais </a>. Especialidades.
		</div>
		<?php
	}


}

if(isset($_POST['pesquisar']) && !empty($_POST['pesquisar'])){
	
	$campo = addslashes($_POST['pesquisar']);
	$listaMedicos = $medico->pesquisaMedico($campo);
} else {

	$listaMedicos = $medico->listarMedicos();
}



?>

<div class="container" style="margin-top: 10px;">
  <h1>Tudo Digital <span class="badge badge-info">Medicos</span></h1>
  <p class="h5">Todos os Médicos em um único lugar </p>
  
	<button class="btn btn-primary" data-toggle="modal" data-target="#janela">Cadastrar Médico</button>

		<div class="modal fade" id="janela">
			<div class="modal-dialog modal-lg">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title"> Ficha de Cadastro </h5>
						<button class="close" data-dismiss="modal"><span>&times;</span></button>
					</div>
					<div class="modal-body">
						<form method="POST">
						  <div class="form-row">
						    <div class="form-group col-md-6">
						      <label for="nome">Nome</label>
						      <input name="nome" type="text" class="form-control" id="nome" required placeholder="Nome">
						    </div>
						    <div class="form-group col-md-6">
						      <label for="CRM">CRM</label>
						      <input name="crm" type="text" class="form-control" id="CRM" required placeholder="CRM">
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
						    <select name="cidade" class="form-control" id="cidade" required ">
						    	
						    </select>
						  </div>
						</div>
						  <div class="form-row">
						    <div class="form-group col-md-3">
						      <label for="telefone">Telefone</label>
						      <input name="telefone" type="text" class="form-control" id="telefone" required placeholder="11 99999-9999">
						    </div>
							<div class="form-group col-md-6">
							<label>Especialidade</label>
						    	<select name="especialidade[]" class="custom-select" required multiple>
						    		<?php foreach ($espec as $item) :?> 
						    			<option><?php echo utf8_encode($item['especialidade']); ?></option>
						    		<?php endforeach; ?>
								</select>
						    </div>
						</div>
						  <button type="submit" class="btn btn-primary">Cadastrar</button>
						<button class="btn btn-danger" data-dismiss="modal">Fechar Janela</button>
						</form>
					</div>
				</div>
			</div>
		</div>

  <hr/>



<div class="jumbotron" style="background-color: rgba(45,35,1, 0.4); color: #FFF;">

	<form method="POST" class="form-group">
	<div class="form-row">
	  <div class="form-group col-sm-8">
	    <input name="pesquisar" type="text" class="form-control" id="pesquisar" placeholder="Nome ou CRM do Médico...">
	  </div>
	  <div class="form-group col-sm-4">
	    <input type="submit" class="btn btn-primary" id="pesquisar" value="Pesquisar">
	  </div>
	</div>
	</form>


  <table class="table table-responsive-sm max-width table-hover">
  <thead>
    <tr>
      <th scope="col">Nome</th>
      <th scope="col">CRM</th>
      <th scope="col">UF - Cidade</th>
      <th scope="col">Telefone</th>
      <th scope="col">Especialidades</th>
      <th> Ações </th>
    </tr>
  </thead>
  <tbody>
  	<?php foreach ($listaMedicos as $lm) :?>
    <tr>
      	  <td><?php echo $lm['nome']; ?></td>
	      <td><?php echo $lm['crm']; ?></td>
	      <td><?php echo $lm['estado']." - ". $lm['cidade']; ?></td>
	      <td><?php echo $lm['telefone']; ?></td>
	      <td><?php echo $lm['especialidade']; ?></td>
      <td>
      	<a href="edit-medico.php?id=<?php echo $lm['id']; ?>" class="btn btn-primary">Editar</a>
      	<a href="delet-medico.php?id=<?php echo $lm['id']; ?>"" class="btn btn-danger">Excluir</a>
      </td>
    </tr>
<?php endforeach; ?>
  </tbody>
</table>
</div>
