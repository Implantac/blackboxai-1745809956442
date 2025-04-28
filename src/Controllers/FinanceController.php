<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Middlewares\AuthMiddleware;
use App\Core\Request;
use App\Core\Response;
use App\Models\Booking;

class FinanceController extends Controller {
    public function __construct() {
        $this->registerMiddleware(new AuthMiddleware());
    }

    public function index() {
        // Show summary or redirect to reports
        return $this->render('finance/index');
    }

    public function reports() {
        return $this->render('finance/reports');
    }

    public function dailyReport(Request $request, Response $response) {
        $bookingModel = new Booking();
        $dailyRevenue = $bookingModel->getTodayRevenue();
        return $this->render('finance/daily', ['dailyRevenue' => $dailyRevenue]);
    }

    public function monthlyReport(Request $request, Response $response) {
        // Implement monthly report logic
        return $this->render('finance/monthly');
    }
}
