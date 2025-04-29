<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Middlewares\AuthMiddleware;
use App\Core\Request;
use App\Core\Response;
use App\Models\MinibarItem;

class MinibarController extends Controller {
    public function __construct() {
        $this->registerMiddleware(new AuthMiddleware());
    }

    public function index() {
        $minibarModel = new MinibarItem();
        $items = $minibarModel->findAll();
        return $this->render('minibar/index', ['items' => $items]);
    }

    public function create() {
        return $this->render('minibar/create');
    }

    public function store(Request $request, Response $response) {
        if ($request->isPost()) {
            $item = new MinibarItem();
            $item->loadData($request->getBody());

            if ($item->save()) {
                $this->setFlashMessage('success', 'Item do frigobar criado com sucesso.');
                $response->redirect('/frigobar');
                return;
            }
        }
        return $this->render('minibar/create');
    }

    public function edit($id) {
        $minibarModel = new MinibarItem();
        $item = $minibarModel->findOne(['id' => $id]);
        if (!$item) {
            $this->setFlashMessage('error', 'Item não encontrado.');
            return $this->redirect('/frigobar');
        }
        return $this->render('minibar/edit', ['item' => $item]);
    }

    public function update(Request $request, Response $response, $id) {
        if ($request->isPost()) {
            $minibarModel = new MinibarItem();
            $item = $minibarModel->findOne(['id' => $id]);
            if (!$item) {
                $this->setFlashMessage('error', 'Item não encontrado.');
                $response->redirect('/frigobar');
                return;
            }
            $minibarModel->loadData($request->getBody());
            if ($minibarModel->update($id, $request->getBody())) {
                $this->setFlashMessage('success', 'Item atualizado com sucesso.');
                $response->redirect('/frigobar');
                return;
            }
        }
        return $this->render('minibar/edit', ['item' => $minibarModel]);
    }

    public function delete(Request $request, Response $response, $id) {
        if ($request->isPost()) {
            $minibarModel = new MinibarItem();
            if ($minibarModel->delete($id)) {
                $this->setFlashMessage('success', 'Item excluído com sucesso.');
            } else {
                $this->setFlashMessage('error', 'Erro ao excluir o item.');
            }
            $response->redirect('/frigobar');
        }
    }
}
