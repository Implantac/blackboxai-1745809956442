<?php

namespace App\Controllers\Api;

use App\Core\Controller;
use App\Core\Middlewares\AuthMiddleware;
use App\Core\Request;
use App\Core\Response;
use App\Models\Booking;

class BookingController extends Controller {
    public function __construct() {
        $this->registerMiddleware(new AuthMiddleware());
    }

    public function active(Request $request, Response $response) {
        $bookingModel = new Booking();
        $activeBookings = $bookingModel->getActiveBookings();

        return $response->json([
            'activeBookings' => $activeBookings
        ]);
    }
}
