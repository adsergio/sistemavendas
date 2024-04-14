<?php

require_once("../../../conexao.php");
$tabela = 'empresas';

$query = $pdo->query("SELECT * FROM $tabela order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if ($total_reg > 0) {

echo <<<HTML
<small>
	<table class="table table-hover" id="tabela">
	<thead> 
	<tr> 
	<th >Nome</th>
    <th class="esc">Telefone</th>		
	<th class="esc">Email</th>
    <th class="esc">CNPJ</th>
    <th class="esc">Data PGTO</th>
    <th class="esc">Mensalidade</th>
    <th>Ações</th>
    
	</tr> 
	</thead> 
	<tbody>	
HTML;


for($i=0; $i < $total_reg; $i++){
		$id = $res[$i]['id'];
		$nome = $res[$i]['nome_resp'];
        $telefone = $res[$i]['telefone'];
        $email = $res[$i]['email'];
        $cpf = $res[$i]['cpf'];
        $cnpj = $res[$i]['cnpj'];
        $ativo = $res[$i]['ativo'];
        $data_cad = $res[$i]['data_cad'];
        $data_pgto = $res[$i]['data_pgto'];
        $valor  = $res[$i]['valor'];
        $endereco = $res[$i]['endereco'];


        //Formatação de campos
$valorF = number_format($valor, 2, ',', '.');
$data_pgtoF = implode('/', array_reverse(explode('-', $data_pgto)));
$data_cadF = implode('/', array_reverse(explode('-', $data_cad)));
$whats = '55'.preg_replace('/[ ()-]+/' , '' , $telefone);


if($ativo == 'Sim'){
    $icone = 'fa-check-square';
    $titulo_link = 'Desativar Item';
    $acao = 'Não';
    $classe_ativo = '';
}else{
    $icone = 'fa-square-o';
    $titulo_link = 'Ativar Item';
    $acao = 'Sim';
    $classe_ativo = '#dbdbdb';
}

     
echo <<<HTML
<!--<tr class="{$classe_ativo}">-->
<tr style="color:{$classe_ativo}">
<td>{$nome}</td>
<td class="esc">{$telefone}</td>
<td class="esc">{$email}</td>
<td class="esc">{$cnpj}</td>
<td class="esc">{$data_pgtoF}</td>
<td class="esc">R$ {$valorF}</td>
<td>
    <big><a href="#" onclick="editar('{$id}','{$nome}','{$email}','{$telefone}','{$cpf}',
    '{$cnpj}','{$valor}','{$data_pgto}','{$endereco}')" title="Editar Dados"><i class="fa fa-edit text-primary"></i></a></big>

<li class="dropdown head-dpdn2" style="display: inline-block;">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><big><i class="fa fa-trash-o text-danger"></i></big></a>

		<ul class="dropdown-menu" style="margin-left:-230px;">
		<li>
		<div class="notification_desc2">
		<p>Confirmar Exclusão? <a href="#" onclick="excluir('{$id}')"><span class="text-danger">Sim</span></a></p>
		</div>
		</li>										
		</ul>
		</li>

        <big><a href="#" onclick="mostrar('{$nome}','{$email}','{$telefone}','{$cpf}','{$cnpj}','{$valorF}','{$data_pgtoF}','{$ativo}',
            '{$data_cadF}','{$endereco}')" title="Mostrar Dados"><i class="fa fa-info-circle text-primary"></i></a></big>

        <big><a href="#" onclick="ativar('{$id}', '{$acao}')" title="{$titulo_link}"><i class="fa {$icone} text-success"></i></a></big>

        <big><a href="http://api.whatsapp.com/send?1=pt_BR&phone=$whats&text=" target="_blank" title="Abrir Whatsapp" class="text-verde"><i class="fa fa-whatsapp text-verde"></i></a></big>

        <big><a href="#" onclick="arquivo('{$id}','{$nome}' )" title="Anexar Arquivo"><i class="fa fa-file-archive-o text-primary"></i></a></big>
        
</td>    
</tr>
HTML;
}

echo <<<HTML
</tbody>
<small><div align="center" id="mensagem-excluir"></div></small>
</table>
</small>
HTML;

} else {
    echo '<small>Não Possui Registros Cadastrados!!</small>';
}
?>

<script type="text/javascript">
	$(document).ready( function () {
    $('#tabela').DataTable({
    		"ordering": false,
			"stateSave": true
    	});
    $('#tabela_filter label input').focus();
} 

);
</script>

<script type="text/javascript">
	function editar(id, nome, email, telefone, cpf, cnpj,valor,data_pgto,endereco){
		$('#id').val(id);
		$('#nome').val(nome);
        $('#email').val(email);
        $('#telefone').val(telefone);
        $('#cpf').val(cpf);
        $('#cnpj').val(cnpj);
        $('#valor').val(valor);
        $('#data_pgto').val(data_pgto);
        $('#endereco').val(endereco);
		
		
		
		$('#titulo_inserir').text('Editar Registro');
		$('#modalForm').modal('show');
		
	}



</script>
    
    <script type="text/javascript">
	function mostrar(nome, email, telefone, cpf, cnpj,valor,data_pgto,ativo,data_cad, endereco){
	
		$('#titulo_dados').text(nome);
        $('#email_dados').text(email);
        $('#telefone_dados').text(telefone);
        $('#cpf_dados').text(cpf);
        $('#cnpj_dados').text(cnpj);
        $('#valor_dados').text(valor);
        $('#data_pgto_dados').text(data_pgto);
        $('#ativo_dados').text(ativo);
        $('#data_cad_dados').text(data_cad);
        $('#endereco_dados').text(endereco);
		
			
		$('#modalDados').modal('show');
		
	}

	function limparCampos(){
		$('#id').val('');
		$('#nome').val('');	
        $('#nome').val('');
        $('#email').val('');
        $('#telefone').val('');
        $('#cpf').val('');
        $('#cnpj').val('');
        $('#valor').val('');
        $('#data_pgto').val('');
        $('#endereco').val('');
	}

    
    function arquivo(id, nome){
    
    $('#titulo_arquivo').text(nome);
    $('#id_arquivo').val(id);
    $('#id_usuario_arquivo').val(localStorage.id_usu);
    $('#target').attr("src","images/arquivos/sem-foto.png");
    $('#modalArquivos').modal('show');
    listarArquivos(id);
    limparArquivos()
    
}

function limparArquivos(){
    $('#nome_arquivo').val('');
    $('#data_validade').val('');
    $('#foto').val('');
    $('#target').attr("src","images/arquivos/sem-foto.png");

}

</script>