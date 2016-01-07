<?php
class Db
{
    private $_connection;
    private static $_instance; //The single instance
    private $_host = DB_HOST;
    private $_username = DB_USER;
    private $_password = DB_PASSWORD;
    private $_database = DB_DB;
    /*
    Get an instance of the Database
    @return Instance
    */
    public static function getInstance()
    {
        if (!self::$_instance) { // If no instance then make one
            self::$_instance = new self();
        }
        return self::$_instance;
    }
    // Constructor
    private function __construct()
    {
        try {
            $this->_connection  = new \PDO("mysql:host=$this->_host;dbname=$this->_database", $this->_username, $this->_password);
            /*** echo a message saying we have connected ***/
            echo 'Connected to database';
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
    // Magic method clone is empty to prevent duplication of connection
    private function __clone()
    {
    }
    // Get mysql pdo connection
    public function getConnection()
    {
        return $this->_connection;
    }
}
/**
 * And you can use it as such in a class
 * */

class Post {
    public function __construct(){
        $db = Db::getInstance();
        $this->_dbh = $db->getConnection();
    }
    public function getPosts()
    {
        try {
            /*** The SQL SELECT statement ***/
            $sql = "SELECT * FROM posts";
            foreach ($this->_dbh->query($sql) as $row) {
                var_dump($row);
            }
            /*** close the database connection ***/
            $this->_dbh = null;
        } catch (PDOException $e) {
            echo $e->getMessage();
        }
    }
}