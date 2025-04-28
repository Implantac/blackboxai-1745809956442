<?php

namespace App\Controllers\Api;

use App\Core\Controller;
use App\Core\Middlewares\AuthMiddleware;
use App\Core\Request;
use App\Core\Response;
use App\Models\Room;
use App\Models\Booking;

class DashboardController extends Controller {
    public function __construct() {
        $this->registerMiddleware(new AuthMiddleware());
    }

    public function stats(Request $request, Response $response) {
        $roomModel = new Room();
        $bookingModel = new Booking();

        $totalRooms = $roomModel->count();
        $occupiedRooms = $roomModel->count(['status' => 'ocupado']);
        $availableRooms = $roomModel->count(['status' => 'disponivel']);
        $cleaningRooms = $roomModel->count(['status' => 'limpeza']);
        $todayBookings = $bookingModel->getTodayBookings();
        $todayRevenue = $bookingModel->getTodayRevenue();
        $roomTypeOccupancy = $roomModel->getOccupancyByType();

        return $response->json([
            'totalRooms' => $totalRooms,
            'occupiedRooms' => $occupiedRooms,
            'availableRooms' => $availableRooms,
            'cleaningRooms' => $cleaningRooms,
            'todayBookings' => count($todayBookings),
            'todayRevenue' => $todayRevenue,
            'roomTypeOccupancy' => $roomTypeOccupancy,
            'recentBookings' => $todayBookings
        ]);
    }
}
