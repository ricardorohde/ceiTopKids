<?php 
session_start();
//se nao existir volta para a pagina do form de login
if(!isset($_SESSION['login_session']) and !isset($_SESSION['senha_session'])){
	header("Location:../index.php");
	exit;		
}
?>
<div id="entrada">
<div id="cabecalho"><h2><i class="icon-file-text iconmd"></i> Meus dados:</h2></div>
<table width="79%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="45%">
    <form action="" method="post">
    <table width="79%" border="0" cellspacing="0">
      <tr>
        <td width="17%" align="right" valign="middle">Razão social:</td>
        <td width="1%">&nbsp;</td>
        <td width="36%" align="left" valign="middle"><div class="input-prepend"> <span class="add-on"><i class="icon-file-text"></i></span>
          <input name="nome" type="text" size="60" value="<?php echo $linha['nome'] ?>" >
        </div></td>
        <td width="46%" rowspan="7" align="left" valign="top"></td>
      </tr>
      <tr>
        <td align="right" valign="middle">E-mail:</td>
        <td>&nbsp;</td>
        <td align="left" valign="middle"><div class="input-prepend"> <span class="add-on"><i class="icon-envelope"></i></span>
          <input name="email" type="email" size="60" value="<?php echo $linha['email'] ?>">
        </div></td>
      </tr>
      <tr>
        <td height="29" align="right" valign="middle">CNPJ:</td>
        <td>&nbsp;</td>
        <td align="left" valign="middle"><div class="input-prepend"> <span class="add-on"><i class="icon-file-text"></i></span>
          <input name="cpf" type="text" size="20" value="<?php echo $linha['cpf'] ?>">
        </div></td>
      </tr>
      <tr>
        <td align="right" valign="middle">Endereco:</td>
        <td>&nbsp;</td>
        <td align="left" valign="middle"><div class="input-prepend"> <span class="add-on"><i class="icon-file-text"></i></span>
          <input name="endereco" type="text" size="40"  value="<?php echo $linha['endereco']; ?>"/>
        </div></td>
      </tr>
      <tr>
        <td align="right" valign="middle">Cidade:</td>
        <td>&nbsp;</td>
        <td align="left" valign="middle"><div class="input-prepend"> <span class="add-on"><i class="icon-file-text"></i></span>
          <input name="alterar" type="hidden" value="alterar">
          <input name="cidade" type="text"  value="<?php echo $linha['cidade'] ?>"/>
        </div></td>
      </tr>
      <tr>
        <td align="right" valign="middle">UF:</td>
        <td>&nbsp;</td>
        <td align="left" valign="middle"><div class="input-prepend"> <span class="add-on"><i class="icon-file-text"></i></span>
          <input name="uf" type="text" size="2" maxlength="2" value="<?php echo $linha['uf']; ?>" style="width:25px;" />
        </div></td>
      </tr>
      <tr>
        <td align="center"></td>
        <td align="center">&nbsp;</td>
        <td align="left" valign="middle"><div class="control-group">
          <div class="controls">
            <button type="submit" class="btn btn-success ewButton" name="alterar" id="btnsubmit2" > <i class="icon-ok icon-white"></i> Alterar</button>
          </div></td>
      </tr>
    </table> 
 </form>
    </td>
    <td width="55%" align="left" valign="top">
    <div id="upload">
    Enviar logo:
    <hr/>
   <form action="php/upload.php" method="post" enctype="multipart/form-data">
   	Selecione sua logo:<br/>
    <input name="logo" type="file" size="40"><br/><br/>
    <input name="submit" type="hidden" value="submit">
    <div class="controls">
          <button type="submit" class="btn btn-success ewButton" name="submit" id="btnsubmit" >
            <i class="icon-ok icon-white"></i> Enviar</button>
        </div> 
   </form> <br/>
  <img src="boleto/imagens/<?php echo $linha['logo'] ?>" width="147" height="46"></div> 
    </td>
  </tr>
</table>

<div id="fatura2"><h2><i class="icon-lock"></i> Dados de acesso</h2></div>
<div id="forms2">
<form name="fomr2" action="" method="post" enctype="multipart/form-data">
	
        Login:<br/>
      <div class="input-prepend">
        <span class="add-on"><i class="icon-lock"></i></span> 
        <input name="user" type="hidden" value="user">
        <input name="login" type="text"  value="<?php echo $linhauser['login']?>"/>
      </div><br/>
      
        Senha:<br/>
       <div class="input-prepend">
        <span class="add-on"><i class="icon-key"></i></span> 
        <input name="user" type="hidden" value="user">
        <input name="senha" type="password"  value="<?php echo $linhauser['senha']?>"/>
       </div>
      
        <div class="control-group">
        <div class="controls">
       
        

</form>
</div>

</div>