<?php


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

function listaObs($id){
    $query = mysql_query("SELECT o.obs, o.data FROM alunos a, observacao_aluno o where a.id = o.id_aluno and a.id = $id");
    return $query;
}

?>