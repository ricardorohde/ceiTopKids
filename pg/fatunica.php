<script type="text/javascript">
    function validar_uni() {
        var id_cliente = formu.id_cliente.value;
        var num_doc = formu.num_doc.value;
        var ref = formu.ref.value;
        var valor = formu.valor.value;
        var data_venci = formu.data_venci.value;

        if (id_cliente == "0") {
            alert('Selecione um cliente.');
            formu.id_cliente.focus();
            return false;
        }

        if (ref == "") {
            alert('Digite a descrição da fatura.');
            formu.ref.focus();
            return false;
        }
        if (valor == "") {
            alert('Digite o valor da(s) parcelas(s).');
            formu.valor.focus();
            return false;
        }
        if (data_venci == "") {
            alert('Selecione a data de vencimento.');
            formu.data_venci.focus();
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
    <div id="cabecalho"><h2><i class="icon-money iconmd"></i> Fatura unica</h2></div>
    <div id="forms">
        <form action="" method="post" name="formu" id="formu" enctype="multipart/formu-data" onSubmit="return validar_uni(this);">
            Cliente:<br/>
            <select name="id_cliente">
                <option value="0">Selecione um cliente...</option>
                <?php
                $sql = mysql_query("SELECT * FROM cliente WHERE bloqueado ='N' ORDER BY nome ASC")or die(mysql_error());
                while ($linha = mysql_fetch_array($sql)) {
                    ?>
                    <option value="<?php echo $linha['id_cliente'] ?>">
                        <?php echo $linha['nome']; ?></option>
                <?php } ?>
            </select><br/>
            <?php
            $cont = mysql_query("SELECT num_doc FROM `faturas` ORDER BY num_doc DESC")or die(mysql_error());
            $cont = mysql_fetch_array($cont)
            ?>
            <input name="num_doc" type="hidden" value="<?php echo $cont['num_doc'] + 1; ?>" style="width:100px;">
            Numero de Idendificação:</br></br>
            <input type="text" style="width:100px;" disabled value="<?php echo $cont['num_doc'] + 1; ?>" name="num_doc"></br>

            Descrição da fatura:<br/>
            <input name="ref" type="text" style="width:400px; height:30px;"><br/>

            Valor:<br/>
            <div class="input-prepend">
                <span class="add-on"><i class="icon-money"></i></span>
                <input name="valor" type="text" size="10" id="valor" style="text-align:right; width:60px;"><br/>
            </div><br/>

            Vencimento:<br/>
            <div class="input-prepend">
                <span class="add-on"><i class="icon-calendar"></i></span>
                <input type="text" name="data_venci" class="data_venci" style="width:100px;"/>
            </div><br/><br/>
            <div class="control-groupa">
                <div class="controlsa">

                    <input name="lancafatunica" type="hidden" value="lancafatunica">

                    <button type="submit" class="btn btn-success ewButton" name="lancafatunica" onclick="return validaruni()">
                        <i class="icon-thumbs-up icon-white"></i> Lançar Fatura</button>
                </div></div>
        </form>
    </div>