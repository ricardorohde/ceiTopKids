<?php 
session_start();
//se nao existir volta para a pagina do form de login
if(!isset($_SESSION['login_session']) and !isset($_SESSION['senha_session'])){
	header("Location:../index.php");
	exit;		
}
?>
<div id="conteudoform">
<div id="entrada">
<div id="cabecalho">
<h2><i class="icon-file-text"></i> Dados Bancários:</h2>
</div>
<div id="forms">
<strong>Banco Ativo</strong>
<div id="img-banco"><img src="img/<?php echo $linhas['img'] ?>" width="80" height="61" /></div>

<form action="" method="post" name="form">
<br/>
Carteira:<br/>
<input name="carteira" type="text" value="<?php echo $linhas['carteira'] ?>" style="text-align:right; width:95px;"/>

<br/>
Agência - dígito:<br/>
<input name="agencia" type="text" size="10"  value="<?php echo $linhas['agencia'] ?>" style="text-align:right; width:50px;"/> - 
<input name="digito_ag" type="text" size="3" value="<?php echo $linhas['digito_ag'] ?>" style="text-align:right; width:20px;"/><br/>

Conta cedente - dígito:<br/>
<input name="conta" type="text" size="10" value="<?php echo $linhas['conta'] ?>" style="text-align:right; width:69px;" /> - 
<input name="digito_co" type="text" size="3" value="<?php echo $linhas['digito_co'] ?>" style="text-align:right; width:20px;"/>
<br/>

<div id="fatura">Obs: Alguns bancos não utilizam os campos abaixo. Caso o banco não utilize o campo, deixar em branco.</div>
Tipo de Carteira:<br/>

<input name="tipo_carteira" type="text" size="5" value="<?php echo $linhas['tipo_carteira'] ?>"
style="text-align:right; width:60px;"/> 
ex: SR (Sem Registro) ou CR (Com Registro)<br/>

Convênio ou Código do Cedente:<br/>
<input name="convenio" type="text" size="10" value="<?php echo $linhas['convenio'] ?>" style="text-align:right; width:100px;"/><br/>

Contrato:<br/>
<input name="bancosgr" type="hidden" value="bancosgr">
<input name="id_banco" type="hidden" value="<?php echo $linhas['id_banco']; ?>">
<input name="contrato" type="text" size="10" value="<?php echo $linhas['contrato'] ?>" style="text-align:right; width:100px;"/><br/>

<div class="control-groupa">
<div class="controlsa">
<button type="submit" class="btn btn-success ewButton" name="bancosgr" id="btnsubmit" >
<i class="icon-thumbs-up icon-white"></i> Atualizar dados bancários</button>
</div></div>
</form>
</div></div></div>
