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

function formataData($data) {
    $data = date_create($data);
    return date_format($data, 'd/m/Y');
}
?>
<script>
    function openModal() {
        document.getElementById("openModal").style.display = "block";
    }

    function salvarObs() {

        var idAluno = $("#idAluno").val();
        var obs = $("#obs").val();
        var div = document.getElementById("resultObs");

        if (obs == "") {
            div.style.display = "block";
            div.innerHTML = "Informe a observa��o";
        } else {
            $.post('./DAO/observacao.php', {idAluno: idAluno, obs: obs}, function (resposta) {
                var idAluno = $("#idAluno").val();
                if (resposta == "salvo") {
                    window.location.href = "./perfilAluno.php?id=" + idAluno;
                }
            });
        }

    }
</script>
<html>
    <head>
        <meta charset="utf-8">
        <title>Perfil</title>
        <link rel="stylesheet" type="text/css" href="./css/ceiTopKids.css" />
        <script src="javascript/angular.js"></script>
        <script src="javascript/angular-messages.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./css/formoid-flat-green.css" type="text/css" />
        <link rel="stylesheet" href="./css/estiloMenu.css" type="text/css">
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css" />
        <link rel="stylesheet" type="text/css" href="css/modal.css"/>
        <script type="text/javascript" language="javascript" src="jquery-1.3.2.js"></script>
    </head>
    <body class='themeDesktopColor'>

        <form id="form1" class="formoid-flat-green">

            <div class="title" align="center" style="font-size: 20px; "><h2><font color="#ffffff">Cadastro</font></h2><?php include "menu2.php"; ?></div>
            <?php
            require "./DAO/perfilAluno.php";

            $idAluno = $_GET["id"];
            $dados = mysql_fetch_array(perfilDatalhe($idAluno));
            ?>
            <input type="hidden" id="idAluno" name="idAluno" value="<?php echo $idAluno; ?>"/>


            <div class='themeDesktopColor'>
                <div class='mainContainer'>
                    <div class="leftColumn leadingColumn">
                        <div class="pictureContainer">
                           <img class="profilePicture"  src="<?php echo $dados["photo"]; ?>" onerror="this.src='./img/nophoto.png';"> 
                        </div>
                        <div class='userPageRow'>
                            <div class='userName'><?php echo $dados["name"]; ?></div>
                            <div>
                                <a class='tabIcon' href='cadastrarAluno.php?id=<?php echo $idAluno; ?>'>
                                    <div class='tabBar'></div>
                                    <span>Editar</span>
                                </a>
                                <a class='tabIcon' href='#openModal'>
                                    <div class='tabBar'></div>
                                    <span onclick="openModal()">Inserir Obs</span>
                                </a>
                                <a class='tabIcon' href='#'>
                                    <div class='tabBar'></div>
                                    <span>Financeiro</span>
                                </a>                            
                            </div>
                        </div>
                    </div>
                    <div class="leadingColumn middleBox innerContainer">
                        <div class="profileNameBar typoSectionTitleFont"><?php echo $dados["name"]; ?></div>
                        <div class="profileSection profileHeader">
                            <span class="profileInfoEntry"><b>Turma:</b> <?php echo $dados["turma"]; ?></span>
                            <span class="profileInfoEntry"><b>Aniverçário:</b> <?php echo formataData($dados["birth_date"]); ?></span>

                            <span class="profileInfoEntry"><b>Aulas Extras</b>
                                <?php
                                $queryAulasExtras = listarAulasExtras($idAluno);
                                while ($dadosAulasExtras = mysql_fetch_array($queryAulasExtras)) {
                                    echo " -" . $dadosAulasExtras["aula"];
                                }
                                ?>
                            </span>
                            <span class="profileInfoEntry">&nbsp;</span>
                            <span class="profileInfoEntry"><b>Professor:</b> <a href='#'>Fernanda Ribas</a></span>
                            <div class="clearFloat"></div>                            
                        </div>
                        <div class="profileSection">
                            <div class="typoSectionTitleFont sectionTitle">Mãe Aluno</div>
                            <div class="profileSection profileHeader">
                                <span class="profileInfoEntry"><b>Nome: </b> <a href='cadastrarAluno.php?id=<?php echo $idAluno; ?>'> <?php echo $dados["mothersName"]; ?></a></span>
                                <span class="profileInfoEntry"><b>Telefone Principal: </b> <?php echo $dados["mothersPhone1"]; ?></span>
                                <div class="clearFloat"></div>                            
                            </div>
                        </div>
                        <div class="profileSection">
                            <div class="typoSectionTitleFont sectionTitle">Pai Aluno</div>
                            <div class="profileSection profileHeader">
                                <span class="profileInfoEntry"><b>Nome: </b> <a href='cadastrarAluno.php?id=<?php echo $idAluno; ?>'> <?php echo $dados["fatherName"]; ?></a></span>
                                <span class="profileInfoEntry"><b>Telefone Principal: </b> <?php echo $dados["fatherPhone1"]; ?></span>
                                <div class="clearFloat"></div>                            
                            </div>                         
                        </div>
                        <div class="profileSection">
                            <div class="typoSectionTitleFont sectionTitle">Certidão de Nascimento</div>
                            <div class="profileSection profileHeader">
                                <span class="profileInfoEntry"><b>Matricula: </b> <?php echo $dados["matricula"]; ?> </span>
                                <span class="profileInfoEntry"><b>Local: </b> <?php echo $dados["local"]; ?></span>
                                <span class="profileInfoEntry"><b>Cartório: </b> <?php echo $dados["cartorio"]; ?></span>
                                <span class="profileInfoEntry"><b>Data de emissção: </b> <?php echo $dados["dataEmissao"]; ?></span>
                                <div class="clearFloat"></div>                            
                            </div>  
                        </div>

                        <div class="profileSection">
                            <div class="typoSectionTitleFont sectionTitle">Pessoas autorizadas a buscar o aluno na escola</div>
                            <div class="profileCenterList">
                                <?php
                                $queryAlunos = listarPessoasAutorizadas($idAluno);
                                while ($dadosPessoasAutorizadas = mysql_fetch_array($queryAlunos)) {
                                    ?>
                                    <div class = "profileSection profileHeader">
                                        <span class = "profileInfoEntry"><b>Nome: </b> <?php echo $dadosPessoasAutorizadas["nome"]; ?></span>
                                        <span class = "profileInfoEntry"><b>RG: </b> <?php echo $dadosPessoasAutorizadas["rg"]; ?></span>
                                        <div class = "clearFloat"></div>
                                    </div>                                    
                                    <?php
                                }
                                ?>
                            </div>

                        </div>

                    </div>
                    <div class = "leadingColumn">

                        <div class = "innerContainer profileBox">
                            <div class = "typoSectionTitleFont boxTitle">Observações</div>
                            <div class = "scrollingItemsList">
                                <div class = "clearFloat">&nbsp;
                                </div>
                                <?php
                                $queryObs = listaObs($idAluno);
                                while ($dadosObs = mysql_fetch_array($queryObs)) {
                                    ?>
                                    <div class = 'tabBar'></div>
                                    <div ><span class = "profileInfoEntry"><b>Data: </b> <?php echo formataData($dadosObs["data"]); ?></span></div>
                                    <div class = "clearFloat"></div>
                                    <div class = "profileSection ">
                                        <span class = ""><?php echo $dadosObs["obs"]; ?></span>
                                        <div class = "clearFloat"></div>
                                    </div>
                                    <?php
                                }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


        </form>
    </body>
</html>             
<div id="openModal" class="modalDialog" style="display: none">
    <div>
        <a href="#close" title="Close" class="close2">X</a>
        <h2>Observação</h2>
        <p>Insira a observação do aluno.</p>
        <br>
        <textarea id="obs" name="obs" cols="49" rows="4"></textarea>
        <br>
        <div class="alert alert-danger" style="display: none" id="resultObs"></div>
        <br><br>
        <input class="btn-warning" onclick="salvarObs()" type="button" value="Salvar"/>
    </div>
</div>