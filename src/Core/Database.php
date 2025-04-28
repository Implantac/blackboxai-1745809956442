<?php

namespace App\Core;

use PDO;
use PDOException;

class Database {
    private PDO $pdo;
    private static array $instances = [];

    public function __construct() {
        $dbPath = dirname(__DIR__, 2) . '/database/motel.db';
        $dbDir = dirname($dbPath);

        // Create database directory if it doesn't exist
        if (!is_dir($dbDir)) {
            mkdir($dbDir, 0777, true);
        }

        try {
            $this->pdo = new PDO("sqlite:$dbPath");
            
            // Enable foreign keys
            $this->pdo->exec('PRAGMA foreign_keys = ON');
            
            // Set error mode
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
            // Set pragmas for better performance
            $this->pdo->exec('PRAGMA journal_mode = WAL');
            $this->pdo->exec('PRAGMA synchronous = NORMAL');
            
        } catch (PDOException $e) {
            throw new \Exception("Erro na conexão com o banco de dados: " . $e->getMessage());
        }
    }

    public function getPdo(): PDO {
        return $this->pdo;
    }

    public function prepare($sql): \PDOStatement {
        return $this->pdo->prepare($sql);
    }

    public function query($sql) {
        return $this->pdo->query($sql);
    }

    public function lastInsertId() {
        return $this->pdo->lastInsertId();
    }

    public function beginTransaction() {
        return $this->pdo->beginTransaction();
    }

    public function commit() {
        return $this->pdo->commit();
    }

    public function rollBack() {
        return $this->pdo->rollBack();
    }

    public function execute($sql, $params = []): bool {
        try {
            $stmt = $this->prepare($sql);
            return $stmt->execute($params);
        } catch (PDOException $e) {
            error_log($e->getMessage());
            throw new \Exception("Erro ao executar query: " . $e->getMessage());
        }
    }

    public function fetch($sql, $params = []) {
        try {
            $stmt = $this->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetch();
        } catch (PDOException $e) {
            error_log($e->getMessage());
            throw new \Exception("Erro ao buscar dados: " . $e->getMessage());
        }
    }

    public function fetchAll($sql, $params = []) {
        try {
            $stmt = $this->prepare($sql);
            $stmt->execute($params);
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log($e->getMessage());
            throw new \Exception("Erro ao buscar dados: " . $e->getMessage());
        }
    }
}
