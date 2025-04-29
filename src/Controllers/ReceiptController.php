<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Middlewares\AuthMiddleware;
use App\Core\Request;
use App\Core\Response;
use App\Models\Receipt;
use App\Models\Booking;

class ReceiptController extends Controller {
    public function __construct() {
        $this->registerMiddleware(new AuthMiddleware());
    }

    public function create(Request $request, Response $response, $bookingId) {
        $bookingModel = new Booking();
        $booking = $bookingModel->findOne(['id' => $bookingId]);
        if (!$booking) {
            $this->setFlashMessage('error', 'Reserva não encontrada.');
            return $response->redirect('/reservas');
        }

        if ($request->isPost()) {
            $receipt = new Receipt();
            $receipt->loadData($request->getBody());
            $receipt->booking_id = $bookingId;

            if ($receipt->save()) {
                $this->setFlashMessage('success', 'Recibo criado com sucesso.');
                return $response->redirect("/recibos/{$receipt->id}");
            }
        }

        return $this->render('receipts/create', ['booking' => $booking]);
    }

    public function show($id) {
        $receiptModel = new Receipt();
        $receipt = $receiptModel->findOne(['id' => $id]);
        if (!$receipt) {
            $this->setFlashMessage('error', 'Recibo não encontrado.');
            return $this->redirect('/recibos');
        }
        return $this->render('receipts/show', ['receipt' => $receipt]);
    }
}
