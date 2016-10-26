<?php
session_start();
//se nao existir volta para a pagina do form de login
if (!isset($_SESSION['login_session']) and ! isset($_SESSION['senha_session'])) {
    header("Location:../index.php");
    exit;
}
?>
<script type="text/javascript">
    function validar_uni() {
        var nome = form.nome.value;
        var valor = form.valor.value;
        var id_grupo = form.id_grupo.value;
        var email = form.email.value;
        if (nome == "") {

            alert('Digite o nome do cliente.');
            form.nome.focus();
            return false;
        }

        if (valor == "") {
            alert('Digite o valor da cobrança');
            form.valor.focus();
            return false;
        }

        if (id_grupo == "0") {
            alert('Selecione um grupo para o cliente.');
            form.id_grupo.focus();
            return false;
        }

        if (email == "") {
            alert('Digite o email do cliente.');
            form.email.focus();
            return false;
        }

    } ////////////// FIM DA FUNCTION /////////////////////
</script>
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/jquery.maskedinput.js"></script>
<script type="text/javascript">
    jQuery(function () {

        $("#telefone").mask("(99) 9999-9999");
        $("#cpf").mask("999.999.999-99");
        $("#cep").mask("99999-999");
        $("#cnpj").mask("99.999.999/9999-99");
    });

    function up(lstr) { // converte minusculas em maiusculas
        var str = lstr.value; //obtem o valor
        lstr.value = str.toUpperCase(); //converte as strings e retorna ao campo
    }
</script>
<div id="entrada">
    <div id="cabecalho"><h2><i class="icon-user iconmd"></i> Cadastro de clientes</h2></div>
    <div id="forms">

        <form action="" method="post" enctype="multipart/form-data" id="gravacliente" name="form" onSubmit="return validar_uni(this);">

            <table width="730" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td width="36%" align="left" valign="top">Nome:<br/><input name="nome" type="text" size="43" onkeyup="up(this)"></td>
                    <td width="34%" align="left" valign="top">CPF/CNPJ<br/>
                        <input name="cpfcnpj" type="text" id="cpf-cnpj" onkeydown="javascript:return aplica_mascara_cpfcnpj(this, 18, event)" onkeyup="javascript:return aplica_mascara_cpfcnpj(this, 18, event)" size="18" maxlength="18" style="width:120px;">
                    </td>
                    <td width="30%" align="left" valign="top">
                        <script src="js/jquery-1.10.2.js"></script>
                        <script type="text/javascript" src="js/jquery.mask-money.js"></script>
                        <script type="text/javascript">
                                $(document).ready(function () {
                                    $("#valor").maskMoney({decimal: ".", thousands: ""});
                                });

                        </script>
                        Valor da cobrança:<br/>
                        <input name="valor" type="text" style="width:80px; text-align:right;" id="valor">
                    </td>
                </tr>
                <tr>
                    <td align="left" valign="top">RG:<br/><input name="rg" type="text"></td>
                    <td align="left" valign="top">Inscrição estadual / Municipal:<br/>
                        <input name="inscricao" type="text">

                    </td>
                    <td align="left" valign="top">Grupo:<br/>
                        <select name="id_grupo">
                            <option value="0">Selecione</option>
                            <option value="AVULSO">AVULSO</option>
                            <?php
                            $sql1 = mysql_query("SELECT * FROM grupo WHERE id_grupo !='1' ORDER BY id_grupo ASC")or die(mysql_error());
                            while ($ver = mysql_fetch_array($sql1)) {
                                $id_grupo = $ver['id_grupo'];
                                ?>
                                <option value="<?php echo $id_grupo ?>"><?php echo $ver['nomegrupo'];
                            echo " - Vencimento dia:" . $ver['dia']; ?></option>
<?php } ?>
                        </select></td>
                </tr>
                <tr>
                    <td colspan="3" align="left" valign="top"><hr/><strong>Endereço:</strong></td>
                </tr>
                <tr>
                    <td align="left" valign="top">Endereço:<br/><input name="endereco" type="text" onkeyup="up(this)" size="43"></td>
                    <td align="left" valign="top">Numero:<br/><input name="numero" type="text" onkeyup="up(this)" size="10" maxlength="10"></td>
                    <td align="left" valign="top">Complemento:<br/><input name="complemento" onkeyup="up(this)" type="text"></td>
                </tr>
                <tr>
                    <td align="left" valign="top">Bairro:<br/><input name="bairro" onkeyup="up(this)" type="text" size="43"></td>
                    <td align="left" valign="top">Cidade:<br/><input name="cidade" onkeyup="up(this)" type="text"></td>
                    <td align="left" valign="top">UF:<br/><input name="uf" type="text" onkeyup="up(this)" size="2" maxlength="2" style="width:30px;"></td>
                </tr>
                <tr>
                    <td align="left" valign="top">Telefone:<br/><input name="telefone" type="text" size="14" id="telefone"></td>
                    <td align="left" valign="top">CEP:<br/>
                        <input name="clientegr" type="hidden" value="clientegr">
                        <input name="cep" type="text" size="9" id="cep"></td>
                    <td align="left" valign="top">    <fieldset>
                            <legend><strong>Senha padrão:</strong></legend>
                            <span class="avisos">
                                Todos seus clientes senha inicial padrão: 123</span>
                        </fieldset></td>
                </tr>
                <tr>
                    <td colspan="3" align="left" valign="top">Observações:<br/>
                        <input type="text" name="obs" rows="2" style="width:100%;"></textarea>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" align="left" valign="top">&nbsp;</td>
                </tr>
                <tr>
                    <td align="left" valign="top">E-mail:<br/><input name="email" type="email" size="43" id="email"></td>
                    <td colspan="2" align="left" valign="top">
                        <fieldset>
                            <legend><strong>Observações</strong></legend>
                            <span class="avisos">
                                Por este email o cliente receberá as faturas.</span>
                        </fieldset>
                    </td>
                </tr>
                <tr>
                    <td colspan="3" align="left" valign="top">
                        <div class="control-groupa">
                            <div class="controlsa">
                                <button type="submit" class="btn btn-success ewButton" name="clientegr" id="btnsubmit" >
                                    <i class="icon-thumbs-up icon-white"></i> Cadastrar cliente</button>
                            </div>


                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

