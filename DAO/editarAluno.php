<?php

//require '../alerta_wamp.php';
$acao = $_GET["acao"];


if ($acao == "salvar") {
    $arquivo = $_FILES['myfile'];
    $judo = isset($_POST['judo']);
    
    salvarImagem($arquivo);
}

function salvarImagem($arquivo) {
    //caminho que sera gravado
    $caminho = "../images/perfil/";
    $target_path = $caminho . basename($_FILES['myfile']['name']);
    $target_path = str_replace($trocarIsso, $porIsso, $target_path);
    $Nome = str_replace($trocarIsso, $porIsso, $arquivo['name']);
    if (preg_match('/^(.*)\.(gif|png|jpg)$/', $Nome)) {
        if (@move_uploaded_file($_FILES['myfile']['tmp_name'], $target_path)) {
            return true;
        }else{
            return false;
        }
    }else{
        return false;
    }
}

function perfilDatalhe($id) {
      $query = mysql_query("SELECT * FROM alunos LEFT JOIN pais ON alunos.id_pais = pais.id "
            . "LEFT JOIN certidao_nascimento ON alunos.id_certidao = certidao_nascimento.id "
            . "LEFT JOIN endereco_aluno ON alunos.id_endereco = endereco_aluno.id "
            . "where alunos.id = $id") or die(mysql_error());
    return $query;
}

function listarPessoasAutorizadas($id) {
    $query = mysql_query("SELECT p.nome, p.rg FROM alunos a, pessoas_autorizadas p ,alunos_pessoas_autorizadas pa WHERE a.id = pa.id_aluno and p.id = pa.id_pessoa_autorizada and a.id = $id") or die(mysql_error());
    return $query;
}

function listarTurmas() {
    $query = mysql_query("select * from turmas") or die(mysql_error());
    return $query;
}

$trocarIsso = array('à', 'á', 'â', 'ã', 'ä', 'å', 'ç', 'è', 'é', 'ê', 'ë', 'ì', 'í', 'î', 'ï', 'ñ', 'ò', 'ó', 'ô', 'õ', 'ö', 'ù', 'ü', 'ú', 'ÿ', 'À', 'Á', 'Â', 'Ã', 'Ä', 'Å', 'Ç', 'È', 'É', 'Ê', 'Ë', 'Ì', 'Í', 'Î', 'Ï', 'Ñ', 'Ò', 'Ó', 'Ô', 'Õ', 'Ö', 'O', 'Ù', 'Ü', 'Ú', 'Ÿ', '­', 'A­', '§', '£', '©', 'ª', 'º', 'Aº', 'A³', 'xlsx');
$porIsso = array('a', 'a', 'a', 'a', 'a', 'a', 'c', 'e', 'e', 'e', 'e', 'i', 'i', 'i', 'i', 'n', 'o', 'o', 'o', 'o', 'o', 'u', 'u', 'u', 'y', 'A', 'A', 'A', 'A', 'A', 'A', 'C', 'E', 'E', 'E', 'E', 'I', 'I', 'I', 'I', 'N', 'O', 'O', 'O', 'O', 'O', 'O', 'U', 'U', 'U', 'Y', '', '', 'c', 'a', '', '', '', '', 'o', 'xls');
?>