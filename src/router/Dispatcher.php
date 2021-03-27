<?php

namespace src\router;

class Dispatcher {

	private $request;

	/*
	 * 
	 * Método construtor 
	 * 
	 */

	public function __construct() {
		$this->request =  new Request;
	}

	/*
	 * 
	 * Esse método compara a URL digitada no browser com o array de rotas
	 * Caso nenhuma rota case com a URL retorna null, do contrário, retorna a rota
	 * 
	 */

	public function dispatch(array $routes) : ?Routes {

		foreach ($routes as $route) {
			
			if (preg_match($route->pattern, $this->request->uri())) {

				return $route;
			}
		}

		return null;
	}

	/*
	*
	*  getParamsToRoutes cria um array com os parâmetros a serem passados para a rota				
	*
	*/

	private function getParamsToRoutes(array $reflectionParams,  Routes $route) : array  {
	
	  $objects = [];
	  $parametrosUrl = array_values($route->paramns);
	
	  foreach ($reflectionParams as $param) {
		   
		$parameter = $param->getClass();

		if($parameter){

			$objects[$param->name] = (new $parameter->name);

		} else {

			$objects[$param->name] = $parametrosUrl[0];
			
			array_shift($parametrosUrl);

		}

	  }
	  
	  return $objects;
	  
	}	
	
	/*
	*
	* splitCallback, retorna um array com os nomes da classe e do método
	*
	*/

	private function splitCallback(string $callback) : array	{

		$callback = preg_split('/@/', $callback);

		$controller = $callback[0];
		$method = $callback[1];

		return [$controller, $method];

	}

	/*
	*
	* Busca parâmetros do construtor
	*
	*/

	private function parametersConstructor($reflectionClass) {

		$constructor = $reflectionClass->getConstructor();

		$parameters = [];

		if ($constructor) {
			foreach ($constructor->getParameters() as $parameter) {
				$parameters[$parameter->name] = $this->typeParameters($parameter);
			}
		}

		return $parameters;

	}

	/*
	*
	* Retorna um array com os tipos (types) dos atributos do construtor
	*
	*/

	private function typeParameters($parameter)	{

		$type = $parameter->getType();

		if (!$type) {
			return $parameter->name;
		}

		$typesAllowed = [
			'string' => (string) $parameter->name,
			'int'    => (int) $parameter->name,
			'float'  => (float) $parameter->name,
			'bool'   => (bool) $parameter->name,
			'array'  => (array) $parameter->name
		];

		$class = $parameter->getClass();

		return $typesAllowed[$type->getName()] ?? new $class->name;

	}

	/*
	* 
	* Executa os Middlewares caso existam
	* 
	*/

	public function executeMiddlewares(array $middlewares) : void {

		if (count($middlewares) > 0) {

			$mdh = \src\middlewares\MiddlewaresHandler::class;

			$middlewaresHandler = new $mdh;

			$middlewaresHandler->execute($middlewares, $this->request);
		}


	}

	/*
	*
	* Ecução do método da classe
	*
	*/
	
	protected function executeMethod($controller, $method, $route) : ?\reflectionMethod {
		
		$reflectionClass = new \ReflectionClass($controller);

		//aqui efetivamente acessamos o construtor e instanciamos os objetos
		$instance = $reflectionClass->newInstanceArgs($this->parametersConstructor($reflectionClass));

		//acessamos a classe e buscamos pelo método escolhido
		$reflectionMethod = $reflectionClass->getMethod($method);

		//capturamos os parâmetros do método escolhido
		$reflectionParams = $reflectionMethod->getParameters();

		$objects = $this->getParamsToRoutes($reflectionParams, $route) ?? [];
		
		return $reflectionMethod->invokeArgs($instance, array_values($objects));

	}


	/*
	* 
	* Aqui se veifica o roteamente propriamente dito
	* 
	*/

	public function dispatcher(array $routes) {

		$route = $this->dispatch($routes);
		
		if ($route === null) {
			redirectToRoute(route("error.404"));
		}
		
		$this->executeMiddlewares($route->middlewares);

		// Verificamos se o callback da rota é uma function ou um conjunto ClasseWmetodo

		if (is_callable($route->callback)) {

			$objects = [];

			//Fazemos a Reflexão da function do callback				
			$reflectionFunc = new \ReflectionFunction($route->callback);

			// e pegamos seus parâmetros, caso existam	
			$reflectionParams = $reflectionFunc->getParameters();
			
			return $reflectionFunc->invokeArgs($this->getParamsToRoutes($reflectionParams, $route));

		}

		[$controller, $method] = $this->splitCallback($route->callback);

		if (!class_exists($controller)) {
			redirectToRoute(route("error.403"));
		}

		if (!method_exists($controller, $method)) {
			redirectToRoute(route("error.401"));
		}

		//executamos o método
		$this->executeMethod($controller, $method, $route);

	}

}