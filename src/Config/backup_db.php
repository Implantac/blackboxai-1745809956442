<?php

$backupDir = __DIR__ . '/../../backups';
$dbFile = __DIR__ . '/../../database/motel.db';

if (!is_dir($backupDir)) {
    mkdir($backupDir, 0777, true);
}

$timestamp = date('Ymd_His');
$backupFile = $backupDir . "/motel_backup_$timestamp.db";

if (!copy($dbFile, $backupFile)) {
    echo "Erro ao criar backup do banco de dados.\n";
    exit(1);
}

echo "Backup criado com sucesso: $backupFile\n";
