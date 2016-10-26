<?php
include "alerta_wamp.php";
include "./DAO/sql.php";

//logar();

//function logar(){
	
	list($login,$senha)  = explode(':',$_COOKIE["CTPK"]);
	//echo $login.":".$senha;
	$nivel = false;
	
	$userQuery = mysql_query("SELECT * FROM usuario WHERE login = '$login'")
	or die("Erro na conexao a tabela de usuarios!");
	$userArray = mysql_fetch_array($userQuery);
		
	if (mysql_num_rows($userQuery) == 0) {
		header("Location:http://localhost/ceitopkids/index.php"); 
	}else{
		setcookie ("CTPK", $login.":".$senha, time()+3600);
		setcookie ("IMG", time()+3600);
		$nivel = $userArray["nivel"];
	}	
//}
/*
function verifyLevel($level) {
	return true;	
}
*/

function verifyLevel($nivel) {
	list($login,$senha)  = explode(':',$_COOKIE["PCORPORATE"]);
	//echo $login.":".$senha;
	

	$nivel = false;
	
	$userQuery = mysql_query("SELECT * FROM usuario WHERE login = '$login'")
	or die("Erro na conexao a tabela usuarios!");
	$userArray = mysql_fetch_array($userQuery);
		
	if (mysql_num_rows($userQuery) == 0) {
		header("Location:http://localhost/condominio/index.php"); 
	}else{
		setcookie ("PCORPORATE", $login.":".$senha, time()+3600);
		$nivel = $userArray["nivel"];
	}	
	return $nivel;
}

?>
