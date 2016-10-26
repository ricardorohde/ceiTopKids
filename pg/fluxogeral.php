<?php 
include '../alerta_wamp.php';
if(isset($_GET['atualizar']) == "true"){

	print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=inicio.php?pg=fluxo#tabs-2'>";	
	
}


session_start();
//se nao existir volta para a pagina do form de login
if(!isset($_SESSION['login_session']) and !isset($_SESSION['senha_session'])){
	header("Location:../index.php");
	exit;		
}
?>
<?php 
$dia_lanc = date("d");
$mes_atual = date("m");
$verifica_data = mysql_query("SELECT * FROM flux_fixas WHERE dia_vencimento <= $dia_lanc");
$contar = mysql_num_rows($verifica_data);
if($contar >= 1){

while($ins = mysql_fetch_array($verifica_data)){
	
$dia_vencimento = $ins['dia_vencimento'];
$valor_fixa = $ins['valor_fixa'];
$descr_fixa = $ins['descricao_fixa'];
$dataagora = date('Y-m-').$dia_vencimento;

$sel = mysql_query("SELECT * FROM flux_entrada WHERE data = '$dataagora' AND descricao = '$descr_fixa'") or die(mysql_error());
$cont = mysql_num_rows($sel);
$confere = mysql_fetch_array($sel);
if($cont < 1){
$lanca_automatico = mysql_query("INSERT INTO flux_entrada (data, tipo, descricao, valor)VALUES('$dataagora','D','$descr_fixa','$valor_fixa')");
}

}
}

?>


<script type="text/javascript">
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}


function NovaJanela(pagina,nome,w,h,scroll){
	LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
	TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
	settings = 'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
	win = window.open(pagina,nome,settings);
	}
window.name = "main";

</script>


<div id="entrada">
<div id="cabecalho"><h2><i class="icon-list-alt"></i> Fluxo de caixa</h2></div>
<script src="js/jquery.min.js" type="text/javascript"></script>
<script src="js/jquery-ui.js"></script>
 <script>
$(function() {
$( "#tabs" ).tabs();
});
</script>

<div id="tabs">
<ul>
<li><a href="#tabs-1" class="fluxo1">MOVIMENTO</a></li>
<li><a href="#tabs-2" class="fluxo1">PLANO DE CONTAS</a></li>
<li><a href="#tabs-3" class="fluxo1">DESPESAS FIXAS</a></li>
<li><a href="#tabs-4" class="fluxo1">RELATÓRIO</a></li>
</ul>
    <div id="tabs-1" style="padding:10px;">
    <p>
    
<script type="text/javascript"> 
jQuery.fn.toggleText = function(a,b) {
return   this.html(this.html().replace(new RegExp("("+a+"|"+b+")"),function(x){return(x==a)?b:a;}));
}

$(document).ready(function(){
$('.tgl').before('<span><div class="adicionamovimento">[+] Adicionar movimento</div></span>');
$('.tgl').css('display', 'none')
$('span', '#box-toggle').click(function() {
$(this).next().slideToggle('slow')
.siblings('.tgl:visible').slideToggle('fast');
// aqui começa o funcionamento do plugin
$(this).toggleText('Revelar','Esconder')
.siblings('span').next('.tgl:visible').prev()
.toggleText('Revelar','Esconder')
});
})

function validar_relatorio() {
var datai = relatorio.datai.value;
var dataf = relatorio.dataf.value;  

if(datai == ""){
alert('Digite a data inicial.');
relatorio.datai.focus();
return false;
}
if(dataf == ""){
alert('Digite a data final.');
relatorio.dataf.focus();
return false;
}
}


function validar_lancamento() {
var data = formlanca.data.value;
var tipo = formlanca.tipo.value;  
var id_plano = formlanca.id_plano.value;
var descricao = formlanca.descricao.value;
var valor = formlanca.valor.value;

if (data == "") {
alert('O campo data deve ser preenchido com a data do lançamento.');
formlanca.data.focus();
return false;
}
if (tipo == "") {
alert('Escolha se o lançamento é RECEITA ou DESPESA.');
formlanca.tipo.focus();
return false;
}
if (id_plano == "0") {
alert('Selecione um plano de contas.');
formlanca.id_plano.focus();
return false;
}
if (descricao == "") {
alert('Descreva o lançamento.');
formlanca.descricao.focus();
return false;
}
if(valor == ""){
alert('Por favor digite o valor do lançamento.');
formlanca.valor.focus();
return false;
}
if(valor == "0.00"){
alert('O valor não pode ser igual a zero.');
formlanca.valor.focus();
return false;
}
}

