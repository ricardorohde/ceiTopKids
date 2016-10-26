<?php 
/// abre a sessao
session_start(); 
include "../classes/conexao.php";
/// pega o valor vindo do campo login
$login = str_replace(".", "", $_POST['cpfcnpj']); 
$login = str_replace("-", "", $login);
/// pega o valor vindo do campo senha
$senha = $_POST['senha'];
//seleciona a tabela
echo "SELECT * FROM cliente WHERE cpfcnpj='$login' AND senha='$senha'";
$sql = mysql_query("SELECT * FROM cliente WHERE cpfcnpj='$login' AND senha='$senha'");
$cont = mysql_num_rows($sql);

// confere se existe no banco
if($cont >= 1){	
	// se existir registra a session com o login e senha e vai para a pagina_principal
	$_SESSION['cpfcnpj_session'] = $login;
	$_SESSION['senha_session'] = $senha;
	header("Location:inicio.php");
	// se nao existir destroi a sessao existente e manda a mensagen de erro para a pagina do form
}else{
	unset($_SESSION['cpfcnpj_session']);
	unset($_SESSION['senha_session']);
	header("location:index.php?login_errado=erro");
}

?>
