<?php
$tabela = 'empresas';
require_once("../../../conexao.php");

$id = $_POST['id'];

//excluir empresa

$pdo->query("DELETE FROM $tabela WHERE id = '$id' ");
echo'Excluído com Sucesso';

//excluir os usuários relacionados a empresa
$pdo->query("DELETE FROM usuarios WHERE empresa = '$id' ");
echo'Excluído com Sucesso';