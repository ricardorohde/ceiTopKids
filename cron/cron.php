<?php 
include "../classes/conexao.php";
require '../classes/class.phpmailer.php';

function datas($dados){
	$s = explode("-",$dados);
		$as = $s[0];
		$ms = $s[1];
		$ds = $s[2];	
	return $ds."/".$ms."/".$as;
}

$mail = new PHPMailer();

// SELECIONA DADOS DO EMAIL QUE ENVIA COBRANÇA
$sql = mysql_query("SELECT * FROM maile")or die (mysql_error());
$linha = mysql_fetch_array($sql);
$host = $linha['url'];
$empresa = $linha['empresa'];
$endereco = $linha['endereco'];
$email = $linha['email'];
$html = $linha['text1'];

//////////////////////// encodifica url //////////////////////////////////////
function base64url_encode($data) {
			return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
			}

// RETIRA PONTOS DOS VALORES
	function tiraMoeda($valor){
	$pontos = '.';
	$virgula = ',';
	$result = str_replace($pontos, "", $valor);
	$result2 = str_replace($virgula, ".", $result);
	return $result2;
	}
// SELECIONA AS CONFIGURAÇÕES
$sql = mysql_query("SELECT * FROM config");
$config = mysql_fetch_array($sql);
	$nomeconf = $config['nome'];
	$emailconf = $config['email'];
	$dias_antes = $config['dias'];

// Cria uma função que retorna o timestamp de uma data no formato DD/MM/AAAA
function geraTimestamp($data) {
$partes = explode('/', $data);
return mktime(0, 0, 0, $partes[1], $partes[0], $partes[2]);
}
	
