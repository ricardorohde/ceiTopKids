<?php 
$protocolo = (strpos(strtolower($_SERVER['SERVER_PROTOCOL']), 'https') === false) ? 'http' : 'https';
function base64url_encode($data) {
			return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
			}
$pagina = base64url_encode('pg=cliente');

$stri = $protocolo."://".$_SERVER['HTTP_HOST'].$_SERVER['SCRIPT_NAME'].'?'.$pagina;
$sql1 = mysql_query("SELECT * FROM maile WHERE ENDERECO ='$stri'")or die (mysql_error());
$conf = mysql_num_rows($sql1);
$str = $_SERVER['QUERY_STRING'];
if($conf == 1){
$string = base64_decode($str);
$array = explode('&', $string);
foreach($array as $valores){
	$valores;
	$arrays = explode('=', $valores);
		foreach($arrays as $val){
		$dado[] = $val;
		}
}
$pg = $dado[0];
if(isset($dado[1])){
$pgi = $dado[1];
}
if($dado[0] == "pg" && $dado[1] == "cliente"){
	header('Location:clientes/index.php');		
}
}

?>