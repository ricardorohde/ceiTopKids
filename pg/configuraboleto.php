
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
<h2><i class="icon-file-text"></i> Dados do boleto:</span></h2>
</div>
<div id="forms">
<form name="form" action="" method="post">
Lançar faturas <br/>
<input name="dias" type="text" value="<?php echo $linha['dias'] ?>" style="width:20px" size="2" maxlength="2"> 
dias antes do vencimento.<br/>

Multa por atrazo:<br/> 
<input name="multa_atrazo" type="text" value="<?php echo $linha['multa_atrazo'] ?>" size="2" maxlength="2"
 style="text-align:right; width:20px;"/>
%. <br/>

Juros/mora ao dia:<br/>
<input name="juros" type="text" value="<?php echo $linha['juro']?>" style="width:30px"> 
%
- Taxa não pode ultrapassar 20% ou seja <strong>"Valor máximo 0.66"</strong> <br/>
<br/>

Receber até:<br/>
<input name="receber" type="text" value="<?php echo $linha['receber']?>" size="1" maxlength="3" style="text-align:right; width:20px;"/> 
dias de vencido.<br/>

Instruções 1:<br/>
<input name="demo1" type="text" size="60" value="<?php echo $linha['demo1'] ?>" style="width:500px;"><br/>

Instruções 2:<br/>
<input name="demo2" type="text" size="60" value="<?php echo $linha['demo2'] ?>" style="width:500px;"><br/>

Instruções 3:<br/>
<input name="demo3" type="text" size="60" value="<?php echo $linha['demo3'] ?>" style="width:500px;"><br/>

Instruções 4:<br/>
<input name="demo4" type="text" size="60" value="<?php echo $linha['demo4'] ?>" style="width:500px;"><br/>

<input name="confgoleto" type="hidden" value="confgoleto">

<div class="control-groupa">
<div class="controlsa">
<button type="submit" class="btn btn-success ewButton" name="confgoleto" id="btnsubmit" >
<i class="icon-thumbs-up icon-white"></i> Atualizar dados do boleto</button>
</div></div>
</form>      
</div></div></div>
