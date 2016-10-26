<?php

error_reporting(0);
include "./sql.php";

$USR = $_POST["login"];
$PASSW = $_POST["senha"];

//Busca o usuario na base
$sqlUserLogin = mysql_query("SELECT * FROM usuario WHERE login = '" . $USR . "'");
$dadosUserBD = mysql_fetch_array($sqlUserLogin);
$numRowsUserLogin = mysql_num_rows($sqlUserLogin);

if ($numRowsUserLogin > 0) {
    $nomeUser = $dadosUserBD["nome"];
    $emailUser = $dadosUserBD["email"];
    $nivelUser = $dadosUserBD["nivel"];
    $data_senha = $dadosUserBD["DATA_SENHA"];
    $status_login = $dadosUserBD["STATUS_LOGIN"];

    if ($status_login == 0) {
        $sqlUserSenha = mysql_query("SELECT * FROM usuario WHERE login = '$USR' AND senha = '" . md5($PASSW) . "'");
        $numRowsUserSenha = mysql_num_rows($sqlUserSenha);
        $sqlUserSenhaArray = mysql_fetch_array($sqlUserSenha);



        if ($numRowsUserSenha > 0) {

            setcookie("CTPK", $USR . ":" . md5($PASSW), time() + 86400, "/");            

            //Liberar acesso aos arquivos
            setcookie("IMG", time() + 3600);
            
            $string_array = implode("|", array(0 =>"1"));
            echo $string_array;
        } else {
            $string_array = implode("|", array(0 =>"Sua senha atual esta incorreta!"));
            echo $string_array;
        }
        //Sem acesso	
    } else {
        $string_array = implode("|", array(0 => "Voce neo possui acesso ao sistema!"));
        echo $string_array;
    }
} else {
    $string_array = implode("|", array(0 => "Voce neo possui acesso ao sistema!"));
    echo $string_array;
}
?>