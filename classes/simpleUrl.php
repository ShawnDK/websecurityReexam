<?php
class simpleUrl {
	var $cleanUri;
	var $exploaded = array();

	function __construct(){
		$this->cleanUri = strtoupper($this->removeTrailingSlash($_SERVER['REQUEST_URI']));
		$this->exploaded = explode('/',$this->cleanUri);
	}

	function __invoke(){
		return $this->exploaded;
	}

	private function removeTrailingSlash($string){

		if($_SERVER['REQUEST_URI']==='/'){
			return $_SERVER['REQUEST_URI'];
		}else{
			if($string[strlen($string)-1] == '/'){
				$string = rtrim($string, '/');
			}
			if($string[0] == '/'){
				$string = ltrim($string, '/');
			}
			return $string;
		}

	}
}
?>