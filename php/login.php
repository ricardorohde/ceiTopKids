<?php 
/// abre a sessao
session_start(); 
include "../classes/conexao.php";
/// pega o valor vindo do campo login
$login = preg_replace('/[^[:alpha:]_]/', '',$_POST['login']); 
/// pega o valor vindo do campo senha
$senha = hash('sha512', preg_replace('/[^[:alnum:]_]/', '',$_POST['senha']));;

//seleciona a tabela
$sql = mysql_query("SELECT * FROM usuario WHERE BINARY login='$login' AND hash='$senha'"); 
// confere se exixte no banco
if(mysql_num_rows($sql) == 1){
	// se existir registra a session com o login e senha e vai para a pagina_principal
	$_SESSION['login_session'] = $login;
	$_SESSION['senha_session'] = $senha;
	header("Location:../inicio.php?pg=inicio");
	// se nao existir destroi a sessao existente e manda a mensagen de erro para a pagina do form
}else{
	unset($_SESSION['login_session']);
	unset($_SESSION['senha_session']);
	header("location:../index.php?login_errado=erro");
}

?>
