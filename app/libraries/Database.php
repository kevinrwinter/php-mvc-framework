<?php
/*
 * PDO Database class
 * Connect to database
 * Create prepared statements
 * Bind values
 * Return rows and results
 */
class Database
{
    private $host    = DB_HOST;
    private $user    = DB_USER;
    private $pass    = DB_PASS;
    private $db_name = DB_NAME;

    private $db_handler;
    private $stmt;
    private $error;

    public function __construct()
    {
        // Set DSN (database source name)
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->db_name;

        // Set attribute options
        $options = array(
            // Persist connection to assist performance
            PDO::ATTR_PERSISTENT => true,
            // Handle errors (throw exceptions)
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        );

        // Create instance of PDO class with try-catch
        try {
            $this->db_handler = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            echo $this->error;
        }
    }

    // Prepare statement with query
    public function query($sql)
    {
        $this->stmt = $this->db_handler->prepare($sql);
    }

    // Bind values
    public function bind($param, $value, $type = null)
    {
        // Check type
        if (is_null($type)) {
            switch (true) {
                case is_int($value):
                    $type = PDO::PARAM_INT;
                    break;
                case is_bool($value):
                    $type = PDO::PARAM_BOOL;
                    break;
                case is_null($value):
                    $type = PDO::PARAM_NULL;
                    break;
                default:
                    $type = PDO::PARAM_STR;
                    break;
            }
        }

        $this->stmt->bindValue($param, $value, $type);
    }

    // Execute prepared statement
    public function execute()
    {
        return $this->stmt->execute();
    }

    // Get result set as array of objects
    public function resultSet()
    {
        $this->execute();
        return $this->stmt->fetchAll(PDO::FETCH_OBJ);
    }

    // Get single record as object
    public function single()
    {
        $this->execute();
        return $this->stmt->fetch(PDO::FETCH_OBJ);
    }

    // Get row count
    public function rowCount()
    {
        return $this->stmt->rowCount();
    }
}