function abreFecha(id){

if (document.getElementById(id).style.display=='')
	document.getElementById(id).style.display='none';
else
	document.getElementById(id).style.display='';
}

function abre(id){
	document.getElementById(id).style.display='block';
}

function fecha(id){
	document.getElementById(id).style.display='none';
}

function abre2(id){
	document.getElementById(id).style.display='';
}


function alternaClasse(id,classe1,classe2){
if (document.getElementById(id).className==classe1)
	document.getElementById(id).className=classe2;
else
	document.getElementById(id).className=classe1;
}
$(document).ready(function(){
	$("li a[href='"+location.href.substring(location.href.lastIndexOf("/")+1,255)+"']").removeClass("meses");
	$("li a[href='"+location.href.substring(location.href.lastIndexOf("/")+1,255)+"']").addClass("diferente");
});

</script>
<?php
$anoinicio = date("Y") - 5;
$anofim = date("Y") + 5;
if(isset($_GET['ano'])){
	$hoje = $_GET['ano'];	
}else{
$hoje = date("Y");
}
$meshoje = date("m");

?>


<div id="meses">
	<ul>
    	<li style="background-color:transparent; border:0;">
        <form name="form" id="form">
          <select name="ano" id="jumpMenu" onchange="MM_jumpMenu('parent',this,0)" style=" width:auto; margin-top:-6px;">
          <?php 
			for($i =$anoinicio; $i < $anofim; $i++){ ?>
			<option value="?pg=fluxo&mes=<?php echo $meshoje ?>&ano=<?php echo $i ?>" <?php if(!(strcmp($i, $hoje))) {echo "selected=\"selected\"";} ?>><?php echo $i ?></option>';
         <?php   
		}
		?> 
          </select>
        </form>
        </li>
    	<li><a href="inicio.php?pg=fluxo&mes=1&ano=<?php echo $hoje?>" class="meses">Janeiro</a></li>
        <li><a href="inicio.php?pg=fluxo&mes=2&ano=<?php echo $hoje?>" class="meses">Fevereiro</a></li>
        <li><a href="inicio.php?pg=fluxo&mes=3&ano=<?php echo $hoje?>" class="meses">Março</a></li>
        <li><a href="inicio.php?pg=fluxo&mes=4&ano=<?php echo $hoje?>" class="meses">Abril</a></li>
        <li><a href="inicio.php?pg=fluxo&mes=5&ano=<?php echo $hoje?>" class="meses">Maio</a></li>
        <li><a href="inicio.php?pg=fluxo&mes=6&ano=<?php echo $hoje?>" class="meses">Junho</a></li>
        <li><a href="inicio.php?pg=fluxo&mes=7&ano=<?php echo $hoje?>" class="meses">Julho</a></li>
        <li><a href="inicio.php?pg=fluxo&mes=8&ano=<?php echo $hoje?>" class="meses">Agosto</a></li>
        <li><a href="inicio.php?pg=fluxo&mes=9&ano=<?php echo $hoje?>" class="meses">Setembro</a></li>
        <li><a href="inicio.php?pg=fluxo&mes=10&ano=<?php echo $hoje?>" class="meses">Outubro</a></li>
        <li><a href="inicio.php?pg=fluxo&mes=11&ano=<?php echo $hoje?>" class="meses">Novembro</a></li>
        <li><a href="inicio.php?pg=fluxo&mes=12&ano=<?php echo $hoje?>" class="meses">Dezembro</a></li>
    </ul>
</div>

<br/>
<div id="box-toggle">
<div class="tgl">
<br/>

