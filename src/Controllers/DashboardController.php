<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Application;
use App\Core\Middlewares\AuthMiddleware;
use App\Models\Room;
use App\Models\Booking;

class DashboardController extends Controller {
    public function __construct() {
        $this->registerMiddleware(new \App\Core\Middlewares\AuthMiddleware());
    }

    public function getLayout() {
        return $this->layout;
    }

    public function index() {
        // Obter estatísticas para o dashboard
        $roomModel = new Room();
        $bookingModel = new Booking();

        try {
            // Total de quartos
            $totalRooms = $roomModel->count();
            
            // Quartos ocupados
            $occupiedRooms = $roomModel->count(['status' => 'ocupado']);
            
            // Quartos disponíveis
            $availableRooms = $roomModel->count(['status' => 'disponivel']);
            
            // Quartos em limpeza
            $cleaningRooms = $roomModel->count(['status' => 'limpeza']);
            
            // Reservas do dia
            $todayBookings = $bookingModel->getTodayBookings();
            
            // Faturamento do dia
            $todayRevenue = $bookingModel->getTodayRevenue();
            
            // Ocupação por tipo de quarto
            $roomTypeOccupancy = $roomModel->getOccupancyByType();

            return $this->render('dashboard/index', [
                'stats' => [
                    'totalRooms' => $totalRooms,
                    'occupiedRooms' => $occupiedRooms,
                    'availableRooms' => $availableRooms,
                    'cleaningRooms' => $cleaningRooms,
                    'todayBookings' => count($todayBookings),
                    'todayRevenue' => $todayRevenue,
                    'roomTypeOccupancy' => $roomTypeOccupancy
                ],
                'recentBookings' => $todayBookings
            ]);
        } catch (\Exception $e) {
            Application::$app->session->setFlash('error', 'Erro ao carregar dados do dashboard');
            return $this->render('dashboard/index', [
                'stats' => [
                    'totalRooms' => 0,
                    'occupiedRooms' => 0,
                    'availableRooms' => 0,
                    'cleaningRooms' => 0,
                    'todayBookings' => 0,
                    'todayRevenue' => 0,
                    'roomTypeOccupancy' => []
                ],
                'recentBookings' => []
            ]);
        }
    }
}
