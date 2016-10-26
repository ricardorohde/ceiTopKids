<?php 
ob_start();
include '../classes/conexao.php';
	$id = $_GET['id'];
	$sql = mysql_query("DELETE FROM cliente WHERE id_cliente='$id'")or die (mysql_error());
header("Location:../inicio.php?pg=listaclientes");
?>