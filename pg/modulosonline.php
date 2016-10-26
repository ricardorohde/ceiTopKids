<?php 
session_start();
//se nao existir volta para a pagina do form de login
if(!isset($_SESSION['login_session']) and !isset($_SESSION['senha_session'])){
	header("Location:../index.php");
	exit;		
}
?>
<div id="entrada">
<div id="cabecalho"><h2><i class="icon-credit-card iconmd"></i> Módulo PayPal</h2></div>
<div id="forms">
<div id="img-banco"><img src="img/paypal.png" width="80" height="61"></div><br/>

<h2>Insira os dados</h2>
<hr/>
<?php 
		$sql1 = mysql_query("SELECT * FROM pag_extra WHERE id='1'")or die (mysql_error());
		$ver = mysql_fetch_array($sql1);
?>
<form action="" method="post" enctype="multipart/form-data">
    	
      Nome do usuário:<br/>
      <input name="userpay" type="text" value="<?php echo $ver['user'] ?>"><br/>
      Senha de autorização:<br/>
      <input name="pass" type="text" value="<?php echo $ver['pass'] ?>"><br/>
      Assinatura:<br/>
      <input name="assinatura" type="text" style="width:425px;" value="<?php echo $ver['assinatura'] ?>"><br/>
      URL da sua logo:<br/>
      <input name="logo" type="text" style="width:425px;" value="<?php echo $ver['logo'] ?>"><br/>
      <input name="atualizapaypal" type="hidden" value="atualizapaypal">
      Ativar modulo?<br/>
      <div id="ativar">
      Sim: <input name="ativo" type="radio" class="radio" value="sim" <?php if($ver['ativo'] == 'sim')echo 'checked';?>> 
      Não: <input name="ativo" type="radio" class="radio" value="nao" <?php if($ver['ativo'] == 'nao')echo 'checked';?>>
      </div><br/>
    <input name="atualizapaypal" type="submit" value="Atualizar dados" class="btn btn-success ewButton">
    
    
    </form>
</div>