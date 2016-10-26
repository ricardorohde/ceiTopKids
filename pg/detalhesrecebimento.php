<?php 
include '../alerta_wamp.php';
session_start();
//se nao existir volta para a pagina do form de login
if(!isset($_SESSION['login_session']) and !isset($_SESSION['senha_session'])){
	header("Location:../index.php");
	exit;		
}
?>
<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Edita fatura</title>
<link href="../css/styles.css" rel="stylesheet" type="text/css">
<link href="../css/jquery-uicss.css" rel="stylesheet" type="text/css">
<link href="../css/principal.css" rel="stylesheet" type="text/css">
<link rel="stylesheet" type="text/css" href="../css/icons.css" />
<link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css" />
<link href="../css/jquery-ui-1.10.4.custom.css" rel="stylesheet" type="text/css">
<style type="text/css">
body {
	background: #f2f2f2;
	padding:10px;
}
#dados{padding:10px; width:90%; background:#FFF; border:1px dashed #666; text-align:left; margin-bottom:5px;}
</style>
</head>

<body>
<div id="entrada">
<div id="cabecalho"><h2><i class="icon-edit iconmd"></i> Detalhes</h2></div>
<?php 
	include "../classes/conexao.php";
	$id = $_GET['id_venda'];
	$sql= mysql_query("SELECT *,date_format(data_venci, '%d/%m/%Y') AS data_v,date_format(dbaixa, '%d/%m/%Y') AS dtabaixa FROM faturas WHERE id_venda='$id'");
	$ver = mysql_fetch_array($sql);
	$juros = $ver['valor_recebido'] - $ver['valor'];
?>

<div id="forms">
<div id="dados">Numero da fatura: <strong><?php echo $ver['id_venda']; ?></strong></div>
<div id="dados">Data de vencimento: <strong><?php echo $ver['data_v']; ?> </strong></div>
<div id="dados">Data da baixa: <strong><?php echo $ver['dtabaixa']; ?> </strong></div>
<div id="dados">Banco de recebimento: <strong><?php echo $ver['codbanco']; ?></strong></div>
<div id="dados">Agência de recebimento: <strong><?php echo $ver['banco_receb']."-".$ver['dv_receb'] ?></strong> </div>
<div id="dados">Valor da fatura: <strong><?php echo number_format($ver['valor'], 2, ',', '.'); ?></strong></div>
<div id="dados">Multa/juros: <strong><?php echo number_format($juros, 2, ',', '.') ?></strong> </div>
<div id="dados">Total recebido: <strong><?php echo number_format($ver['valor_recebido'], 2, ',', '.'); ?></strong></div>

</div>


</body>
</html>