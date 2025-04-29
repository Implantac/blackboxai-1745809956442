<?php

require_once __DIR__ . '/../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 2));
$dotenv->load();

try {
    $dbPath = dirname(__DIR__, 2) . '/database/motel.db';
    $pdo = new PDO("sqlite:$dbPath");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("CREATE TABLE IF NOT EXISTS motels (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        address TEXT,
        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
    )");

    $result = $pdo->query("PRAGMA table_info(rooms)")->fetchAll(PDO::FETCH_ASSOC);
    $columns = array_column($result, 'name');
    if (!in_array('motel_id', $columns)) {
        $pdo->exec("ALTER TABLE rooms ADD COLUMN motel_id INTEGER");
    }

    $result = $pdo->query("PRAGMA table_info(bookings)")->fetchAll(PDO::FETCH_ASSOC);
    $columns = array_column($result, 'name');
    if (!in_array('motel_id', $columns)) {
        $pdo->exec("ALTER TABLE bookings ADD COLUMN motel_id INTEGER");
    }

    echo "✓ Tabela motels criada e colunas motel_id adicionadas.\n";

} catch (PDOException $e) {
    die("Erro na migração de motels: " . $e->getMessage() . "\n");
}
