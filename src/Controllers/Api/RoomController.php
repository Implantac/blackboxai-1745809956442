<?php

namespace App\Controllers\Api;

use App\Core\Controller;
use App\Core\Middlewares\AuthMiddleware;
use App\Core\Request;
use App\Core\Response;
use App\Models\Room;
use App\Models\Booking;

class RoomController extends Controller {
    public function __construct() {
        $this->registerMiddleware(new AuthMiddleware());
    }

    public function available(Request $request, Response $response) {
        $roomModel = new Room();
        $bookingModel = new Booking();

        // Logic to find available rooms considering current bookings and room status
        $availableRooms = $roomModel->getAvailableRooms();

        return $response->json([
            'availableRooms' => $availableRooms
        ]);
    }
}
