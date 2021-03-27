<?php

	namespace src\router;

	class Routes {
		
		public $route;
		public $pattern;
		public $callback;
		public $paramns = [];
		public $middlewares = [];

		public function setName(string $name) : void {
			$this->name = $name;
		}

		public function setRoute(string $route) : void {
			$this->route = $route;
		}

		public function setPattern(string $pattern) : void {
			$this->pattern = $pattern;
		}

		public function setCallback($callback) : void {
			$this->callback = $callback;
		}

		public function setParamns(array $paramns) : void {
			$this->paramns = $paramns;
		}

		public function setMiddlewares(array $middlewares) : void {
			$this->middlewares = $middlewares;
		}



	}

?>