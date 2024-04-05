<?php
require_once("../conexao.php");
$id = $_POST["id"];
$nome = $_POST["nome"];
$email = $_POST["email"];
$telefone = $_POST["telefone"];
$cpf = $_POST['cpf'];
$endereco = $_POST["endereco"];
$senha = $_POST["senha"];
$conf_senha = $_POST["conf_senha"];
$senha_crip = md5($senha);

if($senha != $conf_senha){
    echo "Os campos de senha e confirmação de senha devem ser iguais.";
    exit();
}

if($email == "" and $cpf==""){
    echo "Os campos de senha ou CPF devem ser preenchidos.";
    exit();
}




//validar troca da foto
$query = $pdo->query("SELECT * FROM usuarios where id = '$id'");
$res = $query->fetchAll(PDO::FETCH_ASSOC);
$total_reg = @count($res);
if($total_reg > 0){
	$foto = $res[0]['foto'];
}else{
	$foto = 'sem-foto.jpg';
}



//SCRIPT PARA SUBIR FOTO NO SERVIDOR
$nome_img = date('d-m-Y H:i:s') .'-'.@$_FILES['foto']['name'];
$nome_img = preg_replace('/[ :]+/' , '-' , $nome_img);

$caminho = 'images/perfil/' .$nome_img;

$imagem_temp = @$_FILES['foto']['tmp_name']; 

if(@$_FILES['foto']['name'] != ""){
	$ext = pathinfo($nome_img, PATHINFO_EXTENSION);   
	if($ext == 'png' or $ext == 'jpg' or $ext == 'jpeg' or $ext == 'gif'){ 
	
			//EXCLUO A FOTO ANTERIOR
			if($foto != "sem-foto.jpg"){
				@unlink('images/perfil/'.$foto);
			}

			$foto = $nome_img;
		
		move_uploaded_file($imagem_temp, $caminho);
	}else{
		echo 'Extensão de Imagem não permitida!';
		exit();
	}
}

$query = $pdo->prepare("UPDATE usuarios SET nome =:nome, email =:email, telefone =:telefone, cpf =:cpf, endereco =:endereco, senha =:senha,
senha_crip ='$senha_crip', foto = '$foto' WHERE id ='$id'");

$query->bindValue(":nome", $nome);
$query->bindValue(":email", $email);
$query->bindValue(":telefone", $telefone);
$query->bindValue(":cpf", $cpf);
$query->bindValue(":endereco", $endereco);
$query->bindValue(":senha", $senha);
$query->execute();

echo"Editado com Sucesso";