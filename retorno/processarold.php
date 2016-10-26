<?php
include "conexao.php";

require_once("RetornoBanco.php");
require_once("RetornoFactory.php");



function linhaProcessada($self, $numLn, $vlinha) {
  if($vlinha) {
	  if($vlinha["registro"] == $self::HEADER_ARQUIVO)
		  echo "<b>".$vlinha['nome_empresa']."</b><br />";

	  else if($vlinha["registro"] == $self::DETALHE && $vlinha["segmento"] == "T") {
		  echo "Nosso N&uacute;mero: <b>".$vlinha['nosso_numero']."</b> - 
		  Venc: <b>".$vlinha['vencimento']."</b>".
		  " Vlr Titulo: <b>R\$ ".number_format($vlinha['valor'], 2, ',', '')."</b> - ".
		  " Vlr Tarifa: <b>R\$ ".number_format($vlinha['valor_tarifa'], 2, ',', '')."</b><br/>";
	  }
  } else echo "Tipo da linha n&atilde;o identificado<br/>\n";
}

function linhaProcessada1($self, $numLn, $vlinha) {
 if(!empty($vlinha))
    foreach($vlinha as $nome_indice => $valor){
	echo "$nome_indice: <b>$valor</b><br/>\n ";
	  $nm = $vlinha["nosso_numero"];
	  $venc = $vlinha['vencimento'];
	  $valor = $vlinha['valor'];
	  $banco = $vlinha['banco_receb'];
	  $ag_receb = $vlinha['ag_receb'];
	  $dv_receb = $vlinha['dv_receb'];
	  $lote = $vlinha['lote'];
	  $dbaixa = date("Y-m-d"); 
	  
  
/* $sql = mysql_query("INSERT INTO financeiro (nosso_numero) VALUES('$nm')ON DUPLICATE KEY UPDATE nosso_numero= '$nm'")or die(mysql_error()) ;
$id_res = mysql_insert_id();
//echo $id_res.'<br/>';	  
$contar = mysql_query("SELECT * FROM financeiro WHERE id='$id_res'") or die(mysql_error());
$dado = mysql_fetch_array($contar);
	$bosta = $dado['nosso_numero'];
	echo $bosta; */
  	$sql = mysql_query("UPDATE faturas SET lote='$lote' ,dbaixa = '$dbaixa', situacao = 'B' WHERE nosso_numero = '$nm'") or die(mysql_error());

	}
echo "<br/>";
}
/*  $sql = mysql_query("SELECT dbaixa FROM faturas ORDER BY dbaixa DESC LIMIT 1");
$v = mysql_fetch_array($sql);
$valordbaixa = $v['dbaixa'];

$contar = mysql_query("SELECT dbaixa FROM faturas WHERE dbaixa = '$valordbaixa'");
$dado = mysql_num_rows($contar);
			print "
				<META HTTP-EQUIV=REFRESH CONTENT='0; URL=../inicio.php?pg=baixa'>
				<script type=\"text/javascript\">
				alert(\"Foram Baixadas $dado faturas.\");
				</script>";   */ 
			
//--------------------------------------INÍCIO DA EXECUÇÃO DO CÓDIGO-----------------------------------------------------

$fileName = $_FILES['arquivo']['tmp_name'];

$cnab240 = RetornoFactory::getRetorno($fileName, "linhaProcessada1");

$retorno = new RetornoBanco($cnab240);
$retorno->processar();
?>
