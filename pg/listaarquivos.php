<div id="entrada">

<div id="cabecalho"><h2><i class="icon-download-alt  iconmd"></i> Backups</h2> </div>

<div id="forms">
<div id="form10">
<div id="backup">
<a href="backup/backup.php" class="btn" style="text-decoration:none">
<i class="icon-cloud-download" style="text-decoration:none"></i> NOVO BACKUP</a>
</div>
<div id="fundo-tabela2">
	   
<table width="100%" height="32" border="0" cellpadding="0" cellspacing="1">
<tbody>
  <tr>
    <td width="1031" bgcolor="#0490fc"><span class="fontebranca">BACKUP - DATA - HORÁRIO</span></td>
    <td width="145" align="center" bgcolor="#0490fc"><span class="fontebranca">AÇÃO</span></td>
    </tr>
</tbody>


<?php
if(isset($_GET['arquivo'])){
		$file = $_GET['arquivo'];
		
		unlink("backup/".$file);
		
		echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=inicio.php?pg=listararquivos'>";
	
}


   $path = "backup/";
   $diretorio = dir($path);
      
   while($arquivo = $diretorio -> read()){
	   if($arquivo != "." && $arquivo != ".." && $arquivo != "backup.php"){
	   
	   ?>

  <tr>
    <td width="1031"><i class="icon-fixed-width icon-file-text pull-left icon-border" style="color:green;"></i> <?php echo $arquivo ?></td>
    <td width="145" align="center"><a href="php/baixar.php?download=<?php echo $arquivo ?>" title="Download">
    <i class="icon-save icon-2x pull-left icon-border" style="color:#063; text-decoration:none; font-size:16px;"></i></a>
      <a href="inicio.php?pg=listararquivos&arquivo=<?php echo $arquivo ?>" title="Excluir">
      <i class="icon-trash icon-2x pull-left icon-border" style="color:#FF0000; text-decoration:none; font-size:16px;"></i></a></td>
  </tr>

	<?php   
	   
	   }
      //echo "<a href='".$path.$arquivo."'>".$arquivo."</a><br />";
	  
	  
   }
   $diretorio -> close();

?>
</table>
</div>
</div>
</div>
</div>

