<?php
include '../alerta_wamp.php';
require '../classes/conexao.php';
require '../classes/class.phpmailer.php';
$mail = new PHPMailer();

if (isset($_POST['enviar'])) {
    $cpfcnpj = str_replace(".", "", $_POST['cpfcnpj']);
    $cpfcnpj = str_replace("-", "", $cpfcnpj);

    $sql2 = mysql_query("SELECT * FROM cliente WHERE cpfcnpj='$cpfcnpj'")or die(mysql_error());
    $l = mysql_fetch_array($sql2);
    $cliente = $l['nome'];
    $mailer = $l['email'];
    $senhacli = $l['senha'];

    $sql = mysql_query("SELECT * FROM maile")or die(mysql_error());
    $linha = mysql_fetch_array($sql);
    $host = $linha['url'];
    $empresa = $linha['empresa'];
    $endereco = $linha['endereco'];
    $email = $linha['email'];
    $html = $linha['text1'];



    $mail->IsSMTP();
    $mail->isHTML(true);

    $mail->Charset = 'UTF-8';
    $mail->SMTPAuth = true;
    //$mail->SMTPDebug = true;
    $mail->SMTPSecure = 'SSL';
    $mail->Host = $linha['url'];
    $mail->Port = $linha['porta'];
    $mail->Username = $linha['email'];
    $mail->Password = $linha['senha'];

    // nesse caso seu_login@gmail.com)
    $mail->From = $linha['email'];

// Nome do rementente
    $mail->FromName = utf8_decode($linha['empresa']);

// assunto da mensagem
    $mail->Subject = utf8_decode($linha['empresa'] . ' - Recuperação de senha');
// corpo da mensagem


    $texto = utf8_decode("
<h3>Ola! $cliente</h3>
<h4>ESTA É UMA MENSAGEM AUTOMÁTICA, POR FAVOR NÃO RESPONDA</h4>
Conforme solicitado, estamos enviando  sua senha cadastrada em nosso sistema.<br/><br/>
<strong>Sua senha:</strong> $senhacli<br/>

<hr>
Caso você não tenha solicitado, desconsidere esta mensagem.
");

    $mail->Body = $texto;
    $mail->AddAddress($mailer);


// verifica se enviou corretamente
    if ($mail->Send()) {
        print"
			<script type=\"text/javascript\">
			alert(\"Sua senha foi enviada para seu email cadastrado em nosso sistema!\");
			</script>";
    } else {
        print"
			<script type=\"text/javascript\">
			alert(\" ERRO: CPF não encontrado. Por favor redigite seu CPF!\");
			</script>";
    }
} // fecha a if de enviar
?>

<!DOCTYPE HTML>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
        <title>rEENVIAR SENHA</title>
        <style type="text/css">
            body {
                background:#ebebeb;
                font-family:Verdana, Geneva, sans-serif; font-size:12px;
            }
            fieldset{
                -webkit-border-radius: 10px;
                -moz-border-radius: 10px;
                border-radius: 10px;
                background:#FFFFFF;
                overflow:hidden;	
            }
        </style>
        <script src="../js/jquery.js" type="text/javascript"></script>
        <script type="text/javascript" src="../js/jquery.maskedinput.js"></script>
        <script type="text/javascript">
            jQuery(function () {
                $("#cnpj").mask("999.999.999-99");
            });

            function up(lstr) { // converte minusculas em maiusculas
                var str = lstr.value; //obtem o valor
                lstr.value = str.toUpperCase(); //converte as strings e retorna ao campo
            }

            ///////////////////////// validacao campo cpf/cnpj //////////////////.
            function aplica_mascara_cpfcnpj(campo, tammax, teclapres) {
                var tecla = teclapres.keyCode;

                if ((tecla < 48 || tecla > 57) && (tecla < 96 || tecla > 105) && tecla != 46 && tecla != 8) {
                    return false;
                }

                var vr = campo.value;
                vr = vr.replace(/\//g, "");
                vr = vr.replace(/-/g, "");
                vr = vr.replace(/\./g, "");
                var tam = vr.length;

                if (tam <= 2) {
                    campo.value = vr;
                }
                if ((tam > 2) && (tam <= 5)) {
                    campo.value = vr.substr(0, tam - 2) + '-' + vr.substr(tam - 2, tam);
                }
                if ((tam >= 6) && (tam <= 8)) {
                    campo.value = vr.substr(0, tam - 5) + '.' + vr.substr(tam - 5, 3) + '-' + vr.substr(tam - 2, tam);
                }
                if ((tam >= 9) && (tam <= 11)) {
                    campo.value = vr.substr(0, tam - 8) + '.' + vr.substr(tam - 8, 3) + '.' + vr.substr(tam - 5, 3) + '-' + vr.substr(tam - 2, tam);
                }
                if ((tam == 12)) {
                    campo.value = vr.substr(tam - 12, 3) + '.' + vr.substr(tam - 9, 3) + '/' + vr.substr(tam - 6, 4) + '-' + vr.substr(tam - 2, tam);
                }
                if ((tam > 12) && (tam <= 14)) {
                    campo.value = vr.substr(0, tam - 12) + '.' + vr.substr(tam - 12, 3) + '.' + vr.substr(tam - 9, 3) + '/' + vr.substr(tam - 6, 4) + '-' + vr.substr(tam - 2, tam);
                }
            }

            //Verifica se CPF ou CGC e encaminha para a devida função, no caso do cpf/cgc estar digitado sem mascara
            function verifica_cpf_cnpj(cpf_cnpj) {
                if (cpf_cnpj.length == 11) {
                    return(verifica_cpf(cpf_cnpj));
                } else if (cpf_cnpj.length == 14) {
                    return(verifica_cnpj(cpf_cnpj));
                } else {
                    return false;
                }
                return true;
            }


        </script>

    </head>

    <body>
        <div id="conteudoform">
            <fieldset style="border:1px solid #666;"><legend><strong>Recuperar senha</strong></legend>
                <form action="" method="post" enctype="multipart/form-data">
                    Seu CPF:<br/>
                    <input name="cpfcnpj" type="text" id="cpf-cnpj" onkeydown="javascript:return aplica_mascara_cpfcnpj(this, 18, event)" onkeyup="javascript:return aplica_mascara_cpfcnpj(this, 18, event)" size="18" maxlength="18"><br/>
                    <input name="enviar" type="submit" value="Enviar">

                </form>
                <br/>
                <hr>
                Sua senha será enviada para o email cadastrado no sistema.

            </fieldset>

        </div>


    </body>
</html>