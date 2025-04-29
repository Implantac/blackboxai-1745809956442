<?php

namespace App\Models;

use App\Core\Model;

class Receipt extends Model {
    protected string $table = 'receipts';

    public int $id = 0;
    public int $booking_id = 0;
    public string $receipt_number = '';
    public float $amount = 0.0;
    public string $payment_method = '';
    public string $created_at = '';
    public string $updated_at = '';

    public function tableName(): string {
        return $this->table;
    }

    public function rules(): array {
        return [
            'booking_id' => [self::RULE_REQUIRED],
            'receipt_number' => [self::RULE_REQUIRED],
            'amount' => [self::RULE_REQUIRED, self::RULE_NUMERIC],
            'payment_method' => [self::RULE_REQUIRED],
        ];
    }

    public function labels(): array {
        return [
            'booking_id' => 'Reserva',
            'receipt_number' => 'Número do Recibo',
            'amount' => 'Valor',
            'payment_method' => 'Forma de Pagamento',
        ];
    }
}
