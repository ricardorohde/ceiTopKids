<?php
require_once("RetornoCNAB400Base.php");

class RetornoCNAB400Bradesco extends RetornoCNAB400Base {

	const DETALHE = 1;

  public function __construct($nomeArquivo=NULL, $aoProcessarLinhaFunctionName=""){
       parent::__construct($nomeArquivo, $aoProcessarLinhaFunctionName);
  }
  protected function processarHeaderArquivo($linha) {
		
    $vlinha = array();	 

		return $vlinha;
	}

	protected function processarDetalhe($linha) {
		$vlinha = array();
		$vlinha["nosso_numero"]        = substr($linha,  71,   12); //Identificação do Título no Banco
		$vlinha["vencimento"]     = $this->formataData(substr($linha, 147,   6));  //9  Data de vencimento (DDMMAA) 
		$vlinha["valor"]=$this->formataNumero(substr($linha, 153,  13)); //9  v99 Valor do título
		$vlinha["banco_receb"]           = substr($linha, 166,   3);  //9  Código do banco recebedor 
		$vlinha["ag_receb"]             = substr($linha, 169,   5);  //9  Código da agência recebedora 
		$vlinha["valor_tarifa"] = "0";
		$vlinha["dv_receb"] 			= "";

		$vlinha["juros_atraso"]        = $this->formataNumero(substr($linha, 202,  13)); //9  v99 Juros atraso
		$vlinha["desconto_concedido"]  = $this->formataNumero(substr($linha, 241,  13)); //9  v99 Desconto concedido 
		$vlinha["valor_recebido"]      = $this->formataNumero(substr($linha, 254,  13)); //9  v99 Valor pago
		$vlinha["juros_mora"]          = $this->formataNumero(substr($linha, 267,  13)); //9  v99 Juros de mor
		$vlinha["sequencial"]          = substr($linha, 395,   6); //9 Seqüencial do registro

		return $vlinha;
	}
	
	protected function processarTrailerArquivo($linha) {
	
		$vlinha = array();
					
		return $vlinha;
	}	

	public function processarLinha($numLn, $linha) {
			$tamLinha = 400; //total de caracteres das linhas do arquivo
			//o +2 é utilizado para contar o \r\n no final da linha
			if(strlen($linha)!=$tamLinha and strlen($linha)!=$tamLinha+2)
					die("A linha $numLn não tem $tamLinha posições. Possui " . strlen($linha));
			if(trim($linha)=="")
					die("A linha $numLn está vazia.");

      //é adicionado um espaço vazio no início_linha para que
			//possamos trabalhar com índices iniciando_1, no lugar_zero,
			//e assim, ter os valores_posição_campos exatamente
			//como no manual CNAB400
			$linha = " $linha";
      $tipoLn = substr($linha,  1,  1);
		  if($tipoLn == $this::HEADER_ARQUIVO) 
         $vlinha = $this->processarHeaderArquivo($linha);
      else if($tipoLn == $this::DETALHE)
				 $vlinha = $this->processarDetalhe($linha);
		  else if($tipoLn == $this::TRAILER_ARQUIVO)
			   $vlinha = $this->processarTrailerArquivo($linha); 
			else $vlinha = NULL;
			return $vlinha;
  }
}

?>
