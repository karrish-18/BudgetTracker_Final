<?php
class Database {
    private $host = "sql201.infinityfree.com"; // Get from MySQL Databases tab
    private $db_name = "if0_41597488_budget";  // Must be the FULL name
    private $username = "if0_41597488";        
    private $password = "PASTE_THE_SHOW_HIDE_PASSWORD_HERE"; 
    public $conn;

    public function getConnection() {
        $this->conn = null;
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch(PDOException $e) {
            die("Connection Error: " . $e->getMessage());
        }
        return $this->conn;
    }
}
?>