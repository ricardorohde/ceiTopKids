<?php 
include '../alerta_wamp.php';
session_start();
//se nao existir volta para a pagina do form de login
if(!isset($_SESSION['login_session']) and !isset($_SESSION['senha_session'])){
	header("Location:../index.php");
	exit;		
}
?>
<?php 
require_once('pdf/mpdf.php');
ob_start();
include ('view_relatorio.php');
$html = ob_get_clean();
$mpdf = new mPDF('en-GB','A4',12,'dejavusans'); 
$mpdf->WriteHTML($html);	 
$mpdf->Output();
exit;
?>