<!DOCTYPE HTML>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Untitled Document</title>
</head>

<body>
<?php
include "../classes/conexao.php";

function base64url_encode($data) {
			return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
			}

require '../classes/class.phpmailer.php';
//include("phpmailer/class.smtp.php");
$mail = new PHPMailer();


$sql = mysql_query("SELECT * FROM maile")or die (mysql_error());
$linha = mysql_fetch_array($sql);
$host = $linha['url'];
$empresa = $linha['empresa'];
$endereco = $linha['endereco'];
$email = $linha['email'];
$html = $linha['text2'];
/*
Supondo que o arquivo esteja dentro do
diretório raíz e sub-diretório phpmailer/
*/

 
// define que será usado SMTP
$mail->IsSMTP();
// envia email HTML
$mail->isHTML( true );
// codificação UTF-8, a codificação mais usada recentemente
$mail->Charset = 'UTF-8';
// Configurações do SMTP
$mail->SMTPAuth = true;
//$mail->SMTPDebug = true;
$mail->SMTPSecure = 'SSL';
$mail->Host = $linha['url'];
$mail->Port = $linha['porta'];
$mail->Username = $linha['email'];
$mail->Password = $linha['senha'];
 
// E-Mail do remetente (deve ser o mesmo de quem fez a autenticação
// nesse caso seu_login@gmail.com)
$mail->From = $linha['email'];
 
// Nome do rementente
$mail->FromName = $linha['empresa'];
 
// assunto da mensagem
$mail->Subject = utf8_decode($linha['aviso']);

///// conta o tempo 
$t = $linha['limitemail'] / 60;
// zera o limite de tempo de execução do script
set_time_limit(0);
// eviar emails
$cont = 0;

$sqlss = mysql_query("SELECT *,date_format(data_venci, '%d/%m/%Y') AS data FROM faturas WHERE situacao= 'V'") or die(mysql_error());
while($row = mysql_fetch_array($sqlss)){
	$idfatura = $row['id_venda'];
	$idcliente = $row['id_cliente'];
	$emailcliente = $row['emailcli'];
	$nomecliente = $row['nome'];
	$valorfatura = $row['valor'];
	$datavenc = $row['data'];
	$num_doc = $row['num_doc'];
	$referente = $row['ref'];

$dado = 'id_venda='.$idfatura;
$pagina = base64url_encode($dado);
$link = $endereco.'boleto/boleto.php?'.$pagina;

$dado = $html;
$search = array('[NomedoCliente]', '[valor]','[vencimento]','[numeroFatura]','[Descricaodafatura]','[link]'); // pega oa variaveis do html vindo do banco;
$replace = array($nomecliente, $valorfatura,$datavenc,$num_doc,$referente,$link); //  variavis que substiruem os valores
$subject = $dado;
$texto = str_replace($search, $replace, $subject);

$mail->Body = $texto;
$mail->AddAddress($emailcliente);

$cont ++;
if ( $mail->Send() ){
	/* print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=inicio.php?pg=periodica'>
			<script type=\"text/javascript\">
			alert(\"Foram geradas faturas para $cont clientes... Todas as notificações foram enviadas!\");
			</script>"; */
			//echo 'enviado';
					}else{
			print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=../inicio.php?pg=lancafatura'>
			<script type=\"text/javascript\">
			alert(\" ERRO: O email não foi enviado. Por favor revise os dados na configuração do email.\");
			</script>";
			break;
 						} 	
// adiciona um anexo
//$PHPMailer->AddAttachment( 'arquivo.pdf' );
} 
	print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=../inicio.php?pg=fatvencida'>
			<script type=\"text/javascript\">
			alert(\"Foi enviado cobrança para $cont clientes...\");
			</script>"; 

	
?>
</body>
</html>
