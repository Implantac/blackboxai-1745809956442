<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Middlewares\AuthMiddleware;
use App\Core\Request;
use App\Core\Response;
use App\Models\Room;

class RoomController extends Controller {
    public function __construct() {
        $this->registerMiddleware(new AuthMiddleware());
    }

    public function index() {
        $roomModel = new Room();
        $motelId = $_SESSION['motel_id'] ?? null; // Assuming motel_id stored in session
        $conditions = [];
        if ($motelId) {
            $conditions['motel_id'] = $motelId;
        }
        $rooms = $roomModel->findAll($conditions);
        return $this->render('rooms/index', ['rooms' => $rooms]);
    }

    public function create() {
        return $this->render('rooms/create');
    }

    public function store(Request $request, Response $response) {
        if ($request->isPost()) {
            $room = new Room();
            $room->loadData($request->getBody());

            if ($room->save()) {
                $this->setFlashMessage('success', 'Quarto criado com sucesso.');
                $response->redirect('/quartos');
                return;
            }
        }
        return $this->render('rooms/create', ['room' => $room]);
    }

    public function show($id) {
        $roomModel = new Room();
        $room = $roomModel->findOne(['id' => $id]);
        if (!$room) {
            $this->setFlashMessage('error', 'Quarto não encontrado.');
            return $this->redirect('/quartos');
        }
        return $this->render('rooms/show', ['room' => $room]);
    }

    public function edit($id) {
        $roomModel = new Room();
        $room = $roomModel->findOne(['id' => $id]);
        if (!$room) {
            $this->setFlashMessage('error', 'Quarto não encontrado.');
            return $this->redirect('/quartos');
        }
        return $this->render('rooms/edit', ['room' => $room]);
    }

    public function update(Request $request, Response $response, $id) {
        if ($request->isPost()) {
            $roomModel = new Room();
            $room = $roomModel->findOne(['id' => $id]);
            if (!$room) {
                $this->setFlashMessage('error', 'Quarto não encontrado.');
                $response->redirect('/quartos');
                return;
            }
            $roomModel->loadData($request->getBody());
            if ($roomModel->update($id, $request->getBody())) {
                $this->setFlashMessage('success', 'Quarto atualizado com sucesso.');
                $response->redirect('/quartos');
                return;
            }
        }
        return $this->render('rooms/edit', ['room' => $roomModel]);
    }

    public function delete(Request $request, Response $response, $id) {
        if ($request->isPost()) {
            $roomModel = new Room();
            if ($roomModel->delete($id)) {
                $this->setFlashMessage('success', 'Quarto excluído com sucesso.');
            } else {
                $this->setFlashMessage('error', 'Erro ao excluir o quarto.');
            }
            $response->redirect('/quartos');
        }
    }

    public function updateStatus(Request $request, Response $response, $id) {
        if ($request->isPost()) {
            $status = $request->getBody()['status'] ?? null;
            $roomModel = new Room();
            if ($status && $roomModel->updateStatus($id, $status)) {
                $this->setFlashMessage('success', 'Status do quarto atualizado.');
            } else {
                $this->setFlashMessage('error', 'Erro ao atualizar status do quarto.');
            }
            $response->redirect('/quartos');
        }
    }
}
