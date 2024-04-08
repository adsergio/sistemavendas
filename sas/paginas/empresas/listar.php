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

$valorF = number_format($valor, 2, ',', '.');
$data_pgtoF = implode('/', array_reverse(explode('-', $data_pgto)));

if($ativo == 'Sim'){
    $classe_ativo = '';
} else{
    //$classe_ativo = 'text-muted';
    $classe_ativo = 'dbdbdb';

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
    '{$cnpj}','{$valor}','{$data_pgto}')" title="Editar Dados"><i class="fa fa-edit text-primary"></i></a></big>
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
    echo '<small>Não POssui Registros Cadastrados!!</small>';
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
	function editar(id, nome, email, telefone, cpf, cnpj,valor,data_pgto){
		$('#id').val(id);
		$('#nome').val(nome);
        $('#email').val(email);
        $('#telefone').val(telefone);
        $('#cpf').val(cpf);
        $('#cnpj').val(cnpj);
        $('#valor').val(valor);
        $('#data_pgto').val(data_pgto);
		
		
		
		$('#titulo_inserir').text('Editar Registro');
		$('#modalForm').modal('show');
		
	}

	function limparCampos(){
		$('#id').val('');
		$('#nome').val('');	
	}

</script>