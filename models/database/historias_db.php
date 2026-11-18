<?php

require_once __DIR__ . '/historias_db_interface.php';

class HistoriasDb implements HistoriasDbInterface {
    private string $host = 'localhost';
    private string $user = 'root';
    private string $password = '';
    private string $database = 'gestor_historias_db';

    private ?mysqli $connection = null;

    public function __construct() {
        $this->connection = new mysqli(
            $this->host,
            $this->user,
            $this->password,
            $this->database
        );

        if ($this->connection->connect_error) {
            die("Error de conexión a MySQL: " . $this->connection->connect_error);
        }

        $this->connection->set_charset("utf8mb4");
    }

    public function getConnection(): mysqli {
        return $this->connection;
    }
}