<script type="text/javascript">		
function MascaraMoeda(objTextBox, SeparadorMilesimo, SeparadorDecimal, e){
    var sep = 0;
    var key = '';
    var i = j = 0;
    var len = len2 = 0;
    var strCheck = '0123456789';
    var aux = aux2 = '';
    var whichCode = (window.Event) ? e.which : e.keyCode;
    if ((whichCode == 13) || (whichCode == 0) || (whichCode == 8)) return true;
    key = String.fromCharCode(whichCode); // Valor para o código da Chave
    if (strCheck.indexOf(key) == -1) return false; // Chave inválida
    len = objTextBox.value.length;
    for(i = 0; i < len; i++)
        if ((objTextBox.value.charAt(i) != '0') && (objTextBox.value.charAt(i) != SeparadorDecimal)) break;
    aux = '';
    for(; i < len; i++)
        if (strCheck.indexOf(objTextBox.value.charAt(i))!=-1) aux += objTextBox.value.charAt(i);
    aux += key;
    len = aux.length;
    if (len == 0) objTextBox.value = '';
    if (len == 1) objTextBox.value = '0'+ SeparadorDecimal + '0' + aux;
    if (len == 2) objTextBox.value = '0'+ SeparadorDecimal + aux;
    if (len > 2) {
        aux2 = '';
        for (j = 0, i = len - 3; i >= 0; i--) {
            if (j == 3) {
                aux2 += SeparadorMilesimo;
                j = 0;
            }
            aux2 += aux.charAt(i);
            j++;
        }
        objTextBox.value = '';
        len2 = aux2.length;
        for (i = len2 - 1; i >= 0; i--)
        objTextBox.value += aux2.charAt(i);
        objTextBox.value += SeparadorDecimal + aux.substr(len - 2, len);
    }
    return false;
}
</script>
</script>
    <script type="text/javascript" src="js/jquery.maskedinput.js"></script>
<script type="text/javascript">
    jQuery(function () {
            $("#data_vencimento").mask("99/99/9999");
        });	
		</script>
<hr><br/>
    <form action="" method="post" enctype="multipart/form-data" id="formlanca" name="formlanca" onSubmit="return validar_lancamento(this);">
    Data:<br/> <input name="data" type="text" value="<?php echo date("d/m/Y") ?>" style="width:100px;" id="data_vencimento"><br/>
    Tipo de entrada:<br/>
    <div class="botton"><span class="verde">RECEITA: </span><input name="tipo" type="radio" value="R" style="vertical-align:text-bottom;"></div>
    <div class="botton"><span class="error">DESPESA:</span> <input name="tipo" type="radio" value="D" style="vertical-align:text-bottom;"></div>
    <br><br><br>
    Plano de contas:<br/>
    <select name="id_plano" style="width:auto;">
    <option value="0">== Selecione ==</option>
    <?php 
	$bb = mysql_query("SELECT * FROM flux_planos ORDER BY descricao ASC");
	while($ver = mysql_fetch_array($bb)){
	?>
      <option value="<?php echo $ver['id_plano'] ?>"><?php echo $ver['descricao'] ?></option>
      <?php } ?>
    </select><br/>
    
    
    Descrição:<br/>
    <input name="descricao" type="text" style="width:500px;"><br/>
    Valor:<br/>
    <input name="valor" type="text" style="width:70px; text-align:right;" onKeyPress="return(MascaraMoeda(this,'.',',',event))"><br/>
    <input name="adicionar_conta" type="submit" value="Adicionar" id="adicionar"  class="btn btn-success ewButton"/>
    </form> 
    <hr/>
	</div>
   <?php 
   $mes_agora = date('m');
	$ano = date('Y');
	
	if(isset($_GET['mes'])){
		$mes_sel = $_GET['mes'];	
	}else{
		$mes_sel = $mes_agora;
	}
	if(isset($_GET['ano'])){
	$ano_sel = $_GET['ano'];
	}else{
		$ano_sel = $ano;
	}
	
