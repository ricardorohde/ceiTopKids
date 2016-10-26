<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>Documento sem título</title>
</head>

<body>
<?php

function convdata($dataform, $tipo){
	if ($tipo == 0) {
		$datatrans = explode ("/", $dataform);
		$data = "$datatrans[2]-$datatrans[1]-$datatrans[0]";
	} elseif ($tipo == 1) {
		$datatrans = explode ("-", $dataform);
		$data = "$datatrans[2]/$datatrans[1]/$datatrans[0]";
	}elseif ($tipo == 2) {
		$datatrans = explode ("-", $dataform);
		$data = "$datatrans[1]/$datatrans[2]/$datatrans[0]";
	} elseif ($tipo == 3) {
		$datatrans = explode ("/", $dataform);
		$data = "$datatrans[2]-$datatrans[1]-$datatrans[0]";
	}

	return $data;
};

function diasEntreData($date_ini, $date_end){
	$data_ini = strtotime( convdata(convdata($date_ini,3),2)   ); //data inicial '29 de julho de 2003'
	$hoje = convdata($date_end,3);//date("m/d/Y"); // data atual
	$foo = strtotime($hoje); // transforma data atual em segundos (eu acho)
	$dias = ($foo - $data_ini)/86400; //calcula intervalo
	return $dias;
};

$dat_venc = "25/08/2014";
$dat_novo_venc = date("d/m/Y");
$valor_doc = 116.25;
$valor_multa = 2;
$juros_dia = 0.25;

echo "Vencimento: ".$dat_venc."<br>";
echo "Novo Vencimento: ".$dat_novo_venc."<br>";
echo "<br>";
echo "Valor juros ao dia: R$ 0,25<br>";
echo "Valor Multa: ".$valor_multa."%<br>";
echo "Valor do documento: ".$valor_doc.'<br><br>';

$juros =  (($juros_dia * (diasEntreData($dat_venc,$dat_novo_venc ))));
if($juros < 0){
	$juros = 0;
}

if(diasEntreData($dat_venc,$dat_novo_venc)<=0){
$multa = 0;
}else{
$multa = (($valor_multa * $valor_doc) / 100);}//Moeda(($valor_doc * 2) / 100);

$valorDocComJuros = $valor_doc + ($juros + $multa).'<br/>';




?>
</body>
</html>