<?php

require 'classes/class.phpmailer.php';
$mail = new PHPMailer();

function tiraMoeda($valor) {
    $pontos = '.';
    $virgula = ',';
    $result = str_replace($pontos, "", $valor);
    $result2 = str_replace($virgula, ".", $result);
    return $result2;
}

function datas($dado) {
    $data = explode("/", $dado);
    $dia = $data[0];
    $mes = $data[1];
    $ano = $data[2];

    $resultado = $ano . "-" . $mes . "-" . $dia;
    return $resultado;
}

/////////// ATIVA DESATIVA BANCOS ///////////////////////////
if (isset($_GET["ativa"]) && $_GET["ativa"] == "ok") {

    $id_banco = $_GET['id_banco'];
    $res = $conecta->seleciona("SELECT * FROM bancos WHERE id_banco='$id_banco'");
    $list = mysql_fetch_array($res);
    $link = $list['link'];
    $banco = $list['nome_banco'];
    $tabela = "bancos";
    $valor = "1";
    $string = "id_banco = $id_banco";
    $dados = array(
        'id_banco' => $id_banco,
        'situacao' => $valor
    );
    $zera = mysql_query("UPDATE bancos SET situacao='0'");
    $conecta->alterar($tabela, $dados, $string);
    $endereco = $_SERVER['REQUEST_URI'];
    $link = explode("&", $endereco);
    $reader = $link[0];

    unset($_GET['ativa']);
    print "
				<META HTTP-EQUIV=REFRESH CONTENT='0; URL=$reader'>
				<script type=\"text/javascript\">
				alert(\"Banco $banco ativado com sucesso.\");
				</script>";
}

///////////////////////////// CONFIGURAÇÕES ///////////////////////////

if (isset($_POST['alterar'])) {
    $tabela = "config";
    $string = "id = 1";
    $dados = array(
        'nome' => $_POST['nome'],
        'email' => $_POST['email'],
        'cpf' => $_POST['cpf'],
        'endereco' => $_POST['endereco'],
        'cidade' => $_POST['cidade'],
        'uf' => $_POST['uf']
    );
    $conecta->alterar($tabela, $dados, $string);

    print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=?pg=configuracoes'>
		  <script type=\"text/javascript\">
		  alert(\"DADOS ALTERADOS COM SUCESSO!\");
		  </script>";
}
$sql = $conecta->seleciona("SELECT * FROM config")or die(mysql_error());
$linha = mysql_fetch_array($sql);

/////////////////////////////// DADOS INICIAIS ///////////////////////////////////////

$mes_atual = date("m");
$pendATUAL = $conecta->seleciona("SELECT * FROM faturas WHERE MONTH(data_venci) = '$mes_atual'")or die(mysql_error());


$data_hoje = date("Y-m-d");
$diar = mysql_query("SELECT COUNT(*) AS registros,SUM(valor) AS total FROM faturas WHERE data_venci ='$data_hoje'")or die(mysql_error());
$valordia = mysql_fetch_array($diar);
$totalhoje = $valordia['total'];
$reg = $valordia['registros'];


$sitp = $conecta->seleciona("SELECT * FROM faturas WHERE situacao = 'P'")or die(mysql_error());
$contp = mysql_num_rows($sitp);

$sitv = $conecta->seleciona("SELECT * FROM faturas WHERE situacao = 'V'")or die(mysql_error());
$contv = mysql_num_rows($sitv);

$sitb = $conecta->seleciona("SELECT * FROM faturas WHERE situacao = 'B'")or die(mysql_error());
$contb = mysql_num_rows($sitb);
///// total do mes ////////////
$resmes = $conecta->seleciona("SELECT *,SUM(valor) AS valorm FROM faturas WHERE MONTH(dbaixa) = '$mes_atual'")or die(mysql_error());
$rm = mysql_fetch_array($resmes);
$valorm = $rm['valorm'];
///// baixadas no mes ///////////	
$vrec = $conecta->seleciona("SELECT *,SUM(valor_recebido) AS valorr FROM faturas WHERE MONTH(dbaixa) = '$mes_atual' AND situacao = 'B'")or die(mysql_error());
$vr = mysql_fetch_array($vrec);
$valorr = $vr['valorr'];
//////////// valor vencido do mes ////////////////	
$vv = $conecta->seleciona("SELECT *,SUM(valor) AS valorv FROM faturas WHERE situacao = 'V'")or die(mysql_error());
$vrv = mysql_fetch_array($vv);
$valorv = $vrv['valorv'];
//////////// valor pendente do mes ////////////////	
$vp = $conecta->seleciona("SELECT *,SUM(valor) AS valorp FROM faturas WHERE  MONTH(data_venci) = '$mes_atual' AND situacao = 'P'")or die(mysql_error());
$vrp = mysql_fetch_array($vp);
$valorp = $vrp['valorp'];


//////////////////////////////////// CONFIGURA BANCOS ////////////////////////////////////////////////////////

if (isset($_POST['bancosgr'])) {
    $tabela = "bancos";
    $string = "id_banco = '4'";
    $dados = array(
        'id_banco' => $_POST['id_banco'],
        'carteira' => $_POST['carteira'],
        'agencia' => $_POST['agencia'],
        'digito_ag' => $_POST['digito_ag'],
        'conta' => $_POST['conta'],
        'digito_co' => $_POST['digito_co'],
        'convenio' => $_POST['convenio'],
        'contrato' => $_POST['contrato'],
        'conta' => $_POST['conta'],
        'digito_co' => $_POST['digito_co'],
        'tipo_carteira' => $_POST['tipo_carteira']
    );

    $conecta->alterar($tabela, $dados, $string);

    print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=?pg=banco'>
			<script type=\"text/javascript\">
			alert(\"DADOS ALTERADOS COM SUCESSO!\");
			</script>";
}

$sqlb = $conecta->seleciona("SELECT * FROM bancos")or die(mysql_error());
$linhas = mysql_fetch_array($sqlb);
$bancoativo = $linhas['id_banco'];

/////////////////////////// ATUALIZA PAYPAL /////////////////////////////

if (isset($_POST['atualizapaypal'])) {
    $tabela = "pag_extra";
    $string = "id = 1";
    $dados = array(
        'user' => $_POST['userpay'],
        'pass' => $_POST['pass'],
        'assinatura' => $_POST['assinatura'],
        'logo' => $_POST['logo'],
        'ativo' => $_POST['ativo']
    );

    $conecta->alterar($tabela, $dados, $string);

    print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=?pg=modulos'>
		<script type=\"text/javascript\">
		alert(\"DADOS ALTERADOS COM SUCESSO!\");
		</script>";
}


/////////////////////////// CONFIGURA BOLETOS /////////////////////////////

if (isset($_POST['confgoleto'])) {
    $tabela = "config";
    $string = "id = 1";
    $dados = array(
        'dias' => $_POST['dias'],
        'receber' => $_POST['receber'],
        'multa_atrazo' => $_POST['multa_atrazo'],
        'juro' => $_POST['juros'],
        'demo1' => $_POST['demo1'],
        'demo2' => $_POST['demo2'],
        'demo3' => $_POST['demo3'],
        'demo4' => $_POST['demo4']
    );

    $conecta->alterar($tabela, $dados, $string);

    print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=?pg=confboleto'>
		<script type=\"text/javascript\">
		alert(\"DADOS ALTERADOS COM SUCESSO!\");
		</script>";
}
$d_boleto = $conecta->seleciona("SELECT * FROM config")or die(mysql_error());
$linha = mysql_fetch_array($d_boleto);

///////////////////////// CONFIGURA SERVIDOR DE EMAIL ////////////////////////

if (isset($_POST['emailgr'])) {
    $tabela = "maile";
    $string = "id = 1";
    $dados = array(
        'empresa' => $_POST['empresa'],
        'url' => $_POST['url'],
        'porta' => $_POST['porta'],
        'endereco' => $_POST['endereco'],
        'limitemail' => $_POST['limitemail'],
        'email' => $_POST['email'],
        'senha' => $_POST['senha'],
    );

    $conecta->alterar($tabela, $dados, $string);
    print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=?pg=confmail'>
		<script type=\"text/javascript\">
		alert(\"DADOS ALTERADOS COM SUCESSO!\");
		</script>";
}

///////////////////////// CONFIGURA AVISO DE FATURA ////////////////////////

if (isset($_POST['aviso'])) {
    $tabela = "maile";
    $string = "id = 1";
    $dados = array(
        'aviso' => $_POST['aviso'],
        'text1' => $_POST['editor1']
    );


    $conecta->alterar($tabela, $dados, $string);
    print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=?pg=confmail#page=page-2'>
		<script type=\"text/javascript\">
		alert(\"DADOS ALTERADOS COM SUCESSO!\");
		</script>";
}

/////////////////// FATURA EM ABERTO /////////////////////////
if (isset($_POST['avisofataberto'])) {
    $tabela = "maile";
    $string = "id = 1";
    $dados = array(
        'avisofataberto' => $_POST['tata'],
        'text2' => $_POST['editor1']
    );

    $conecta->alterar($tabela, $dados, $string);

    print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=?pg=confmail#page=page-3'>
		<script type=\"text/javascript\">
		alert(\"DADOS ALTERADOS COM SUCESSO!\");
		</script>";
}
/////////////////// EMAIL DADOS ACESSO CLIENTE /////////////////////////
if (isset($_POST['dadosacesso'])) {
    $tabela = "maile";
    $string = "id = 1";
    $dados = array(
        'dadosacesso' => $_POST['enviadados'],
        'text3' => $_POST['editor1']
    );

    $conecta->alterar($tabela, $dados, $string);
    print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=?pg=confmail#page=page-4'>
		<script type=\"text/javascript\">
		alert(\"DADOS ALTERADOS COM SUCESSO!\");
		</script>";
}

$g_mail = $conecta->seleciona("SELECT * FROM maile")or die(mysql_error());
$linhamail = mysql_fetch_array($g_mail);

/////////////////////// ALTERA DADOS DE ACESSO ////////////////////////////
if (isset($_POST['user'])) {

    $tabela = "usuario";
    $string = "id_usuario = '1'";
    $dados = array(
        'login' => $_POST['login'],
        'senha' => $_POST['senha'],
        'hash' => hash('sha512', $_POST['senha'])
    );
    $conecta->alterar($tabela, $dados, $string);

    print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=?pg=configuracoes'>
		<script type=\"text/javascript\">
		alert(\"DADOS ALTERADOS COM SUCESSO!\");
		</script>";
}
$g_user = $conecta->seleciona("SELECT * FROM usuario")or die(mysql_error());
$linhauser = mysql_fetch_array($g_user);

//////////////////////////// CADASTRO PLANO DE CONTAS //////////////////////////

if (isset($_POST['cadastar_plano'])) {
    $tabela = "flux_planos";
    $dados = array(
        'descricao' => $_POST['descricao']
    );

    $sql = $conecta->inserir($tabela, $dados);
    print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=?pg=fluxo#tabs-2'>";
}

//////////////////////////// CADASTRO CONTAS //////////////////////////

if (isset($_POST['adicionar_conta'])) {
    $tabela = "flux_entrada";
    $dados = array(
        'data' => datas($_POST['data']),
        'tipo' => $_POST['tipo'],
        'id_plano' => $_POST['id_plano'],
        'descricao' => $_POST['descricao'],
        'valor' => tiraMoeda($_POST['valor'])
    );

    $sql = $conecta->inserir($tabela, $dados);
    print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=?pg=fluxo'>";
}
//////////////////////////// EDITAR CONTAS LANÇADAS ////////////////////////
if (isset($_POST['atualizalancamento'])) {

    $tabela = "flux_entrada";
    $id_entrada = $_POST['id_entrada'];
    $string = "id_entrada = '$id_entrada'";
    $teste = tiraMoeda($_POST['valor']);
    $dados = array(
        'data' => datas($_POST['data']),
        'tipo' => $_POST['tipo'],
        'id_plano' => $_POST['id_plano'],
        'descricao' => $_POST['descricao'],
        'valor' => tiraMoeda($_POST['valor'])
    );
    $conecta->alterar($tabela, $dados, $string);
}
//////////////////////////// CADASTRO DESPESAS FIXAS //////////////////////////

if (isset($_POST['grava_despesa_fixa'])) {
    $tabela = "flux_fixas";
    $dados = array(
        'dia_vencimento' => $_POST['dia_vencimento'],
        'descricao_fixa' => $_POST['descricao_fixa'],
        'valor_fixa' => tiraMoeda($_POST['valor_fixa'])
    );

    $sql = $conecta->inserir($tabela, $dados);
    print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=?pg=fluxo'>";
}
//////////////////////////// CADASTRO DE CLIENTES //////////////////////////
if (isset($_POST['clientegr'])) {
    $tabela = "cliente";
    $bloqueado = "N";
    $dados = array(
        'id_grupo' => $_POST['id_grupo'],
        'nome' => $_POST['nome'],
        'cpfcnpj' => $_POST['cpfcnpj'],
        'valor' => $_POST['valor'],
        'rg' => $_POST['rg'],
        'inscricao' => $_POST['inscricao'],
        'endereco' => $_POST['endereco'],
        'numero' => $_POST['numero'],
        'complemento' => $_POST['complemento'],
        'bairro' => $_POST['bairro'],
        'cidade' => $_POST['cidade'],
        'uf' => $_POST['uf'],
        'telefone' => $_POST['telefone'],
        'cep' => $_POST['cep'],
        'uf' => $_POST['uf'],
        'email' => $_POST['email'],
        'obs' => $_POST['obs'],
        'bloqueado' => $bloqueado,
        'senha' => '123'
    );

    $sql = $conecta->inserir($tabela, $dados);
    print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=?pg=cadclientes'>
		<script type=\"text/javascript\">
		alert(\"CLIENTE CADASTRADO COM SUCESSO!\");
		</script>";
}

///////////////////////////// CADASTRO DE GRUPOS //////////////////////
if (isset($_POST['cadgrupocli'])) {
    $tabela = "grupo";
    $dados = array(
        'nomegrupo' => $_POST['nomegrupo'],
        'meses' => $_POST['meses'],
        'dia' => $_POST['dia'],
        'valor' => $_POST['valor']
    );
    $sql = $conecta->inserir($tabela, $dados);
    print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=?pg=grupo'>
			<script type=\"text/javascript\">
			alert(\"GRUPO CADASTRADO COM SUCESSO!\");
			</script>";
}
$gr = $conecta->seleciona("SELECT * FROM grupo WHERE id_grupo !='1'");
///////////////////// DELETA GRUPOS ///////////////////////
if (isset($_GET['del']) && $_GET['del'] == "del") {
    $idGrupo = $_GET['id_grupo'];
    $del = mysql_query("DELETE FROM grupo WHERE id_grupo='$idGrupo'")or die(mysql_error());
    print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=?pg=grupo'>
			<script type=\"text/javascript\">
			alert(\"GRUPO DELETADO COM SUCESSO!\");
			</script>";
}
/////////////////////// EDITA CLIENTES //////////////////////////
$consulta = $conecta->seleciona("SELECT * FROM cliente ORDER BY nome ASC")or die(mysql_error());

////////////////////////// CONFERE SE EXISTE O DOCUMENTO //////////////////////
if (isset($_POST['lancafatunica']) && $_POST['id_cliente'] != "0") {

    $num_doc = $_POST['num_doc'];
    $ver = mysql_query("SELECT num_doc FROM faturas WHERE num_doc ='$num_doc'"); // verifica se o numero do documento ja existe
    $confere = mysql_num_rows($ver);

    if ($confere != 0) {
        print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL='>
			<script type=\"text/javascript\">
			alert(\"ERRO: JA EXISTE UMA FATURA COM ESTE NUMERO. POR FAVOR ESCOLHA OUTRO.\");
			</script>";
    } else {

////////////////////////////////////// LANÇA FATURA UNICA SE O DOCUMENTO NAO EXISTIR ///////////////////////

        $id_cliente = $_POST['id_cliente'];
        $cli = $conecta->seleciona("SELECT * FROM cliente WHERE id_cliente = '$id_cliente' ")or die(mysql_error());
        $nomecli = mysql_fetch_array($cli);

        $id = $nomecli['id_cliente'];
        $nome = $nomecli['nome'];
        $emailc = $nomecli['email'];
        $ref = $_POST['ref'];

        $valor = tiraMoeda($_POST['valor']);
        $data_ven = $_POST['data_venci'];
        $dv = explode("/", $data_ven);
        $dia = $dv[0];
        $mes = $dv[1];
        $ano = $dv[2];

        $vencimento = $ano . "-" . $mes . "-" . $dia;

        $situacao = 'P';
        $tabela = "faturas";
        $tipofatura = 'AVULSO';
        $dados = array(
            'id_cliente' => $id,
            'nosso_numero' => "00",
            'banco' => $banco,
            'nome' => $nome,
            'ref' => $ref,
            'data' => date("Y-m-d"),
            'data_venci' => $vencimento,
            'valor' => $valor,
            'situacao' => $situacao,
            'num_doc' => $num_doc,
            'emailcli' => $emailc,
            'tipofatura' => $tipofatura
        );

        $sql_mail = $conecta->inserir($tabela, $dados);
        $id_res = mysql_insert_id();
        if ($conecta == true) {
            include "mail_fat_unica.php";
        }
    }
}

//////////////////////// encodifica url //////////////////////////////////////
function base64url_encode($data) {
    return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
}

////////////////////////// LANÇA FATURA POR GRUPOS ////////////////////////////
if (isset($_POST['lancafatperiodica']) && $_POST['id_grupo'] != "0") {

    $s = explode("/", $_POST['data_venci']);
    $d = $s[0];
    $m = $s[1];
    $a = $s[2];
    $dat = $a . '-' . $m . '-' . $d;



// SELECIONA AS CONFIGURAÇÕES
    $sql = mysql_query("SELECT * FROM config");
    $config = mysql_fetch_array($sql);
    $nomeconf = $config['nome'];
    $emailconf = $config['email'];
    $dias_antes = $config['dias'];
    $id_grupo = $_POST['id_grupo'];
    $define = $_POST['define'];
    $ref = $_POST['ref'];

// SELECIONA OS CLIENTES E GERA AS FATURAS

    $sql_cliente = mysql_query("SELECT * FROM cliente WHERE bloqueado = 'N' AND id_grupo = '$id_grupo'");
    while ($select_cliente = mysql_fetch_array($sql_cliente)) {
        $id_cliente = $select_cliente['id_cliente'];
        $nome_cliente = $select_cliente['nome'];
        $cpf_cliente = $select_cliente['cpfcnpj'];
        $email_cliente = $select_cliente['email'];

//        if ($define == "s") {
        $valor_cliente = tiraMoeda($_POST['valor']);
//        } else {
//            $valor_cliente = $select_cliente['valor'];
//        }
        // pega o numero do documento
        $verdoc = mysql_query("SELECT id_venda, num_doc FROM faturas ORDER BY id_venda DESC LIMIT 1");
        $DOC = mysql_fetch_array($verdoc);
        $id_res = $DOC['id_venda'];
        $num_doc = $DOC['num_doc'] + 1;

        $sql_periodica = mysql_query("INSERT INTO faturas ( id_cliente, nome, ref, data, data_venci, valor,situacao, num_doc, condmail, emailcli, tipoFatura) VALUES
			('$id_cliente','$nome_cliente','$ref','$datahoje', '$dat','$valor_cliente','P','$num_doc','1','$email_cliente', 'GRUPO')") or die(mysql_error());
        include "mail_fat_periodica.php";
        //}
    }
    if (isset($sql_periodica) && $sql_periodica == 1) {
        print"<META HTTP-EQUIV=REFRESH CONTENT='0; URL=inicio.php?pg=periodica'>
								<script type=\"text/javascript\">
								alert(\"Foram geradas e emails enviados!\");
								</script>";
    } else {
        echo "<META HTTP-EQUIV=REFRESH CONTENT='0; URL=?pg=periodica'>
									<script type=\"text/javascript\">
									alert(\"Este grupo não possui clientes associados!\");
									</script>";
    }
}// fecha lancamento	
///////////////////////// gera link fatura //////////////////
$url = $conecta->seleciona("SELECT * FROM bancos WHERE situacao='1'");
$lista = mysql_fetch_array($url);
$link = $lista['link'];
?>