<?php 
require_once('pdf/mpdf.php');
ob_start();
include ('Relatorioestoque.php');
$html = ob_get_clean();
$mpdf = new mPDF('en-GB','A4',12,'dejavusans'); 
$mpdf->WriteHTML($html);	 
$mpdf->Output();
exit;
?>