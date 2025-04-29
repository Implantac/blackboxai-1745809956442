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
        $cache = new \App\Core\Cache();
        $cacheKey = 'dashboard_stats';
        $cacheTtl = 300; // 5 minutes

        $stats = $cache->get($cacheKey);
        if (!$stats) {
            // Obter estatísticas para o dashboard
            $roomModel = new Room();
            $bookingModel = new Booking();

            try {
                $stats = [
                    'totalRooms' => $roomModel->count(),
                    'occupiedRooms' => $roomModel->count(['status' => 'ocupado']),
                    'availableRooms' => $roomModel->count(['status' => 'disponivel']),
                    'cleaningRooms' => $roomModel->count(['status' => 'limpeza']),
                    'todayBookings' => count($bookingModel->getTodayBookings()),
                    'todayRevenue' => $bookingModel->getTodayRevenue(),
                    'roomTypeOccupancy' => $roomModel->getOccupancyByType()
                ];
                $cache->set($cacheKey, $stats, $cacheTtl);
            } catch (\Exception $e) {
                Application::$app->session->setFlash('error', 'Erro ao carregar dados do dashboard');
                $stats = [
                    'totalRooms' => 0,
                    'occupiedRooms' => 0,
                    'availableRooms' => 0,
                    'cleaningRooms' => 0,
                    'todayBookings' => 0,
                    'todayRevenue' => 0,
                    'roomTypeOccupancy' => []
                ];
            }
        }

        $recentBookings = (new Booking())->getTodayBookings();

        return $this->render('dashboard/index', [
            'stats' => $stats,
            'recentBookings' => $recentBookings
        ]);
    }
}
