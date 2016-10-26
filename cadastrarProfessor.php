<?php
require './alerta_wamp.php';
require './classes/conexao.php';
require "./DAO/cadastrarProfessor.php";
$idProfessor = $_GET["id"];
$acao = "salvar";
if ($idProfessor != "") {
    $acao = "editar";
}

function formataIdade($data) {
    $data = date_create($data);
    return date_format($data, 'm/d/Y');
}
?>
<html ng-app="formularioMatricula">
    <head>
        <title ng-controller="formularioMatriculaCtrl">{{app}}</title>
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css" />
        <script src="javascript/angular.js"></script>
        <script src="javascript/angular-messages.js"></script>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./css/formoid-flat-green.css" type="text/css" />
        <link rel="stylesheet" href="./css/estiloMenu.css" type="text/css">
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css" />
        <script type="text/javascript" language="javascript" src="jquery-1.3.2.js"></script>
        <style>
            .jumbotron{
                width: 95%;
                text-align: center;
                margin-top: 20px;
                margin-left: auto;
                margin-right: auto;
            }
            .table{
                margin-top: 20px;
            }
            .form-control{
                margin-bottom: 5px;
            }
            .selecionado{
                background-color: yellow;
            }
            .negrito {
                font-weight: bold;
            }
            hr {
                border-color: #999;
            }
        </style>
        <script>
            angular.module("formularioMatricula", ["ngMessages"]);
            angular.module("formularioMatricula").controller("formularioMatriculaCtrl", function ($scope, uppercaseFilter) {
                $scope.app = "Cadastro Professor";
                $scope.sexoAluno = [
                    {nome: "Masculino"},
                    {nome: "Feminino"}
                ];

            });

            function habilitaCadastroTurma(v) {
                if (v != "")
                    document.getElementById("imgCadastrarTurma").style.display = "block";
                else
                    document.getElementById("imgCadastrarTurma").style.display = "none";
            }

            var arrayTurma = [];
            function addTurma() {
                var turma = document.getElementById("turma").value;
                arrayTurma.push(turma);

                // Captura a referência da tabela com id “minhaTabela”
                var table = document.getElementById("tableTurmas");
                // Captura a quantidade de linhas já existentes na tabela
                var numOfRows = table.rows.length;
                // Captura a quantidade de colunas da última linha da tabela
                var numOfCols = table.rows[numOfRows - 1].cells.length;

                // Insere uma linha no fim da tabela.
                var newRow = table.insertRow(numOfRows);

                // Faz um loop para criar as colunas
                for (var j = 0; j < arrayTurma.length; j++) {
                    // Insere uma linha no fim da tabela.
                    newRow = table.insertRow(numOfRows);
                    //alert(arrayTurma);
                    // Insere uma coluna na nova linha 
                    newCell = newRow.insertCell(j);
                    // Insere um conteúdo na coluna
                    newCell.innerHTML = arrayTurma[arrayTurma.length - 1];
                }
                document.getElementById("arrayTurma").value = arrayTurma;
                
            }
        </script>
        <style>
            .tudo4 {
                float: right; width:74%; 
            }
        </style>
    </head>
    
   <div class="useracess">
        <div id="userregisterform" style="clear:both; display:block; ">
            <form id="form1" name="matriculaForm" enctype="multipart/form-data" class="formoid-flat-green" style="background-color:#cccccc; font-size:14px;font-family:'Lato', sans-serif;color:#666666;" method="post" action="./DAO/cadastrarProfessor.php?acao=<?php echo $acao; ?>" >
                <input type="hidden" id="idProfessor" name="idProfessor" value="<?php echo $idProfessor; ?>"/>
                <div class="title" align="center" style="font-size: 20px; "><h2><font color="#ffffff">{{app}}</font></h2><?php include "menu2.php"; ?></div>

                <?php
                if ($idProfessor != "") {
                    $dados = mysql_fetch_array(perfilDatalhe($idProfessor));
                }
                
                  ?>
                 
                <body ng-controller="formularioMatriculaCtrl">
                    <div class="jumbotron">
                        <table style="width: 100%; " class="table table-striped">
                            <tr>
                                <td colspan="4" class="alert alert-info jumbotron negrito">
                                    Dados do professor
                                </td>
                            </tr>
                            <tr>
                                <td>Nome<font style="color: #ff0000">*</font></td>
                                <td><input class="form-control" type="text" name="nome" id="nome" style="text-transform: uppercase" value="<?php echo $dados["nome"];?>" placeholder="Nome" ng-required="true" /></td>
                                <td>RG<font style="color: #ff0000">*</font></td>
                                <td><input class="form-control" type="text" name="rg" id="rg" value="<?php echo $dados["rg"];?>" placeholder="RG" ng-required="true" /></td>
                            </tr>                              
                            <tr>
                                <td>CPF<font style="color: #ff0000">*</font></td>
                                <td><input class="form-control" type="text" value="<?php echo $dados["cpf"];?>" name="cpf" id="cpf" value="" placeholder="CPF" ng-required="true"/></td>
                                <td>Função<font style="color: #ff0000">*</font></td>
                                <td><input class="form-control" type="text" name="funcao" id="funcao" value="<?php echo $dados["funcao"];?>" style="text-transform: uppercase" placeholder="Função" value="" ng-required="true"></td>
                            </tr>  
                            <tr>
                                <td>Estado Civil<font style="color: #ff0000">*</font></td>
                                <td><input class="form-control" type="text" name="estadoCivil" value="<?php echo $dados["estadoCivil"];?>" id="estadoCivil" style="text-transform: uppercase" value="" placeholder="Estado Civil" /></td>
                                <td>Data Nascimento<font style="color: #ff0000">*</font></td>
                                <td><input class="form-control" type="date" value="<?php echo $dados["dataNascimento"];?>" name="dataNascimento" id="dataNascimento" placeholder="Data Nascimento" value="" ng-required="true"></td>
                            </tr>
                            <tr>
                                <td>Formação</td>
                                <td><input class="form-control" type="text" value="<?php echo $dados["formacao"];?>" name="formacao" id="formacao" style="text-transform: uppercase" value="" placeholder="Formação" ng-required="false" /></td>
                                <td>Ano de cconclusão</td>
                                <td><input class="form-control" type="number" value="<?php echo $dados["anoConclusao"];?>" name="anoConclusao" id="anoConclusao" value="anoConclusao" placeholder="Ano Conclusão" ng-required="false" /></td>
                            </tr>                            
                            <tr>
                                <td colspan="4" class="alert alert-info jumbotron negrito">
                                    Endereço
                                </td>
                            </tr>
                            <tr>
                                <td>Logradouro<font style="color: #ff0000">*</font></td>
                                <td><input class="form-control" type="text" name="logradouro" id="logradouro" style="text-transform: uppercase" value="<?php echo $dados["logradouro"]; ?>" placeholder="Logradouro" ng-required="true" ng-minlength="2"/></td>
                                <td>Número<font style="color: #ff0000">*</font></td>
                                <td><input class="form-control" type="text" name="numeroLogradouro" id="numeroLogradouro" value="<?php echo $dados["numero"]; ?>" placeholder="Numero" ng-required="true" /></td>
                            </tr>
                            <tr>
                                <td>Bairro</td>
                                <td><input class="form-control" type="text" name="bairro" id="bairro" style="text-transform: uppercase" value="<?php echo $dados["bairro"]; ?>" placeholder="Bairro" ng-required="false" ng-minlength="2"/></td>
                                <td>Cidade</td>
                                <td><input class="form-control" type="text" name="cidade" id="cidade" style="text-transform: uppercase" value="<?php echo $dados["cidade"]; ?>" placeholder="Cidade" ng-required="false" /></td>
                            </tr>
                            <tr>
                                <td>CEP<font style="color: #ff0000">*</font></td>
                                <td><input class="form-control" type="text" name="cep" id="cep" value="<?php echo $dados["cep"]; ?>" placeholder="Cep"  ng-required="true" ng-minlength="2"/></td>
                                <td>Estado</td>
                                <td><input class="form-control" type="text" name="cidade" id="cidade" style="text-transform: uppercase" value="Paraná" placeholder="Cidade" ng-required="false" /></td>
                            
                            </tr>

                            <tr>
                                <td colspan="4" class="alert alert-info jumbotron negrito">
                                    Turma
                                </td>
                            </tr>
                            <tr>
                                <td>Turma</td>                                
                                <td>
                                    <select multiple id="turma[]" name="turma[]" >
                                        <?php
                                        $queryTurmas = listarTurmas();
                                        $selectedTurma = "";
                                        if ($idProfessor != "") {
                                            $dados["id_turma"];
                                        }
                                        while ($listaTurmas = mysql_fetch_array($queryTurmas)) {                                            
                                            $selectedTurma = ($dados["id_turma"] == $listaTurmas["id"]) ? "selected" : "";
                                            $turmaSelected = "";
                                            if($idProfessor != ""){
                                                $turmaSelected = listarTurmasProfessor($idProfessor, $listaTurmas["id"]);
                                            }
                                            
                                            ?>
                                        <option <?php echo ($turmaSelected > 0)?"selected":""; ?> value="<?php echo $listaTurmas["id"]; ?>" <?php echo $selectedTurma; ?>><?php echo $listaTurmas["turma"]; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                   
                                </td>
                            </tr>
                            
                             <tr>
                                <td colspan="4" class="alert alert-success jumbotron negrito">
                                    Upload foto do perfil
                                </td>
                            </tr>
                            <tr>
                                <td>Arquivo</td>
                                <td colspan="3">
                                    <input type="file" name="myfile" id="myfile" accept="image/gif, image/jpeg, image/png" />
                                </td>
                            </tr>
                            <tr>
                        </table>

                        <input style="background-color: #03C;" type="submit" id="pesquisa" value="Salvar"/>
                    </div>
                </body>
            </form>
        </div>
    </div>
</html>
