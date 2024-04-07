<?php
require_once("../../../conexao.php");
$tabela = 'empresas';
$nome = $_POST["nome_rep"];
$telefone = $_POST['telefone'];
$email = $_POST["email"];
$cpf = $_POST['cpf'];
$cnpj = $_POST['cnpj'];
$endereco = $_POST['endereco'];
$valor = $_POST['valor'];
$data_pgto = $_POST['data-pgto'];
$id = $_POST['id'];

if ($email == "" and $cpf == "") {
    echo "Preencha o Email ou CPF";
    exit();
}

//validar CNPJ
if ($cnpj != "") {

    $query = $pdo->query("SELECT * from $tabela where cnpj = '$cnpj'");
    $res = $query->fetchAll(PDO::FETCH_ASSOC);
    if (@count($res) > 0 and $id != $res[0]['id']) {
        echo 'CNPJ já Cadastrado, escolha outro!!';
        exit();
    }
}