switch ($mes_sel){

case 1: $mes = "Janeiro"; break;
case 2: $mes = "Fevereiro"; break;
case 3: $mes = "Março"; break;
case 4: $mes = "Abril"; break;
case 5: $mes = "Maio"; break;
case 6: $mes = "Junho"; break;
case 7: $mes = "Julho"; break;
case 8: $mes = "Agosto"; break;
case 9: $mes = "Setembro"; break;
case 10: $mes = "Outubro"; break;
case 11: $mes = "Novembro"; break;
case 12: $mes = "Dezembro"; break;

}
	
	 
   $bolet = mysql_query("SELECT SUM(valor_recebido) AS total FROM faturas WHERE situacao='B' AND MONTH(dbaixa) ='$mes_sel' AND YEAR(dbaixa) = '$ano_sel'")
   or die(mysql_error());
   $boletos = mysql_fetch_array($bolet);	
	
   $ent = mysql_query("SELECT SUM(valor) AS total FROM flux_entrada WHERE tipo='R' AND MONTH(data) ='$mes_sel' AND YEAR(data) = '$ano_sel'")or die(mysql_error());
   $entradas = mysql_fetch_array($ent);
   
   $totalentrada = $boletos['total'] + $entradas['total'];
   
   $sai = mysql_query("SELECT SUM(valor) AS total FROM flux_entrada WHERE tipo='D' AND MONTH(data) ='$mes_sel' AND YEAR(data) = '$ano_sel'")or die(mysql_error());
   $saida = mysql_fetch_array($sai);
   $resultado = $totalentrada - $saida['total'];
   if($resultado < 0){$cor = "resultadonegativo";}else{$cor = "resultadopositivo";}
   ?> 
<table width="79%" border="0" cellspacing="5">
  <tr>
    <td width="51%">
    	<fieldset><legend class="legend">Entradas e Saídas deste mês</legend>
        	<table width="99%" border="0">
              <tr>
                <td align="left"><span class="receita">Entradas de boletos:</span></td>
                <td align="right"><span class="receita"><?php echo number_format($boletos['total'], 2,',','.') ?></span></td>
              </tr>
              <tr>
                <td width="77%" align="left"><span class="receita">Outras Entradas:</span></td>
                <td width="23%" align="right"><span class="receita"><?php echo number_format($entradas['total'], 2,',','.') ?></span></td>
              </tr>
              <tr>
                <td align="left"><span class="azul">Total de entradas:</span></td>
                <td align="right"><span class="azul"><?php echo number_format($totalentrada, 2,',','.') ?></span></td>
              </tr>
              <tr>
                <td align="left"><span class="despesa">Saídas:</span></td>
                <td align="right"><span class="despesa"><?php echo number_format($saida['total'], 2,',','.') ?></span></td>
              </tr>
              <tr align="left">
                <td colspan="2"><hr/></td>
                </tr>
              <tr>
                <td align="left"><span class="<?php echo $cor ?>">Resultado:</span></td>
                <td align="right"><span class="<?php echo $cor ?>"><?php echo number_format($resultado, 2,',','.') ?></span></td>
              </tr>
            </table>
        </fieldset>
    
    </td>
    
    
    
    
    
    
    <td width="49%">
    	<fieldset><legend class="legend">Balanço Geral</legend>
     <?php 

	$bolett = mysql_query("SELECT SUM(valor_recebido) AS total FROM faturas WHERE situacao='B'") or die(mysql_error());
   $boletost = mysql_fetch_array($bolett);
	 
   $entg = mysql_query("SELECT SUM(valor) AS total FROM flux_entrada WHERE tipo='R'")or die(mysql_error());
   $entradag = mysql_fetch_array($entg);
   
   $total_entrada = $boletost['total'] + $entradag['total'];
   
   $saig = mysql_query("SELECT SUM(valor) AS total FROM flux_entrada WHERE tipo='D'")or die(mysql_error());
   $saidag = mysql_fetch_array($saig);
   $resultadog = $total_entrada - $saidag['total'];
   if($resultadog < 0){$cor = "resultadonegativo";}else{$cor = "resultadopositivo";}
   ?> 
          <table width="99%" border="0">
            <tr>
              <td align="left"><span class="receita">Entradas de boletos:</span></td>
              <td align="right"><span class="receita"><?php echo number_format($boletost['total'], 2,',','.') ?></span></td>
            </tr>
            <tr>
              <td width="76%" align="left"><span class="receita">Outras Entradas:</span></td>
              <td width="24%" align="right"><span class="receita"><?php echo number_format($entradag['total'], 2,',','.') ?></span></td>
            </tr>
            <tr>
              <td align="left"><span class="azul">Total de entradas</span></td>
              <td align="right"><span class="azul"><?php echo number_format($total_entrada, 2,',','.') ?></span></td>
            </tr>
            <tr>
              <td align="left"><span class="despesa">Saídas:</span></td>
              <td align="right"><span class="despesa"><?php echo number_format($saidag['total'], 2,',','.') ?></span></td>
            </tr>
            <tr align="left">
              <td colspan="2"><hr/></td>
              </tr>
            <tr>
              <td align="left"><span class="<?php echo $cor ?>">Resultado:</span></td>
              <td align="right"><span class="<?php echo $cor ?>"><?php echo number_format($resultadog, 2,',','.') ?></span></td>
            </tr>
          </table>
    	</fieldset>
    </td>
  </tr>
