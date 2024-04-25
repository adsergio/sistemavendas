<?php

require_once("../../../conexao.php");
$tabela = 'receber';

$data_inicial = @$_POST['data_inicial'];
$data_final = @$_POST['data_final'];
$status = @$_POST['status'];
$vencidas = @$_POST['vencidas'];

if($vencidas != ""){
    $query = $pdo->query("SELECT * FROM $tabela WHERE data_venc < curDate() and pago != 'Sim' order by data_venc asc");
}
else{
    $query = $pdo->query("SELECT * FROM $tabela WHERE data_venc >= '$data_inicial' and data_venc <= '$data_final' and pago LIKE '%$status%' order by id desc");
}
//$data_inicial = '2024-04-01';
//$data_final = '2024-04-31';





$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if ($total_reg > 0) {

    echo <<<HTML
<small>
	<table class="table table-hover" id="tabela">
	<thead> 
	<tr> 
	<th>Descrição</th>
				<th class="esc">Valor</th> 
				<th class="esc">Vencimento</th> 
				<th class="esc">Frequência</th>
				<th class="esc">Empresa</th>
				<th>Arquivo</th>				
				<th>Ações</th>
    
	</tr> 
	</thead> 
	<tbody>	
HTML;


    for ($i = 0; $i < $total_reg; $i++) {
        $id = $res[$i]['id'];
        $descricao = $res[$i]['descricao'];
        $pessoa = $res[$i]['pessoa'];
        $valor = $res[$i]['valor'];
        $data_lanc = $res[$i]['data_lanc'];
        $data_venc = $res[$i]['data_venc'];
        $data_pgto = $res[$i]['data_pgto'];
        $usuario_lanc = $res[$i]['usuario_lanc'];
        $usuario_pgto = $res[$i]['usuario_pgto'];
        $frequencia = $res[$i]['frequencia'];
        $saida = $res[$i]['saida'];
        $arquivo = $res[$i]['arquivo'];
        $pago = $res[$i]['pago'];

        //extensão do arquivo
        $ext = pathinfo($arquivo, PATHINFO_EXTENSION);
        if ($ext == 'pdf') {
            $tumb_arquivo = 'pdf.png';
        } else if ($ext == 'rar' || $ext == 'zip') {
            $tumb_arquivo = 'rar.png';
        } else if ($ext == 'doc' || $ext == 'docx') {
            $tumb_arquivo = 'word.png';
        } else {
            $tumb_arquivo = $arquivo;
        }

        $data_lancF = implode('/', array_reverse(explode('-', $data_lanc)));
        $data_vencF = implode('/', array_reverse(explode('-', $data_venc)));
        $data_pgtoF = implode('/', array_reverse(explode('-', $data_pgto)));
        $valorF = number_format($valor, 2, ',', '.');


        $query2 = $pdo->query("SELECT * FROM usuarios where id = '$usuario_lanc'");
        $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
        if (@count($res2) > 0) {
            $nome_usu_lanc = $res2[0]['nome'];
        } else {
            $nome_usu_lanc = 'Sem Usuário';
        }


        $query2 = $pdo->query("SELECT * FROM usuarios where id = '$usuario_pgto'");
        $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
        if (@count($res2) > 0) {
            $nome_usu_pgto = $res2[0]['nome'];
        } else {
            $nome_usu_pgto = 'Sem Usuário';
        }


        $query2 = $pdo->query("SELECT * FROM frequencias where dias = '$frequencia'");
        $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
        if (@count($res2) > 0) {
            $nome_frequencia = $res2[0]['frequencia'];
        } else {
            $nome_frequencia = 'Indefinida';
        }


        $query2 = $pdo->query("SELECT * FROM empresas where id = '$pessoa'");
        $res2 = $query2->fetchAll(PDO::FETCH_ASSOC);
        if (@count($res2) > 0) {
            $nome_pessoa = $res2[0]['nome_resp'];
        } else {
            $nome_pessoa = 'Sem Cliente';
        }



        if ($pago == 'Sim') {
            $classe_pago = 'verde';
            $ocultar = 'ocultar';
        } else {
            $classe_pago = 'text-danger';
            $ocultar = '';
        }



        echo <<<HTML

<tr>
<td><i class="fa fa-square {$classe_pago} mr-1"></i> {$descricao}</td> 
					<td class="esc">R$ {$valorF}</td>	
				<td class="esc">{$data_vencF}</td>
				<td class="esc">{$nome_frequencia}</td>
				<td class="esc">{$nome_pessoa}</td>
				<td><a href="images/contas/{$arquivo}" target="_blank"><img src="images/contas/{$tumb_arquivo}" width="30px" height="30px"></a></td>
				<td>
					<big><a class="{$ocultar}" href="#" onclick="editar('{$id}', '{$descricao}', '{$pessoa}','{$valor}','{$data_venc}','{$frequencia}','{$saida}','{$arquivo}')" title="Editar Dados"><i class="fa fa-edit text-primary "></i></a></big>

					<big><a href="#" onclick="mostrar('{$id}', '{$descricao}', '{$nome_pessoa}','{$valor}','{$data_lancF}','{$data_vencF}','{$data_pgtoF}','{$nome_usu_lanc}','{$nome_usu_pgto}','{$nome_frequencia}','{$saida}','{$arquivo}','{$pago}')" title="Ver Dados"><i class="fa fa-info-circle text-secondary"></i></a></big>

					<big><a class="{$ocultar}" href="#" onclick="excluir('{$id}', '{$descricao}')" title="Excluir Item"><i class="fa fa-trash-o text-danger"></i></a></big>

					<big><a class="{$ocultar}" href="#" onclick="parcelar('{$id}', '{$valor}', '{$descricao}')" title="Parcelar Conta"><i class="fa fa-calendar-o " style="color:#7f7f7f"></i></a></big>

					<big><a class="{$ocultar}" href="#" onclick="baixar('{$id}', '{$valor}', '{$descricao}', '{$saida}')" title="Baixar Conta"><i class="fa fa-check-square " style="color:#079934"></i></a></big>

					<big><a href="#" onclick="arquivo('{$id}', '{$descricao}')" title="Inserir / Ver Arquivos"><i class="fa fa-file-o " style="color:#22146e"></i></a></big>
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
    $(document).ready(function() {
            $('#tabela').DataTable({
                "ordering": false,
                "stateSave": true
            });
            $('#tabela_filter label input').focus();
        }

    );
</script>

<script type="text/javascript">
    function editar(id, nome, email, telefone, cpf, cnpj, valor, data_pgto, endereco) {
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
    function mostrar(nome, email, telefone, cpf, cnpj, valor, data_pgto, ativo, data_cad, endereco) {

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

    function limparCampos() {
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


    function arquivo(id, nome) {

        $('#titulo_arquivo').text(nome);
        $('#id_arquivo').val(id);
        $('#id_usuario_arquivo').val(localStorage.id_usu);
        $('#target').attr("src", "images/arquivos/sem-foto.png");
        $('#modalArquivos').modal('show');
        listarArquivos(id);
        limparArquivos()

    }

    function limparArquivos() {
        $('#nome_arquivo').val('');
        $('#data_validade').val('');
        $('#foto').val('');
        $('#target').attr("src", "images/arquivos/sem-foto.png");

    }
</script>