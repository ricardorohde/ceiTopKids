<?php
session_start();
//se nao existir volta para a pagina do form de login
if (!isset($_SESSION['login_session']) and ! isset($_SESSION['senha_session'])) {
    header("Location:../index.php");
    exit;
}
?>
<div id="conteudoform">
    <script type="text/javascript">
        function confirmar_cliente(query) {
            if (confirm("Tem certeza que deseja excluir este usuário?")) {
                window.location = "php/deleta_cliente.php" + query;
                return true;
            }
            else
                window.location = "inicio.php?pg=listaclientes";
            return false;
        }
        function NovaJanela(pagina, nome, w, h, scroll) {
            LeftPosition = (screen.width) ? (screen.width - w) / 2 : 0;
            TopPosition = (screen.height) ? (screen.height - h) / 2 : 0;
            settings = 'height=' + h + ',width=' + w + ',top=' + TopPosition + ',left=' + LeftPosition + ',scrollbars=' + scroll + ',resizable'
            win = window.open(pagina, nome, settings);
        }
        window.name = "main";
    </script>
    <div id="entrada">
        <div id="cabecalho"><h2><i class="icon-user iconmd"></i> Lista clientes</h2></div>
        <div id="formbus">
            <form action="" method="post" enctype="multipart/form-data">
                <span class="avisos">&nbsp;*Pesquize por cliente</span><br/>
                <input name="pesquisa" type="text" style="width:350px;">
                <button type="submit" class="btn ewButton" name="pesqui" id="btnsubmit" style="margin-top:-10px;"/>
                <i class="icon-search  icon-white"></i></button>

            </form>
        </div>
        <div id="tab-lista-clientes">

            <table width="100%" border="0" cellpadding="3" cellspacing="1">
                <tr>
                    <!--<th width="7%" align="center" bgcolor="#66CCFF" style="margin-left:5px;"><strong>Cod</strong></th>-->
                    <th width="47%" align="left" bgcolor="#66CCFF" style="margin-left:5px;"><strong>Nome Responsável</strong></th>
                    <th width="30%" align="left" bgcolor="#66CCFF" style="margin-left:5px;"><strong>Aluno</strong></th>
                    <th width="8%" align="center" bgcolor="#66CCFF" style="margin-left:5px;">Situação</th>
                    <th width="9%" align="left" bgcolor="#66CCFF" style="margin-left:5px;">Valor</th>
                    <th width="11%" align="left" bgcolor="#66CCFF" style="margin-left:5px;">Grupo</th>
                    <th width="6%" align="center" bgcolor="#66CCFF" style="margin-left:5px;"><strong>Ações</strong></th>
                </tr>
                <?php
                if (isset($_POST['pesqui'])) {
                    $pesquisa = $_POST['pesquisa'];
                    $cons = mysql_query("SELECT * FROM cliente left join pais on (cliente.cpfcnpj = pais.mothersCpf or cliente.cpfcnpj = pais.fatherCpf) LEFT JOIN alunos ON alunos.id_pais = pais.id WHERE nome LIKE '%$pesquisa%'") or die(mysql_error());
                } else {
                    $cons = mysql_query("SELECT * FROM cliente left join pais on (cliente.cpfcnpj = pais.mothersCpf or cliente.cpfcnpj = pais.fatherCpf) LEFT JOIN alunos ON alunos.id_pais = pais.id ORDER BY nome ASC");
                }

                while ($l = mysql_fetch_array($cons)) {
                    $idgrupo = $l['id_grupo'];
                    ?>
                    <tr>
                        <!--<td align="center"><?php echo $l['id_cliente'] ?></td>-->
                        <td><?php echo $l['nome'] ?></td>
                        <td><?php echo $l['name'] ?></td>
                        <?php
                        if ($l['bloqueado'] == "N") {
                            $sit = "ATIVO";
                        } else {
                            $sit = "BLOQUEADO";
                        }
                        ?>
                        <td align="center"><?php echo $sit ?></td>
                        <td><?php echo number_format($l['valor'], '2', ',', '.'); ?></td>
                        <?php
                        $dad = mysql_query("SELECT * FROM grupo WHERE id_grupo = '$idgrupo'");
                        $dado = mysql_fetch_array($dad);
                        if ($dado['nomegrupo'] == "") {
                            $grupo = "AVULSO";
                        } else {
                            $grupo = $dado['nomegrupo'];
                        }
                        ?>
                        <td><?php echo $grupo; ?></td>
                        <td>
                            <div class="btn-group">
                                <a href="pg/editacliente.php?id=<?php echo $l['id_cliente'] ?>" style="text-decoration:none;" 
                                   class="btn btn-default" onclick="NovaJanela(this.href, 'nomeJanela', '740', '500', 'yes');
                                               return false" title="Editar">
                                    <i class="icon-edit"></i></a>
                                <a class="btn btn-default"
                                   href="javascript:confirmar_cliente('?pg=listaclientes&deleta=cliente&id=<?php echo $l['id_cliente'] ?>')"
                                   style="text-decoration:none;" title="Excluir cadastro"> 
                                    <i class="icon-trash"></i></a>
                            </div>


                        </td>
                    </tr>
                <?php } ?>
            </table>
        </div>
    </div>
</div>