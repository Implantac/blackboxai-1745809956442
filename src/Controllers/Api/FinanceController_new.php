<?php

namespace App\Controllers\Api;

use App\Core\Controller;
use App\Core\Middlewares\AuthMiddleware;
use App\Core\Request;
use App\Core\Response;
use App\Models\Booking;

class FinanceController extends Controller {
    public function __construct() {
        $this->registerMiddleware(new AuthMiddleware());
    }

    public function dailyReport(Request $request, Response $response) {
        $bookingModel = new Booking();
        $dailyRevenue = $bookingModel->getTodayRevenue();

        return $response->json([
            'dailyRevenue' => $dailyRevenue
        ]);
    }

    public function monthlyReport(Request $request, Response $response) {
        // Implement monthly report logic here
        return $response->json([
            'message' => 'Monthly report not implemented yet'
        ]);
    }
}
