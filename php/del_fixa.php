<?php 	
include "../classes/conexao.php";

foreach($_POST['id_fixa'] as $key => $id_fixa){	
	$id_fixa = isset($_POST['id_fixa'][$key])? $_POST['id_fixa'][$key] :null;

	$del = mysql_query("DELETE FROM flux_fixas WHERE id_fixa='$id_fixa'") or die(mysql_error());
	
	if($del == 1){
		
			print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=../inicio.php?pg=fluxo#tabs-3'>";
			

	}
}
?>