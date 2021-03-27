<?php

    namespace mvc\models;

    use  src\database\Database;
    use  src\support\PdoDebugger;

    class Model {

        protected  $pdo;

        /*mérodo construtor */

        public function __construct() {
            $this->pdo = Database::abreConexao();
            $this->pdoDebugger = new PdoDebugger();
        }
        
        /* esse método lista todos os registros de uma tabela sem filteo  */

        public function selectAll () : ?array   {

            $sql = 'SELECT * FROM ' . $this->table;
                   
			$find =  $this->pdo->prepare ($sql);
			
		    $find->execute();
            
            return  $find->rowCount() === 0
                           ? NULL
                           : $find->fetchAll(\PDO::FETCH_ASSOC);

        }

        /* esae m´wétodo lista o primeiro regustro retornado de todos registros de uma tabela sem filteo  */

        public function selectFirstInAll () : ?array  {

            $selectFirst = $this->selectAll();

            return is_null($selectFirst) ? NULL : $selectFirst[0];

        }

        /* esse méodo encontra um registro na base de dados pelo ID  */

        public function find (int $id) : ?array   {
            
            $sql = 'SELECT * FROM ' . $this->table . ' WHERE id = :id';   
            
			$find =  $this->pdo->prepare ($sql);
			$find->bindValue(":id", $id);
            $find->execute();
            
            return  $find->rowCount() === 0
                           ? NULL
                           : $find->fetch(\PDO::FETCH_ASSOC);

        }

        /* esse méodo grava na base de dados um regitsro */

        public function store(array $data) : bool { 
            
            $campos = "";    
            
            foreach ($data as $key => $value) { 
                if ($key !== "crypt") {
                    $campos .= $key . "=:" . $key . ","; 
                }
            } 
            
            $campos = rtrim($campos, ',');

            $sql = "INSERT INTO " . $this->table . " SET " . $campos; 
            
            $insere = $this->pdo->prepare($sql);
            
            foreach ($data as $key => $value) { 
                if ($key !== "crypt") {
                   // echo "Key: " . $key . "<br>";
                   // echo "value: " . $value . "<p>";
                     $insere->bindValue(":" . $key, $value); 
                }
            } 
            
            return $insere->execute();
            
        }        
        
		/* Esse método retorna o ultimo id registrado gravado na tabela */
		
		public function lastInsertId () : int { return $this->pdo->lastInsertId (); }
		
		/* Esse método atualiza um registro baseado em um objeto da classe */
        public function update (array $data, int $id) {

            $campos = "";   
            
            foreach ($data as $key => $value) { 
                if ($key !== "crypt") {
                    $campos .= $key . "=:" . $key . ","; 
                }
            } 
            
            $campos = rtrim($campos, ',');

            $sql = "UPDATE " . $this->table . " SET " . $campos . " WHERE id = :id"; 
            
            $update = $this->pdo->prepare($sql);

            foreach ($data as $key => $value) { 
                if ($key !== "crypt") {
                     $update->bindValue(":" . $key, $value); 
                }
            } 

            $update->bindValue(':id', $id, \PDO::PARAM_INT);            
            
            return $update->execute();

        }
		
		/* Esse método exclui um registros com um determinado id */
		
		public function delete (int $id) : bool{
			
            $sql = "DELETE FROM " . $this->table . " WHERE id = :id";
            
            $delete = $this->pdo->prepare ($sql);

            $delete->bindValue(':id', $id, \PDO::PARAM_INT);
			
			return $delete->execute();
			
		}
		
		/* Esse método exclui um registros com um determinado id */
		
		public function bloq (int $id, string $condition) : bool{
			
            $sql = "UPDATE " . $this->table . " SET bloq = :condition  WHERE id = :id";
            
            $update = $this->pdo->prepare ($sql);

            $update->bindValue(':condition', $condition);

            $update->bindValue(':id', $id, \PDO::PARAM_INT);
			
            return $update->execute();
            
		}

    }