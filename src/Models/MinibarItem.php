<?php

namespace App\Models;

use App\Core\Model;

class MinibarItem extends Model {
    protected string $table = 'minibar_items';

    public int $id = 0;
    public string $name = '';
    public int $quantity = 0;
    public float $price = 0.0;
    public string $created_at = '';
    public string $updated_at = '';

    public function tableName(): string {
        return $this->table;
    }

    public function rules(): array {
        return [
            'name' => [self::RULE_REQUIRED],
            'quantity' => [self::RULE_REQUIRED, self::RULE_NUMERIC],
            'price' => [self::RULE_REQUIRED, self::RULE_NUMERIC],
        ];
    }

    public function labels(): array {
        return [
            'name' => 'Nome do Item',
            'quantity' => 'Quantidade',
            'price' => 'Preço',
        ];
    }
}
