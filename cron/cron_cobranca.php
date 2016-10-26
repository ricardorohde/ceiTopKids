<?php
require ("../classes/conexao.php");
//verificar se extiste faturas vencidas e atualizar a situação delas
$baixa = mysql_query("UPDATE faturas SET situacao = 'V' WHERE situacao != 'B' AND data_venci < DATE(NOW())");

// encriptar a url
function base64url_encode($data) {
			return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
			}

require "../classes/class.phpmailer.php"; // chama a classe
$mail = new PHPMailer(); // estancia a classe

$sql = mysql_query("SELECT * FROM maile")or die (mysql_error());
$linha = mysql_fetch_array($sql);
	$host 		= $linha['url'];
	$empresa 	= $linha['empresa'];
	$endereco 	= $linha['endereco'];
	$email 		= $linha['email'];
	$html 		= $linha['text2'];

$sql = mysql_query("SELECT *,date_format(data_venci, '%d/%m/%Y') AS data FROM faturas WHERE situacao = 'V'") or die(mysql_error());
while($ver = mysql_fetch_array($sql)){
		$idCli 			= $ver['id_cliente'];
		$idfatura 		= $ver['id_venda'];
		$valorfatura 	= $ver['valor'];
		$datavenc 		= $ver['data'];
		$num_doc		= $ver['id_venda'];
		$referente 		= $ver['ref'];

$sql2 = mysql_query("SELECT * FROM cliente WHERE id_cliente='$idCli'")or die (mysql_error());
$l = mysql_fetch_array($sql2);
		$cliente 	= $l['nome'];
		$mailer 	= $l['email'];
		

// define que será usado SMTP
$mail->IsSMTP();
// envia email HTML
$mail->isHTML( true );
// codificação UTF-8, a codificação mais usada recentemente
$mail->Charset = 'UTF-8';
// Configurações do SMTP
$mail->SMTPAuth = true;
//$mail->SMTPDebug = true;
$mail->SMTPSecure 	= 'SSL';
$mail->Host 		= $linha['url'];
$mail->Port 		= $linha['porta'];
$mail->Username 	= $linha['email'];
$mail->Password 	= $linha['senha'];
 
// E-Mail do remetente (deve ser o mesmo de quem fez a autenticação
// nesse caso seu_login@gmail.com)
$mail->From = $linha['email'];
// Nome do rementente
$mail->FromName = utf8_decode($linha['empresa']);
// assunto da mensagem
$mail->Subject = utf8_decode($linha['avisofataberto']);
// corpo da mensagem

$dado = 'id_venda='.$idfatura;
$pagina = base64url_encode($dado);
$link = $endereco.'boleto/boleto.php?'.$pagina; // monta a url

$dado = $html;
// substituindo valores dentro do html
$search = array('[NomedoCliente]', '[valor]','[vencimento]','[numeroFatura]','[Descricaodafatura]','[link]'); // pega oa variaveis do html vindo do banco;
$replace = array($cliente, number_format($valorfatura,2,',','.'),$datavenc,$idfatura,$referente,$link); //  variavis que substiruem os valores
$subject = $dado;
	$texto = str_replace($search, $replace, $subject);

$mail->Body = $texto;
$mail->AddAddress($mailer);

$mail->ClearAllRecipients();
$mail->ClearAttachments();

// verifica se enviou corretamente
if($mail->Send())
{
	 echo "Enviado para: ".$mailer.'<br/>';
} 
}
?>