<?php
require_once("../../../conexao.php");
$tabela = 'arquivos';
$id_empresa = $_POST['id'];

$query = $pdo->query("SELECT * FROM $tabela WHERE empresa = '0' and tipo = 'Empresa' and id_ref = '$id_empresa' order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if ($total_reg > 0) {

echo <<<HTML
<small>
	<table class="table table-hover">
	<thead> 
	<tr> 
	<th >Nome</th>
    <th class="esc">Cadastrado</th>	
    <th class="esc">Validade</th>		
	<th>Excluir</th>
    
	</tr> 
	</thead> 
	<tbody>	
HTML;


for($i=0; $i < $total_reg; $i++){
		$id = $res[$i]['id'];
		$nome = $res[$i]['nome'];
        $data_validade = $res[$i]['data_validade'];
        $data_validade = implode('/', array_reverse(explode('-', $data_validade)));
        $data_cad = $res[$i]['data_cad'];
        $data_cad = implode('/', array_reverse(explode('-', $data_cad)));
        


        //Formatação de campos


     
echo <<<HTML

<tr>
<td>{$nome}</td>
<td class="esc">{$data_cad}</td>
<td class="esc">{$data_validade}</td>

<td>
    

<li class="dropdown head-dpdn2" style="display: inline-block;">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false"><big><i class="fa fa-trash-o text-danger"></i></big></a>

		<ul class="dropdown-menu" style="margin-left:-230px;">
		<li>
		<div class="notification_desc2">
		<p>Confirmar Exclusão? <a href="#" onclick="excluirArquivo('{$id}')"><span class="text-danger">Sim</span></a></p>
		</div>
		</li>										
		</ul>
		</li>
        

</td>    
</tr>
HTML;
}

echo <<<HTML
</tbody>

</table>
</small>
HTML;

} else {
    echo '<small>Não Possui arquivo cadastrado!!</small>';
}