</table>

 
  <br/>  
<span class="resultados">Movimento do mês de <?php echo $mes ?>/<?php echo $ano_sel ?></span>
<table width="79%" border="0" cellspacing="0">
<tr style="height:25px;">
<td style="padding-left:8px; font-size:12px; background:#06F; color:#FFF;"><strong>Tipo</strong></td>
<td style="padding-left:8px; font-size:12px; background:#06F; color:#FFF;"><strong>Descrição</strong></td>
<td style="padding-right:8px; font-size:12px;  background:#06F;color:#FFF;" align="center"><strong>Valor</strong></td>
</tr>
<?php 

$v = mysql_query("SELECT *, date_format(data,'%d/%m/%Y')AS data, month(data) AS mes, year(data) AS ano FROM flux_entrada WHERE MONTH(data) ='$mes_sel' AND YEAR(data) = '$ano_sel'")or die(mysql_error());
while($dados = mysql_fetch_array($v)){
$background = (++$i%2) ? '#F9F9F9' : '#eceaea';
if($dados['tipo'] == "R"){
	$tipo = "<span class='verde'>R</span>";
}
else{
	$tipo = "<span class='vermelho'>D</span>";
}
?>
  <tr style="height:25px;">
    <td width="4%" align="center" bgcolor="<?php echo $background ?>" style="padding-left:8px;"><?php echo $tipo ?></td>
    <td width="83%" align="left" bgcolor="<?php echo $background ?>" style="padding-left:8px;"><?php echo $dados['descricao'] ?> 
      <a href="#" style="font-size:10px; color:#666" 
      onclick="javascript:abreFecha('editar_mov_<?php echo $dados['id_entrada']?>').style.display='';" title="Editar" class="edit">[editar]</a>
      </td>
    <td width="13%" align="right" bgcolor="<?php echo $background ?>" style="padding-right:8px;"><?php echo number_format($dados['valor'],2,',','.')?></td>
  </tr>
  
  <tr style="display:none;" id="editar_mov_<?php echo $dados['id_entrada']?>" >
    <td colspan="3" align="left" style="padding-left:8px;">
    <div id="formedita">
      <form action="" method="post" enctype="multipart/form-data">
      Data: <input name="data" type="text" value="<?php echo $dados['data'];?>" style="width:70px;"/> |
      
          Plano de contas:
    <select name="id_plano" style="width:auto; height:22px; padding:0; margin-top:6px;" >
    <option value="0">== Selecione ==</option>
    <?php 
	$bb = mysql_query("SELECT * FROM flux_planos ORDER BY descricao ASC");
	while($ver = mysql_fetch_array($bb)){
	?>
      <option value="<?php echo $ver['id_plano'] ?>"
	  <?php if(!(strcmp($dados['id_plano'], $ver['id_plano']))) {echo "selected=\"selected\"";} ?>>
	  <?php echo $ver['descricao'] ?></option>
      <?php } ?>
    </select>
    <input name="id_entrada" type="hidden" value="<?php echo $dados['id_entrada']?>" />
    | Tipo de entrada: 
    <span class="verde">RECEITA: </span>
    <input name="tipo" type="radio" value="R" style="vertical-align:text-bottom;" <?php if($dados['tipo'] == "R") echo "checked";?>>
    <span class="vermelho">DESPESA:</span> 
    <input name="tipo" type="radio" value="D" style="vertical-align:text-bottom;" <?php if($dados['tipo'] == "D") echo "checked";?>><br/>
    Descrição: <input name="descricao" type="text" value="<?php echo $dados['descricao']; ?>"  style="width:450px;"/>
    Valor: <input name="valor" type="text" value="<?php echo number_format($dados['valor'],2,',','.')?>" style="width:70px;" onKeyPress="return(MascaraMoeda(this,'.',',',event))"/>
    <input name="atualizalancamento" type="submit" value="Atualizar" style="margin-top:0px; padding:5px; background:#090; color:#FFF;" />
        </form>
        </div>
      </td>
  </tr>

  <?php } ?>  
  
