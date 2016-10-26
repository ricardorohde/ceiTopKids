<?php

error_reporting(0);
include "./sql.php";

mysql_query("SET character_set_results = 'utf8', character_set_client = 'utf8', character_set_connection = 'utf8', character_set_database = 'utf8', character_set_server = 'utf8'", $conn);

$idAluno = $_POST["idAluno"];
$obs = $_POST["obs"];
$data = date("Y-m-d");

mysql_query("INSERT INTO observacao_aluno (id, id_aluno, obs, data) VALUES (NULL, '$idAluno', '$obs', '$data')") or die (mysql_error());

$string_array = implode("|", array(0 => "salvo"));
echo $string_array;
?>