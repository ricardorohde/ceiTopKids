<?php
include "conexao.php";
class recordset{

// ************** SELECIONAR DADOS **************************
function seleciona($sql){
	$result = mysql_query($sql)or die(mysql_error());
	return $result;		
}

//***************** INSERIR DADOS ****************************
function inserir($tabela, $dados){
	// PEGAR CAMPOS DA ARRAY
	$arrCampo = array_keys($dados);
	//PEGAR VALORES DA ARRAY
	$arrValores = array_values($dados);
	// CONTAR CAMPOS DA ARRAY
	$numCampo = count($arrCampo);
	// CONTAR OS VALORES DA ARRAY
	$numValores = count($arrValores);
	// VALIDAÇÃO
	if($numCampo == $numValores){ // if insert
		$SQL = "INSERT INTO	".$tabela." (";
		foreach($arrCampo as $campo){
			$SQL .= "$campo, ";	
		}
		$SQL = substr_replace($SQL, ")", -2, 1);
		$SQL .="VALUES (";
			foreach($arrValores as $valores){
			$SQL .= "'".$valores."', ";	
			}
		$SQL = substr_replace($SQL, ")", -2, 1);
	}else{
		echo 'Erro ao checar valores';
	}
	$this->seleciona($SQL);		
}// fim da function inserir

// ******************* ALTERAR DADOS ***************************
function alterar($tabela, $dados, $string){
	// PEGAR CAMPOS DA ARRAY
	$arrCampo = array_keys($dados);
	//PEGAR VALORES DA ARRAY
	$arrValores = array_values($dados);
	// CONTAR CAMPOS DA ARRAY
	$numCampo = count($arrCampo);
	// CONTAR OS VALORES DA ARRAY
	$numValores = count($arrValores);
	// CONSTRUÇÃO DA SCRTING
	if($numCampo == $numValores && $numValores > 0){ // if alterar
		$SQL = "UPDATE ".$tabela." SET ";
		for($i = 0; $i < $numCampo; $i++){
			$SQL .= $arrCampo[$i]." = '".$arrValores[$i]."',";
		}
		$SQL = substr_replace($SQL, " ", -1, 1);
		$SQL .= "WHERE $string";
	}else{
		echo 'Erro ao checar o update';	
	}// fim da if alterar
	$this->seleciona($SQL);
}// FIM DA FUNCTION ALTERAR
	
}// FIM DA CLASSE

?>