<?php
require_once("../conexao.php");
$nome_sistema = $_POST["nome_sistema"];
$telefone_sistema = $_POST["telefone_sistema"];
$telefone_fixo = $_POST["telefone_fixo"];
$email_sistema = $_POST['email_sistema'];
$tipo_rel = $_POST['tipo_rel'];
$endereco_sistema = $_POST['endereco_sistema'];
$instagram_sistema = $_POST['instagram_sistema'];
$msg_bloqueio = $_POST['msg_bloqueio'];
$dias_bloqueio = $_POST['dias_bloqueio'];




//SCRIPT PARA SUBIR LOGO NO SERVIDOR

$nome_img = @$_FILES['foto-logo']['name'];
$caminho = '../img/logo.png';

$imagem_temp = @$_FILES['foto-logo']['tmp_name']; 

if(@$_FILES['foto-logo']['name'] != ""){
	$ext = pathinfo($nome_img, PATHINFO_EXTENSION);   
	if($ext == 'png'){ 
	
		
			
		
		move_uploaded_file($imagem_temp, $caminho);
	}else{
		echo 'Extensão de Imagem não permitida, somente PNG';
		exit();
	}
}

//SCRIPT PARA SUBIR ICONE DO SISTEMA NO SERVIDOR

$nome_img = @$_FILES['foto-icone']['name'];
$caminho = '../img/icone.png';

$imagem_temp = @$_FILES['foto-icone']['tmp_name']; 

if(@$_FILES['foto-icone']['name'] != ""){
	$ext = pathinfo($nome_img, PATHINFO_EXTENSION);   
	if($ext == 'png'){ 
	
		
			
		
		move_uploaded_file($imagem_temp, $caminho);
	}else{
		echo 'Extensão de Imagem não permitida, somente JPG';
		exit();
	}
}

//SCRIPT PARA SUBIR RELATÓRIO NO SERVIDOR

$nome_img = @$_FILES['foto-logo-rel']['name'];
$caminho = '../img/logo-rel.jpg';

$imagem_temp = @$_FILES['foto-logo-rel']['tmp_name']; 

if(@$_FILES['foto-logo-rel']['name'] != ""){
	$ext = pathinfo($nome_img, PATHINFO_EXTENSION);   
	if($ext == 'jpg'){ 
	
		
			
		
		move_uploaded_file($imagem_temp, $caminho);
	}else{
		echo 'Extensão de Imagem não permitida, somente JPG';
		exit();
	}
}

$query = $pdo->prepare("UPDATE config SET nome_sistema =:nome_sistema, telefone_sistema =:telefone_sistema, telefone_fixo =:telefone_fixo, 
 email_sistema =:email_sistema, tipo_rel ='$tipo_rel',  endereco_sistema =:endereco_sistema, instagram_sistema =:instagram_sistema, msg_bloqueio =:msg_bloqueio,
 dias_bloqueio = '$dias_bloqueio' WHERE empresa = '0' ");

$query->bindValue(":nome_sistema", $nome_sistema);
$query->bindValue(":telefone_sistema", $telefone_sistema);
$query->bindValue(":telefone_fixo", $telefone_fixo);
$query->bindValue(":email_sistema", $email_sistema);
$query->bindValue(":endereco_sistema", $endereco_sistema);
$query->bindValue(":instagram_sistema", $instagram_sistema);
$query->bindValue(":msg_bloqueio", $msg_bloqueio);
$query->execute();

echo"Editado com Sucesso";

