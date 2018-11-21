<?php

class Router {

	function __construct() {

		// Montando URL
		$url = isset($_GET['url']) ? $_GET['url'] : null;
		$url = rtrim($url, '/');
		$url = explode('/', $url);

		//echo "<pre>"; print_r($url);
		// Caso não tenha url
		if (empty($url[0])) {
			require 'controllers/user.php';
			$controller = new User();
			$controller->loadModel('user');
			$controller->index();
			return false;
		}

		$file = 'controllers/' . $url[0] . '.php';
		if (file_exists($file)) {
			require $file;
		} else {
			require 'controllers/user.php';
		}
		
		$controller = new $url[0];
		$controller->loadModel($url[0]);

		// Chamando os metodos
		if (isset($url[2])) {
			if (method_exists($controller, $url[1])) {
				$controller->{$url[1]}($url[2]);
			} else {
				$this->error();
			}
		} else {
			if (isset($url[1])) {
				if (method_exists($controller, $url[1])) {
					$controller->{$url[1]}();
				} else {
					require 'controllers/user.php';
				}
			} else {
				$controller->index();
			}
		}
		
		
	}

}