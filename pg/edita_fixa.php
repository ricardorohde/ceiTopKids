<?php 
session_start();
//se nao existir volta para a pagina do form de login
if(!isset($_SESSION['login_session']) and !isset($_SESSION['senha_session'])){
	header("Location:../index.php");
	exit;		
}
?>
<?php include "../classes/conexao.php";?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Editar Despesa fixa</title>
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
</head>
<script language="javascript">
function fechajanela() {
window.open("../inicio.php?pg=fluxo","main");
}
</script>
<?php 
function tiraMoeda($valor){
	$pontos = '.';
	$virgula = ',';
	$result = str_replace($pontos, "", $valor);
	$result2 = str_replace($virgula, ".", $result);
	return $result2;
	}
	
$id_fixa = $_GET['id'];

if(isset($_POST['update'])){
	$descricao_fixa = $_POST['descricao_fixa'];
	$dia_vencimento = $_POST['dia_vencimento'];
	$valor_fixa = tiraMoeda($_POST['valor_fixa']);
	
	$up = mysql_query("UPDATE flux_fixas SET descricao_fixa = '$descricao_fixa', dia_vencimento = '$dia_vencimento', valor_fixa = '$valor_fixa' 
	WHERE id_fixa = '$id_fixa'
	");	
	
	if($up == 1){
print "<script type=\"text/javascript\">javascript:window.close()</script>";		
	}
}


$sql = mysql_query("SELECT * FROM flux_fixas WHERE id_fixa = $id_fixa");
$linha = mysql_fetch_array($sql);
?>

<body onUnload="fechajanela()">
    <form action="" method="post" enctype="multipart/form-data">
    Descrição:<br/>
    <input name="descricao_fixa" type="text" style="width:450px;" value="<?php echo $linha['descricao_fixa']; ?>"/><br/>
    Dia do vencimento:<br/>
    <input name="dia_vencimento" type="text" style="width:30px;" maxlength="2" value="<?php echo $linha['dia_vencimento']; ?>"/><br/>
    Valor:<br/>
    <input name="valor_fixa" type="text" value="<?php echo number_format($linha['valor_fixa'],2,',','.'); ?>" style="width:80px; text-align:right;" onKeyPress="return(MascaraMoeda(this,'.',',',event))"/><br/>
    <input name="update" type="submit" value="Gravar"  class="btn btn-success ewButton"/>
    </form>

</body>
</html>