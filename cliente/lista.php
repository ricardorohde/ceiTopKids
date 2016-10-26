<div id="forms">
<div id="form10">
<form action="inicio.php?pg=fatpendente" method="post" enctype="multipart/form-data">
<div id="pesquizar">

<span class="avisos">&nbsp;*Pesquise pelo numero do documento</span><br/>
<input name="pesquizar" type="text">
<button type="submit" class="btn ewButton" name="pesq" id="btnsubmit" style="margin-top:-10px;"/>
<i class="icon-search  icon-white"></i></button>
</form>
</div>
<div id="form11">
<span class="avisos">* Ou entre datas de vencimento</span><br/>
<form action="inicio.php?pg=fatpendente" method="post" enctype="multipart/form-data" name="formu" id="formu" onSubmit="return datas(this);">
<input name="datai" type="text" style="width:100px;" class="data"> e <input name="dataf" type="text" style="width:100px;" class="data">
<button type="submit" class="btn ewButton" name="pesq" id="btnsubmit" style="margin-top:-10px;"/>
<i class="icon-search  icon-white"></i></button>
</form>
</div>
<strong>OBS: Será cobrado Juros mais multa de todos os pagamentos em atrazo.</strong>
</div>
<?php 

$sql = mysql_query("SELECT * FROM pag_extra WHERE id = '1'") or die(mysql_error());
$dados = mysql_fetch_array($sql);
?>
<form name="form" action="php/delfat.php" method="post" enctype="multipart/form-data" onsubmit="return excluir(this);">
<?php
	$cpfcnpj = $_SESSION['cpfcnpj_session'];
$cli = mysql_query("SELECT * FROM cliente WHERE cpfcnpj = '$cpfcnpj' ")or die (mysql_error());
	$nomecli = mysql_fetch_array($cli);
		$id_cliente = $nomecli['id_cliente'];

if(isset($_POST['pesquizar']) && $_POST['pesquizar'] != ""){
$pesquisar = $_POST['pesquizar'];
$sql_1 = "SELECT * ,date_format(data_venci, '%d/%m/%Y') AS data FROM faturas WHERE id_cliente = '$id_cliente' AND nosso_numero LIKE '%$pesquisar%'";
}
elseif(isset($_POST['datai']) && $_POST['datai'] and $_POST['dataf'] != ""){	
$datai = implode("-",array_reverse(explode("/",$_POST['datai'])));
$dataf = implode("-",array_reverse(explode("/",$_POST['dataf'])));			
$sql_1 = "SELECT * ,date_format(data_venci, '%d/%m/%Y') AS data FROM faturas WHERE id_cliente = '$id_cliente' AND data_venci BETWEEN ('$datai') AND ('$dataf')";	
}else{
$sql_1 = "SELECT * ,date_format(data_venci, '%d/%m/%Y') AS data FROM faturas WHERE id_cliente = '$id_cliente' ORDER BY data_venci ASC";	
}

//AND situacao != 'B'

@$p = $_GET["p"];

if(isset($p)) {
$p = $p;
} else {
$p = 1;
}

$qnt = 15;

$inicio = ($p*$qnt) - $qnt;

?>
<div id="fundo-tabela">

<table width="100%" border="0" cellspacing="1" cellpadding="5" data-rowindex="1" data-rowtype="1">
<tbody>
  <tr>
    <td width="235" bgcolor="#0490fc"><span class="fontebranca">Nome</span></td>
    <td width="251" bgcolor="#0490fc"><span class="fontebranca">Descrição</span></td>
    <td width="57" bgcolor="#0490fc"><span class="fontebranca">Nº Doc</span></td>
    <td width="123" align="center" bgcolor="#0490fc"><span class="fontebranca">Vencimento</span></td>
    <td width="97" align="center" bgcolor="#0490fc"><span class="fontebranca">Valor</span></td>
    <td width="97" align="center" bgcolor="#0490fc"><span class="fontebranca">status</span></td>
    <td width="224" colspan="2" align="center" bgcolor="#0490fc"><span class="fontebranca">Pagar com:</span></td>
    </tr>
</tbody>
<?php
// Seleciona no banco de dados com o LIMIT indicado pelos números acima

