<?php 
session_start();
//se nao existir volta para a pagina do form de login
if(!isset($_SESSION['login_session']) and !isset($_SESSION['senha_session'])){
	header("Location:../index.php");
	exit;		
}
?>
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.mask-money.js"></script>
<script type="text/javascript">
$(document).ready(function() {
        $("#valor").maskMoney({decimal:",",thousands:""});
      });
</script>
<script type="text/javascript">
	function NovaJanela(pagina,nome,w,h,scroll){
	LeftPosition = (screen.width) ? (screen.width-w)/2 : 0;
	TopPosition = (screen.height) ? (screen.height-h)/2 : 0;
	settings = 'height='+h+',width='+w+',top='+TopPosition+',left='+LeftPosition+',scrollbars='+scroll+',resizable'
	win = window.open(pagina,nome,settings);
	}
window.name = "main";
</script>


<div id="entrada">
<div id="cabecalho"><h2><span class="iconfont grupo"> Cadastro de grupo de clientes</span></h2></div>
<div id="forms">
<form action="" method="post" enctype="multipart/form-data" name="cadgrupocli">
Nome do grupo:<br/>
<input name="nomegrupo" type="text"><br/>
Intervalo de vencimento:<br/>
<select name="meses">
  <option value="1">30 dias</option>
  <option value="2">60 dias</option>
  <option value="3">90 dias</option>
  <option value="6">6 meses</option>
  <option value="12">1 ano</option>
  <option value="24">2 anos</option>
  <option value="36">3 anos</option>
</select>
<br/>
Dia do vencimento:<br/>
<select name="dia">
<option value="">= Selecione =</option>
	<?php 
	for($i = 1; $i <= 31; $i++){
	?>
  <option value="<?php echo $i ?>"><?php echo "Todo dia: ". $i ?></option>
  <?php } ?>
</select><br/>
<br/>
<div class="controlsa">
  <button type="submit" class="btn btn-success ewButton" name="cadgrupocli" id="btnsubmit" >
<i class="icon-thumbs-up icon-white"></i> Cadastrar grupo de clientes</button>
</div>
</form>

<hr/>
<div id="tabela1" style="width:700px;">

    <table width="700" cellspacing="1">
        <tr>
          <th width="360" align="left">Grupo</th>
          <th width="112" align="left">Dia vencimento</th>
          <th width="71" align="center">Ações</th>
        </tr>
       <?php 
	  while($g = mysql_fetch_array($gr)){
	  ?>
        <tr>
          <td><?php echo $g['nomegrupo']; ?></td>
          <td>Todo dia: <strong><?php echo $g['dia']; ?></strong></td>
          <td align="left">
            <div class="btn-group">
              <a href="pg/upgrupo.php?id_grupo=<?php echo $g['id_grupo'];?>" name="modal" style="text-decoration:none;" class="btn btn-default" onclick="NovaJanela(this.href,'nomeJanela','400','350','yes');return false"><i class="icon-edit"></i></a>
              <a class="btn btn-default" href="inicio.php?pg=grupo&del=del&id_grupo=<?php echo $g['id_grupo'] ?>" style="text-decoration:none;"><i class="icon-trash"></i></a>
            </div>
          </td>
        </tr>
        <?php } ?>
    </table>
    
</div>