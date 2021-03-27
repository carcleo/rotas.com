<?php

	namespace src\router;

	use \src\router\Request;
	
	class Router {
		
		private  $routesNamed = [];
		private  $routePattern;		
		private  $routesGet = [];
		private  $routesPost = [];
		private  $routesPut = [];
		private  $routesDelete = [];
		private  $groupStack  = [];
		private  $method;
		private  $uri;
		private  $namespaceControllers;
		
		/*
		*
		* Método construtor
		*
		*/
		
		public function __construct() {
			$request = new Request;
			$this->method = $request->method();
			$this->uri = $request->uri();
			$this->namespaceControllers = $request->namespaceControllers();
		}	
		
		/*
		*
		* hasGoupStack retorna se o o array de grupos está iu não vazio
		*
		*/

		private function hasGoupStack () : bool{
			return !empty($this->groupStack);
		}
		
		/*
		*
		* 
		*
		*/
		
		public function group (array $actributes,  \Closure $callback) : void {		
			
			if ($this->hasGoupStack()) {
				
				if ( isset ( $this->groupStack["namespace"] ) ) {

					$this->groupStack["namespace"] = isset ( $actributes["namespace"] )
														  ? isset ( $actributes["namespace"] )
														  : $this->groupStack["namespace"];
					
				}
				
				if ( isset ( $this->groupStack["middlewares"] ) ) {
					
					if ( isset ( $actributes["middlewares"] ) ) {
					
						$this->groupStack["middlewares"] = array_merge( $this->groupStack["middlewares"],$actributes["middlewares"]);
						
					} 
					
				}
				
			} else {	
			
				$this->groupStack = $actributes;
				
			}		
			
			$callback();
			
			array_pop($this->groupStack);
			
		}	

		
		/*
		 * 
		 * pattern cria o padrão em REGEX para as rotas com resultado sendo uma string
		 * 
		 */

		private function pattern(string $route): string {

			$pattern = explode('/', $route);
			$pattern = array_filter($pattern);
			$pattern = implode('/', $pattern);
			$pattern = str_replace('/', '\/', $pattern);
			$pattern = '/^\/' . $pattern . '$/';

			if (preg_match("/\{[A-Za-z0-9\_\-]{1,}\}/", $pattern)) {
				$pattern = preg_replace("/\{[A-Za-z0-9\_\-]{1,}\}/", "[A-Za-z0-9-_]{1,}", $pattern);
			}

			return $pattern;
			
		}
		
		/*
		 *  
		 * getParams entrega um array de Parametros do callback
		 * 
		 */

		public function getParamns(?array $metaTagPos): array {

			$result = [];

			$uri = array_filter(explode('/', $this->uri));

			if (count($uri) > 0) {

				foreach ($uri as $key => $value) {

					if ($metaTagPos !== null) {
						
						if (in_array($key, $metaTagPos)) {

							$result[array_search($key, $metaTagPos)] = $value;

						}

					}

				}

			}

			return $result;

		}

		/*
		 * 
		 * strposArray traz a posição que se encontra a tag procurada na rota ($haystack) como um número inteiro ou
		 * caso contrário, retorna null
		 * 
		 */

		private function strposArray(string $haystack, array $needles, int $offset = 0): ?int {

			$result = false;

			if (strlen($haystack) > 0 && count($needles) > 0) {

				foreach ($needles as $element) {

					$result = strpos($haystack, $element, $offset);

					$result = $result !== false ?? null;

					if ($result !== null) {
						break;
					}
					
				}
				
			}
			
			return $result;
			
		}

		/*
		 * 
		 * pesquisa na rota se existe algum caracter especial que possa configurar um parâmeto na url 
		 * se encontrar, traz um array com os parametros encontrados na rota
		 * senão, retorna null
		 * 
		 */

		public function getMetaTags($route): ?array {

			$result = [];

			$needles = ['{', '[', '(', "\\"];

			$route = array_filter(explode('/', $route));

			foreach ($route as $key => $element) {

				$found = $this->strposArray($element, $needles);
				
				if ($found !==false) {

					$firstLether = substr($element, 0, 1);
					
					if ( $firstLether === '{') {

						$result[preg_filter('/([\{\}])/', '', $element)] = $key;
						
					} else {

						if ( $firstLether === '[') {

							$index = 'value_' . (!empty($result) ? count($result) + 1 : 1);
							
							$result = array_merge($result, [$index => $key]);

						}

					}

				}

			}

			return count($result) > 0 ? $result : null;

		}

		/*
		* Adicionando um nome à rota
		*/
		
		public function name($name) : void {						
			$this->routesNamed = array_merge([$name => $this->routePattern ], $this->routesNamed);
		}	

		/*
		* Encontrando a rota nomeada
		*/

		public function getRouteByNamed($name, array $parameters = NULL) : ?string {
			
			$needles = ['{', '[', '(', "\\"];				

			$route = array_filter(array_values(explode('/', $this->routesNamed[$name])));
			
			foreach ($route as $key => $element) {

				$found = $this->strposArray($element, $needles);
				
				if ($found !==false) {

					$firstLether = substr($element, 0, 1);
					
					if ( $firstLether === '{') {
						
						$route[$key] = $parameters[0];
						array_shift($parameters);
						
					} else {

						if ( $firstLether === '[') {
							
							$route[$key] = $parameters[0];
						    array_shift($parameters); 

						}

					}

				}

			}
	
			return '/' . implode('/', $route); 

		}

		/*
		* Encontrando as rotas nomeadas
		*/

		public function getRoutesNamed() : array {
			return $this->routesNamed;
		}

		/*
		*
		* returnMethod retorna um array com os dados da Rota
		*
		*/	
	  
		private function returnMethod (string $route, $callback) {		
			
			if ($this->hasGoupStack()) {
								
				$namespace = $this->namespaceControllers . ($this->groupStack["namespace"] ?? "") ;
				
				$middlewares = $this->groupStack["middlewares"] ?? [];		
				
			}

			// aqui eu pego a rota
			$this->routePattern = $route;

			$routes = new Routes();
			$routes->setRoute($route);
			$routes->setPattern($this->pattern($route));
			$routes->setCallback(
				is_callable($callback)
					? $callback
					: ($namespace ?? $this->namespaceControllers) . $callback 
			);
			$routes->setParamns($this->getParamns($this->getMetaTags($route)));
			$routes->setMiddlewares($middlewares ?? []);
			
			return $routes;
			
		}			
		
		
		/*
		 * 
		 * routesGet popula o array de rotasGet
		 * 
		 */
		public function routesGet (string $route, $callback) {
			$this->routesGet[] = $this->returnMethod ($route, $callback);
		}		
		
		/*
		 * 
		 * routesPost popula o array de rotasPost
		 * 
		 */
		public function routesPost (string $route, $callback) {
			$this->routesPost[] = $this->returnMethod ($route, $callback);
		}		
		
		/*
		 * 
		 * routesPut popula o array de rotasPut
		 * 
		 */
		public function routesPut (string $route, $callback) {
			$this->routesPut[] = $this->returnMethod ($route, $callback);
		}	

		/*
		 * 
		 * routesDelete popula o array de rotasDelete
		 * 
		 */	
		public function routesDelete (string $route, $callback) {
			$this->routesDelete[] = $this->returnMethod ($route, $callback);
		}

		/*
		 * 
		 * getRoutes obtem a lista de rotas
		 * 
		 */	
		
		public function getRoutes () : ?array {
			
			switch ($this->method) {
				case "GET":
					return $this->routesGet;
					break;
				case "POST":
					$method = filter_input(INPUT_POST,"method", FILTER_SANITIZE_STRIPPED);
					if ($method === "PUT") {
						return $this->routesPut;
					} else if ($method === "DELETE") {
						return $this->routesDelete;
					} else {
						return $this->routesPost;
					}
					break;
			}	
			
		}	

		public function dispatcher () {
			$dispatcher = new Dispatcher();
			return $dispatcher->dispatcher($this->getRoutes());
		}
		
		
	}


?>