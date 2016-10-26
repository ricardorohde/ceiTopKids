<?php 
include "../classes/conexao.php";

function base64url_encode($data) {
			return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
			}

$str = $_SERVER['QUERY_STRING'];
$string = base64_decode($str);
$array = explode('&', $string);
foreach($array as $valores){
	$valores;
	$arrays = explode('=', $valores);
		foreach($arrays as $val){
		$dado[] = $val;
		}
}

$url = mysql_query("SELECT * FROM bancos WHERE situacao='1'");
$lista = mysql_fetch_array($url);
	$links = $lista['link'];
	$banco = $links."?".base64url_encode($dado[0]."=".$dado[1]);	

include $links;

?>