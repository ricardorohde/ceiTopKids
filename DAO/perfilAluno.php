<?php

$deletar = $_POST["deletar"];
$id_endereco = $_POST["id_endereco"];
$id_certidao = $_POST["id_endereco"];
$id = $_POST["id"];
if ($deletar == "SIM") {
    deletarAluno($id, $id_endereco, $id_certidao);
}

function perfilDatalhe($id) {
    $query = mysql_query("SELECT * FROM alunos LEFT JOIN pais ON alunos.id_pais = pais.id LEFT JOIN certidao_nascimento ON alunos.id_certidao = certidao_nascimento.id LEFT JOIN turmas ON alunos.id_turma = turmas.id where alunos.id = $id") or die(mysql_error());
    return $query;
}

function listarPessoasAutorizadas($id) {
    $query = mysql_query("SELECT p.nome, p.rg FROM alunos a, pessoas_autorizadas p ,alunos_pessoas_autorizadas pa WHERE a.id = pa.id_aluno and p.id = pa.id_pessoa_autorizada and a.id = $id") or die(mysql_error());
    return $query;
}

function listarAulasExtras($id) {
    $query = mysql_query("SELECT ae.aula FROM alunos a, aulas_extras ae, alunos_aulas_extras aae WHERE a.id = aae.id_aluno and ae.id = aae.id_aulas_extras and a.id = $id") or die(mysql_error());
    return $query;
}

function professorAluno($id) {
    $query = mysql_query("SELECT nome FROM professores p, professor_turma pt where p.id = id_professor and id_turma = $id") or die(mysql_error());
    return $query;
}

function listaObs($id) {
    $query = mysql_query("SELECT o.obs, o.data FROM alunos a, observacao_aluno o where a.id = o.id_aluno and a.id = $id");
    return $query;
}

function deletarAluno($id, $id_endereco, $id_certidao) {
    require '../alerta_wamp.php';
    require '../classes/conexao.php';
    mysql_query("delete from alunos_aulas_extras where id_aluno = $id") or die(mysql_error());
    mysql_query("delete from alunos_pessoas_autorizadas where id_aluno = $id");
    mysql_query("delete from certidao_nascimento where id = $id_certidao");
    mysql_query("delete from endereco_aluno where id = $id_endereco");
    mysql_query("delete from observacao_aluno where id_aluno = $id_endereco");
    $string_array = implode("|", array(0 => "Registro Excluido"));
    echo $string_array;
}

?>