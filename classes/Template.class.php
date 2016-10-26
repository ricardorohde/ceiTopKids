<?php 
	class Template{
		private $dados = array();
		private $arquivo;
		private $pasta;
		
		function __construct($arquivo = ''){
			//$this->setPasta($pasta);
			$this->setArquivo($arquivo);
				
		}
	
		public function setDados($campo, $valor){
			$this->dados[$campo] = $valor;	
		}
		public function getDados(){
			return $this->dados;	
		}
		public function setArquivo($arquivo){
			$this->arquivo = $arquivo;
		}
		public function getArquivo(){
			return $this->arquivo;	
		}
		public function setPasta($pasta){
			$this->pasta = $pasta;	
		}
		public function getPasta(){
			return $this->pasta;	
		}
		
		protected function carregarArquivo(){
			if(file_exists($this->getArquivo())){
				$arquivo = file_get_contents($this->getArquivo());
			}else{
				throw new Exception('Erro ao carregar o arquivo: '.$this->getArquivo());	
			}
			return $arquivo;
		}
		
		public function publicar(){
				try{
					$arquivo = $this->carregarArquivo();
					foreach($this->getDados() as $k => $v){
						$troca = '[$'.$k.']';
						$arquivo = str_replace($troca,$v,$arquivo);	
					}
					echo $arquivo;
				}catch(Exception $erro){
					echo $erro->getMessage();
					
				}
		}
		
		
	}


?>