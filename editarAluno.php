<?php

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
        <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
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
        </script>
        <style>
            .tudo4 {
                float: right; width:74%; 
            }
        </style>
    </head>
    <div class="useracess">
        <div id="userregisterform" style="clear:both; display:block; ">
            <form id="form1" name="matriculaForm" enctype="multipart/form-data" class="formoid-flat-green" style="background-color:#cccccc; font-size:14px;font-family:'Lato', sans-serif;color:#666666;" method="post" action="./DAO/editarAluno.php?func=salvar" >
                <div class="title" align="center" style="font-size: 20px; "><h2><font color="#ffffff">{{app}}</font></h2><?php include "menu.php"; ?></div>

                <?php
                require "./DAO/editarAluno.php";

                $idAluno = $_GET["id"];
                $dados = mysql_fetch_array(perfilDatalhe($idAluno));
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
                                <td><input class="form-control" type="text" name="nomeAluno" value="<?php echo $dados["name"]; ?>" id="nomeAluno" placeholder="Nome Aluno" ng-required="true" ng-minlength="2"/></td>
                                <td>Data Nascimeto<font style="color: #ff0000">*</font></td>
                                <td><input class="form-control" type="date" name="dataNascimento" id="dataNascimento" value="<?php echo $dados["birth_date"]; ?>" placeholder="Idade" ng-required="true" ng-minlength="2"/></td>
                            </tr>  
                            <tr>
                                <td>Sexo Aluno<font style="color: #ff0000">*</font></td>
                                <td><select class="form-control" name="sexo" id="sexo" required="true">
                                        <option value="">Selecione o Sexo</option>
                                        <option value="MASCULINO" <?php if($dados["gender"] == "MASCULINO"){ echo "selected";} ?> >MASCULINO</option>
                                        <option value="FEMININO" <?php if($dados["gender"] == "FEMININO"){ echo "selected";} ?> >FEMININO</option>
                                    </select>
                                </td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                            </tr>
                            <tr>
                                <td>Nome da Mãe<font style="color: #ff0000">*</font></td>
                                <td><input class="form-control" type="text" name="nomeMae" id="nomeMae" value="<?php echo $dados["mothersName"]; ?>" placeholder="Nome Mãe" ng-required="true" ng-minlength="2"/></td>
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
                                <td><input class="form-control" type="text" name="nomePai" id="nomePai" value="<?php echo $dados["fatherName"]; ?>" placeholder="Nome Pai" ng-required="false" ng-minlength="2"/></td>
                                <td>RG Pai</td>
                                <td><input class="form-control" type="number" name="rgPai" id="rgPai" value="<?php echo $dados["fatherRg"]; ?>" placeholder="RG" ng-required="false" ng-maxlength="8"/></td>
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
                                <td colspan="4" class="alert alert-info jumbotron negrito">
                                    Endereço.
                                </td>
                            </tr>
                            <tr>
                                <td>Logradouro<font style="color: #ff0000">*</font></td>
                                <td><input class="form-control" type="text" name="logradouro" id="logradouro" value="<?php echo $dados["logradouro"]; ?>" placeholder="Logradouro" ng-required="true" ng-minlength="2"/></td>
                                <td>Número<font style="color: #ff0000">*</font></td>
                                <td><input class="form-control" type="text" name="numeroLogradouro" id="numeroLogradouro" value="<?php echo $dados["numero"]; ?>" placeholder="Numero" ng-required="true" /></td>
                            </tr>
                            <tr>
                                <td>Bairro</td>
                                <td><input class="form-control" type="text" name="bairro" id="bairro" value="<?php echo $dados["bairro"]; ?>" placeholder="Bairro" ng-required="false" ng-minlength="2"/></td>
                                <td>Cidade</td>
                                <td><input class="form-control" type="text" name="cidade" id="cidade" value="<?php echo $dados["cidade"]; ?>" placeholder="Cidade" ng-required="false" /></td>
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
                                <td><input class="form-control" type="text" name="local" id="local" value="<?php echo $dados["local"]; ?>" placeholder="Local" ng-required="false" /></td>
                            </tr>
                            <tr>
                                <td>Cartório</td>
                                <td><input class="form-control" type="text" name="cartorio" id="cartorio" value="<?php echo $dados["cartorio"]; ?>" placeholder="Cartório"  ng-required="false" ng-minlength="2"/></td>
                                <td>Data Emissão</td>
                                <td><input class="form-control" type="text" name="dataEmissao" id="dataEmissao" value="<?php echo $dados["dataEmissao"]; ?>" placeholder="Data Emissão" ng-required="false" /></td>
                            </tr>
                            <tr>
                                <td colspan="4" class="alert alert-info jumbotron negrito">
                                    Pessoas autorizadas a buscar o aluno na escola 
                                </td>
                            </tr>
                            <?php
                            $queryAlunos = listarPessoasAutorizadas($idAluno);
                            $arrayNomePessoas = array();
                            $arrayRgPessoas = array();
                            $aux = 0;
                            while ($dadosPessoasAutorizadas = mysql_fetch_array($queryAlunos)) {
                                $arrayNomePessoas[$aux] = $dadosPessoasAutorizadas["nome"];
                                $arrayRgPessoas[$aux] = $dadosPessoasAutorizadas["rg"];
                                $aux++;
                            }

                            for ($i = 1; $i <= 3; $i++) {
                                ?>
                                <tr>
                                    <td>Nome</td>
                                    <td><input class="form-control" type="text" name="nomePessoa<?php echo $i; ?>" id="nomePessoa<?php echo $i; ?>" value="<?php echo $arrayNomePessoas[$i - 1]; ?>" placeholder="Nome" ng-required="false" ng-minlength="2"/></td>
                                    <td>RG</td>
                                    <td><input class="form-control" type="text" name="rgPessoa<?php echo $i; ?>" id="rgPessoa<?php echo $i; ?>" placeholder="RG" value="<?php echo $arrayRgPessoas[$i - 1]; ?>" ng-required="false" /></td>
                                </tr>
                                <?php
                            }
                            ?>
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
                                        while ($listaTurmas = mysql_fetch_array($queryTurmas)) {
                                            ?>
                                            <option value="<?php echo $listaTurmas["turma"]; ?>"><?php echo $listaTurmas["turma"]; ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select>
                                </td>
                                <td>&nbsp;</td>
                                <td>&nbsp;</td>
                                
                            </tr>
                            
                            <tr>
                                <td>Aulas Extras</td>                                
                                <td>
                                    <input type="checkbox" name="bale" value="bale">Balé<br>
                                </td>
                                <td>
                                    <input type="checkbox" name="capoeira" value="capoeira">Capoeira<br>
                                </td>
                                <td><input type="checkbox" name="judo" value="judo">Judô<br></td>
                                
                            </tr>
                            
                        </table>

                        <input style="background-color: #03C;" type="submit" id="pesquisa" value="Salvar"/>
                    </div>
                </body>
            </form>
        </div>
    </div>
</html>
