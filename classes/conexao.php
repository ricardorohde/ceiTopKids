<?php
include "config_conexao.php";

	$bd = mysql_connect($host,$usuario,$senha);
	mysql_select_db($banco) or die(mysql_error());
	
	mysql_query("SET NAMES 'utf8'");
	mysql_query('SET character_set_connection=utf8');
	mysql_query('SET character_set_client=utf8');
	mysql_query('SET character_set_results=utf8');
?>
