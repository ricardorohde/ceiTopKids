
<!DOCTYPE html>
<html>

    <link rel="stylesheet" href="./css/formoid-flat-green.css" type="text/css" />
    <link rel="stylesheet" href="./css/estiloMenu.css" type="text/css">
    <link rel="stylesheet" href="./css/styles.css" />
    <script type="text/javascript" language="javascript" src="jquery-1.3.2.js"></script>

    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title>Lista de Usuarios</title>
    </head>

    <style>
        .tudo4 {
            float: right; width:74%; 
        }
    </style>
    
    <script>

function deletaArquivo(v, nivel){
	var name=confirm("Deseja Deletar este Usuario?")
	if (name==true){
		deleta_arquivo(v, nivel);
	}
}

function deleta_arquivo(v, nivel) {
			$.post('deleta_usuario.php', {
			   id_deletar : v,
			   nivel : nivel
			   },
			   function(resposta) {
					if (resposta == "Excluido") {
						alert("Usuario Excluido");
						
						location.reload();
					}else{
						alert(resposta);
					}
				}
			)//fim do metodo post
	
}


</script>

    <div class="useracess">
        <div id="userregisterform" style="clear:both; display:block; ">
            <h22>&nbsp;</h22>
            <form id="form1" name="form1" action="listarUsuarios.php" class="formoid-flat-green" style="background-color:#CAF2FF;font-size:14px;font-family:'Lato', sans-serif;color:#666666;max-width:80%;min-width:100%;min-height: 100%; max-height: 100%;" method="post" onSubmit="return valida(this)" >
                <div class="title" align="center" style="font-size: 20px; ">
                  <h2><font color="#ffffff">Lista Usuarios</font></h2><?php include "menuCondominio.php";?></div>
                
                <?php

include "alerta_wamp.php";

?>

                <body>
                    <div class="table">
                        <table style="width: 100%" >
                            <tr>
                                <td colspan="3" align="center" style="font-size:250%"/></td>
                            </tr>

                            <tr>
                                <td>
                                  <div class="element-input">
                                        <label class="title"><font color="#666666">Pesquisar</font></label>
                                      <input class="small" type="text" name="valorPesquisa" id="valorPesquisa" value="" />       
                                       <input style="background-color: #03C;" type="submit" id="pesquisa" value="Pesquisar"/>
                                    </div>

                                </td>
                                <td></td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>
                                    <table width="100%" style="background-color: #ffffff;" class="table-bordered">
                                        <tr style="background-color:#039">
                                            <td width="21%" align=center><strong><font color="#999999">NOME</font></strong></td>
                                            <td width="17%" align=center><strong><font color="#999999">LOGIN</font></strong></td>
                                            <td width="13%" align=center><strong><font color="#999999">TELEFONE</font></strong></td>
                                            <td width="17%" align=center><strong><font color="#999999">EMAIL</font></strong></td>
                                            <td width="23%" align=center><strong><font color="#999999">NIVEL</font></strong></td>
                                            <td width="9%" align=center><strong><font color="#999999">DELETAR</font></strong></td>
                                        </tr>
                                        <tr>
                                            <td>&nbsp;</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        
                                        <?php
										require "./DAO/listarUsuario.php";
										
										$valorPesquisa = $_POST["valorPesquisa"];
										$query = listaUsuario($valorPesquisa);
										while($dados = mysql_fetch_array($query)) {
											?>
                                            <tr>
                                            <td align=left><strong><font color="#999999"><?php echo $dados["nome"];?></font></strong></td>
                                            <td align=left><strong><font color="#999999"><?php echo $dados["login"];?></font></strong></td>
                                            <td align=center><strong><font color="#999999"><?php echo $dados["telefone"];?></font></strong></td>
                                            <td align=center><strong><font color="#999999"><?php echo $dados["email"];?></font></strong></td>
                                            <td align=center><strong><font color="#999999"><?php 
											if($dados["nivel"] == 0){
												echo "ADMIN";
											}else{
												echo "PORTEIRO";
											}
											?></font></strong></td>
                                            <td align=center><a href="javascript:" onClick="javascript:deletaArquivo('<?php echo $dados["id"]; ?>', <?php echo $dados["nivel"]; ?>);" ><img src="images/remove.png" alt="" width="28" height="29" border="0" /></a></td>
                                        </tr>
                                            <?php
											
										}
										?>
                                       
                                       <?php
                                          for($i = 0; $i < 10; $i++){
                                        ?>
                                        <tr>
                                            <td align=center><strong>&nbsp;</strong></td>
                                            <td align=center><strong>&nbsp;</strong></td>
                                            <td align=center><strong>&nbsp;</strong></td>
                                            <td align=center><strong>&nbsp;</strong></td>
                                            <td align=center><strong>&nbsp;</strong></td>
                                            <td align=center><strong>&nbsp;</strong></td>
                                        </tr>
                                        <?php
                                            }

                                        ?>
                                        
                                        
                                        
                                        <tr>
                                            <td align=center><strong>&nbsp;</strong></td>
                                            <td align=center><strong>&nbsp;</strong></td>
                                            <td align=center><strong>&nbsp;</strong></td>
                                            <td align=center><strong>&nbsp;</strong></td>
                                        </tr>
                                       




                                    </table>
                                </td>
                            </tr>

                        </table>
                    </div>




            </form>
        </div>
    </div>

</html>