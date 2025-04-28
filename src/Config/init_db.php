<?php

require_once __DIR__ . '/../../vendor/autoload.php';

// Carregar variáveis de ambiente
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 2));
$dotenv->load();

try {
    $dbPath = dirname(__DIR__, 2) . '/database/motel.db';
    $dbDir = dirname($dbPath);

    // Create database directory if it doesn't exist
    if (!is_dir($dbDir)) {
        mkdir($dbDir, 0777, true);
    }

    // Connect to SQLite database
    $pdo = new PDO("sqlite:$dbPath");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Create tables
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS users (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            name TEXT NOT NULL,
            email TEXT NOT NULL UNIQUE,
            password TEXT NOT NULL,
            role TEXT NOT NULL DEFAULT 'recepcionista',
            status TEXT NOT NULL DEFAULT 'active',
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )
    ");
    
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS rooms (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            number TEXT NOT NULL UNIQUE,
            type TEXT NOT NULL,
            status TEXT NOT NULL DEFAULT 'disponivel',
            price_hour REAL NOT NULL,
            price_overnight REAL NOT NULL,
            description TEXT,
            features TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
        )
    ");
    
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS bookings (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            room_id INTEGER NOT NULL,
            client_name TEXT,
            client_document TEXT,
            check_in DATETIME NOT NULL,
            check_out DATETIME,
            status TEXT NOT NULL DEFAULT 'pendente',
            total_amount REAL,
            payment_status TEXT NOT NULL DEFAULT 'pendente',
            payment_method TEXT,
            notes TEXT,
            created_by INTEGER NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (room_id) REFERENCES rooms(id),
            FOREIGN KEY (created_by) REFERENCES users(id)
        )
    ");
    
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS consumptions (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            booking_id INTEGER NOT NULL,
            item_name TEXT NOT NULL,
            quantity INTEGER NOT NULL,
            price_unit REAL NOT NULL,
            total_amount REAL NOT NULL,
            created_by INTEGER NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (booking_id) REFERENCES bookings(id),
            FOREIGN KEY (created_by) REFERENCES users(id)
        )
    ");
    
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS payments (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            booking_id INTEGER NOT NULL,
            amount REAL NOT NULL,
            payment_method TEXT NOT NULL,
            status TEXT NOT NULL DEFAULT 'pendente',
            transaction_id TEXT,
            created_by INTEGER NOT NULL,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (booking_id) REFERENCES bookings(id),
            FOREIGN KEY (created_by) REFERENCES users(id)
        )
    ");
    
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS system_logs (
            id INTEGER PRIMARY KEY AUTOINCREMENT,
            user_id INTEGER,
            action TEXT NOT NULL,
            entity_type TEXT,
            entity_id INTEGER,
            details TEXT,
            ip_address TEXT,
            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
            FOREIGN KEY (user_id) REFERENCES users(id)
        )
    ");

    echo "✓ Tabelas criadas com sucesso\n";

    // Insert admin user if not exists
    $adminPassword = password_hash('admin123', PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("
        INSERT INTO users (name, email, password, role) 
        SELECT 'Administrador', 'admin@sistema.com', ?, 'admin'
        WHERE NOT EXISTS (
            SELECT 1 FROM users WHERE email = 'admin@sistema.com'
        )
    ");
    $stmt->execute([$adminPassword]);
    echo "✓ Usuário administrador criado com sucesso\n";

    // Insert sample rooms
    $rooms = [
        ['101', 'standard', 50.00, 150.00, 'Quarto Standard', '{"tv":true,"ar":true,"frigobar":true}'],
        ['102', 'standard', 50.00, 150.00, 'Quarto Standard', '{"tv":true,"ar":true,"frigobar":true}'],
        ['201', 'luxo', 80.00, 200.00, 'Quarto Luxo', '{"tv":true,"ar":true,"frigobar":true,"hidro":true}'],
        ['202', 'luxo', 80.00, 200.00, 'Quarto Luxo', '{"tv":true,"ar":true,"frigobar":true,"hidro":true}'],
        ['301', 'suite', 120.00, 300.00, 'Suíte Master', '{"tv":true,"ar":true,"frigobar":true,"hidro":true,"sauna":true}'],
    ];

    $stmt = $pdo->prepare("
        INSERT INTO rooms (number, type, price_hour, price_overnight, description, features) 
        SELECT ?, ?, ?, ?, ?, ?
        WHERE NOT EXISTS (
            SELECT 1 FROM rooms WHERE number = ?
        )
    ");
    
    foreach ($rooms as $room) {
        $stmt->execute([
            $room[0], // number
            $room[1], // type
            $room[2], // price_hour
            $room[3], // price_overnight
            $room[4], // description
            $room[5], // features
            $room[0]  // number again for WHERE clause
        ]);
    }
    echo "✓ Quartos de exemplo criados com sucesso\n";

    echo "\nInicialização concluída com sucesso!\n";
    echo "Credenciais do administrador:\n";
    echo "Email: admin@sistema.com\n";
    echo "Senha: admin123\n";

} catch (PDOException $e) {
    die("Erro na inicialização do banco de dados: " . $e->getMessage() . "\n");
}
