<?php
$tabela = 'usuarios';
require_once("../../../conexao.php");

$id = $_POST['id'];

//excluir Usuário

$pdo->query("DELETE FROM $tabela WHERE id = '$id' ");
echo'Excluído com Sucesso';

