<?php

include '../alerta_wamp.php';
include "../classes/conexao.php";
include './calculaIdade.php';

$acao = $_GET["acao"];
$idAlunoUpdate = $_POST["idAluno"];

$idTurma = $_POST["turma"];

$nomeAluno = $_POST["nomeAluno"];
$dataNascimento = $_POST["dataNascimento"];
//$idade = calc_idade($dataNascimento);
$sexo = $_POST["sexo"];

//pais
$nomeMae = $_POST["nomeMae"];
$rgMae = $_POST["rgMae"];
$cpfMae = $_POST["cpfMae"];
$foneMae = $_POST["foneMae"];
$nomePai = $_POST["nomePai"];
$rgPai = $_POST["rgPai"];
$cpfPai = $_POST["cpfPai"];
$fonePai = $_POST["fonePai"];
$responsavelPagamento = $_POST["responsavelPagamento"];
$emailResp = $_POST["emailPagamento"];
$obs = $_POST["obs"];

$logradouro = $_POST["logradouro"];
$numeroLogradouro = $_POST["numeroLogradouro"];
$bairro = $_POST["bairro"];
$cidade = $_POST["cidade"];
$cep = $_POST["cep"];

//certidao nascimento
$matricula = $_POST["matricula"];
$local = $_POST["local"];
$cartorio = $_POST["cartorio"];
$dataEmissao = $_POST["dataEmissao"];

//pessoas responsaveis em buscar o aluno
$nomePessoa1 = $_POST["nomePessoa1"];
$rgPessoa1 = $_POST["rgPessoa1"];
$nomePessoa2 = $_POST["nomePessoa2"];
$rgPessoa2 = $_POST["rgPessoa2"];
$nomePessoa3 = $_POST["nomePessoa3"];
$rgPessoa3 = $_POST["rgPessoa3"];

//FOTO
$arquivo = $_FILES['myfile'];

//AULAS EXTRAS
$judo = isset($_POST['judo']);
$capoeira = isset($_POST['capoeira']);
$bale = isset($_POST['bale']);

//cria lista com os phones dos pais
$arrayTelefoneMae = explode(";", $foneMae);
$phone1Mae = $arrayTelefoneMae[0];
$phone2Mae = $arrayTelefoneMae[1];
$phone3Mae = $arrayTelefoneMae[2];
$arrayTelefonePai = explode(";", $fonePai);
$phone1Pai = $arrayTelefonePai[0];
$phone2Pai = $arrayTelefonePai[1];
$phone3Pai = $arrayTelefonePai[2];

