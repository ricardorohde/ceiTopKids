<br/>
<ul> 
    <li><a href='inicio.php?pg=inicio' class="iconfont inicio">home</a></li>
    <li><a href='#' class="iconfont config">configuracões</a>
        <ul>
            <li class='active'><a href='inicio.php?pg=configuracoes'>meus dados</a></li>
            <!-- <li class='active'><a href='inicio.php?pg=modulos'>PayPal</a></li> -->
            <li class='active'><a href='inicio.php?pg=confboleto'>configurar Boletos</a></li>
            <li class='active'><a href='inicio.php?pg=confmail'>Configurar Email</a></li>
        </ul>
    </li>
    <li class='last'><a href='inicio.php?pg=listaclientes' class="iconfont clientes">clientes</a>
        <ul>
            <!--<li class='active'><a href='inicio.php?pg=cadclientes'><?php echo $config['cadclientes'] ?></a></li>-->
            <!--<li class='active'><a href='inicio.php?pg=listaclientes'><?php echo $config['listaclientes'] ?></a></li>-->
            <!--<li class='active'><a href='inicio.php?pg=grupo'><?php echo $config['grupo'] ?></a></li>-->
        </ul>

    </li>
    <li class='last'><a href='#' class="iconfont fatura">boletos</a>
        <ul>
            <li class='active'><a href='inicio.php?pg=lancafatura'><?php echo $config['lfatura'] ?></a></li>
            <li class='active'><a href='inicio.php?pg=fatpendente'><?php echo $config['pendentes'] ?></a></li>
            <li class='active'><a href='inicio.php?pg=fatvencida'><?php echo $config['vencidos'] ?></a></li>
            <li class='active'><a href='inicio.php?pg=fatbaixada'><?php echo $config['quitados'] ?></a></li> 
        </ul>
    </li>

    <li class='active'><a href='inicio.php?pg=fluxo' class="iconfont fluxo"><i class="icon-list-alt"></i>&nbsp;&nbsp;&nbsp;fluxo de caixa</a></li>
    <li class='active'><a href='inicio.php?pg=baixa' class="iconfont baixar">baixar</a></li>
    <!--<li class='active'><a href='inicio.php?pg=listararquivos' class="iconfont baixar">Backup's</a></li>-->
    <li class='last'><a href='php/sair.php' class="iconfont sair">sair</a></li>


</ul>