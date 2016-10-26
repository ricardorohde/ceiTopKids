<?php
require './alerta_wamp.php';
include "./classes/conexao.php";
$idAluno = $_GET["id"];
$acao = "salvar";
if ($idAluno != "") {
    $acao = "editar";
}

function formataIdade($data) {
    $data = date_create($data);
    return date_format($data, 'm/d/Y');
}
?>
<html ng-app="formularioMatricula">
    <head>
        <meta charset="utf-8">
        <title ng-controller="formularioMatriculaCtrl">{{app}}</title>
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css" />
        <script src="javascript/angular.js"></script>
        <script src="javascript/angular-messages.js"></script>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="./css/formoid-flat-green.css" type="text/css" />
        <link rel="stylesheet" href="./css/estiloMenu.css" type="text/css">
        <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css" />

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
                $scope.app = "Cadastro Alunos";
                $scope.sexoAluno = [
                    {nome: "Masculino"},
                    {nome: "Feminino"}
                ];

            });

            function validaResponsavelBoleto(v) {
                nomePai = document.getElementById("nomePai").value;
                cpfPai = document.getElementById("cpfPai").value;
                rgPai = document.getElementById("rgPai").value;

                if (v == "PAI" && (nomePai == "" || cpfPai == "" || rgPai == "")) {
                    alert("Informe os dados do Pai");
                    document.getElementById("responsavelPagamento").options[0].selected = "true";
                }
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
            <form id="form1" name="matriculaForm" enctype="multipart/form-data" class="formoid-flat-green" style="background-color:#cccccc; font-size:14px;font-family:'Lato', sans-serif;color:#666666;" method="post" action="./DAO/cadastrarAluno.php?acao=<?php echo $acao; ?>" >
                <input type="hidden" id="idAluno" name="idAluno" value="<?php echo $idAluno; ?>"/>
                <div class="title" align="center" style="font-size: 20px; "><h2><font color="#ffffff">{{app}}</font></h2><?php include "menu2.php"; ?></div>

                <?php
                require "./DAO/cadastrarAluno.php";

                if ($idAluno != "") {
                    $dados = mysql_fetch_array(perfilDatalhe($idAluno));
                }
                ?>

                <body ng-controller="formularioMatriculaCtrl">
                    <div class="jumbotron">
                        <table style="width: 100%; " class="table table-striped">
                            <tr>
                                <td colspan="4" class="alert alert-info jumbotron negrito">
                                    Dados do aluno e dos pais.
                                </td>
                            </tr>
                            <tr>
                                <td>Nome Aluno<font style="color: #ff0000">*</font></td>
                                <td><input class="form-control" type="text" name="nomeAluno" style="text-transform: uppercase" value="<?php echo $dados["name"]; ?>" id="nomeAluno" placeholder="Nome Aluno" ng-required="true" ng-minlength="2"/></td>
                                <td>Data Nascimeto<font style="color: #ff0000">*</font></td>
                                <td><input class="form-control" type="date" name="dataNascimento" id="dataNascimento" value="<?php echo $dados["birth_date"]; ?>" placeholder="Idade" ng-required="true" ng-minlength="2"/></td>
                            </tr>  
                            <tr>
                                <td>Sexo Aluno<font style="color: #ff0000">*</font></td>
                                <td><select class="form-control" name="sexo" id="sexo" required="true">
                                        <option value="">Selecione o Sexo</option>
                                        <option value="MASCULINO" <?php
                                        if ($dados["gender"] == "MASCULINO") {
                                            echo "selected";
                                        }
                                        ?> >MASCULINO</option>
                                        <option value="FEMININO" <?php
                                        if ($dados["gender"] == "FEMININO") {
                                            echo "selected";
                                        }
                                        ?> >FEMININO</option>
                                    </select>
                                </td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>Nome da Mãe<font style="color: #ff0000">*</font></td>
                                <td><input class="form-control" type="text" name="nomeMae" id="nomeMae" style="text-transform: uppercase" value="<?php echo $dados["mothersName"]; ?>" placeholder="Nome Mãe" ng-required="true" ng-minlength="2"/></td>
                                <td>RG Mãe<font style="color: #ff0000">*</font></td>
                                <td><input class="form-control" type="number" name="rgMae" id="rgMae" placeholder="RG" value="<?php echo $dados["mothersRg"]; ?>" ng-required="true" ng-maxlength="8"/></td>
                            </tr>  
                            <tr>
                                <td>CPF da Mãe</td>
                                <td><input class="form-control" type="number" name="cpfMae" id="cpfMae" placeholder="CPF Mãe" value="<?php echo $dados["mothersCpf"]; ?>" ng-required="false" ng-minlength="2"/></td>
                                <td>Fone Contato Mãe<font style="color: #ff0000">*</font></td>
                                <td><input class="form-control" type="text" name="foneMae" id="foneMae" value="<?php
                                    echo $dados["mothersPhone1"];
                                    if ($dados["mothersPhone2"] != "") {
                                        echo "; " . $dados["mothersPhone2"];
                                    } if ($dados["mothersPhone3"] != "") {
                                        echo "; " . $dados["mothersPhone3"];
                                    }
                                    ?>" placeholder="Telefone Contato" title="Separar por ; para mais telefones" ng-required="true" /></td>
                            </tr>
                            <tr>
                                <td>Nome da Pai</td>
                                <td><input class="form-control" type="text" name="nomePai" id="nomePai" style="text-transform: uppercase" value="<?php echo $dados["fatherName"]; ?>" placeholder="Nome Pai" ng-required="false" ng-minlength="2"/></td>
                                <td>RG Pai</td>
                                <td><input class="form-control" type="text" name="rgPai" id="rgPai" value="<?php echo $dados["fatherRg"]; ?>" placeholder="RG" ng-required="false" /></td>
                            </tr>
                            <tr>
                                <td>CPF da Pai</td>
                                <td><input class="form-control" type="number" name="cpfPai" id="cpfPai" value="<?php echo $dados["fatherCpf"]; ?>" placeholder="CPF Pai" ng-required="false" ng-minlength="2"/></td>
                                <td>Fone Contato Pai</td>
                                <td><input class="form-control" type="text" name="fonePai" id="fonePai" value="<?php
                                    echo $dados["fatherPhone1"];
                                    if ($dados["fatherPhone2"] != "") {
                                        echo "; " . $dados["fatherPhone2"];
                                    } if ($dados["fatherPhone3"] != "") {
                                        echo "; " . $dados["fatherPhone3"];
                                    }
                                    ?>" placeholder="Telefone Contato" title="Separar por ; para mais telefones" ng-required="false" ng-maxlength="8"/></td>
                            </tr>
                            <tr>
                                <td>Responsavel Pagamento<font style="color: #ff0000">*</font></td>
                                <td>
                                    <select class="form-control" name="responsavelPagamento" id="responsavelPagamento" onChange="validaResponsavelBoleto(this.options[this.selectedIndex].value)" ng-required="true">
                                        <option value="">Selecione o Responsavel</option>
                                        <option value="MAE">MAE</option>
                                        <option value="PAI">PAI</option>
                                    </select>
                                </td>
                                <td>E-mail Responsavel</td>
                                <td><input class="form-control" type="email" name="emailPagamento" id="emailPagamento" style="text-transform: uppercase" value="<?php echo $dados["emailPagamento"]; ?>" placeholder="E-mail Responsavel" ng-required="true" /></td>
                            </tr>
                            <tr>
                                <td colspan="4" class="alert alert-info jumbotron negrito">
                                    Endereço.
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
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td colspan="4" class="alert alert-info jumbotron negrito">
                                    Dados da Certidão de Nascimento do Aluno 
                                </td>
                            </tr>
                            <tr>
                                <td>Matricula</td>
                                <td><input class="form-control" type="text" name="matricula" id="matricula" value="<?php echo $dados["matricula"]; ?>" placeholder="Matricula" ng-required="false" ng-minlength="2"/></td>
                                <td>Local</td>
                                <td><input class="form-control" type="text" name="local" id="local" style="text-transform: uppercase" value="<?php echo $dados["local"]; ?>" placeholder="Local" ng-required="false" /></td>
                            </tr>
                            <tr>
                                <td>Cartório</td>
                                <td><input class="form-control" type="text" name="cartorio" id="cartorio" style="text-transform: uppercase" value="<?php echo $dados["cartorio"]; ?>" placeholder="Cartório"  ng-required="false" ng-minlength="2"/></td>
                                <td>Data Emissão</td>
                                <td><input class="form-control" type="date" name="dataEmissao" id="dataEmissao" value="<?php echo $dados["dataEmissao"]; ?>" placeholder="Data Emissão" ng-required="false" /></td>
                            </tr>
                            <tr>
                                <td colspan="4" class="alert alert-info jumbotron negrito">
                                    Pessoas autorizadas a buscar o aluno na escola 
                                </td>
                            </tr>
                            <?php
                            if ($idAluno != "") {
                                $queryAlunos = listarPessoasAutorizadas($idAluno);
                                $arrayNomePessoas = array();
                                $arrayRgPessoas = array();
                                $aux = 0;
                                while ($dadosPessoasAutorizadas = mysql_fetch_array($queryAlunos)) {
                                    $arrayNomePessoas[$aux] = $dadosPessoasAutorizadas["nome"];
                                    $arrayRgPessoas[$aux] = $dadosPessoasAutorizadas["rg"];
                                    $aux++;
                                }
                            }


                            for ($i = 1; $i <= 3; $i++) {
                                ?>
                                <tr>
                                    <td>Nome</td>
                                    <td><input class="form-control" type="text" name="nomePessoa<?php echo $i; ?>" id="nomePessoa<?php echo $i; ?>" style="text-transform: uppercase" value="<?php echo $arrayNomePessoas[$i - 1]; ?>" placeholder="Nome" ng-required="false" ng-minlength="2"/></td>
                                    <td>RG</td>
                                    <td><input class="form-control" type="text" name="rgPessoa<?php echo $i; ?>" id="rgPessoa<?php echo $i; ?>"  placeholder="RG" value="<?php echo $arrayRgPessoas[$i - 1]; ?>" ng-required="false" /></td>
                                </tr>
                                <?php
                            }
                            ?>
                            <tr>
                                <td colspan="4" class="alert alert-success jumbotron negrito">
                                    Observa&ccedil;&atilde;o
                                </td>
                            </tr>
                            <tr>
                                <td>Obs</td>
                                <td colspan="2"><textarea id="obs" name="obs" cols="10" rows="4"></textarea></td>
                                <td ></td>
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
                                <td colspan="4" class="alert alert-info jumbotron negrito">
                                    Turma / Aulas Extras 
                                </td>
                            </tr>
                            <tr>
                                <td>Turma</td>                                
                                <td>
                                    
                                    <select class="form-control" name="turma" id="turma" >
                                        <option value="">Selecione a turma</option>
                                        <?php
                                        $queryTurmas = listarTurmas();
                                        $selectedTurma = "";
                                        if ($idAluno != "") {
                                            $dados["id_turma"];
                                        }
                                        while ($listaTurmas = mysql_fetch_array($queryTurmas)) {
                                            $selectedTurma = ($dados["id_turma"] == $listaTurmas["id"]) ? "selected" : "";
                                            ?>
                                            <option value="<?php echo $listaTurmas["id"]; ?>" <?php echo $selectedTurma; ?>><?php echo $listaTurmas["turma"]; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>

                            </tr>
                            <?php
                            $judoChecked = "";
                            $baleChecked = "";
                            $capoeiraChecked = "";
                            if ($idAluno != "") {
                                $queryAulasExtras = listarAulasExtras($idAluno);
                                while ($dadosAulasExtras = mysql_fetch_array($queryAulasExtras)) {
                                    if ($dadosAulasExtras["aula"] == "Judô") {
                                        $judoChecked = "checked";
                                    }
                                    if ($dadosAulasExtras["aula"] == "Balé") {
                                        $baleChecked = "checked";
                                    }
                                    if ($dadosAulasExtras["aula"] == "Capoeira") {
                                        $capoeiraChecked = "checked";
                                    }
                                }
                            }
                            ?>

                            <tr>
                                <td>Aulas Extras</td>                                
                                <td>
                                    <input type="checkbox" name="bale" value="bale" <?php echo $baleChecked; ?>>Balé<br>
                                </td>
                                <td>
                                    <input type="checkbox" name="capoeira" value="capoeira" <?php echo $capoeiraChecked; ?>>Capoeira<br>
                                </td>
                                <td><input type="checkbox" name="judo" value="judo" <?php echo $judoChecked; ?>>Judô<br></td>

                            </tr>

                        </table>

                        <input style="background-color: #03C;" type="submit" id="pesquisa" value="Salvar"/>
                    </div>
                </body>
            </form>
        </div>
    </div>
</html>
