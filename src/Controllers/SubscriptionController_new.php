<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Middlewares\AuthMiddleware;
use App\Core\Request;
use App\Core\Response;
use App\Models\Subscription;

class SubscriptionController extends Controller {
    public function __construct() {
        $this->registerMiddleware(new AuthMiddleware());
    }

    public function index() {
        $subscriptionModel = new Subscription();
        $subscriptions = $subscriptionModel->findAll();
        return $this->render('subscriptions/index', ['subscriptions' => $subscriptions]);
    }

    public function create() {
        return $this->render('subscriptions/create');
    }

    public function store(Request $request, Response $response) {
        if ($request->isPost()) {
            $subscription = new Subscription();
            $subscription->loadData($request->getBody());

            if ($subscription->save()) {
                $this->setFlashMessage('success', 'Assinatura criada com sucesso.');
                $response->redirect('/subscriptions');
                return;
            }
        }
        return $this->render('subscriptions/create');
    }

    public function edit($id) {
        $subscriptionModel = new Subscription();
        $subscription = $subscriptionModel->findOne(['id' => $id]);
        if (!$subscription) {
            $this->setFlashMessage('error', 'Assinatura não encontrada.');
            return $this->redirect('/subscriptions');
        }
        return $this->render('subscriptions/edit', ['subscription' => $subscription]);
    }

    public function update(Request $request, Response $response, $id) {
        if ($request->isPost()) {
            $subscriptionModel = new Subscription();
            $subscription = $subscriptionModel->findOne(['id' => $id]);
            if (!$subscription) {
                $this->setFlashMessage('error', 'Assinatura não encontrada.');
                $response->redirect('/subscriptions');
                return;
            }
            $subscriptionModel->loadData($request->getBody());
            if ($subscriptionModel->update($id, $request->getBody())) {
                $this->setFlashMessage('success', 'Assinatura atualizada com sucesso.');
                $response->redirect('/subscriptions');
                return;
            }
        }
        return $this->render('subscriptions/edit', ['subscription' => $subscriptionModel]);
    }

    public function delete(Request $request, Response $response, $id) {
        if ($request->isPost()) {
            $subscriptionModel = new Subscription();
            if ($subscriptionModel->delete($id)) {
                $this->setFlashMessage('success', 'Assinatura excluída com sucesso.');
            } else {
                $this->setFlashMessage('error', 'Erro ao excluir a assinatura.');
            }
            $response->redirect('/subscriptions');
        }
    }
}
