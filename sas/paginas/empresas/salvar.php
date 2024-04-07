<?php
require_once("../../../conexao.php");
$tabela = 'empresas';
$nome_resp = $_POST["nome_resp"];
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

if ($id == ""){
    $query = $pdo->prepare("INSERT $tabela SET nome_resp = :nome_resp, telefone = :telefone, 
    email = :email,  cpf = :cpf, cnpj = :cnpj, endereco = :endereco ,ativo = 'Sim', data_cad = curDate(),
    data_pgto = '$data_pgto', valor = :valor ");
}else{
    $query = $pdo->prepare("UPDATE $tabela SET nome_resp = :nome_resp, telefone = :telefone, 
    email = :email,  cpf = :cpf, cnpj = :cnpj, endereco = :endereco ,ativo = 'Sim', data_cad = curDate(),
    data_pgto = '$data_pgto', valor = :valor WHERE id = '$id' ");
}
$query->bindValue(":nome_resp", $nome_resp);
$query->bindValue(":email", $email);
$query->bindValue(":telefone", $telefone);
$query->bindValue(":cpf", $cpf);
$query->bindValue(":cnpj", $cnpj);
$query->bindValue(":endereco", $endereco);
$query->bindValue(":valor", $valor);
$query->execute();

echo"Editado com Sucesso";

$id_empresa = $pdo->lastInsertId();
