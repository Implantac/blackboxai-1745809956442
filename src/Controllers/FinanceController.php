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
        $cache = new \App\Core\Cache();
        $cacheKey = 'finance_daily_revenue';
        $cacheTtl = 300; // 5 minutes

        $dailyRevenue = $cache->get($cacheKey);
        if ($dailyRevenue === null) {
            $bookingModel = new Booking();
            $dailyRevenue = $bookingModel->getTodayRevenue();
            $cache->set($cacheKey, $dailyRevenue, $cacheTtl);
        }

        return $this->render('finance/daily', ['dailyRevenue' => $dailyRevenue]);
    }

    public function monthlyReport(Request $request, Response $response) {
        $cache = new \App\Core\Cache();
        $cacheKey = 'finance_monthly_report';
        $cacheTtl = 3600; // 1 hour

        $monthlyReport = $cache->get($cacheKey);
        if ($monthlyReport === null) {
            // TODO: Implement actual monthly report logic
            $monthlyReport = []; // Placeholder
            $cache->set($cacheKey, $monthlyReport, $cacheTtl);
        }

        return $this->render('finance/monthly', ['monthlyReport' => $monthlyReport]);
    }
}
