<?php

require_once __DIR__ . '/../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 2));
$dotenv->load();

try {
    $dbPath = dirname(__DIR__, 2) . '/database/motel.db';
    $pdo = new PDO("sqlite:$dbPath");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if column exists
    $result = $pdo->query("PRAGMA table_info(users)")->fetchAll(PDO::FETCH_ASSOC);
    $columns = array_column($result, 'name');

    if (!in_array('two_factor_secret', $columns)) {
        $pdo->exec("ALTER TABLE users ADD COLUMN two_factor_secret TEXT");
        echo "Coluna 'two_factor_secret' adicionada com sucesso.\n";
    } else {
        echo "Coluna 'two_factor_secret' já existe.\n";
    }
} catch (PDOException $e) {
    die("Erro na migração do banco de dados: " . $e->getMessage() . "\n");
}
