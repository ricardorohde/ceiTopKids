<?php

$deletar = $_POST["deletar"];
$id_endereco = $_POST["id_endereco"];
$id = $_POST["id"];

if ($deletar == "SIM") {
    deletarProfessor($id, $id_endereco);
}

function perfilDatalhe($id) {
    $query = mysql_query("SELECT * FROM professores LEFT JOIN endereco_professor ON professores.id_endereco = endereco_professor.id  where professores.id = $id") or die(mysql_error());
    return $query;
}

function listaObs($id) {
    $query = mysql_query("SELECT o.obs, o.data FROM professores a, observacao_professor o where a.id = o.id_professor and a.id = $id");
    return $query;
}

function deletarProfessor($id, $id_endereco) {
    require '../alerta_wamp.php';
    require '../classes/conexao.php';
    mysql_query("delete from professores where id = $id") or die(mysql_error());
    mysql_query("delete from professor_turma where id_professor = $id");
    mysql_query("delete from observacao_professor where id_professor = $id");
    mysql_query("delete from endereco_professor where id = $id_endereco");
    $string_array = implode("|", array(0 => "Registro Excluido"));
    echo $string_array;
}

?>