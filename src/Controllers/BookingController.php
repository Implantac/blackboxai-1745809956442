<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Middlewares\AuthMiddleware;
use App\Core\Request;
use App\Core\Response;
use App\Models\Booking;
use App\Models\Room;

class BookingController extends Controller {
    public function __construct() {
        $this->registerMiddleware(new AuthMiddleware());
    }

    public function index() {
        $bookingModel = new Booking();
        $bookings = $bookingModel->findAll();
        return $this->render('bookings/index', ['bookings' => $bookings]);
    }

    public function create() {
        $roomModel = new Room();
        $availableRooms = $roomModel->getAvailableRooms();
        return $this->render('bookings/create', ['rooms' => $availableRooms]);
    }

    public function store(Request $request, Response $response) {
        if ($request->isPost()) {
            $booking = new Booking();
            $booking->loadData($request->getBody());

            if ($booking->createBooking($request->getBody())) {
                $this->setFlashMessage('success', 'Reserva criada com sucesso.');
                $response->redirect('/reservas');
                return;
            } else {
                $this->setFlashMessage('error', 'Erro ao criar reserva.');
            }
        }
        return $this->render('bookings/create');
    }

    public function show($id) {
        $bookingModel = new Booking();
        $booking = $bookingModel->findOne(['id' => $id]);
        if (!$booking) {
            $this->setFlashMessage('error', 'Reserva não encontrada.');
            return $this->redirect('/reservas');
        }
        return $this->render('bookings/show', ['booking' => $booking]);
    }

    public function checkout(Request $request, Response $response, $id) {
        if ($request->isPost()) {
            $bookingModel = new Booking();
            if ($bookingModel->checkout($id)) {
                $this->setFlashMessage('success', 'Check-out realizado com sucesso.');
            } else {
                $this->setFlashMessage('error', 'Erro ao realizar check-out.');
            }
            $response->redirect('/reservas');
        }
    }

    public function cancel(Request $request, Response $response, $id) {
        if ($request->isPost()) {
            $bookingModel = new Booking();
            if ($bookingModel->update($id, ['status' => 'cancelada'])) {
                $this->setFlashMessage('success', 'Reserva cancelada com sucesso.');
            } else {
                $this->setFlashMessage('error', 'Erro ao cancelar reserva.');
            }
            $response->redirect('/reservas');
        }
    }
}
