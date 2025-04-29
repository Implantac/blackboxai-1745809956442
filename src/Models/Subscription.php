<?php

namespace App\Models;

use App\Core\Model;

class Subscription extends Model {
    protected string $table = 'subscriptions';

    public int $id = 0;
    public int $motel_id = 0;
    public string $plan_name = '';
    public float $price = 0.0;
    public string $status = 'active';
    public string $start_date = '';
    public string $end_date = '';
    public string $created_at = '';
    public string $updated_at = '';

    public function tableName(): string {
        return $this->table;
    }

    public function rules(): array {
        return [
            'motel_id' => [self::RULE_REQUIRED],
            'plan_name' => [self::RULE_REQUIRED],
            'price' => [self::RULE_REQUIRED, self::RULE_NUMERIC],
            'status' => [self::RULE_REQUIRED],
            'start_date' => [self::RULE_REQUIRED],
            'end_date' => [self::RULE_REQUIRED],
        ];
    }

    public function labels(): array {
        return [
            'motel_id' => 'Motel',
            'plan_name' => 'Plano',
            'price' => 'Preço',
            'status' => 'Status',
            'start_date' => 'Data de Início',
            'end_date' => 'Data de Término',
        ];
    }
}
