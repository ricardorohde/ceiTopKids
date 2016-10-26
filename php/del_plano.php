<?php 	
include "../classes/conexao.php";
$pg = $_POST['pg'];
foreach($_POST['id_plano'] as $key => $id_plano){	
	$id_plano = isset($_POST['id_plano'][$key])? $_POST['id_plano'][$key] :null;
	
	$del = mysql_query("DELETE FROM flux_planos WHERE id_plano='$id_plano'") or die(mysql_error());
	
	if($del == 1){
		
			print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=../inicio.php?pg=fluxo#tabs-2'>
			";

	}
}
?>