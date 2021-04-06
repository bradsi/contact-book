<?php
namespace Bradsi\Models;

use PDO;

class DbConnectionManager {
    private $host;
    private $user;
    private $pass;
    private $db;

    public function __construct() {
        // Path is relative to where the constructor is called. Example:
        // For auth, path needs to be '../config.ini'
        // For tests, path needs to be 'config.ini'

        // Comment out the below if running app
        // $ini = parse_ini_file('config.ini');

        // Comment out the below if running tests
        $ini = parse_ini_file('../config.ini');

        $this->host = $ini['db_host'];
        $this->user = $ini['db_user'];
        $this->pass = $ini['db_pass'];
        $this->db = $ini['db_name'];
    }

    public function connect(): PDO {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->db;
        $pdo = new PDO($dsn, $this->user, $this->pass);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    }
}