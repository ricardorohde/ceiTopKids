<?php 
session_start();
//se nao existir volta para a pagina do form de login
if(!isset($_SESSION['login_session']) and !isset($_SESSION['senha_session'])){
	header("Location:../index.php");
	exit;		
}
?>
<link href="css/tabs.css" rel="stylesheet" type="text/css" />
<ol id="toc">
    <li><a href="#page-1"><span><i class="icon-cog"></i> Dados do servidor</span></a></li>
    <li><a href="#page-2"><span><i class="icon-envelope "></i> Aviso de Fatura</span></a></li>
    <li><a href="#page-3"><span> <i class="icon-envelope"></i> Reaviso de cobrança</span></a></li>
</ol>
<div class="content" id="page-1">
<div id="cabecalho"><h2><i class="icon-share "></i> Servidor</h2></div>

<div id="forms">
<form action="" method="post" enctype="multipart/form-data">

<p><strong>Razão Social:</strong><br/>
  <input name="empresa" type="text" size="50" value="<?php echo $linhamail['empresa'] ?>"><br/>
  
<!--  <strong>Seu SMTP:</strong><br/>
  <input name="url" type="text" size="50" value="<?php echo $linhamail['url'] ?>"> 
  <span class="avisos">*Caso utilize cpanel deixe como "localhost".</span><br/>-->
  
  <strong>Conta que enviará os emails:</strong><br/>
  <input name="email" type="text" size="50" value="<?php echo $linhamail['email'] ?>"><br/>
  
<!--  <strong>Limite de emails por hora:</strong><br/>
  <input name="limitemail" type="number" value="<?php echo $linhamail['limitemail'] ?>" style="width:80px;">
  <span class="avisos">* Verifique no seu servidor o limite de emails que podem ser enviados por hora</span><br/>-->
  
  
<!--  <strong>Senha da conta:</strong><br/>
  <input name="senha" type="password" size="20" value="<?php echo $linhamail['senha'] ?>"><br/>-->
  
<!--  <strong>Porta utilizada para enviar:</strong><br/>
  <input name="porta" type="text" size="6" value="<?php echo $linhamail['porta'] ?>" style="width:40px;">
  (Portas padrão: 25 e 587. Se não funcionar com uma tente a outra. <strong>Obs:</strong> O Gmail está bloqueando o acesso por sistemas externos não homologados.)<br/>-->
  
  <input name="endereco" type="hidden" size="60" 
<?php 
$protocolo = (strpos(strtolower($_SERVER['SERVER_PROTOCOL']), 'https') === false) ? 'http' : 'https';

$pasta = $_SERVER['SCRIPT_NAME'];
$d = explode("/",$pasta);
	$p = $d[1];

$banco = mysql_query("SELECT * FROM bancos WHERE situacao = '1'");
$ver = mysql_fetch_array($banco);
$url = $ver['link'];

?>
value="<?php echo $protocolo."://".$_SERVER['HTTP_HOST'].'/'.$p.'/';?>" 
style="width:300px;"><br/>
  
  <br/>
</p>
<div class="control-groupa">
  <div class="controlsa">
<button type="submit" class="btn btn-success ewButton" name="emailgr" id="btnsubmit" >
<i class="icon-thumbs-up icon-white"></i> Gravar alterações</button>
</div></div>
</form>
</div>

</div>


<div class="content" id="page-2">
<div id="cabecalho"><h2><i class="icon-share "></i> Aviso de fatura</h2></div>
<span class="avisos"><strong>Obs: </strong>Este email avisa ao seu cliente que ele tem uma nova fatura.</span><br/><br/>
<form action="" method="post" enctype="multipart/form-data">
<strong>Assunto do email:</strong><br/>
<input name="aviso" type="text" value="<?php echo $linhamail['aviso']?>" style="width:300px;"><br/>
<strong>Texto do email ao gerar fatura:</strong><br/>
<textarea cols="80" name="editor1" rows="20"><?php echo $linhamail['text1'] ?></textarea><br/>
<div class="control-groupa">
<div class="controlsa">
<button type="submit" class="btn btn-success ewButton" name="assunto1" id="btnsubmit" >
<i class="icon-thumbs-up icon-white"></i> Gravar alterações</button>
</div>
</form>
</div></div>


<div class="content" id="page-3">
<div id="cabecalho"><h2><i class="icon-share "></i> Reaviso de cobrança</h2></div>
<span class="avisos"><strong>Obs: </strong>Este email avisa ao seu cliente ele tem fatura vencida (Reaviso de cobrança).</span><br/><br/>
<form action="" method="post" enctype="multipart/form-data" name="formulario">
<strong>Assunto do email:</strong><br/>
<input name="tata" type="text" value="<?php echo $linhamail['avisofataberto']?>" style="width:300px;"><br/>
<strong>Texto do email de cobrança:</strong><br/>
<textarea  cols="80"  name="editor1" rows="20"><?php echo $linhamail['text2'] ?></textarea><br/>
<div class="control-groupa">
<div class="controlsa">
<button type="submit" class="btn btn-success ewButton" name="avisofataberto" id="btnsubmit" >
<i class="icon-thumbs-up icon-white"></i> Gravar alterações</button>
</div>
</form>
</div>



<script src="js/activatables.js" type="text/javascript"></script>
<script type="text/javascript">
activatables('page', ['page-1', 'page-2', 'page-3']);
</script>
