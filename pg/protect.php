<?php 
####  verificando de a session existe ou nao #####

// inicia  a sessiom
session_start();
//se nao existir volta para a pagina do form de login
if(!isset($_SESSION['login_session']) and !isset($_SESSION['senha_session'])){
	header("Location:index.php");
	exit;		
}
//// a parte acima deve estar em todas as paginas onde houver restrições de acesso no site
?>