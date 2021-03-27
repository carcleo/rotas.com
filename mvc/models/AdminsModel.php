<?php 

	namespace mvc\models;
	
    use src\support\Session;
 
	class AdminsModel extends Model {

		 protected $table = "admins";
		 
		 private $id;
		 private $privilege;
		 private $name;
		 private $login;
		 private $password;
		 private $bloq;

		 ///////////////SETTERS///////////////		 
		 public function setId (int $id) :void {
			 $this->id = $id;
		 }
		 
		 public function setPrivilege (string $privilege)  :void  {
			 $this->privilege = $privilege;
		 }
		 
		 public function setName (string $name)  :void  {
			 $this->name = $name;
		 }
		 
		 public function setLogin (string $login)  :void  {
			 $this->login = $login;
		 }
		 
		 public function setPassword (string $password)  :void  {
			 $this->password = $password;
		 }
		 
		 public function setBloq (string $bloq)  :void  {
			 $this->bloq = $bloq;
		 }

		 ///////////////GETTERS///////////////		 
		 public function getId () :int {
			 return $this->id;
		 }
		 
		 public function getPrivilege () :string{
			 return $this->privilege;
		 }
		 
		 public function getName () :string {
			 return $this->name;
		 }
		 
		 public function getLogin () :string {
			 return $this->login;
		 }
		 
		 public function getPassword () :string {
			 return $this->password;
		 }
		 
		 public function getBloq () :string {
			 return $this->bloq;
		 }

		 ///////////////METHODS///////////////

        /*Verifica se o admin esta logado */
        public function loginAdmin() :bool {
            return Session::has("loginAdmin");
		}
		
		public function findAdmin(string $name) :bool {

            $sql = 'SELECT id FROM ' . $this->table . ' WHERE name = :name';
                   
			$find =  $this->pdo->prepare ($sql);

			$find->bindValue(":name", $name);
			
		    $find->execute();
            
            return  $find->rowCount() === 0
                           ? false
                           : true;

		}
		
		public function findLogin(string $login) :bool {

            $sql = 'SELECT id FROM ' . $this->table . ' WHERE login = :login';
                   
			$find =  $this->pdo->prepare ($sql);

			$find->bindValue(":login", $login);
			
		    $find->execute();
            
            return  $find->rowCount() === 0
                           ? false
                           : true;

		}

		public function findAdminLogin(string $login, string $password) : ?array{

            $sql = 'SELECT * FROM ' . $this->table . ' WHERE login = :login AND password = :password';
                   
			$find =  $this->pdo->prepare ($sql);

			$find->bindValue(":login", $login);

			$find->bindValue(":password", $password);
			
		    $find->execute();
            
            return  $find->rowCount() === 0
                           ? NULL
                           : $find->fetch(\PDO::FETCH_ASSOC);


		}

		 
	 }
?>