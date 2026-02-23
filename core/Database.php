<?php 

namespace Core;

class Database {
    private $DB_HOST;
    private $DB_NAME;
    private $DB_USER;
    private $DB_PASS;

    /** @var array<string,string> */
    private array $typeMap = [
        'int' => 'INT',
        'string' => 'VARCHAR',
        'text' => 'TEXT',
        'bool' => 'TINYINT',
        'float' => 'FLOAT',
    ];

    private \PDO $pdo;

    public function __construct()
    {
        $this->DB_HOST = ENV['DB_HOST'];
        $this->DB_NAME = ENV['DB_NAME'];
        $this->DB_USER = ENV['DB_USER'];
        $this->DB_PASS = ENV['DB_PASS'];

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


    /**
     * creates new SQL table if there are not more with same tablename
     * @param string $tablename name of table
     * @param array<array{0: string, 1: string, 2?: int}> columns of table
     */
    public function create(string $tablename, array $columns)
    {
        // $array = [
        //     [
        //         "column1", 
        //         "int", 
        //         "1", 
        //     ],
        //     [
        //         "column2", 
        //         "string", 
        //         "12", 
        //     ],
        //     [
        //         "column3", 
        //         "bool"
        //     ]
        // ];

        if(!is_array($columns[0])) {
            $columns = [$columns];
        }

        $columns = $this->normalizeColumnsToSQL($columns);
    }


    /**
     * @param array $columns : columns for table
     * @return string normalized $columns
     * @throws \Error if @var $typeMap doesnt have this type
     */
    private function normalizeColumnsToSQL(array $columns): string
    {
        $normalized = implode(', ', (array_map(function ($item) {
            $typeMap = $this->typeMap;

            if(isset($typeMap[$item[1]])) {
                $item[1] = ' ' . $typeMap[$item[1]];
            } else {
                throw new \Error('Not supported type');
            }
            if(isset($item[2])) $item[2] = "({$item[2]})";
            return implode('', $item);
        }, $columns)));

        return $normalized;
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