$sql_select = $sql_1." LIMIT $inicio, $qnt";
// Executa o Query
$sql_query = mysql_query($sql_select) or die(mysql_error());
// Cria um while para pegar as informações do BD
while($array = mysql_fetch_array($sql_query)) {
// Variável para capturar o campo "nome" no banco de dados
$nome = $array["nome"];
$nm = $array['nosso_numero'];
// Exibe o nome que está no BD e pula uma linha
?>
  <tr>
    <td><?php echo $array['nome']; ?></td>
    <td align="left"><?php echo $array['ref']; ?></td>
    <td align="left"><?php echo $array['id_venda']; ?></td>
    <td align="center"><?php echo $array['data']; ?></td>
    <td align="right"><?php echo number_format($array['valor'], 2, ',', '.'); ?></td>
    <td align="center" valign="middle">
    	<?php 
		if($array['situacao'] == 'P'){
			$sit = 'Pendente';	
		}
		elseif($array['situacao'] == 'V'){
		$sit = '<span class="vencida">Vencida</span>';	
		}
		else{
			$sit = '<span class="baixada">Quitado</span>';	
		}
		
		?>
        <span class="editar" style="color:#03F; font-weight:bold;"><?php echo $sit ?></span>
    </td>
    <td align="center">
    <?php if($dados['ativo'] == 'sim' and $array['situacao'] != 'B'){?>
    
    <a href="../modulosExtras/paypal/setExpressCheckout.php?id_venda=<?php echo $array['id_venda'] ?>" target="_blank">
    <img src="img/bt_paypal.png" width="84" height="27" border="0" title="Pagar com PayPal"/></a>
    
      <?php 
	}
	$bc = mysql_query("SELECT * FROM bancos WHERE situacao = '1'");
	$banco = mysql_fetch_array($bc);
	$link = $banco['link'];	
	if($array['situacao'] != 'B'){
	?>
    <a href="<?php echo "../boleto/".$link."?id_venda=".$array['id_venda']; ?>" target="_blank">
    <img src="img/pagboleto.png" width="38" height="26" title="Pagar com Boleto Bancário" /></a>
    

<?php } ?>
</td>
    </tr>
<?php } ?> 
	<tr>
    	<td colspan="8" bgcolor="#0490fc"><br/>
    </table>
</form>
</div>

<?php
// Depois que selecionou todos os nome, pula uma linha para exibir os links(próxima, última...)
echo "<br />";

// para pegarmos o número total de registros
$sql_select_all = "SELECT * FROM faturas WHERE id_cliente = '$id_cliente'";
// Executa o query da seleção acimas
$sql_query_all = mysql_query($sql_select_all) or die(mysql_error());
// Gera uma variável com o número total de registros no banco de dados
$total_registros = mysql_num_rows($sql_query_all);
// Gera outra variável, desta vez com o número de páginas que será precisa. 
// O comando ceil() arredonda "para cima" o valor
$pags = ceil($total_registros/$qnt);
// Número máximos de botões de paginação
$max_links = 3;
// Exibe o primeiro link "primeira página", que não entra na contagem acima(3)
echo "<a class=\"pag\" href=\"inicio.php?pg=fatpendente&p=1\" target=\"_self\">&laquo;&laquo; Primeira</a> ";
// Cria um for() para exibir os 3 links antes da página atual
for($i = $p-$max_links; $i <= $p-1; $i++) {
// Se o número da página for menor ou igual a zero, não faz nada
// (afinal, não existe página 0, -1, -2..)
if($i <=0) {
//faz nada
// Se estiver tudo OK, cria o link para outra página
} else {
echo "<a class=\"pag\" href=\"inicio.php?pg=fatpendente&p=".$i."\" target=\"_self\">".$i."</a> ";
}
}
// Exibe a página atual, sem link, apenas o número
echo "<span class=\"pags\">".$p."&nbsp;</span> ";
// Cria outro for(), desta vez para exibir 3 links após a página atual
for($i = $p+1; $i <= $p+$max_links; $i++) {
// Verifica se a página atual é maior do que a última página. Se for, não faz nada.
if($i > $pags)
{
//faz nada
}
// Se tiver tudo Ok gera os links.
else
{
echo "<a class=\"pag\" href=\"inicio.php?pg=fatpendente&p=".$i."\" target=\"_self\">".$i."</a> ";
}
}
// Exibe o link "última página"
echo "<a class=\"pag\" href=\"inicio.php?pg=fatpendente&p=".$pags."\" target=\"_self\">Ultima &raquo;&raquo;</a> ";
?>