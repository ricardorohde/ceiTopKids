<?php
include "alerta_wamp.php";
include './classes/conexao.php';
$valorPesquisa = $_POST["valorPesquisa"];
?>


<!DOCTYPE html>
<html>
    <meta charset="utf-8">
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
    function delete(){
        alert();
    }
    </script>
    
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Listar Professores</title>
    </head>

    <style>
        .tudo4 {
            float: right; width:74%; 
        }
    </style>

    <div class="useracess">
        <div id="userregisterform" style="clear:both; display:block; ">
            <h22>&nbsp;</h22>
            <form id="form1" class="formoid-flat-green" style="background-color:#cccccc;font-size:14px;font-family:'Lato', sans-serif;color:#666666;max-width:80%;min-width:100%;min-height: 100%; max-height: 100%;" method="post" onSubmit="return valida(this)" >
                <div class="title" align="center" style="font-size: 20px; "><h2><font color="#ffffff">Cadastro</font></h2><?php include "menu2.php"; ?></div>

                <div >
                    <table style="width: 100%" >
                        <tr>
                            <td colspan="3" align="center" style="font-size:250%"/></td>
                        </tr>

                        <tr>
                            <td>
                                <div class="element-input">
                                    <label class="title"><font color="#666666">Pesquisar</font></label>
                                    <input class="small" type="text" name="valorPesquisa" id="valorPesquisa" value="<?php echo $valorPesquisa; ?>" />       
                                    <input style="background-color: #03C;" type="submit" id="pesquisa" value="Pesquisar"/>
                                </div>

                            </td>
                        </tr>

                        <tr>
                            <td>
                                <table width="100%" style="background-color: #ffffff;" class="table table-striped">
                                    <tr class="alert alert-info jumbotron negrito">
                                        <td align=center ><strong><font color="#999999">NOME</font></strong></td>
                                        <td align=center><strong><font color="#999999">RG</font></strong></td>
                                        <td align=center><strong><font color="#999999">CPF</font></strong></td>
                                        <td align=center><strong><font color="#999999">FUNÇÃO</font></strong></td>
                                        <td align=center colspan="2">AÇÕES</td>
                                    </tr>
                                    <tr>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                        <td>&nbsp;</td>
                                    </tr>

                                    <?php
                                    require "./DAO/listarProfessores.php";

                                    $queryProfessores = listaDeProfessores($valorPesquisa);
                                    while ($dados = mysql_fetch_array($queryProfessores)) {
                                        ?>
                                        <tr>
                                            <td align=left><strong><font color="#999999"><?php echo $dados["nome"]; ?> <?php echo $dados["last_name"]; ?></font></strong></td>
                                            <td align=center><strong><font color="#999999"><?php echo $dados["rg"]; ?></font></strong></td>
                                            <td align=center><strong><font color="#999999"><?php echo $dados["cpf"]; ?></font></strong></td>
                                            <td align=center><strong><font color="#999999"><?php echo $dados["funcao"]; ?></font></strong></td>
                                            <td align=center><strong><font color="#999999"><a href="perfilProfessor.php?id=<?php echo $dados["id"]; ?>" ><img src="./img/lupa.png" title="Visualizar Cadastro" width="24" height="23" border="0"></a></font></strong></td>
                                            <td align=center><strong><font color="#999999"><img src="./img/delete.png" title="Excluir Cadastro" onclick="delete();" width="24" height="23" border="0"></font></strong></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>

                                    <?php
                                    for ($i = 0; $i < 10; $i++) {
                                        ?>
                                        <tr>
                                            <td align=center><strong>&nbsp;</strong></td>
                                            <td align=center><strong>&nbsp;</strong></td>
                                            <td align=center><strong>&nbsp;</strong></td>
                                            <td align=center><strong>&nbsp;</strong></td>
                                            <td align=center><strong>&nbsp;</strong></td>
                                            <td align=center><strong>&nbsp;</strong></td>
                                        </tr>
                                        <?php
                                    }
                                    ?>


                                    <tr>
                                        <td align=center><strong>&nbsp;</strong></td>
                                        <td align=center><strong>&nbsp;</strong></td>
                                        <td align=center><strong>&nbsp;</strong></td>
                                        <td align=center><strong>&nbsp;</strong></td>
                                        <td align=center><strong>&nbsp;</strong></td>
                                        <td align=center><strong>&nbsp;</strong></td>
                                    </tr>





                                </table>
                            </td>
                        </tr>

                    </table>
                </div>




            </form>
        </div>
    </div>

</html>