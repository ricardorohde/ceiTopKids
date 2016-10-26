<?php

class RetornoBanco {

	public $retorno;

	public function RetornoBanco($retorno) {
	 	$this->retorno=$retorno;
	}

	public function processar() {
		$linhas = file($this->retorno->getNomeArquivo());  
		foreach($linhas as $numLn => $linha) {
		   $vlinha = $this->retorno->processarLinha($numLn, $linha);
			 $this->retorno->triggerAoProcessarLinha($this->retorno, $numLn, $vlinha);
		}
	}
}

?>
