<?php
$pag = 'receber';
?>

<a class="btn btn-primary" onclick="inserir()" class="btn btn-primary btn-flat btn-pri"><i class="fa fa-plus" aria-hidden="true"></i> Nova Conta</a>

<div class="bs-example widget-shadow" style="padding:15px" id="listar">
</div>

<!-- Modal Inserir Contas Receber-->
<div class="modal fade" id="modalForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title"><span id="titulo_inserir"></span></h4>
				<button id="btn-fechar" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -20px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form method="post" id="form">
				<div class="modal-body">

					<div class="row">
						<div class="col-md-4">						
							<div class="form-group"> 
								<label>Descrição</label> 
								<input type="text" class="form-control" name="descricao" id="descricao"> 
							</div>						
						</div>

						<div class="col-md-4">						
							<div class="form-group"> 
								<label>Empresa</label> 
								<select class="form-control sel2" name="pessoa" id="pessoa" style="width:100%;"> 

									<option value="">Selecione uma Empresa</option>

									<?php 
									$query = $pdo->query("SELECT * FROM empresas order by nome_resp asc");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									for($i=0; $i < @count($res); $i++){
										

											?>	
										<option value="<?php echo $res[$i]['id'] ?>"><?php echo $res[$i]['nome_resp'] ?></option>

									<?php } ?>

								</select>
							</div>						
						</div>


						<div class="col-md-4">						
							<div class="form-group"> 
								<label>Valor</label> 
								<input type="text" class="form-control" name="valor" id="valor" required> 
							</div>						
						</div>


					</div>


					<div class="row">
						<div class="col-md-4">						
							<div class="form-group"> 
								<label>Vencimento</label> 
								<input type="date" class="form-control" name="data_venc" id="data_venc" required> 
							</div>						
						</div>

						<div class="col-md-4">						
							<div class="form-group"> 
								<label>Frequência</label> 
								<select class="form-control sel2" name="frequencia" id="frequencia" required style="width:100%;"> 
									<?php 
									$query = $pdo->query("SELECT * FROM frequencias WHERE empresa = '0' order by id asc");
									$res = $query->fetchAll(PDO::FETCH_ASSOC);
									for($i=0; $i < @count($res); $i++){
										foreach ($res[$i] as $key => $value){}

											?>	
										<option value="<?php echo $res[$i]['dias'] ?>"><?php echo $res[$i]['frequencia'] ?></option>

									<?php } ?>

								</select>
							</div>						
						</div>


						

					</div>

					

					<div class="row">						

						<div class="col-md-4">						
							<div class="form-group"> 
								<label>Arquivo</label> 
								<input type="file" name="arquivo" onChange="carregarImg();" id="arquivo">
							</div>						
						</div>
						<div class="col-md-2">
							<div id="divImg">
								<img src="images/contas/sem-foto.png"  width="100px" id="target">									
							</div>
						</div>

					</div>				
					

					<br>
					<input type="hidden" name="id" id="id"> 
					<small><div id="mensagem" align="center" class="mt-3"></div></small>					

				</div>


				<div class="modal-footer">
					<button type="submit" class="btn btn-primary">Salvar</button>
				</div>



			</form>

		</div>
	</div>
</div>





<!-- Modal Arquivos -->
<div class="modal fade" id="modalArquivos" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title" id="exampleModalLabel"><span id="titulo_arquivo"></span></h4>
				<button id="btn-fechar-arquivo" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="form-arquivos">
				<div class="modal-body">

					<div class="row">
						<div class="col-md-6">
							<label>Nome</label>
							<input type="text" class="form-control" id="nome_arquivo" name="nome" placeholder="Nome do arquivo" required>
						</div>

						<div class="col-md-6">
							<label>Data Validade</label>
							<input type="date" class="form-control" id="data_validade" name="data_validade" placeholder="">
						</div>
					</div>

					<div class="row">
						<div class="col-md-6">
							<label>Foto</label>
							<input type="file" class="form-control" id="foto" name="foto" value="" onChange="carregarImg()">

						</div>
						
						<div class="col-md-6">
							<img src="" width="80px" id="target">

						</div>


					</div>
					
					<input type="hidden" name="id_usuario" id="id_usuario_arquivo">
					<input type="hidden" name="id_arquivo" id="id_arquivo">
					
					

					<br>
					<small>
							<div id="mensagem-arquivo" align="center"></div>
					</small>

					<hr>
					
					<div id="listar-arquivos"></div>

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
				<button id="btn-fechar-dados" type="button" class="close" data-dismiss="modal" aria-label="Close" style="margin-top: -25px">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>


			<div class="modal-body">

				<div class="class=" row" style="margin-top: -20px">

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





<script type="text/javascript">
	function carregarImg() {
		var target = document.getElementById('target');
		var file = document.querySelector("#foto").files[0];

		var arquivo = file['name'];
		resultado = arquivo.split(".", 2);

		if (resultado[1] === 'pdf') {
			$('#target').attr('src', "images/pdf.png");
			return;
		}

		if (resultado[1] === 'rar' || resultado[1] === 'zip') {
			$('#target').attr('src', "images/rar.png");
			return;
		}

		if (resultado[1] === 'doc' || resultado[1] === 'docx' || resultado[1] === 'txt') {
			$('#target').attr('src', "images/word.png");
			return;
		}


		if (resultado[1] === 'xlsx' || resultado[1] === 'xlsm' || resultado[1] === 'xls') {
			$('#target').attr('src', "images/excel.png");
			return;
		}


		if (resultado[1] === 'xml') {
			$('#target').attr('src', "images/xml.png");
			return;
		}



		var reader = new FileReader();

		reader.onloadend = function() {
			target.src = reader.result;
		};

		if (file) {
			reader.readAsDataURL(file);

		} else {
			target.src = "";
		}
	}
</script>

<script type="text/javascript">
	$("#form-arquivos").submit(function() {
		
		var id_empresa = $('#id_arquivo').val();
		event.preventDefault();
		var formData = new FormData(this);

		$.ajax({
			url: 'paginas/' + pag + "/inserir-arquivo.php",
			type: 'POST',
			data: formData,

			success: function(mensagem) {
				$('#mensagem-arquivo').text('');
				$('#mensagem-arquivo').removeClass()
				if (mensagem.trim() == "Salvo com Sucesso") {

					limparArquivos()
					//$('#btn-fechar-arquivo').click();
					listarArquivos(id_empresa);

				} else {

					$('#mensagem-arquivo').addClass('text-danger')
					$('#mensagem-arquivo').text(mensagem)
				}


			},

			cache: false,
			contentType: false,
			processData: false,

		});

	});
</script>


<script type="text/javascript">

function listarArquivos(id){
    var id_usuario = localStorage.id_usu;
    $.ajax({
        url: 'paginas/' + pag + "/listar-aquivos.php",
        method: 'POST',
        data: {id_usuario, id},
        dataType: "html",

        success:function(result){
            $("#listar-arquivos").html(result);
            
        }
    });
}

function excluirArquivo(id){
    var id_usuario = localStorage.id_usu;
	var id_empresa = $('#id_arquivo').val();
    $.ajax({
        url: 'paginas/' + pag + "/excluir-arquivo.php",
        method: 'POST',
        data: {id,id_usuario},
        dataType: "html",

        success:function(mensagem){
            if (mensagem.trim() == "Excluído com Sucesso") {
                listarArquivos(id_empresa);                       

            } else {

               
            }
        }
    });
}

</script>
