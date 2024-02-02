<?php

namespace database;

use PDO;

class MySQL
{
    private static ?MySQL $instance = null;
    private PDO $db;

    private function __construct()
    {
        $host = 'localhost';
        $port = '3307';
        $dbname = 'app';
        $username = 'app';
        $password = 'app';

        try {
            $this->db = new PDO("mysql:host=$host; port=$port; dbname=$dbname;  cherset=utf8mb3", $username, $password);
            $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Erro de conexão: ' . $e->getMessage();
            exit;
        }
    }

    public static function getInstance()
    {
        if (!self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getConnection()
    {
        return $this->db;
    }

}