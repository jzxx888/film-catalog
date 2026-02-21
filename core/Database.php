<?php 

namespace Core;

class Database {
    private $DB_HOST;
    private $DB_NAME;
    private $DB_USER;
    private $DB_PASS;

    private \PDO $pdo;

    public function __construct()
    {
        $this->DB_HOST = 'localhost';
        $this->DB_NAME = 'jz_films';
        $this->DB_USER = 'root';
        $this->DB_PASS = 'root';

        try {
            $this->pdo = new \PDO("mysql:host=$this->DB_HOST;dbname=$this->DB_NAME;charset=utf8", $this->DB_USER, $this->DB_PASS);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        } catch (\PDOException $e) {
            die("Failed to connect to database: " . $e->getMessage());
        }
    }

    public function getConnectionPDO(): \PDO
    {
        return $this->pdo;
    }

    public function create($tablename)
    {
        
    }

    private function tableExists($tablename): bool
    {
        $query = $this->pdo->prepare("SHOW TABLES LIKE ?");
        $query->execute();
        $isTableExists = $query->fetchAll();
        return !empty($isTableExists);
    }
}

// create table (tablename, [columnname, type])
// change table (tablename, columnname, type)