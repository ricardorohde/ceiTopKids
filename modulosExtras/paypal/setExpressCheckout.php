<?php

require "../../classes/conexao.php";
////////////// arredonda valores /////////////////////////////////
function ceil_dec($number,$precision,$separator)
{
    $numberpart=explode($separator,$number); 
	@$numberpart[1]=substr_replace($numberpart[1],$separator,$precision,0);
    if($numberpart[0]>=0)
    {$numberpart[1]=ceil($numberpart[1]);}
    else
    {$numberpart[1]=floor($numberpart[1]);}

    $ceil_number= array($numberpart[0],$numberpart[1]);
    return implode($separator,$ceil_number);
}


$id_venda = $_GET['id_venda'];

$sql = mysql_query("SELECT * FROM config")or die (mysql_error());
$linha = mysql_fetch_array($sql);
/////////////////////////////////////////////////////////////////////////////
$compra = mysql_query("SELECT *,date_format(data_venci, '%d/%m/%Y') AS datad, date_format(data, '%d/%m/%Y') AS data FROM faturas WHERE id_venda='$id_venda' AND situacao !='B'")or die (mysql_error());
$contar = mysql_num_rows($compra);
$valor = mysql_fetch_array($compra);
$valor_doc = $valor['valor'];

$idcliente = $valor['id_cliente'];
$dat_novo_venc = date("d/m/Y");
$juros = $linha['juro'];
$multa = $linha['multa_atrazo'];



////////////////////////// CALCULA DIAS DE VENCIDO /////////////////////
$data_inicial = $valor['datad'];;
$data_final = date("d/m/Y");

function geraTimestamp($data) {
$partes = explode('/', $data);
return mktime(0, 0, 0, $partes[1], $partes[0], $partes[2]);
}
$time_inicial = geraTimestamp($data_inicial);
$time_final = geraTimestamp($data_final);
$diferenca = $time_final - $time_inicial; 
$dias = (int)floor( $diferenca / (60 * 60 * 24));
//------------- SE O VALOR FOR NEGATIVO COLOCA ZERO NA DIVERENCA ------------------------
if($dias <= 0){
	$dias = 0;		
}

////////////////////////////////////CALCULA JUROS //////////////////////////////////////////
$jurost = ($juros * $dias);

$valordojuro = ($valor_doc * $jurost / 100); 
$valorcomjuros = ($valor_doc + $valordojuro);
if($dias <= 0){
	$multa = 0;		
}
$valormulta = ($valorcomjuros * $multa / 100 );

$valor_boleto = @ceil_dec($valorcomjuros + $valormulta,2,'.');



//////////////////////////////////////////////////////////////////////////



$atu = mysql_query("UPDATE faturas SET modulo='PayPal', nosso_numero='' WHERE id_venda='$id_venda'");

// pagamento paypal id 1
$sql = mysql_query("SELECT * FROM pag_extra WHERE id = '1'") or die(mysql_error());
$dados = mysql_fetch_array($sql);


// pegando dados do pagamento

$d = mysql_query("SELECT * FROM faturas WHERE id_venda = '$id_venda'")or die(mysql_error());
$fatura = mysql_fetch_array($d);


//Incluindo o arquivo que contém a função sendNvpRequest
require 'sendNvpRequest.php';
 
//Vai usar o Sandbox, ou produção?
$sandbox = false;
 
//Baseado no ambiente, sandbox ou produção, definimos as credenciais
//e URLs da API.

   //credenciais da API para produção
    $user = $dados['user'];
    $pswd = $dados['pass'];
    $signature = $dados['assinatura'];
	
 
    //URL da PayPal para redirecionamento, não deve ser modificada
    $paypalURL = 'https://www.paypal.com/cgi-bin/webscr';
	
//Campos da requisição da operação SetExpressCheckout, como ilustrado acima.
$requestNvp = array(
    'USER' => $user,
    'PWD' => $pswd,
    'SIGNATURE' => $signature,
 
    'VERSION' => '108.0',
    'METHOD'=> 'SetExpressCheckout',
 
    'PAYMENTREQUEST_0_PAYMENTACTION' => 'SALE',
    'PAYMENTREQUEST_0_AMT' => $valor_boleto, // soma dos items do carrinho
    'PAYMENTREQUEST_0_CURRENCYCODE' => 'BRL',
    'PAYMENTREQUEST_0_ITEMAMT' => $valor_boleto, // soma dos items do carrinho
    'PAYMENTREQUEST_0_INVNUM' => $fatura['id_venda'],// id do produto
 
    'L_PAYMENTREQUEST_0_NAME0' => $fatura['ref'],
    'L_PAYMENTREQUEST_0_DESC0' => $fatura['ref'],
    'L_PAYMENTREQUEST_0_AMT0' => $valor_boleto,
    'L_PAYMENTREQUEST_0_QTY0' => '1',
    'L_PAYMENTREQUEST_0_ITEMAMT' => $valor_boleto,
	
	'HDRIMG' => $dados['logo'],
    'LOCALECODE' => 'pt_BR',
	
 
    'RETURNURL' => 'http://PayPalPartner.com.br/VendeFrete?return=1',
    'CANCELURL' => 'http://PayPalPartner.com.br/CancelaFrete',
    'BUTTONSOURCE' => 'BR_EC_EMPRESA'
);
 
//Envia a requisição e obtém a resposta da PayPal
$responseNvp = sendNvpRequest($requestNvp, $sandbox);
 
//Se a operação tiver sido bem sucedida, redirecionamos o cliente para o
//ambiente de pagamento.
if (isset($responseNvp['ACK']) && $responseNvp['ACK'] == 'Success') {
    $query = array(
        'cmd'    => '_express-checkout',
        'token'  => $responseNvp['TOKEN']
    );
 
    $redirectURL = sprintf('%s?%s', $paypalURL, http_build_query($query));
 
    header('Location: ' . $redirectURL);
} else {
    error_log($message);
}
