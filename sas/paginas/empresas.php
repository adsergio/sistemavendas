<?php
$pag = 'empresas';
?>

<a class="btn btn-primary" onclick="inserir()" class="btn btn-primary btn-flat btn-pri"><i class="fa fa-plus" aria-hidden="true"></i> Nova Empresa</a>

<div class="bs-example widget-shadow" style="padding:15px" id="listar">
</div>



<!-- Modal Inserir/Editar -->
<div class="modal fade" id="modalForm" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_inserir"></span></h4>
				<button id="btn-fechar" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="form">
				<div class="modal-body">


					<div class="row">
						<div class="col-md-6">
							<label>Nome</label>
							<input type="text" class="form-control" id="nome" name="nome_resp" placeholder="Seu Nome" required>
						</div>

						<div class="col-md-6">
							<label>Email</label>
							<input type="email" class="form-control" id="email" name="email" placeholder="Seu Email">
						</div>
					</div>


					<div class="row">
						<div class="col-md-6">
							<label>Telefone</label>
							<input type="text" class="form-control" id="telefone" name="telefone" placeholder="Seu Telefone">
						</div>

						<div class="col-md-6">
							<label>CPF</label>
							<input type="text" class="form-control" id="cpf" name="cpf" placeholder="Seu CPF">
						</div>
					</div>
					<div class="row">
						<div class="col-md-4">
							<label>CNPJ</label>
							<input type="text" class="form-control" id="cnpj" name="cnpj" placeholder="Seu CNPJ">
						</div>
						<div class="col-md-4">
							<label>Valor Mensalidade</label>
							<input type="text" class="form-control" id="valor" name="valor" placeholder="Valor Mensal">
						</div>

						<div class="col-md-4">
							<label>Data PGTO</label>
							<input type="date" class="form-control" id="data_pgto" name="data-pgto" placeholder="">
						</div>


					</div>
					<div class="row">

						<div class="col-md-12">

							<label>Endereço</label>
							<input type="text" class="form-control" id="endereco" name="endereco" placeholder="Endereço">
						</div>
					</div>



					<input type="hidden" name="id" id="id">


					<br>
					<small>
						<small>
							<div id="mensagem" align="center"></div>
						</small>
					</small>
				</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Salvar</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- Modal Mostrar Dados -->
<div class="modal fade" id="modalDados" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_dados"></span></h4>
				<button id="btn-fechar" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

		
				<div class="modal-body">

					<div class="class="row" style="margin-top: -20px">
					
						<div class="col-md-6">
							<span><b>Email: </b></span><span id="email_dados"></span>
						</div>

						<div class="col-md-6">
							<span><b>Telefone: </b></span><span id="telefone_dados"></span>
						</div>
						<hr>
						<div class="col-md-6">
						 	<span><b>CPF: </b></span><span id="cpf_dados"></span>
						</div>	

						<div class="col-md-6">
							<span><b>CNPJ: </b></span><span id="cnpj_dados"></span>
						</div>	
						<hr>
						<div class="col-md-6">
							<span><b>Mensalidade: R$</b></span><span id="valor_dados"></span>
						</div>

						<div class="col-md-6">
							<span><b>Data de Pgto: </b></span><span id="data_pgto_dados"></span>
						</div>
						<hr>
						<div class="col-md-6">
							<span><b>Ativo: </b></span><span id="ativo_dados"></span>
						</div>

						<div class="col-md-6">
							<span><b>Data de Cadastro: </b></span><span id="data_cad_dados"></span>
						</div>
						<hr>
						<div class="col-md-12">
							<span><b>Endereço: </b></span><span id="endereco_dados"></span>
						</div>	
						<hr>
						<hr>
						<hr>
					</div>
				
					<div class="modal-footer">
					</div>
				
				</div>
			
			
		</div>
	</div>
</div>



<script type="text/javascript">
	var pag = "<?= $pag ?>"
</script>
<script src="js/ajax.js"></script>