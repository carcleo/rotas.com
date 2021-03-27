<?php

	namespace src\database;

	use PDO;
	
    /*Classe Database*/

	class Database {
		
		private static $conn;	
		
		private function __construct (){}

		private static function obtemConexao() {

			$db = env_database();			

			if ( !isset( self::$conn ) ) {

				try {
							
					if (self::$conn == null) {

						self::$conn = new PDO($db['dsn'], $db['username'], $db['password'], $db['options']);
						self::$conn->setAttribute(PDO::ATTR_ERRMODE, $db['errmode']);
						self::$conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, $db['fetch_mode']);
						
					}	

				} catch ( \PDOException $e ) {

					throw new \PDOException( "Reveja suas credênciais de conexão ao banco de dados!\nContate o administrador!" );

					return;

				}
				
			}
			
			return self::$conn;

		}

		public static function abreConexao () { return self::obtemConexao(); }

	}

?>