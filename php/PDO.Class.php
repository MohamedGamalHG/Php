<?php




class PDO_Connect implements PDO_Intserface{
    
    // This Property Especially To Deal With The Database Connection 
    
    private $dbhost , $dbuser , $dbpass , $dbname , $charset , $connection , $stmt , $error , $options;
    
    public function __construct() {
        
        //Sets an attribute on the database handle. 
        
        $this->options = [
            PDO::ATTR_EMULATE_PREPARES          => FALSE,
            PDO::ATTR_ERRMODE                   => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_PERSISTENT                => TRUE,
            PDO::ATTR_DEFAULT_FETCH_MODE        => PDO::FETCH_ASSOC,
            PDO::MYSQL_ATTR_USE_BUFFERED_QUERY  => TRUE
        ];

        // Set Property Value
        
        $this->dbhost   =  'localhost';   //DB_HOST;
        $this->dbuser   =    'root';             //DB_USER;
        $this->dbpass   =     '';          //DB_PASS;
        $this->dbname   =    'shop';       //DB_NAME;
        $this->charset  =     'UTF-8';          // CHARSET;
        
        // Connect To Database 
        try {
            $this->connection = 
                    new PDO(
                    "mysql:host={$this->dbhost};dbname={$this->dbname};charset={$this->charset}",
                    $this->dbuser,
                    $this->dbpass,
                    $this->options
                    );
                    
        } catch (PDOException $error) {
            $this->error = $error->getMessage();
            die($this->error);
        }
        
    }
    
    /*
     * Bind Values
     * Passing arguments To execute Frowned Upon For Any Type
     */
    
    public function bind($params = []){
        foreach ($params as $key => $value) {

            if (is_string($value))
                $type = PDO::PARAM_STR;
            elseif (is_int($value))
                $type = PDO::PARAM_INT;
            elseif (is_bool($value))
                $type = PDO::PARAM_BOOL;
            else
                $type = PDO::PARAM_NULL;
            
            $this->stmt->bindValue(':'.$key , $value , $type);
        }
        return $this;
    }
    
    /*
     * Query Model
     * Executes An Select SQL Statement
     * 
     * :: Additional Notes ::
     * 
     * Arguments $other Use it If Query Not Finished Yet As your use (WHERE , LIKE ..Etc)
     */
    
    public function query($colum , $table , $other = null){
        $this->stmt = $this->connection->prepare("SELECT $colum FROM `$table` $other");
        return $this;
    }
    
    /*
     * Insert Model
     * Executes An Insert SQL Statement
     */
    
    public function insert($table , $colums , $values){
        $this->stmt = $this->connection->prepare("INSERT INTO `$table` ($colums) VALUES ($values)");
        return $this;
    }
    
    /*
     * Update Model
     * Executes An Update SQL Statement
     */
    
    public function update($table , $values ,$colum, $value){
        $this->stmt = $this->connection->prepare("UPDATE `$table` SET $values WHERE `$colum` = $value");
        return $this;
    }
    
    /*
     * Delete Model
     * Executes An Insert SQL Statement
     */
    
    public function delete($table , $colum , $value){
        $this->stmt = $this->connection->prepare("DELETE FROM `$table` WHERE `$colum` = $value");
        return $this;
    }
    
    /*
     * Execute
     * Responsible For execution Any Model 
     */
    
    public function execute(){
        $this->stmt->execute();
        return $this;
    }
    
    /*
     * Row Count
     * To Get Row Count From Database Table
     */
    
    public function rowCount(){
        return $this->stmt->rowCount();
    }
    
    /*
     * Last Insert Id
     * To Get Last Insert Id After Use Insert Model
     */
    
    public function lastInsertId(){
        return $this->connection->lastInsertId();
    }
    
    /*
     * Fetch
     * You Can Use it To get One Row With Single Query
     */
    
    public function fetch(){
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    /*
     * Fetch All
     * You Can Use it To get All Rows As an array
     */
    
    public function fetchAll(){
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
  
    /*
     * Close Databse Connect
     * Use It When you Want Close Connection
     */
  
    public function close(){
        $this->connection = NULL;
    }
  
}

?>