</table>



</div>

        
    </p>
    </div>
    <div id="tabs-2" style="padding:10px;">
    <script type="text/javascript">

function marcardesmarcar(){
   if ($("#todos").attr("checked")){
      $('.marcar').each(
         function(){
            $(this).attr("checked", true);
         }
      );
   }else{
      $('.marcar').each(
         function(){
            $(this).attr("checked", false);
         }
      );
   }
}

function validaCheckbox(v){ 
    todos = document.getElementsByTagName('input'); 
    for(x = 0; x < todos.length; x++) { 
        if (todos[x].checked){ 
            return true; 
        } 
    } 
    alert("Selecione pelo menos uma fatura!"); 
    return false; 
}

</script>
    <p>
    <div id="table-flux">
    <form action="" method="post" enctype="multipart/form-data">
    Descrição:<br/>
    <input name="descricao" type="text"><input name="cadastar_plano" type="submit" value="Cadastrar" id="Cadastrar" class="btn btn-success ewButton"
    style="margin-top:-8px; margin-left:3px;"
    >
    </form>
    
<form action="php/del_plano.php" method="post" enctype="multipart/form-data">
<table width="499" border="0" cellspacing="0">
  <thead style="background:#069; color:#FFFFFF;">
  <tr>
    <th width="28" style="padding:5px;"><input type="checkbox" name="todos" id="todos" value="todos" onclick="marcardesmarcar();" /></th>
    <th width="408">Descrição</th>
    <th width="57">Editar</th>
  </tr>
  </thead>
  <tbody>
  <?php 
  $sql = mysql_query("SELECT * FROM flux_planos ORDER BY descricao ASC") or die(mysql_error());
  while($linha = mysql_fetch_array($sql)){
  ?>
  <tr>
    <td style="padding:5px;"><input type="checkbox" name="id_plano[]" class="marcar" value="<?php echo $linha['id_plano'] ?>" id="marcar"></td>
    <td><?php echo $linha['descricao'] ?></td>
    <td><div id="baixar"><a href="pg/edita_plano.php?id_plano=<?php echo $linha['id_plano']; ?>" class="editar" title="Receber título" onclick="NovaJanela(this.href,'nomeJanela','400','200','yes');return false">Editar</a></div></td>
  </tr>
  <?php } ?>
  <tfoot>
  <tr>
    <td colspan="3" style="padding:5px;">
    <input name="deletar_plano" type="submit" value="&nbsp;&nbsp;Deletar Selecionados&nbsp;&nbsp; " class="btn deleteboton ewButton" onClick="return validaCheckbox(this);" id="deletar_plano">

    </td>
    </tr>
  </tfoot>

</tbody>

</table>
 </form>
