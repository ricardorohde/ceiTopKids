<?php 
// desttroi a sessao
session_start();
unset($_SESSION['cpfcnpj_session']);
header("location:index.php");
?>
