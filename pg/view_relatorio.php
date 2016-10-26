<?php 
session_start();
//se nao existir volta para a pagina do form de login
if(!isset($_SESSION['login_session']) and !isset($_SESSION['senha_session'])){
	header("Location:../index.php");
	exit;		
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>RElatório de fluxo</title>
<style type="text/css">
body {
        font-family: sans-serif; font-size:11px;
    }
.titulo{
	font-size: 18px;
	font-family:Verdana, Geneva, sans-serif;
	font-weight:bold;
}
th{background:#E6E6E6; margin:0;}
table.bordasimples {border-collapse: collapse;}

table td{border-bottom:1px solid #CCC; font-size:10px;}

h2{text-align:center;}
</style>
</head>

<body>
<?php echo date("d/m/Y"); ?>

<?php 
	function datas($dado){
		$data = explode("/", $dado);
		$dia = $data[0];
		$mes = $data[1];
		$ano = $data[2];
		
		$resultado = $ano."-".$mes."-".$dia;
		return $resultado;	
		
	}


include "../classes/conexao.php";

$datai = datas($_POST['datai']);
$dataf = datas($_POST['dataf']);
$tipomov = $_POST['tipomov'];
$id_plano = $_POST['id_plano'];

$v = mysql_query("SELECT * FROM  flux_planos  WHERE id_plano = '$id_plano'");
$bb = mysql_fetch_array($v);
  if($tipomov == "b"){
	$titulo = "Recebimento de Boleto";
  }else{
	 $titulo =  $bb['descricao'];
  }

?>
<h2> Relatório de fluxo - <?php echo $titulo ?> </h2>
<table width="100%" border="0" cellpadding="5" cellspacing="0">
  <tr>
    <th width="9%" align="center" bgcolor="#999999">Tipo</th>
    <th align="left" bgcolor="#999999">Descrição do Movimento</td>
    <th align="left" bgcolor="#999999">Data    
    <th width="11%" bgcolor="#999999">Valor</th>
  </tr>
  
  <?php
  // se nao selecionar novimento ou plano //
  if($tipomov == "0" && $id_plano == 0 ){
  
$tabela = mysql_query("SELECT *,date_format(data, '%d/%m/%Y') AS datas FROM flux_entrada 
WHERE data BETWEEN ('$datai') AND ('$dataf')");		
  		while($j = mysql_fetch_array($tabela)){
	  	$total += $j['valor'];
  ?>
  <tr>
    <td><?php echo $j['tipo']?></td>
    <td width="42%"><?php echo $j['descricao'] ?></td>
    <td width="38%"><?php echo $j['datas'] ?></td>
    <td align="right"><?php echo number_format($j['valor'],2,",",".") ?></td>
  </tr>
  <?php } 
  
 $sql = mysql_query("SELECT *,date_format(dbaixa, '%d/%m/%Y') AS data FROM faturas WHERE situacao = 'B' AND dbaixa BETWEEN ('$datai') AND ('$dataf')");
  		while($ja = mysql_fetch_array($sql)){
	  	$total += $ja['valor_recebido'];
		if($ref = $ja['ref'] == ""){
			$ref = "Boleto Gerado pelo sistema";
		}else{
		$ref = $ja['ref'];
		}
		$totalgeral = $ja['valor_recebido'];
  ?>
  <tr>
    <td><?php echo "Boleto" ?></td>
    <td><?php echo $ref ?></td>
    <td><?php echo $ja['data'] ?></td>
    <td align="right"><?php echo number_format($totalgeral,2,",",".") ?></td>
  </tr>
  <?php } ?>
  
  
  
        <tr>
    <td colspan="4" align="right"><strong>Valor Total:</strong> <?php echo number_format($total,2,",",".") ?></td>
  </tr>
  
  
  <?php 
  }
  ///////////////////// se o movimento  for boleto ////////////////////
  elseif($tipomov == "b" && $id_plano == 0){
	$tipomov = "Boleto";
  	$sql = mysql_query("SELECT *,date_format(dbaixa, '%d/%m/%Y') AS data FROM faturas WHERE situacao = 'B' AND dbaixa BETWEEN ('$datai') AND ('$dataf')");
  		while($j = mysql_fetch_array($sql)){
	  	$total += $j['valor_recebido'];
		if($ref = $j['ref'] == ""){
			$ref = "Boleto Gerado pelo sistema";
		}else{
		$ref = $j['ref'];
		}
		$totalgeral += $j['valor_recebido'];
  ?>
  <tr>
    <td><?php echo "Boleto" ?></td>
    <td><?php echo $ref ?></td>
    <td><?php echo $j['data'] ?></td>
    <td align="right"><?php echo number_format($j['valor_recebido'],2,",",".") ?></td>
  </tr>
  <?php } ?>
        <tr>
    <td colspan="4" align="right"><strong>Valor Total:</strong> <?php echo number_format($totalgeral,2,",",".") ?></td>
  </tr>
<?php
  }
  //////////////////////// se nao for boleto selecionar somento o movimento //////////////////////////////// 
  elseif($tipomov != "b" && $id_plano == 0 ){
  
$tabela = mysql_query("SELECT *,date_format(data, '%d/%m/%Y') AS datas FROM flux_entrada 
WHERE data BETWEEN ('$datai') AND ('$dataf') AND tipo='$tipomov'");		
  		while($j = mysql_fetch_array($tabela)){
	  	$totalgeral += $j['valor'];
  ?>
  <tr>
    <td><?php echo $j['tipo'] ?></td>
    <td width="42%"><?php echo $j['descricao'] ?></td>
    <td width="38%"><?php echo $j['datas'] ?></td>
    <td align="right"><?php echo number_format($j['valor'],2,",",".") ?></td>
  </tr>
    <?php } ?>
        <tr>
    <td colspan="4" align="right"><strong>Valor Total:</strong> <?php echo number_format($totalgeral,2,",",".") ?></td>
  </tr>
<?php

/// selecionando tudo
}else{
$tabela = mysql_query("SELECT *,date_format(data, '%d/%m/%Y') AS datas FROM flux_entrada 
WHERE data BETWEEN ('$datai') AND ('$dataf') AND tipo='$tipomov' AND id_plano = '$id_plano'");		
  		while($j = mysql_fetch_array($tabela)){
	  	$totalgeral += $j['valor'];
  ?>
  <tr>
    <td><?php echo $tipomov ?></td>
    <td width="42%"><?php echo $j['descricao'] ?></td>
    <td width="38%"><?php echo $j['datas'] ?></td>
    <td align="right"><?php echo number_format($j['valor'],2,",",".") ?></td>
  </tr>
  <?php } ?>
        <tr>
    <td colspan="4" align="right"><strong>Valor Total:</strong> <?php echo number_format($totalgeral,2,",",".") ?></td>
  </tr>
<?php
}
?>
</table>


</body>
</html>