//ACAO SALVAR ALUNO
if ($acao == "salvar") {

    //INSERE DADOS DO ALUNO
    mysql_query("INSERT INTO alunos (id, name, birth_date, gender "
                    . ") VALUES (NULL, '$nomeAluno',  '$dataNascimento', '$sexo')") or die(mysql_error());
    $id_aluno = mysql_insert_id();

    //SALVA IMAGEM DO PERFIL
    if ($id_aluno > 0) {
        if ($arquivo != "" || $arquivo != NULL) {
            salvarImagem($arquivo, $id_aluno);
        }
    }


    //CADASTRO PAIS
    if ($id_aluno > 0) {
        if (responsavelPagamento == "MAE") {
            $nomeResp = $nomeMae;
            $cpfResp = $cpfMae;
            $rgResp = $rgMae;
            $foneResp = $foneMae;
        } else {
            $nomeResp = $nomePai;
            $cpfResp = $cpfPai;
            $rgResp = $rgPai;
            $foneResp = $fonePai;
        }

        mysql_query("INSERT INTO cliente (id_cliente, id_grupo, nome, cpfcnpj, rg, "
                        . "inscricao, endereco, numero, complemento, bairro, "
                        . "cidade, uf, telefone, cep, email, obs, valor, bloqueado, senha) "
                        . "VALUES "
                        . "(NULL, '$idTurma', '$nomeResp', '$cpfResp', '$rgResp', "
                        . "'', '$logradouro', '$numeroLogradouro', '', '$bairro', '$cidade', "
                        . "'PR', '$foneResp', '$cep', '$emailResp', '$obs', "
                        . "'0', 'N', '123')") or die(mysql_error());
        $idCliente = mysql_insert_id();
        //insere dados do grupo
        //buscnome da turma
        $dadosTurma = mysql_query("SELECT * FROM turmas WHERE id = $idTurma");
        $dadosTurma = mysql_fetch_array($dadosTurma);
        $dadosTurma = $dadosTurma["turma"];
        
        mysql_query("INSERT INTO grupo (id, id_grupo, id_cliente, nomegrupo, meses, dia, valor)"
                . " VALUES"
                . " (NULL, '$idTurma', '$idCliente', '$dadosTurma', '0', '0', '')");

        mysql_query("INSERT INTO pais (id, mothersName, mothersCpf, mothersRg, mothersPhone1, mothersPhone2, mothersPhone3,"
                        . " fatherName, fatherCpf, fatherRg, fatherPhone1, fatherPhone2, fatherPhone3 , responsavelPagamento, emailPagamento"
                        . ") VALUES (NULL, '$nomeMae', '$cpfMae', '$rgMae', '$phone1Mae', '$phone2Mae', '$phone3Mae',"
                        . "'$nomePai', '$cpfPai', ' $rgPai', ' $phone1Pai', '$phone2Pai', '$phone3Pai', '$responsavelPagamento', '$emailResp')") or die(mysql_error());

        updateForeignkeyAluno($id_aluno, "id_pais", mysql_insert_id());
    }

    //CADASTRO ENDERECO
    if ($id_aluno > 0) {
        mysql_query("INSERT INTO endereco_aluno (id, logradouro, numero, bairro, cidade, cep) VALUES (NULL,' $logradouro', ' $numeroLogradouro', '$bairro', '$cidade', '$cep')") or die(mysql_error());
        updateForeignkeyAluno($id_aluno, "id_endereco", mysql_insert_id());
    }

    //CADASTRO SERTIDAO DE NASCIMENTO
    if ($id_aluno > 0) {
        mysql_query("INSERT INTO certidao_nascimento (id, matricula, local, cartorio, dataEmissao) VALUES (NULL, '$matricula', '$local', '$cartorio', '$dataEmissao')") or die(mysql_error());
        updateForeignkeyAluno($id_aluno, "id_certidao", mysql_insert_id());
    }

    //CADASTRO TURMA
    if ($id_aluno > 0) {
        if ($idTurma != "") {
            updateForeignkeyAluno($id_aluno, "id_turma", $idTurma);
        }
    }


    //CADASTRO PESSOAS AUTORIZADAS
    if ($id_aluno > 0) {
        inserePessoasAutorizadas($id_aluno);
    }

    //CADASTRO AULAS EXTRAS
    if ($id_aluno > 0) {
        if ($bale != "") {
            cadastrarAulasExtras($id_aluno, 1);
        }
        if ($capoeira != "") {
            cadastrarAulasExtras($id_aluno, 2);
        }
        if ($judo != "") {
            cadastrarAulasExtras($id_aluno, 3);
        }
    }
    echo "<script language=javascript>location.href='../listarAlunos.php'</script>";
}


########################  UPDATE  ############################
if ($acao == "editar") {
    $queryAluno = mysql_query("select * from alunos where id = $idAlunoUpdate");
    $dadosAluno = mysql_fetch_array($queryAluno);

    mysql_query("UPDATE alunos SET name = '$nomeAluno', age = '$idade', birth_date = '$dataNascimento', gender = '$sexo' WHERE id = $idAlunoUpdate");

    if ($arquivo != "" || $arquivo != NULL) {
        salvarImagem($arquivo, $idAlunoUpdate);
    }


    //editar pais
    mysql_query("UPDATE pais SET mothersName = '$nomeMae', mothersCpf = '$cpfMae', mothersRg = '$rgMae', "
                    . "mothersPhone1 = '$phone1Mae', mothersPhone2 = '$phone2Mae', mothersPhone3 = '$phone3Mae', "
                    . "fatherName = '$nomePai', fatherCpf = '$cpfPai', fatherRg = '$rgPai', fatherPhone1 = '$phone1Pai', "
                    . "fatherPhone2 = '$phone2Pai', fatherPhone3 = '$phone3Pai' WHERE id = " . $dadosAluno["id_pais"] . "") or die(mysql_error());


    //editar endereco
    mysql_query("UPDATE endereco_aluno SET logradouro = '$logradouro', numero = '$numeroLogradouro', "
                    . "bairro = '$bairro', cidade = '$cidade', cep = '$cep' WHERE id = " . $dadosAluno["id_endereco"] . "") or die(mysql_error());

    if ($idTurma != "") {
        mysql_query("UPDATE alunos SET id_turma = '$idTurma' WHERE id = $idAlunoUpdate");
    }

    //editar certidao nascimento
    $numRowscertidao = mysql_query("select * from alunos where id = " . $dadosAluno["id_certidao"] . "");
    if (mysql_num_rows($numRowscertidao) > 0) {//update
        mysql_query("UPDATE certidao_nascimento SET matricula = '$matricula', local = '$local', cartorio = '$cartorio', dataEmissao = '$dataEmissao' WHERE id = " . $dadosAluno["id_certidao"] . "") or die(mysql_error());
    } else { //ainda nao foi cadastrado, insere
        mysql_query("INSERT INTO certidao_nascimento (id, matricula, local, cartorio, dataEmissao) VALUES (NULL, '$matricula', '$local', '$cartorio', '$dataEmissao')") or die(mysql_error());
        updateForeignkeyAluno($id_aluno, "id_certidao", mysql_insert_id());
    }

    inserePessoasAutorizadas($idAlunoUpdate);

    //deleta as aulas extras cadastradas para inserir as novas
    mysql_query("delete from alunos_aulas_extras where id_aluno = $idAlunoUpdate");
    if ($bale != "") {
        cadastrarAulasExtras($idAlunoUpdate, 1);
    }
    if ($capoeira != "") {
        cadastrarAulasExtras($idAlunoUpdate, 2);
    }
    if ($judo != "") {
        cadastrarAulasExtras($idAlunoUpdate, 3);
    }

    echo "<script language=javascript>location.href='../listarAlunos.php'</script>";
}