// SELECIONA OS CLIENTES E GERA AS FATURAS
$sql_cliente = mysql_query("SELECT * FROM cliente WHERE bloqueado = 'N' AND id_grupo !='1'");
while($select_cliente = mysql_fetch_array($sql_cliente)){
		$id_cliente = $select_cliente['id_cliente'];	
		$id_grupo		= $select_cliente['id_grupo'];
		$nome_cliente 	= $select_cliente['nome'];
		$cpf_cliente 	= $select_cliente['cpfcnpj']; 
		$email_cliente  = $select_cliente['email'];
		$valor_cliente 	= $select_cliente['valor'];
			
			// pega o numero do documento
		$verdoc = mysql_query("SELECT id_venda FROM faturas ORDER BY id_venda DESC LIMIT 1");
		$DOC = mysql_fetch_array($verdoc);
		$id_res = $DOC['id_venda'];
		$num_doc = $DOC['id_venda'] + 1;
				
				// seleciona o grupo para pegar a data de vencimento
				$sql_data = mysql_query("SELECT * FROM grupo WHERE id_grupo = '$id_grupo'");
					$data = mysql_fetch_array($sql_data);
					$id_grupo_cliente 	= $data['id_grupo'];
					$meses 				= $data['meses'];
					$dia_vencimento		= $data['dia'];
					$valorGrupo			= $data['valor'];
					
					
		// seleciona as faturas e verifica se ja foi lancada
		$verdat = mysql_query("SELECT * FROM faturas WHERE id_cliente ='$id_cliente' AND tipofatura !='AVULSO' AND situacao ='P'") or die (mysql_error());
		$contar = mysql_num_rows($verdat);
		$tultimafatura = mysql_fetch_array($verdat);
		$ref = $tultimafatura['ref']; 
			if($ref == ""){
				$ref = 	$select_cliente['obs'];
			}
		
			if($contar == 0){
				$ultimoboleto = date("Y-m-d");
			}else{
			$ultimoboleto = $tultimafatura['data_venci'];
			}
			$s = explode("-",$ultimoboleto);
				$a = $s[0];
				$m = $s[1];
				$d = $s[2];	
				
			$ultima = $a.'-'.$m.'-'.$dia_vencimento;
			$fatura = date("Y-m-d", strtotime("+$meses month", strtotime($ultima)));
		
	
		if($contar == 0){
			$dat = date('Y-m-'.$dia_vencimento);
				$hoje = date("Y-m-d");
				if(strtotime($hoje) > strtotime ($dat)){
					$dat = date("Y-m-d", strtotime("+1 month"));	
				}
		}	
		else{	
		$dat = $fatura;
		}


// Define os valores a serem usados
$data_inicial = date("d/m/Y");
$data_final = datas($dat);


// Usa a função criada e pega o timestamp das duas datas:
$time_inicial = geraTimestamp($data_inicial);
$time_final = geraTimestamp($data_final);

// Calcula a diferença de segundos entre as duas datas:
$diferenca = $time_final - $time_inicial; // 19522800 segundos

// Calcula a diferença de dias
$dias = (int)floor( $diferenca / (60 * 60 * 24)); // 225 dias
	
		$montavencimento = explode("-", $dat);
			$dia = $montavencimento[2];
			$mes = $montavencimento[1];
			$ano = $montavencimento[0];	
			
			$lancamento = $ano."-".$mes."-".$dia_vencimento;
				
				
				//break;
			if($dias <= $dias_antes && $contar == 0){
			$sql_periodica = mysql_query("INSERT INTO faturas ( id_cliente, nome, ref, data, data_venci, valor,situacao, num_doc, condmail, emailcli, tipofatura) VALUES
			('$id_cliente','$nome_cliente','$ref','$datahoje', '$lancamento','$valor_cliente','P','$num_doc','1','$email_cliente','CRON')") or die(mysql_error());
			
		if($sql_periodica == 1){
		echo "fatura lancada";	
		}
/* ********* ENVIA OS EMAILS CASO A FATURA SEJA LANCADA **********************************************************************************/

if($sql_periodica == 1){
$mail->IsSMTP();
$mail->isHTML( true );
$mail->Charset = 'UTF-8';
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'SSL';
$mail->Host = $linha['url'];
$mail->Port = $linha['porta'];
$mail->Username = $linha['email'];
$mail->Password = $linha['senha'];
$mail->From = $linha['email'];
$mail->FromName = $linha['empresa'];
$mail->Subject = utf8_decode($linha['aviso']);

///// conta o tempo 
$t = $linha['limitemail'] / 60;
// zera o limite de tempo de execução do script
set_time_limit(0);
// eviar emails
$cont = 0;
$sqlss = mysql_query("SELECT *,date_format(data_venci, '%d/%m/%Y') AS data FROM faturas WHERE condmail = '1' AND id_cliente='$id_cliente' AND situacao='P'") or die(mysql_error());
$row = mysql_fetch_array($sqlss);
	$idfatura = $row['id_venda'];
	$idcliente = $row['id_cliente'];
	$emailcliente = $row['emailcli'];
	$nomecliente = $row['nome'];
	$valorfatura = $row['valor'];
	$datavenc = $row['data'];
	$num_doc = $row['num_doc'];
	$referente = $row['ref'];
	if($referente == ""){
		$referente = $select_cliente['obs'];	
	}

$dado = 'id_venda='.$idfatura;
$pagina = base64url_encode($dado);
$link = $endereco.'boleto/boleto.php?'.$pagina;

$dado = $html;
$search = array('[NomedoCliente]', '[valor]','[vencimento]','[numeroFatura]','[Descricaodafatura]','[link]'); // pega oa variaveis do html vindo do banco;
$replace = array($nomecliente, $valorfatura,$datavenc,$idfatura,$referente,$link); //  variavis que substiruem os valores
$subject = $dado;

$texto = str_replace($search, $replace, $subject);

$mail->Body = $texto;
$mail->AddAddress($emailcliente);

$mail->Send();

$mail->ClearAllRecipients();
$mail->ClearAttachments();

						
}// fin do envio de emails
} 
					
}// fecha while


?>