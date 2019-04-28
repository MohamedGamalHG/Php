<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of DbConnection
 *
 * @author Wael
 */
class DbConnection {
    //put your code here
    private $host="localhost";
    private $username="root";
    private $password="";
    private static $instance;// single database object i will explain it next section 
    private $db_name="shop";//your database name 
    private  $database_connection; // 
    public function __construct() {
      $this->database_connection = $this->database_connect($this->host, $this->username,
      $this->password);
      $this->database_select($this->db_name);
      
    }
    public static function getInstance(){// create only one object for databse 
        if(!self::$instance){
            self::$instance= new  self();
        }
        return self::$instance;
    }
    /**
     * Connect to database
     *
     * @param string $database_host
     * @param string $database_username
     * @param string $database_password
     * @return mysql_connection link
     */
    private function database_connect($database_host, $database_username, $database_password) {
        if ($c = mysql_connect($database_host, $database_username, $database_password)) {
            return $c;
            
        } else {
            
              
                die("Database connection error");
            
        }
    }
        /**
     * select a db
     *
     * @param string $database_name
     * @return mysql link
     */
    private function database_select($database_name) {
        return mysql_select_db($database_name, $this->database_connection)
            or die("no db is selecteted");
    }
        /**
     * Close db connection
     *
     */
    public   function database_close() {
        if(!mysql_close($this->database_connection))die ("Connection close failed.");
           
    }
     function clean($str) {
		$str = trim($str); // remove 
                /*Magic Quotes, generally speaking, is the process of escaping special characters with a '\' to allow a string to be entered into a database. This is considered 'magic' because PHP can do this automatically for you if you have magic_quotes_gpc turned on.

More specifically if magic_quotes_gpc is turned on for the copy of PHP you are using all Get, Post & Cookie variables (gpc, get it?) in PHP will already have special characters like ", ' and \ escaped so it is safe to put them directly into an SQL query.*/
		
                if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return mysql_real_escape_string($str);
	}
    /**
     * Make query to the database
     *
     * @param string $database_query
     * @return sqlresult
     */
 public function database_query($database_query) {
        
        $query_result = mysql_query($database_query);
        return $query_result;
    }
        /**
     * Executes query and returns query result (row, array)
     *
     * @param string $query   SQL query text
     *         
     * @access public
     * @return associated array
     */
    public function get_row($query) {
        if (!strstr(strtoupper($query), "LIMIT"))
            $query .= " LIMIT 0,1";
        if (!($res =$this->database_query($query))) {
         die( "Database error: " . mysql_error() . "<br/>In query: " . $query);
        }
        return mysql_fetch_assoc($res);
    }
        /**
     * Executes query result (table, array of array)
     *
     * @param string database_result
 
     * @access public
     * @return array of rows 
     */
    public function database_all_array($database_result) {
        $array_return=array();
        while ($row = mysql_fetch_array($database_result)) {
            $array_return[] = $row;
        }
//        if(count($array_return)>0)
        return $array_return;


    }
            /**
     * Executes query result (table, array of array)
     *
     * @param string database_result
 
     * @access public
     * @return associated array of rows 
     */
   public function database_all_assoc($database_result) {

        while ($row = mysql_fetch_assoc($database_result)) {
            $array_return[] = $row;
        }
        return $array_return;
    }
        /**
     * Returns number of rows in the result
     *
     * @param mixed $database_result
     * @return integer
     */
      public   function database_affected_rows($database_result) {

        return mysql_affected_rows($database_result);
    }
    
    /**
     * Returns number of rows in the result
     *
     * @param mixed $database_result
     * @return integer
     */
     public   function database_num_rows($database_result) {

        return mysql_num_rows($database_result);
    }
    
#-#############################################
# desc: does an update query with an array
# param: table, assoc array with data (not escaped), where condition (optional. if none given, all records updated)
# returns: (query_id) for fetching results etc
public function update($table, $data, $where='1'){
    $q="UPDATE `$table` SET ";

    foreach($data as $key=>$val){
        if(strtolower($val)=='null') $q.= "`$key` = NULL, ";
        elseif(strtolower($val)=='now()') $q.= "`$key` = NOW(), ";
        elseif(preg_match("/^increment\((\-?\d+)\)$/i",$val,$m)) $q.= "`$key` = `$key` + $m[1], "; 
        else $q.= "`$key`='".$this->escape($val)."', ";
    }

    $q = rtrim($q, ', ') . ' WHERE '.$where.';';

    return $this->query($q);
}#-#update()


#-#############################################
# desc: does an insert query with an array
# param: table, assoc array with data (not escaped)
# returns: id of inserted record, false if error
public function insert($table, $data){
    $q="INSERT INTO `$table` ";
    $v=''; $n='';

    foreach($data as $key=>$val){
        $n.="`$key`, ";
        if(strtolower($val)=='null') $v.="NULL, ";
        elseif(strtolower($val)=='now()') $v.="NOW(), ";
        else $v.= "'".$this->escape($val)."', ";
    }

    $q .= "(". rtrim($n, ', ') .") VALUES (". rtrim($v, ', ') .");";

    if($this->query($q)){
        return mysql_insert_id($this->link_id);
    }
    else return false;

}#-#insert() +
    
}