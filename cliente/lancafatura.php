<script type="text/javascript">
function validar() {
var email = formu.email.value;
var senha = formu.senha.value; 
var confsenha = formu.confsenha.value;

if (email == "") {
alert('O campo email é obrigatório.');
formu.email.focus();
return false;
}
if (senha == "") {
alert('O campo senha é obrigatório.');
formu.senha.focus();
return false;
}
if (confsenha == "") {
alert('Digite sua senha novamente.');
formu.confsenha.focus();
return false;
}
if (confsenha != senha) {
alert('As senhas não conferem. Digite novamente.');
formu.confsenha.focus();
return false;
}
}

</script>

<?php 
$cpfcnpj = $_SESSION['cpfcnpj_session'];
$venc = date("d/m/Y", strtotime('+3 day', time()));

if(isset($_POST['lancafatunica'])){

////////////////////////////////////// LANÇA FATURA UNICA SE O DOCUMENTO NAO EXISTIR ///////////////////////
	$email = $_POST['email'];
	$senha = $_POST['senha'];
	$cpfcnpj = $_POST['cpfcnpj'];
	
	$cli = mysql_query("UPDATE cliente SET email='$email', senha='$senha' WHERE cpfcnpj='$cpfcnpj'")or die (mysql_error());
	if($cli == 1){
		print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=inicio.php?pag=lancafatura'>
		<script type=\"text/javascript\">
		alert(\"DADOS ALTERADOS COM SUCESSO!\");
		</script>";		
	}

  }

$fat = mysql_query("SELECT * FROM cliente WHERE cpfcnpj = '$cpfcnpj'") or die(mysql_error());
$cont = mysql_fetch_array($fat);
?>
<div id="cabecalho"><h2><i class="icon-paste iconmd"></i> Meus Dados</h2></div>
<div id="forms">
  <form action="" method="post" name="formu" id="formu" enctype="multipart/formu-data" onSubmit="return validar(this);">
   <table width="835" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="231"><strong>Nome:</strong> <?php echo $cont['nome'] ?></td>
    <td width="233"><strong>CPF:</strong> <?php echo $cont['cpfcnpj']; ?></td>
    <td width="371"><strong>RG:</strong> <?php echo $cont['rg']; ?></td>
    </tr>
  <tr>
    <td colspan="3"><hr></td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"><strong>Endereço:</strong> <?php echo $cont['endereco']; ?> , Nº <?php echo $cont['numero']; ?>, <?php echo $cont['complemento']; ?> - <?php echo $cont['bairro']; ?>
    - <?php echo $cont['cidade']; ?> - <?php echo $cont['uf']; ?> - CEP: <?php echo $cont['cep'] ?>
    
    </td>
    </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3"><hr></td>
  </tr>
  <tr>
    <td colspan="3"><strong>Alterar dados:</strong></td>
    </tr>
  <tr>
    <td>
    <input name="cpfcnpj" type="hidden" value="<?php echo $cont['cpfcnpj']; ?>">
    <br/>Meu E-mail: <br/><input name="email" type="text" value="<?php echo $cont['email'] ?>"></td>
    <td><br/>Digite a nova senha: <input name="senha" type="password" value="<?php echo $cont['senha']; ?>"></td>
    <td><br/>Confirme a nova senha:<br/> <input name="confsenha" type="password" value="<?php echo $cont['senha']; ?>"></td>
    </tr>
   </table>

    
    <input name="lancafatunica" type="hidden" value="lancafatunica">
    
    <button type="submit" class="btn btn-success ewButton" name="lancafatunica" onclick="return validaruni()">
    <i class="icon-thumbs-up icon-white"></i> Atualizar dados</button>
  </form>
