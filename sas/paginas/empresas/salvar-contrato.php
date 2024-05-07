<?php
require_once("../../../conexao.php");
$tabela = 'contratos';
$contrato = $_POST['contrato'];
$id = $_POST['id'];

$query = $pdo->query("SELECT * FROM $tabela WHERE empresa = '$id' order by id desc");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if ($total_reg == 0) {
      $query = $pdo->prepare("INSERT into $tabela SET empresa = '$id', texto = :texto, data = curDate() ");
    
  
    
}else{
    $query = $pdo->prepare("UPDATE $tabela SET texto = :texto WHERE empresa = '$id' ");
}

$query->bindValue(":texto", "$contrato");
$query->execute();


echo"Salvo com Sucesso";


