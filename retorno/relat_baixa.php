<?php include "../classes/conexao.php";?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Relatório de faturas baixadas.</title>
<style type="text/css">
body {
        font-family: sans-serif; font-size:11px;
    }
.titulo{
	font-size: 18px;
	font-family:Verdana, Geneva, sans-serif;
	font-weight:bold;
}
th{background:#E6E6E6;}
table.bordasimples {border-collapse: collapse;}

table.bordasimples tr td {border:1px solid #CCC; font-size:10px;}

h2{text-align:center;}
</style>
</head>

<body>
Data: <?php echo date("d/m/Y"); ?>
<h2> Faturas baixadas </h2>
<table width="100%" border="0" cellspacing="0" cellpadding="3" class="bordasimples">
  <tr>
  <th width="4%" align="left" ></th>
    <th width="24%" align="left" ><strong>Cliente</strong></th>
    <th width="31%" align="left" ><strong>Nosso Numero</strong></th>
    <th width="13%" align="center" ><strong>Vencimento</strong></th>
    <th width="13%" align="center" ><strong>VLR boleto</strong></th>
    <th width="15%" align="center" ><strong>VLR Recebido</strong></th>
  </tr>
  <?php 
  $rel = mysql_query("SELECT * FROM financeiro ORDER BY nosso_numero ASC") or die(mysql_error());
  while($result = mysql_fetch_array($rel)){
	  $nosso = $result['nosso_numero'];
	  $pg = mysql_query("SELECT *,date_format(data_venci, '%d/%m/%Y') AS datav FROM faturas WHERE nosso_numero ='$nosso'");
	  $nomes = mysql_fetch_array($pg); 
	  if($nomes['nome'] != ""){
	  ?>
  
  	
  <tr>
    <td align="right"><?php echo $result['id']; ?></td>
    <td align="left"><?php if( $nomes['nome'] == ""){echo "Fatura inexistente.";}else{ echo $nomes['nome'];} ?></td>
    <td align="left"><?php echo $nomes['nosso_numero'];?></td>
    <td align="center"><?php echo $nomes['datav'];?></td>
    <td align="right"><?php echo number_format($nomes['valor'],2,',','.');?></td>
    <td align="right"><?php echo number_format($result['valor'],2,',','.');?></td>
  </tr> 
  
  <?php $total += $result['valor']; ?>
  <?php  } }?>
</table>
Total Recebido: <?php echo number_format($total,2,',','.'); ?>
<?php 
$limpa = mysql_query("TRUNCATE TABLE financeiro");

/* 	print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=../inicio.php?pg=fatbaixada'>
		  <script type=\"text/javascript\">
		  alert(\"FORAM BAIXADAS!\");
		  </script>";  */

?>

</body>
</html>