<?php

namespace App\Models;

use App\Core\Model;
use App\Core\Application;

class Booking extends Model {
    protected string $table = 'bookings';

    public function tableName(): string {
        return 'bookings';
    }

    public function getTodayBookings(): array {
        $sql = "SELECT b.*, r.number as room_number 
                FROM {$this->table} b 
                JOIN rooms r ON b.room_id = r.id 
                WHERE DATE(b.check_in) = CURDATE() 
                ORDER BY b.check_in DESC";
        
        try {
            return $this->db->fetchAll($sql);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function getTodayRevenue(): float {
        $sql = "SELECT COALESCE(SUM(total_amount), 0) as total 
                FROM {$this->table} 
                WHERE DATE(check_in) = CURDATE() 
                AND status = 'finalizada' 
                AND payment_status = 'pago'";
        
        try {
            $result = $this->db->fetch($sql);
            return (float) $result['total'];
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return 0.0;
        }
    }

    public function createBooking(array $data): bool {
        try {
            $this->db->beginTransaction();

            // Verificar se o quarto está disponível
            $room = (new Room())->findOne([
                'id' => $data['room_id'],
                'status' => 'disponivel'
            ]);

            if (!$room) {
                throw new \Exception('Quarto não está disponível');
            }

            // Criar a reserva
            $bookingData = [
                'room_id' => $data['room_id'],
                'client_name' => $data['client_name'],
                'client_document' => $data['client_document'] ?? null,
                'check_in' => date('Y-m-d H:i:s'),
                'status' => 'em_andamento',
                'created_by' => Application::$app->session->getUserId()
            ];

            $columns = implode(',', array_keys($bookingData));
            $values = implode(',', array_fill(0, count($bookingData), '?'));
            
            $sql = "INSERT INTO {$this->table} ($columns) VALUES ($values)";
            $this->db->execute($sql, array_values($bookingData));

            // Atualizar status do quarto
            (new Room())->updateStatus($data['room_id'], 'ocupado');

            $this->db->commit();
            return true;
        } catch (\Exception $e) {
            $this->db->rollBack();
            error_log($e->getMessage());
            return false;
        }
    }

    public function checkout($bookingId): bool {
        try {
            $this->db->beginTransaction();

            // Buscar a reserva
            $booking = $this->findOne(['id' => $bookingId, 'status' => 'em_andamento']);
            if (!$booking) {
                throw new \Exception('Reserva não encontrada ou já finalizada');
            }

            // Calcular valor total
            $checkIn = strtotime($booking['check_in']);
            $checkOut = time();
            $duration = ceil(($checkOut - $checkIn) / 3600); // Duração em horas

            // Buscar preços do quarto
            $room = (new Room())->findOne(['id' => $booking['room_id']]);
            
            // Calcular valor baseado na duração
            $totalAmount = $duration <= 12 
                ? $duration * $room['price_hour']
                : $room['price_overnight'];

            // Atualizar reserva
            $this->update($bookingId, [
                'check_out' => date('Y-m-d H:i:s'),
                'status' => 'finalizada',
                'total_amount' => $totalAmount
            ]);

            // Atualizar status do quarto para limpeza
            (new Room())->updateStatus($booking['room_id'], 'limpeza');

            $this->db->commit();
            return true;
        } catch (\Exception $e) {
            $this->db->rollBack();
            error_log($e->getMessage());
            return false;
        }
    }

    public function getActiveBookings(): array {
        $sql = "SELECT b.*, r.number as room_number, r.type as room_type 
                FROM {$this->table} b 
                JOIN rooms r ON b.room_id = r.id 
                WHERE b.status = 'em_andamento' 
                ORDER BY b.check_in DESC";
        
        try {
            return $this->db->fetchAll($sql);
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return [];
        }
    }

    public function rules(): array {
        return [
            'room_id' => [self::RULE_REQUIRED],
            'client_name' => [self::RULE_REQUIRED],
            'check_in' => [self::RULE_REQUIRED]
        ];
    }

    public function labels(): array {
        return [
            'room_id' => 'Quarto',
            'client_name' => 'Nome do Cliente',
            'client_document' => 'Documento',
            'check_in' => 'Check-in',
            'check_out' => 'Check-out',
            'status' => 'Status',
            'total_amount' => 'Valor Total',
            'payment_status' => 'Status do Pagamento',
            'payment_method' => 'Forma de Pagamento',
            'notes' => 'Observações'
        ];
    }
}
