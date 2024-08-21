<?php

namespace App\Services\Invoices\HBOGO;

use PDO;
use PDOException;

class ConnectService
{
    public mixed $connection;

    public function __construct()
    {
        $servername = config('services.api.5.hbo_go.url');
        $dbName = config('services.api.5.hbo_go.database');
        $username = config('services.api.5.hbo_go.username');
        $password = config('services.api.5.hbo_go.password');
        try {
            $this->connection = new PDO("mysql:host=$servername;dbname=$dbName", $username, $password);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection failed: ' . $e->getMessage();
        }
    }

    public function count_all_results(string $table): int
    {
        $stmt = $this->connection->prepare("SELECT * FROM $table");
        $stmt->execute();

        // $result = $stmt->setFetchMode(PDO::FETCH_ASSOC);
        return count($stmt->fetchAll());
    }
}
