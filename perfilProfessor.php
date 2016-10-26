<?php
require './alerta_wamp.php';
include './classes/conexao.php';
function formataData($data) {
    $data = date_create($data);
    return date_format($data, 'm/d/Y');
}
?>
<script>
    function openModal() {
        document.getElementById("openModal").style.display = "block";
    }

    function salvarObs() {

        var idProfessor = $("#idProfessor").val();
        var obs = $("#obs").val();
        var div = document.getElementById("resultObs");

        if (obs == "") {
            div.style.display = "block";
            div.innerHTML = "Informe a observação";
        } else {
            $.post('./DAO/observacaoProfessor.php', {idProfessor: idProfessor, obs: obs}, function (resposta) {
                var idProfessor = $("#idProfessor").val();
                if (resposta == "salvo") {
                    window.location.href = "./perfilProfessor.php?id=" + idProfessor;
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
           
            require "./DAO/perfilProfessor.php";

            $idProfessor = $_GET["id"];
            $dados = mysql_fetch_array(perfilDatalhe($idProfessor));
            ?>
            <input type="hidden" id="idProfessor" name="idProfessor" value="<?php echo $idProfessor; ?>"/>


            <div class='themeDesktopColor'>
                <div class='mainContainer'>
                    <div class="leftColumn leadingColumn">
                        <div class="pictureContainer">
                           <img class="profilePicture"  src="<?php echo $dados["photo"]; ?>" onerror="this.src='./img/nophoto.png';"> 
                        </div>
                        <div class='userPageRow'>
                            <div class='userName'><?php echo $dados["nome"]; ?></div>
                            <div>
                                <a class='tabIcon' href='cadastrarProfessor.php?id=<?php echo $idProfessor; ?>'>
                                    <div class='tabBar'></div>
                                    <span>Editar</span>
                                </a>
                                <a class='tabIcon' href='#openModal'>
                                    <div class='tabBar'></div>
                                    <span onclick="openModal()">Inserir Obs</span>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="leadingColumn middleBox innerContainer">
                        <div class="profileNameBar typoSectionTitleFont"><?php echo $dados["name"]; ?></div>
                        <div class="profileSection profileHeader">
                                <span class="profileInfoEntry"><b>Turma:</b> <?php echo $dadosTurma["turma"]; ?></span>
                                <span class="profileInfoEntry"><b>Aniversário:</b> <?php echo formataData($dados["birth_date"]); ?></span>
                                <span class = "profileInfoEntry"><b>RG: </b> <?php echo $dados["rg"]; ?></span>
                                <span class = "profileInfoEntry"><b>CPF: </b> <?php echo $dados["cpf"]; ?></span>
                                <span class = "profileInfoEntry"><b>Função: </b> <?php echo $dados["funcao"]; ?></span>
                                <span class = "profileInfoEntry"><b>Estado Civil: </b> <?php echo $dados["estadoCivil"]; ?></span>
                                <span class = "profileInfoEntry"><b>Formação: </b> <?php echo $dados["formacao"]; ?></span>
                                <span class = "profileInfoEntry"><b>Ano de Conclusão: </b> <?php echo $dados["anoConclusao"]; ?></span>
                                <span class="profileInfoEntry">&nbsp;</span>
                                <div class="clearFloat"></div>                            
                            </div>
                            <div class="profileSection">
                                <div class="typoSectionTitleFont sectionTitle">Endereço</div>
                                <div class="profileSection profileHeader">
                                    <span class="profileInfoEntry"><b>Logradouro: </b> <?php echo $dados["logradouro"]; ?></span>
                                    <span class="profileInfoEntry"><b>Número: </b> <?php echo $dados["numero"]; ?></span>
                                    <span class="profileInfoEntry"><b>Bairro: </b> <?php echo $dados["bairro"]; ?></span>
                                    <span class="profileInfoEntry"><b>Cidade: </b> <?php echo $dados["cidade"]; ?></span>
                                    <span class="profileInfoEntry"><b>Estado: </b> Paraná </span>
                                    <span class="profileInfoEntry"><b>Cep: </b> <?php echo $dados["cep"]; ?></span>
                                    <div class="clearFloat"></div>                            
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
                                $queryObs = listaObs($idProfessor);
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