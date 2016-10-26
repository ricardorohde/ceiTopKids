<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>
<script language="javascript">
function fechajanela() {
window.open("../inicio.php?pg=fluxo&atualizar=true","main");
}
</script>

<body onUnload="fechajanela()">
<?php 
include "../classes/conexao.php";

$id = $_GET['id_plano'];

if(isset($_POST['alterar'])){
		$descricao = $_POST['descricao'];
	$a = mysql_query("UPDATE flux_planos SET descricao='$descricao' WHERE id_plano= '$id'") or die(mysql_error());	
	if($a == 1){
	print "<script type=\"text/javascript\">javascript:window.close()</script>";		
	}
}

$sql = mysql_query("SELECT * FROM flux_planos WHERE id_plano='$id'");
$v = mysql_fetch_array($sql);
?>
<hr/>
<form action="" method="post" enctype="multipart/form-data">
	Descricao:<br/>
	<input name="descricao" type="text" value="<?php echo $v['descricao'] ?>" size="60"/><br/><br/>
    <input name="alterar" type="submit" value="Alterar" id="alterar" />

</form>
<hr/>

</body>
</html>