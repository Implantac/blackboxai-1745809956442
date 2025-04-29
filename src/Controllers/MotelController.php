<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Middlewares\AuthMiddleware;
use App\Core\Request;
use App\Core\Response;
use App\Models\Motel;

class MotelController extends Controller {
    public function __construct() {
        $this->registerMiddleware(new AuthMiddleware());
    }

    public function index() {
        $motelModel = new Motel();
        $motels = $motelModel->findAll();
        return $this->render('motels/index', ['motels' => $motels]);
    }

    public function create() {
        return $this->render('motels/create');
    }

    public function store(Request $request, Response $response) {
        if ($request->isPost()) {
            $motel = new Motel();
            $motel->loadData($request->getBody());

            if ($motel->save()) {
                $this->setFlashMessage('success', 'Motel criado com sucesso.');
                $response->redirect('/motels');
                return;
            }
        }
        return $this->render('motels/create');
    }

    public function edit($id) {
        $motelModel = new Motel();
        $motel = $motelModel->findOne(['id' => $id]);
        if (!$motel) {
            $this->setFlashMessage('error', 'Motel não encontrado.');
            return $this->redirect('/motels');
        }
        return $this->render('motels/edit', ['motel' => $motel]);
    }

    public function update(Request $request, Response $response, $id) {
        if ($request->isPost()) {
            $motelModel = new Motel();
            $motel = $motelModel->findOne(['id' => $id]);
            if (!$motel) {
                $this->setFlashMessage('error', 'Motel não encontrado.');
                $response->redirect('/motels');
                return;
            }
            $motelModel->loadData($request->getBody());
            if ($motelModel->update($id, $request->getBody())) {
                $this->setFlashMessage('success', 'Motel atualizado com sucesso.');
                $response->redirect('/motels');
                return;
            }
        }
        return $this->render('motels/edit', ['motel' => $motelModel]);
    }

    public function delete(Request $request, Response $response, $id) {
        if ($request->isPost()) {
            $motelModel = new Motel();
            if ($motelModel->delete($id)) {
                $this->setFlashMessage('success', 'Motel excluído com sucesso.');
            } else {
                $this->setFlashMessage('error', 'Erro ao excluir o motel.');
            }
            $response->redirect('/motels');
        }
    }
}
