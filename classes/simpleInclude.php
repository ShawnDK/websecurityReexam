<?php
class simpleInclude {

	var $includeUrl;

	function __invoke($type,$name){
		switch ($type){
			case 'page':
				$this->includeUrl = 'pages/'.$name.'.php';
				break;
			
			case 'class':
				$this->includeUrl = 'classes/'.$name.'.php';
				break;
			
			case 'template':
				$this->includeUrl = 'templates/'.$name.'.php';
				break;
			
			default:
				$this->includeUrl = 'errorPages/somethingWrong.php';
				break;
		}
		include $this->includeUrl;
	}
}
?>