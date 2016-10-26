<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Pagina não encontrada</title>
<?php 
$protocolo    = (strpos(strtolower($_SERVER['SERVER_PROTOCOL']),'https') === false) ? 'http' : 'https';
$host         = $_SERVER['HTTP_HOST'];
?>
<script type="text/javascript">
<!--
 var numero = 5;
 function chamar(){if(numero>0){document.getElementById('timers').innerHTML = --numero;}}
setInterval("chamar();", 1000);
setTimeout("document.location = '<?php echo $protocolo."://".$host ?>';",5000);
//-->
</script>
<style type="text/css">
body {
	background:#bfd3ee;
	font-family:Tahoma, Geneva, sans-serif;
}
#centro{
	position:absolute;
		left:50%;
		top:50%;
		margin-left:-220px;
		margin-top:-160px;
		background:#FFFFFF;
		width:400px;
		height:200px;
		padding:30px;
		-webkit-border-radius: 10px;
		-moz-border-radius: 10px;
		border-radius: 10px;
		-webkit-box-shadow: -1px 0px 7px 0px rgba(50, 50, 50, 0.75);
		-moz-box-shadow:    -1px 0px 7px 0px rgba(50, 50, 50, 0.75);
		box-shadow:         -1px 0px 7px 0px rgba(50, 50, 50, 0.75);
}
</style>
</head>

<body>



<div id="centro">
<h1>Está fatura foi excluida ou ja foi baixada.</h1>
<div align="center" style="font-family: tahoma; font-size: 16px;">Você será redirecionado em: <br><div style="font-family: tahoma; font-size: 56px;" id="timers">5</div>
</div>
</div>
</body>
</html>