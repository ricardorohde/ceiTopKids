<?php
session_start();
//se nao existir volta para a pagina do form de login
if (!isset($_SESSION['login_session']) and ! isset($_SESSION['senha_session'])) {
    header("Location:../index.php");
    exit;
}
?>
<script type="text/javascript">
    function validar() {
        var id_grupo = form.id_grupo.value;
        var ref = form.ref.value;
        var valor = form.valor.value;
        var data_venci = form.data_venci.value;

        if (id_grupo == "0") {
            alert('Selecione um grupo de clientes.');
            form.id_grupo.focus();
            return false;
        }
        if (ref == "") {
            alert('Digite a descrição da fatura.');
            form.ref.focus();
            return false;
        }

        if (data_venci == "") {
            alert('Selecione a data de vencimento.');
            form.data_venci.focus();
            return false;
        }
    } ////////////// FIM DA FUNCTION /////////////////////
</script>
<link href="css/jquery-ui-1.10.4.custom.css" rel="stylesheet" type="text/css">
<script src="js/jquery-1.10.2.js"></script>
<script src="js/jquery-ui-1.10.4.custom.js"></script>
<script>
    $(document).ready(function () {
        $(".data_venci").datepicker({
            dateFormat: 'dd/mm/yy',
            dayNames: ['Domingo', 'Segunda', 'Terça', 'Quarta', 'Quinta', 'Sexta', 'Sábado'],
            dayNamesMin: ['D', 'S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
            dayNamesShort: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sáb', 'Dom'],
            monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
            monthNamesShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],
            nextText: 'Proximo',
            prevText: 'Anterior'
        });
    });
</script>
<script type="text/javascript" src="js/jquery.mask-money.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#valor").maskMoney({decimal: ",", thousands: ""});
    });

    function SomenteNumero(e) {

        var tecla = (window.event) ? event.keyCode : e.which;
        if ((tecla > 47 && tecla < 58)) {
            return true;
        } else {
            if (tecla == 8 || tecla == 0) {
                return true;
            } else {
                return false;
            }
        }
    }
</script>
<div id="menufatura">
    <ul>
        <li>
            <div class="control-group">
                <div class="controls">
                    <div class="btn ewButton" name="user" id="btnsubmit"/>
                    <a href="inicio.php?pg=lancafatura" style=" text-decoration:none; color:#000;">
                        <i class="icon-refresh"></i> Fatura unica</a></div>
        </li>
        <li>
            <div class="control-group">
                <div class="controls">
                    <div class="btn ewButton" name="user" id="btnsubmit"/>
                    <a href="inicio.php?pg=periodica" style=" text-decoration:none; color:#000;">
                        <i class="icon-refresh"></i> Fatura para grupo de clientes</a></div>

        </li>
    </ul>

</div>
<div style="clear:both;"></div>
<br/>
<div id="entrada">
    <?php
    $fat = mysql_query("SELECT * FROM faturas") or die(mysql_error());
    $cont = mysql_num_rows($fat);
    ?>
    <div id="cabecalho">
        <h2><i class="icon-money iconmd"></i> Fatura para grupo</h2></div>
    <div id="forms">
        <form action="" method="post" name="form" id="form" enctype="multipart/form-data" onSubmit="return validar(this);">
            Grupo de Clientes:<br/>
            <select name="id_grupo">
                <option value="0">Selecione um grupo...</option>
                <?php
//                $sql = mysql_query("SELECT * FROM grupo WHERE id_grupo != '1' ORDER BY id_grupo ASC")or die(mysql_error());
                $sql = mysql_query("SELECT * FROM turmas ORDER BY turma ASC")or die(mysql_error());
                while ($linha = mysql_fetch_array($sql)) {
                    ?>
                    <option value="<?php echo $linha['id'] ?> ">
                        <?php echo $linha['turma']; ?></option>
                <?php } ?>
            </select><br/>

            <input name="num_doc" type="hidden" value="<?php echo $cont + 1; ?>" onkeypress="return SomenteNumero(event)" style="width:100px;">

            Descrição das faturas:<br/>
            <input name="ref" type="text" style="width:400px;"><br/>

            Vencimento:<br/>
            <div class="input-prepend">
                <span class="add-on"><i class="icon-calendar"></i></span>
                <input type="text" name="data_venci" class="data_venci" style="width:100px;" />
            </div><br/>

<!--            Lançar valores iguais para todos do grupo?<br/>
            <div id="sim"><input name="define" type="radio" value="s" onclick="document.form.valor.disabled = false">Sim</div>
            <div id="sim"><input name="define" type="radio" value="n" checked="CHECKED" onclick="document.form.valor.disabled = true">Não</div><br/><br/>-->

            Valor:<br/>
            <div class="input-prepend">
                <span class="add-on"><i class="icon-money"></i></span>
                <input name="valor" type="text" size="10" id="valor" style="text-align:right; width:60px;" >
                <span class="avisos" style="margin-left:10px;"> </span>
                <br/>
            </div><br/>

            <div class="control-groupa">
                <div class="controlsa">

                    <input name="lancafatperiodica" type="hidden" value="lancafatperiodica">

                    <button type="submit" class="btn btn-success ewButton" name="lancafatperiodica">
                        <i class="icon-thumbs-up icon-white"></i> Lançar Fatura</button>
                </div></div>
        </form>
    </div>