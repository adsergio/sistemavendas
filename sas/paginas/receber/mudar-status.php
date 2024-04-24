<?php
$tabela = 'empresas';
require_once("../../../conexao.php");

$id = $_POST['id'];
$acao = $_POST['acao'];

//excluir empresa

$pdo->query("UPDATE usuarios SET ativo = '$acao' WHERE empresa = '$id' ");


//excluir os usuários relacionados a empresa
$pdo->query("UPDATE $tabela SET ativo = '$acao' WHERE id = '$id' ");
echo'Alterado com Sucesso';