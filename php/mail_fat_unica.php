<?php

$sql2 = mysql_query("SELECT * FROM cliente WHERE id_cliente='$id_cliente'")or die (mysql_error());
$l = mysql_fetch_array($sql2);
$cliente = $l['nome'];

$sql = mysql_query("SELECT * FROM maile")or die (mysql_error());
$linha = mysql_fetch_array($sql);
$host = $linha['url'];
$empresa = utf8_decode($linha['empresa']);
$endereco = $linha['endereco'];
$email = $linha['email'];
$html = $linha['text1'];
$mailer = $nomecli['email'];

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
$mail->FromName = utf8_decode($linha['empresa']);
 
// assunto da mensagem
$mail->Subject = utf8_decode($linha['aviso']);
// corpo da mensagem

$sqlss = mysql_query("SELECT *,date_format(data_venci, '%d/%m/%Y') AS data FROM faturas WHERE id_venda = '$id_res'") or die(mysql_error());
$row = mysql_fetch_array($sqlss);
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
 // pega oa variaveis do html vindo do banco;
$search = array('[NomedoCliente]', '[valor]','[vencimento]','[numeroFatura]','[Descricaodafatura]','[link]');
$replace = array($nomecliente, $valorfatura,$datavenc,$idfatura,$referente,$link); //  variavis que substiruem os valores
$subject = $dado;

$texto = str_replace($search, $replace, $subject);

$mail->Body = $texto;
$mail->AddAddress($mailer);

 
// verifica se enviou corretamente
if ($mail->Send() )
{
	 print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=inicio.php?pg=lancafatura'>
			<script type=\"text/javascript\">
			alert(\"FATURA GERADA E NOTIFICAÇÃO ENVIADA COM SUCESSO!\");
			</script>";
}
else
{
		 print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=inicio.php?pg=lancafatura'>
			<script type=\"text/javascript\">
			alert(\" ERRO: O email não foi enviado. Por favor revise os dados na configuração do email.\");
			</script>";
}
?>
