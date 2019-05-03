<?php

class Router {
	
	private $route;
	
	public function __construct(){
		$this->route = $_SERVER['REQUEST_URI'];
	}
	
	public function getId(){

	//Удалим слеш слева -> /запрос/запрос
	$result = ltrim($this->route, '/');

	//Разбить строку по слешу -> запрос/запрос
	$string = explode('/', $result);

	//Получить второй элемент в массиве -> id
	$id = $string['1'];
	
	return $id;
	}
	
	
	public function Routes(){

	//Получить id
	$id = $this->getId();

	$routes = [
		"/" => 'index.view.php',
		"/about" => 'about.php',
		"/create" => 'create.php',
		"/store" => 'store.php',
		"/show/$id" => 'show.php',
		"/edit/$id" => 'edit.php',
		"/update/$id" => 'update.php',
		"/delete/$id" => 'delete.php',
		"/404" => '404.php',
	];


	if(array_key_exists($this->route, $routes)){
		include '../' . $routes[$this->route];exit;
	}else{
		include '../404.php';
	}	
	
	}
}


?>