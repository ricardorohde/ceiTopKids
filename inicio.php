<?php
require './alerta_wamp.php';
session_start();

///////////////////////////////////////////////////////////////////
// 					DESENVOLVIDO POR: EZEQUIEL SANTOS				//				
//////////////////////////////////////////////////////////////////

if (isset($_SESSION['cpfcnpj_session'])) {
    unset($_SESSION['cpfcnpj_session']);
    header("Location:index.php");
    exit;
}
//se nao existir volta para a pagina do form de login
if (!isset($_SESSION['login_session']) and ! isset($_SESSION['senha_session'])) {
    unset($_SESSION['login_session']);
    unset($_SESSION['senha_session']);
    header("Location:index.php");
    exit;
}

include "classes/conexao.php";

include "classes/funcoes.class.php";
include ("php/config.php");
$conecta = new recordset();
?>
<!DOCTYPE HTML>
<html><head>
        <meta charset="utf-8">
        <?php
        require ("classes/conexao.php");
        $sqld = mysql_query("SELECT * FROM config") or die(mysql_error());
        $d = mysql_fetch_array($sqld);
        ?>
        <title><?php echo $d['nome'] ?> - Gerênciador de Boletos</title>
        <link href="css/estiloMenu.css" rel="stylesheet" type="text/css">
        <link href="css/jquery-uicss.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="css/icons.css" />
        <link href="css/principal.css" rel="stylesheet" type="text/css">
        <link href="css/styles.css" rel="stylesheet" type="text/css">
        <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" />
        <script type="text/javascript" src="js/jquery.js"></script>
        <link rel="stylesheet" href="./css/estiloMenu.css" type="text/css">
        <?php
        if (isset($_GET['pg']) && $_GET['pg'] == "inicio") {
            ?>
            <script type="text/javascript" src="js/jquery.charts.js"></script>
        <?php } ?>
        <script type="text/javascript">
            $(function () {
                $("#estatistica").charts();
            })

        </script>
        <script type="text/javascript" src="js/jquery.mask-money.js"></script>
        <script type="text/javascript" src="tinymce/js/tinymce/tinymce.min.js"></script>
        <script type="text/javascript">
            tinymce.init({
                selector: "textarea",
                editor_deselector: "mceNoEditor",
                height: 400,
                plugins: [
                    "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
                    "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
                    "save table contextmenu directionality emoticons template paste textcolor"
                ],
                paste_data_images: true,
                language: 'pt_BR',
                toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l  link image | print preview media fullpage | forecolor backcolor emoticons",
            });
        </script>
        <script type="text/javascript" src="js/funcoes.js"></script>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    </head>

    <body>
        <form class="formoid-flat-green" style="background-color:#1F5A9D; font-size:14px;font-family:'Lato', sans-serif;color:#666666;" method="" action="" >
            <div class="title" align="center" style="font-size: 20px; "><br><h2><font color="#ffffff">Controle Financeiro</font></h2><?php include "menu2.php"; ?></div>
            <?php
            include "php/recordsets.php";
            $endereco = $_SERVER['REQUEST_URI'];
            $res = mysql_query("SELECT * FROM bancos WHERE id_banco ='1'");
            while ($list = mysql_fetch_array($res)) {
                $situacao = $list["situacao"];
                if ($situacao == "1") {
                    $banco = $list['img'];
                } else {
                    $banco = $list["img2"];
                }
                ?>

            <?php } ?>    
        </form>
        <br>
        <div id="cssmenu"><?php require ("menu.php"); ?></div>


        <div style="clear:both"></div>
        <div id="contents">
            <div id="conteudo">
                <div class="bar-success" id="includes">
                    <?php
                    if (isset($_GET['pg']) && $_GET['pg'] == "inicio") {
                        include "pg/main.php";
                    } elseif (isset($_GET['pg']) && $_GET['pg'] == "configuracoes") {
                        include "pg/configura.php";
                    } elseif (isset($_GET['pg']) && $_GET['pg'] == "banco") {
                        include "pg/banco.php";
                    } elseif (isset($_GET['pg']) && $_GET['pg'] == "confboleto") {
                        include "pg/configuraboleto.php";
                    } elseif (isset($_GET['pg']) && $_GET['pg'] == "confmail") {
                        include "pg/configmail.php";
                    } elseif (isset($_GET['pg']) && $_GET['pg'] == "cadclientes") {
                        include "pg/cadclientes.php";
                    } elseif (isset($_GET['pg']) && $_GET['pg'] == "listaclientes") {
                        include "pg/listaclientes.php";
                    } elseif (isset($_GET['pg']) && $_GET['pg'] == "grupo") {
                        include "pg/grupo.php";
                    } elseif (isset($_GET['pg']) && $_GET['pg'] == "lancafatura") {
                        include "pg/fatunica.php";
                    } elseif (isset($_GET['pg']) && $_GET['pg'] == "fatpendente") {
                        include "pg/fatpendente.php";
                    } elseif (isset($_GET['pg']) && $_GET['pg'] == "fatvencida") {
                        include "pg/fatvencidas.php";
                    } elseif (isset($_GET['pg']) && $_GET['pg'] == "fatbaixada") {
                        include "pg/fatbaixada.php";
                    } elseif (isset($_GET['pg']) && $_GET['pg'] == "baixa") {
                        include "retorno/index.php";
                    } elseif (isset($_GET['pg']) && $_GET['pg'] == "periodica") {
                        include "pg/fatperiodica.php";
                    } elseif (isset($_GET['pg']) && $_GET['pg'] == "modulos") {
                        include "pg/modulosonline.php";
                    } elseif (isset($_GET['pg']) && $_GET['pg'] == "fluxo") {
                        include "pg/fluxogeral.php";
                    } elseif (isset($_GET['pg']) && $_GET['pg'] == "listararquivos") {
                        include "pg/listaarquivos.php";
                    } else {
                        echo "<h2> Esta página não existe.</h2>";
                    }
                    mysql_close($bd);
                    ?>

                </div>
            </div>
            <div id="rodape">  Gerador de boletos <a href="https://www.facebook.com/afdesenvolvimentos/" target="_blank">AF Desenvolvimento de Sites e Sistemas Web</a> </div>
        </div>


    </body>
</html>
