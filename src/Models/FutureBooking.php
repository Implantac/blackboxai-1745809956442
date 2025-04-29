<?php

namespace App\Models;

use App\Core\Model;

class FutureBooking extends Model {
    protected string $table = 'future_bookings';

    public int $id = 0;
    public int $room_id = 0;
    public string $client_name = '';
    public string $client_document = '';
    public string $reservation_date = '';
    public string $status = 'pending';
    public string $created_at = '';
    public string $updated_at = '';

    public function tableName(): string {
        return $this->table;
    }

    public function rules(): array {
        return [
            'room_id' => [self::RULE_REQUIRED],
            'client_name' => [self::RULE_REQUIRED],
            'reservation_date' => [self::RULE_REQUIRED],
        ];
    }

    public function labels(): array {
        return [
            'room_id' => 'Quarto',
            'client_name' => 'Nome do Cliente',
            'client_document' => 'Documento',
            'reservation_date' => 'Data da Reserva',
            'status' => 'Status',
        ];
    }
}
