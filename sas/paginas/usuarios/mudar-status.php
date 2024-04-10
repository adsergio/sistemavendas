<?php
$tabela = 'usuarios';
require_once("../../../conexao.php");

$id = $_POST['id'];
$acao = $_POST['acao'];


//Atualiza status do usuário
$pdo->query("UPDATE $tabela SET ativo = '$acao' WHERE id = '$id' ");
echo'Alterado com Sucesso';