function inserePessoasAutorizadas($id_aluno) {
    $arrayNomePessoas = array();
    $arrayRgPessoas = array();
    $arrayIdPessoas = array();

    mysql_query("DELETE FROM alunos_pessoas_autorizadas WHERE $id_aluno");

    global $nomePessoa1;
    global $rgPessoa1;
    global $nomePessoa2;
    global $rgPessoa2;
    global $nomePessoa3;
    global $rgPessoa3;

    if ($nomePessoa1 != "") {
        mysql_query("insert into pessoas_autorizadas (id, nome, rg) values (null, '$nomePessoa1', '$rgPessoa1')") or die(mysql_error());
        $arrayIdPessoas[0] = mysql_insert_id();
    }
    if ($nomePessoa2 != "") {
        mysql_query("insert into pessoas_autorizadas (id, nome, rg) values (null, '$nomePessoa2', '$rgPessoa2')") or die(mysql_error());
        $arrayIdPessoas[1] = mysql_insert_id();
    }
    if ($nomePessoa3 != "") {
        mysql_query("insert into pessoas_autorizadas (id, nome, rg) values (null, '$nomePessoa3',  '$rgPessoa3')") or die(mysql_error());
        $arrayIdPessoas[2] = mysql_insert_id();
    }

    foreach ($arrayIdPessoas as &$value) {
        mysql_query("insert into alunos_pessoas_autorizadas (id_aluno, id_pessoa_autorizada) values (  $id_aluno, $value)") or die(mysql_error());
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
    $query = mysql_query("select * from turmas order by turma asc") or die(mysql_error());
    return $query;
}

function cadastrarAulasExtras($idAluno, $idAulaExtra) {
    mysql_query("INSERT INTO alunos_aulas_extras (id, id_aluno, id_aulas_extras) VALUES (NULL, '$idAluno', '$idAulaExtra')") or die(mysql_error());
}

function updateForeignkeyAluno($idAluno, $coluna, $idChave) {
    mysql_query("UPDATE alunos SET $coluna = '$idChave' WHERE id = $idAluno") or die(mysql_error());
}

function salvarImagem($arquivo, $idAluno) {
    //caminho que sera gravado
    $caminho = "../img/perfilAluno/";
    $target_path = $caminho . basename($_FILES['myfile']['name']);
    $target_path = $target_path;
    $Nome = $arquivo['name'];
    if (preg_match('/^(.*)\.(gif|png|jpg)$/', $Nome)) {
        if (@move_uploaded_file($_FILES['myfile']['tmp_name'], $target_path)) {
            $target_path = str_replace("../", "./", $target_path);
            mysql_query("UPDATE alunos SET photo = '$target_path' WHERE id = $idAluno");
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }
}

function listarAulasExtras($id) {
    $query = mysql_query("SELECT ae.aula FROM alunos a, aulas_extras ae, alunos_aulas_extras aae WHERE a.id = aae.id_aluno and ae.id = aae.id_aulas_extras and a.id = $id") or die(mysql_error());
    return $query;
}

function calc_idade($data_nasc) {
    $data_nasc = date_create($data_nasc);

    $data_nasc = date_format($data_nasc, 'm/d/Y');
    $data_nasc = explode('/', $data_nasc);

    $data = date('d/m/Y');

    $data = explode('/', $data);

    $anos = $data[2] - $data_nasc[2];


    if ($data_nasc[1] >
            $data[1])
        return $anos - 1;

    if ($data_nasc[1] == $data[1])
        if ($data_nasc[0] <= $data[0]) {
            return $anos;
        } else {
            return $anos - 1;
        }

    if ($data_nasc[1] < $data[1])
        return $anos;
}
