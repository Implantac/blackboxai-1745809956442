<?php

namespace App\Models;

use App\Core\Model;

class Room extends Model {
    protected string $table = 'rooms';

    public function tableName(): string {
        return 'rooms';
    }

    public function count($conditions = []): int {
        $sql = "SELECT COUNT(*) as count FROM {$this->table}";
        
        if (!empty($conditions)) {
            $sql .= " WHERE ";
            $conditions_sql = [];
            foreach ($conditions as $key => $value) {
                $conditions_sql[] = "$key = :$key";
            }
            $sql .= implode(" AND ", $conditions_sql);
        }

        try {
            $stmt = $this->db->prepare($sql);
            
            if (!empty($conditions)) {
                foreach ($conditions as $key => $value) {
                    $stmt->bindValue(":$key", $value);
                }
            }
            
            $stmt->execute();
            $result = $stmt->fetch();
            return (int) $result['count'];
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return 0;
        }
    }

    public function getOccupancyByType(): array {
        $sql = "SELECT type, COUNT(*) as count FROM {$this->table} WHERE status = 'ocupado' GROUP BY type";
        
        try {
            $result = $this->db->fetchAll($sql);
            $occupancy = [
                'standard' => 0,
                'luxo' => 0,
                'suite' => 0
            ];
            
            foreach ($result as $row) {
                $occupancy[$row['type']] = (int) $row['count'];
            }
            
            return $occupancy;
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return [
                'standard' => 0,
                'luxo' => 0,
                'suite' => 0
            ];
        }
    }

    public function getAvailableRooms(): array {
        return $this->findAll(['status' => 'disponivel'], 'number ASC');
    }

    public function updateStatus($roomId, $status): bool {
        return $this->update($roomId, ['status' => $status]);
    }

    public function getRoomDetails($roomId): ?array {
        $room = $this->findOne(['id' => $roomId]);
        if ($room) {
            $room['features'] = json_decode($room['features'], true);
        }
        return $room;
    }

    public function rules(): array {
        return [
            'number' => [self::RULE_REQUIRED, self::RULE_UNIQUE],
            'type' => [self::RULE_REQUIRED],
            'price_hour' => [self::RULE_REQUIRED, self::RULE_NUMERIC],
            'price_overnight' => [self::RULE_REQUIRED, self::RULE_NUMERIC]
        ];
    }

    public function labels(): array {
        return [
            'number' => 'Número',
            'type' => 'Tipo',
            'status' => 'Status',
            'price_hour' => 'Preço por Hora',
            'price_overnight' => 'Preço Pernoite',
            'description' => 'Descrição',
            'features' => 'Características'
        ];
    }

    public function save(): bool {
        if (isset($this->features) && is_array($this->features)) {
            $this->features = json_encode($this->features);
        }
        
        return parent::save();
    }
}
