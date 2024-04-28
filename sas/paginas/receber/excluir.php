<?php
$tabela = 'receber';
require_once("../../../conexao.php");

$id = $_POST['id'];

$query = $pdo->query("SELECT * FROM $tabela WHERE id = '$id' ");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$foto = $res[0]['arquivo'];

if($foto != "sem-foto-png"){
    //EXCLUO A FOTO ANTERIOR
			
	@unlink('../../images/contas/'.$foto);
			

}


$pdo->query("DELETE FROM $tabela WHERE id = '$id' ");
echo'Excluído com Sucesso';