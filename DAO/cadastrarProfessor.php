<?php

include '../alerta_wamp.php';
include "../DAO/sql.php";

$acao = $_GET["acao"];
$idProfessor = $_POST["idProfessor"];
$idProfessorUpdate = $_POST["idProfessor"];
$arrayTurma = $_POST["turma"];

$nome = $_POST["nome"];
$rg = $_POST["rg"];
$cpf = $_POST["cpf"];
$funcao = $_POST["funcao"];
$estadoCivil = $_POST["estadoCivil"];
$dataNascimento = $_POST["dataNascimento"];
$formacao = $_POST["formacao"];
$anoConclusao = $_POST["anoConclusao"];
$logradouro = $_POST["logradouro"];
$numeroLogradouro = $_POST["numeroLogradouro"];
$bairro = $_POST["bairro"];
$cidade = $_POST["cidade"];
$cep = $_POST["cep"];

//FOTO
$arquivo = $_FILES['myfile'];

//ACAO SALVAR PROFESSOR
if ($acao == "salvar") {

    //INSERE DADOS DO PROFESSOR
    mysql_query("INSERT INTO professores (id, nome, rg, cpf, funcao, estadoCivil, dataNascimento, formacao, anoConclusao) "
                    . "VALUES "
                    . "(NULL, '$nome', '$rg', '$cpf', '$funcao', '$estadoCivil', '$dataNascimento', '$formacao', '$anoConclusao')") or die(mysql_error());
    $id_professor = mysql_insert_id();

    for ($i = 0; $i < count($arrayTurma); $i++) {
        mysql_query("INSERT INTO professor_turma (id,id_turma,id_professor) VALUES (NULL,'" . $arrayTurma[$i] . "',$id_professor)");
    }

    //CADASTRO ENDERECO
    if ($id_professor > 0) {
        mysql_query("INSERT INTO endereco_professor (id, logradouro, numero, bairro, cidade, cep) VALUES (NULL,' $logradouro', ' $numeroLogradouro', '$bairro', '$cidade', '$cep')") or die(mysql_error());
        updateForeignkeyProfessor($id_professor, "id_endereco", mysql_insert_id());
    }

    //SALVA IMAGEM DO PERFIL
    if ($id_professor > 0) {
        if ($arquivo != "" || $arquivo != NULL) {
            salvarImagem($arquivo, $id_professor);
        }
    }

    echo "<script language=javascript>location.href='../listarProfessores.php'</script>";
}
########################  UPDATE  ############################
if ($acao == "editar") {
    $queryProfessor = mysql_query("select * from professores where id = $idProfessor");
    $dadosProfessor = mysql_fetch_array($queryProfessor);

    mysql_query("UPDATE professores SET nome = '$nome',rg = '$rg', cpf = '$cpf', funcao = '$funcao', estadoCivil = '$estadoCivil', dataNascimento = '$dataNascimento', formacao = '$formacao', anoConclusao = '$anoConclusao' WHERE id = $idProfessorUpdate");

    if ($arquivo != "" || $arquivo != NULL) {
        salvarImagem($arquivo, $idProfessorUpdate);
    }

    //editar endereco
    mysql_query("UPDATE endereco_professor SET logradouro = '$logradouro', numero = '$numeroLogradouro', "
                    . "bairro = '$bairro', cidade = '$cidade', cep = '$cep' WHERE id = " . $dadosProfessor["id_endereco"] . "") or die(mysql_error());

   

    //deleta as turmas cadastradas para inserir as novas
    mysql_query("delete from professor_turma where id_professor = $idProfessor");
   
    for ($i = 0; $i < count($arrayTurma); $i++) {
        mysql_query("INSERT INTO professor_turma (id,id_turma,id_professor) VALUES (NULL,'" . $arrayTurma[$i] . "',$idProfessor)");
    }
    
    echo "<script language=javascript>location.href='../listarProfessores.php'</script>";
}

function salvarImagem($arquivo, $idProfessor) {
    //caminho que sera gravado
    $caminho = "../img/perfilProfessor/";
    $target_path = $caminho . basename($_FILES['myfile']['name']);
    $target_path = str_replace($trocarIsso, $porIsso, $target_path);
    $Nome = str_replace($trocarIsso, $porIsso, $arquivo['name']);
    if (preg_match('/^(.*)\.(gif|png|jpg)$/', $Nome)) {
        if (@move_uploaded_file($_FILES['myfile']['tmp_name'], $target_path)) {
            $target_path = str_replace("../", "./", $target_path);
            mysql_query("UPDATE professores SET photo = '$target_path' WHERE id = $idProfessor");
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function listarTurmas() {
    $query = mysql_query("select * from turmas order by turma asc") or die(mysql_error());
    return $query;
}

function updateForeignkeyProfessor($idProfessor, $coluna, $idChave) {
    mysql_query("UPDATE professores SET $coluna = '$idChave' WHERE id = $idProfessor") or die(mysql_error());
}

function perfilDatalhe($idProfessor) {

    $query = mysql_query("SELECT * FROM professores LEFT JOIN endereco_professor ON professores.id_endereco = endereco_professor.id   where professores.id = $idProfessor") or die(mysql_error());
    return $query;
}

function listarTurmasProfessor($idProfessor, $id_turma) {
    $query = mysql_query("SELECT * FROM professor_turma where id_professor = $idProfessor and id_turma = $id_turma") or die(mysql_error());
    return mysql_num_rows($query);
}
