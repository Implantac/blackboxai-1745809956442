<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Middlewares\AuthMiddleware;
use App\Core\Request;
use App\Core\Response;
use App\Models\FutureBooking;
use App\Models\Room;

class FutureBookingController extends Controller {
    public function __construct() {
        $this->registerMiddleware(new AuthMiddleware());
    }

    public function index() {
        $futureBookingModel = new FutureBooking();
        $motelId = $_SESSION['motel_id'] ?? null; // Assuming motel_id stored in session
        $conditions = [];
        if ($motelId) {
            $conditions['motel_id'] = $motelId;
        }
        $futureBookings = $futureBookingModel->findAll($conditions);
        return $this->render('future_bookings/index', ['futureBookings' => $futureBookings]);
    }

    public function create() {
        $roomModel = new Room();
        $rooms = $roomModel->findAll(['status' => 'disponivel']);
        return $this->render('future_bookings/create', ['rooms' => $rooms]);
    }

    public function store(Request $request, Response $response) {
        if ($request->isPost()) {
            $futureBooking = new FutureBooking();
            $futureBooking->loadData($request->getBody());

            if ($futureBooking->save()) {
                $this->setFlashMessage('success', 'Reserva futura criada com sucesso.');
                $response->redirect('/reservas/futuras');
                return;
            }
        }
        return $this->render('future_bookings/create');
    }

    public function edit($id) {
        $futureBookingModel = new FutureBooking();
        $futureBooking = $futureBookingModel->findOne(['id' => $id]);
        if (!$futureBooking) {
            $this->setFlashMessage('error', 'Reserva futura não encontrada.');
            return $this->redirect('/reservas/futuras');
        }
        $roomModel = new Room();
        $rooms = $roomModel->findAll(['status' => 'disponivel']);
        return $this->render('future_bookings/edit', ['futureBooking' => $futureBooking, 'rooms' => $rooms]);
    }

    public function update(Request $request, Response $response, $id) {
        if ($request->isPost()) {
            $futureBookingModel = new FutureBooking();
            $futureBooking = $futureBookingModel->findOne(['id' => $id]);
            if (!$futureBooking) {
                $this->setFlashMessage('error', 'Reserva futura não encontrada.');
                $response->redirect('/reservas/futuras');
                return;
            }
            $futureBookingModel->loadData($request->getBody());
            if ($futureBookingModel->update($id, $request->getBody())) {
                $this->setFlashMessage('success', 'Reserva futura atualizada com sucesso.');
                $response->redirect('/reservas/futuras');
                return;
            }
        }
        return $this->render('future_bookings/edit', ['futureBooking' => $futureBookingModel]);
    }

    public function delete(Request $request, Response $response, $id) {
        if ($request->isPost()) {
            $futureBookingModel = new FutureBooking();
            if ($futureBookingModel->delete($id)) {
                $this->setFlashMessage('success', 'Reserva futura excluída com sucesso.');
            } else {
                $this->setFlashMessage('error', 'Erro ao excluir a reserva futura.');
            }
            $response->redirect('/reservas/futuras');
        }
    }
}
