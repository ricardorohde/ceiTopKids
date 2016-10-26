<?php
include '../alerta_wamp.php';
?>
<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Editar dados de clientes</title>
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
    </head>
    <script language="javascript">
        function fechajanela() {
            window.open("../inicio.php?pg=listaclientes", "main");
        }
    </script>

    <script type="text/javascript" src="../js/funcoes.js"></script>
    <script type="text/javascript" src="../js/jquery.min.js"></script>

    <script type="text/javascript" src="../js/jquery.maskedinput.js"></script>
    <script type="text/javascript">
        jQuery(function () {
            $("#telefone").mask("(99) 9999-9999");
            $("#cep").mask("99999-999");

        });


        function up(lstr) { // converte minusculas em maiusculas
            var str = lstr.value; //obtem o valor
            lstr.value = str.toUpperCase(); //converte as strings e retorna ao campo
        }
    </script>
    <body onunload="fechajanela()">
        <div id="conteudoform">
            <?php
            include "../classes/conexao.php";

            if (isset($_POST['update'])) {
                $id = $_GET['id'];
                $id_grupo = $_POST['id_grupo'];
                $nome = $_POST['nome'];
                $cpfcnpj = $_POST['cpfcnpj'];
                $valor = $_POST['valor'];
                $rg = $_POST['rg'];
                $inscricao = $_POST['inscricao'];
                $endereco = $_POST['endereco'];
                $nome = $_POST['nome'];
                $numero = $_POST['numero'];
                $complemento = $_POST['complemento'];
                $bairro = $_POST['bairro'];
                $cidade = $_POST['cidade'];
                $uf = $_POST['uf'];
                $telefone = $_POST['telefone'];
                $cep = $_POST['cep'];
                $uf = $_POST['uf'];
                $email = $_POST['emails'];
                $obs = $_POST['obs'];
                $bloqueado = $_POST['bloqueado'];

                $sql = mysql_query("UPDATE cliente SET id_grupo='$id_grupo', nome='$nome', cpfcnpj='$cpfcnpj',valor = '$valor',inscricao='$inscricao', 
rg='$rg', endereco='$endereco', numero='$numero', complemento='$complemento', bairro='$bairro', cidade='$cidade',
 uf='$uf', telefone='$telefone', cep='$cep', email='$email', obs='$obs', bloqueado='$bloqueado' WHERE id_cliente='$id'")or die(mysql_error());
                if ($sql == 1) {
                    print "<script type=\"text/javascript\">javascript:window.close()</script>";
                }
            }

/////////////////////////////////////////////////////////////////////////////////////////////////////
            $id = $_GET['id'];
            $sql = mysql_query("SELECT * FROM cliente WHERE id_cliente='$id'")or die(mysql_error());
            $l = mysql_fetch_array($sql);
            ?>
            <fieldset style="border:1px solid #666;"><legend><strong>Edita Cadastro de Clientes</strong></legend>

                <form action="" method="post" enctype="multipart/form-data" id="clientes">

                    <table width="600" border="0">
                        <tr>
                            <td width="44%" align="left" valign="top">Nome:<br/>
                                <input name="nome" onkeyup="up(this)" type="text" size="43" value="<?php echo $l['nome'] ?>"></td>
                            <td colspan="2" align="left" valign="top">CPF/CNPJ:<br/>
                                <input name="cpfcnpj" onkeydown="javascript:return aplica_mascara_cpfcnpj(this, 18, event)" onkeyup="javascript:return aplica_mascara_cpfcnpj(this, 18, event)" size="18" maxlength="18" style="width:120px;" value="<?php echo $l['cpfcnpj'] ?>"><br/></td>
                            <td align="left" valign="top">
                                <script src="../js/jquery-1.10.2.js"></script>
                                <script type="text/javascript" src="../js/jquery.mask-money.js"></script>
                                <script type="text/javascript">
                                    $(document).ready(function () {
                                        $("#valor").maskMoney({decimal: ".", thousands: ""});
                                    });

                                </script>
                                Valor:<br/>
                                <input name="valor" type="text" id="valor" style="text-align:right; width:70px;" value="<?php echo $l['valor']; ?>" maxlength="10">

                            </td>
                        </tr>
                        <tr>
                            <td align="left" valign="top">RG:<br/><input name="rg" type="text" value="<?php echo $l['rg'] ?>"></td>
                            <td colspan="2" align="left" valign="top">Grupo:<br/>
                                <select name="id_grupo">
                                    <option value="">Selecione</option>
                                    <?php
                                    $confi = mysql_query("SELECT * FROM cliente WHERE id_cliente='$id'")or die(mysql_error());
                                    $confere = mysql_fetch_array($confi);
                                    $idss = $confere['id_grupo'];

                                    $sql1 = mysql_query("SELECT * FROM grupo WHERE id_grupo !='1' ORDER BY meses ASC")or die(mysql_error());
                                    while ($ver = mysql_fetch_array($sql1)) {
                                        $id_g = $ver['id_grupo'];
                                        $nomegrupo = $ver['nomegrupo'];
                                        ?>
                                        <option value="<?php echo $ver['id_grupo'] ?>" <?php
                                        if (!(strcmp($id_g, $idss))) {
                                            echo "selected=\"selected\"";
                                        }
                                        ?>>
                                                    <?php
                                                    echo $nomegrupo;
                                                    echo " - Vencimento dia:" . $ver['dia'];
                                                    ?></option>
                                    <?php } ?>
                                </select>
                                
                            </td>
                            <td width="28%" align="left" valign="top"><br/>
                                
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" align="left" valign="top"><hr/><strong>Endereço:</strong></td>
                        </tr>
                        <tr>
                            <td align="left" valign="top">Endereço:<br/>
                                <input name="endereco" type="text" size="43" onkeyup="up(this)" value="<?php echo $l['endereco'] ?>"></td>
                            <td colspan="2" align="left" valign="top">Numero:<br/>
                                <input name="numero" type="text" size="10" onkeyup="up(this)" maxlength="10" value="<?php echo $l['numero'] ?>"></td>
                            <td align="left" valign="top">Complemento:<br/>
                                <input name="complemento" type="text" onkeyup="up(this)" value="<?php echo $l['complemento'] ?>"></td>
                        </tr>
                        <tr>
                            <td align="left" valign="top">Bairro:<br/>
                                <input name="bairro" type="text" onkeyup="up(this)" size="43" value="<?php echo $l['bairro'] ?>"></td>
                            <td colspan="2" align="left" valign="top">Cidade:<br/>
                                <input name="cidade" type="text" onkeyup="up(this)" value="<?php echo $l['cidade'] ?>"></td>
                            <td align="left" valign="top">UF:<br/>
                                <input name="uf" type="text" size="2" onkeyup="up(this)" maxlength="2" value="<?php echo $l['uf'] ?>"></td>
                        </tr>
                        <tr>
                            <td align="left" valign="top">Telefone:<br/>
                                <input name="telefone" type="text" size="14" id="telefone" value="<?php echo $l['telefone'] ?>"></td>
                            <td colspan="2" align="left" valign="top">CEP:<br/>
                                <input name="cep" type="text" size="9" id="cep" value="<?php echo $l['cep'] ?>"></td>
                            <td align="left" valign="top">&nbsp;</td>
                        </tr>
                        <tr>
                            <td colspan="4" align="left" valign="top">Observações:<br/>
                                <textarea name="obs" rows="2" style="width:100%;"><?php echo $l['obs']; ?></textarea>

                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" align="left" valign="top"><hr/>
                                <strong>Dados de Acesso</strong></td>
                        </tr>
                        <tr>
                            <td align="left" valign="top">E-mail:<br/><input name="emails" type="email" size="43" value="<?php echo $l['email'] ?>"></td>
                            <td width="4%" align="left" valign="top">



                            </td>
                            <td colspan="2" align="left" valign="top" style="padding-left:5px;">
                                <fieldset style="width:90%;border:1px solid #666; color:green;">
                                    <legend style="margin-left:5px;">Bloquear cliente</legend>
                                    <input name="bloqueado" type="radio" value="S" <?php
                                    if ($l['bloqueado'] == "S") {
                                        echo "checked=\"checked\"";
                                    }
                                    ?>>Sim 
                                    <input name="bloqueado" type="radio" value="N" <?php
                                    if ($l['bloqueado'] == "N") {
                                        echo "checked=\"checked\"";
                                    }
                                    ?>>Não    
                                </fieldset>    
                            </td>
                        </tr>
                        <tr>
                            <td colspan="4" align="left" valign="top"><input name="update" type="submit" value="Atualizar" class="button"></td>
                        </tr>
                    </table>
                </form>
            </fieldset>
        </div>
    </body>
</html>