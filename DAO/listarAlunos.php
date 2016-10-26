<?php

function listaDeAlunos($v) {
    $query = mysql_query("SELECT alunos.name, alunos.id, alunos.age, turmas.turma, alunos.birth_date "
            . " FROM alunos LEFT JOIN pais ON alunos.id_pais = pais.id LEFT JOIN certidao_nascimento ON alunos.id_certidao = certidao_nascimento.id LEFT JOIN turmas ON alunos.id_turma = turmas.id ") or die(mysql_error());
    return $query;
}

?>