</p>
</div>                 
</div>

    <div id="tabs-3" style="padding:10px;">
    <p>
    <form action="" method="post" enctype="multipart/form-data">
    Descrição:<br/>
    <input name="descricao_fixa" type="text" style="width:450px;"/><br/>
    Dia do vencimento:<br/>
    <input name="dia_vencimento" type="text" style="width:30px;" maxlength="2"/><br/>
    Valor:<br/>
    <input name="valor_fixa" type="text" style="width:80px; text-align:right;" onKeyPress="return(MascaraMoeda(this,'.',',',event))"/><br/>
    <input name="grava_despesa_fixa" type="submit" value="Gravar"  class="btn btn-success ewButton"/>
    </form>
    <br/>
    <hr/>
    
      <script type="text/javascript">
  function marcardesmarcar2(){
   if ($("#todos2").attr("checked")){
      $('.marcar2').each(
         function(){
            $(this).attr("checked", true);
         }
      );
   }else{
      $('.marcar2').each(
         function(){
            $(this).attr("checked", false);
         }
      );
   }
}
  </script>
    
    <form action="php/del_fixa.php" method="post" enctype="multipart/form-data">
    <table width="79%" border="0" cellpadding="3" cellspacing="0">
    <tr style="height:25px;">
        <td width="4%" style="padding-left:8px; font-size:12px; background:#06F; color:#FFF;">
        <input type="checkbox" name="todos2" id="todos2" value="todos2" onclick="marcardesmarcar2();" /></td>
        <td width="58%" style="padding-left:8px; font-size:12px; background:#06F; color:#FFF;"><strong>Descrição</strong></td>
        <td width="15%" align="center" style="padding-left:8px; font-size:12px; background:#06F; color:#FFF;"><strong>Dia Vencimento</strong></td>
        <td width="23%" align="right" style="padding-right:8px; font-size:12px; background:#06F; color:#FFF;"><strong>Valor</strong></td>
  </tr>
   <?php 
  $sql = mysql_query("SELECT * FROM flux_fixas ORDER BY id_fixa DESC") or die(mysql_error());
  while($linhafixa = mysql_fetch_array($sql)){
	  $background = (++$i%2) ? '#F9F9F9' : '#eceaea';
  ?>
  <tr style="height:25px;">
    <td width="4%" style="padding-left:8px; font-size:12px;" 
        bgcolor="<?php echo $background ?>">
      <input type="checkbox" name="id_fixa[]" class="marcar2" value="<?php echo $linhafixa['id_fixa'] ?>" id="marcar2">
      </td>
    <td width="58%" style="padding-left:8px; font-size:12px;" bgcolor="<?php echo $background ?>"><?php echo $linhafixa['descricao_fixa'] ?>
      <a href="pg/edita_fixa.php?id=<?php echo $linhafixa['id_fixa'] ?>"class="edit"
       onclick="NovaJanela(this.href,'nomeJanela','500','300','yes');return false"> [Editar]</a>
      </td>
    <td width="15%" align="center" bgcolor="<?php echo $background ?>" style="padding-left:8px; font-size:12px;"><?php echo $linhafixa['dia_vencimento'] ?></td>
    <td width="23%" align="right" bgcolor="<?php echo $background ?>" style="padding-right:8px; font-size:12px;" >
	<?php echo number_format($linhafixa['valor_fixa'],2,',','.');  ?></td>
  </tr>
  <?php } ?>
    </table>
   <input name="deletar_despesa" type="submit" value="&nbsp;&nbsp;Deletar Selecionados&nbsp;&nbsp; " class="btn deleteboton ewButton" onClick="return validaCheckbox(this);" id="deletar_despesa" style="margin-top:5px;">
</form>
    
    </p>
    </div>
        <script type="text/javascript" src="js/jquery.maskedinput.js"></script>
<script type="text/javascript">
    jQuery(function () {
            $("#datai").mask("99/99/9999");
			$("#dataf").mask("99/99/9999");
        });	
		</script>
    <div id="tabs-4" style="padding:10px;">
    <p>
    <h2>Relatórios</h2><br/>
    <hr/>
    <form action="pg/relatoriofluxo.php" method="post" enctype="multipart/form-data" name="relatorio" onSubmit="return validar_relatorio(this);">
    <table width="80%" border="0">
  	<tr>
        <td width="29%">Data Inicio:<br/> <input name="datai" type="text" id="datai" style="width:80px;"/></td>
        <td width="71%">Data Final:<br/> <input name="dataf" type="text" id="dataf" style="width:80px;"//></td>
  	</tr>
  	<tr>
  	  <td>Tipo de Movimento:<br/>
      <select name="tipomov">
      <option value="0">=Selecione=</option>
  	    <option value="D">Despesa</option>
  	    <option value="R">Receita</option>
        <option value="b">Recebimento de boletos</option>
      </select></td>
  	  <td>Plano de contas:<br/> 
      <select name="id_plano">
        <option value="0">=Selecione=</option>
        <?php 
		$selplano = mysql_query("SELECT * FROM flux_planos ORDER BY descricao ASC");
		while($l = mysql_fetch_array($selplano)){
		?>
        <option value="<?php echo $l['id_plano'] ?>"><?php echo $l['descricao']; ?></option>
        <?php } ?>
      </select>
      </td>
	  </tr>
  	<tr>
  	  <td><input type="submit" name="gerar" id="button" value="Gerar relatório" class="btn btn-success ewButton" onclick="this.form.target='_blank';return true;" /></td>
  	  <td>&nbsp;</td>
	  </tr>
	</table>

    
    
    </form>
    
    
    
    </p>
    </div>

</div>

</div>