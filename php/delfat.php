<?php 	
include "../classes/conexao.php";
$pg = $_POST['pg'];
foreach($_POST['id_venda'] as $key => $id_cliente){	
	$id_venda = isset($_POST['id_venda'][$key])? $_POST['id_venda'][$key] :null;
	
	$del = mysql_query("DELETE FROM faturas WHERE id_venda='$id_venda'") or die(mysql_error());

	
	if($del == 1){
		
			print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=../inicio.php?pg=".$pg."'>
			";

	}
}
?>