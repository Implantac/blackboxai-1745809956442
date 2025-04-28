<?php

namespace App\Models;

use App\Core\Model;

class AuditLog extends Model {
    protected string $table = 'system_logs';

    public function tableName(): string {
        return 'system_logs';
    }

    public function logAction($userId, $action, $entityType = null, $entityId = null, $details = null, $ipAddress = null) {
        $data = [
            'user_id' => $userId,
            'action' => $action,
            'entity_type' => $entityType,
            'entity_id' => $entityId,
            'details' => $details ? json_encode($details) : null,
            'ip_address' => $ipAddress,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $columns = implode(',', array_keys($data));
        $placeholders = implode(',', array_fill(0, count($data), '?'));

        $sql = "INSERT INTO {$this->table} ($columns) VALUES ($placeholders)";
        return $this->db->execute($sql, array_values($data));
    }
}
