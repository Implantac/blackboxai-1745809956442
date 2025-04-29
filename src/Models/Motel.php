<?php

namespace App\Models;

use App\Core\Model;

class Motel extends Model {
    protected string $table = 'motels';

    public int $id = 0;
    public string $name = '';
    public string $address = '';
    public string $created_at = '';
    public string $updated_at = '';

    public function tableName(): string {
        return $this->table;
    }

    public function rules(): array {
        return [
            'name' => [self::RULE_REQUIRED],
        ];
    }

    public function labels(): array {
        return [
            'name' => 'Nome do Motel',
            'address' => 'Endereço',
        ];
    }
}
