<?php

require_once __DIR__ . '/../../vendor/autoload.php';

$dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__, 2));
$dotenv->load();

try {
    $dbPath = dirname(__DIR__, 2) . '/database/motel.db';
    $pdo = new PDO("sqlite:$dbPath");
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Add indexes for performance
    $indexes = [
        "CREATE INDEX IF NOT EXISTS idx_users_email ON users(email);",
        "CREATE INDEX IF NOT EXISTS idx_rooms_number ON rooms(number);",
        "CREATE INDEX IF NOT EXISTS idx_bookings_room_id ON bookings(room_id);",
        "CREATE INDEX IF NOT EXISTS idx_bookings_created_by ON bookings(created_by);",
        "CREATE INDEX IF NOT EXISTS idx_consumptions_booking_id ON consumptions(booking_id);",
        "CREATE INDEX IF NOT EXISTS idx_payments_booking_id ON payments(booking_id);",
        "CREATE INDEX IF NOT EXISTS idx_system_logs_user_id ON system_logs(user_id);"
    ];

    foreach ($indexes as $sql) {
        $pdo->exec($sql);
    }

    echo "✓ Índices adicionados com sucesso.\n";

} catch (PDOException $e) {
    die("Erro na migração de índices: " . $e->getMessage() . "\n");
}
