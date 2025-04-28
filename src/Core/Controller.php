<?php

namespace App\Core;

class Controller {
    public string $layout = 'main';
    public string $action = '';
    protected array $middlewares = [];

    public function render($view, $params = []) {
        return Application::$app->router->renderView($view, $params);
    }

    public function setLayout($layout) {
        $this->layout = $layout;
    }

    public function registerMiddleware($middleware) {
        $this->middlewares[] = $middleware;
    }

    public function getMiddlewares(): array {
        return $this->middlewares;
    }

    protected function json($data, $statusCode = 200) {
        return Application::$app->response->json($data, $statusCode);
    }

    protected function redirect($url) {
        return Application::$app->response->redirect($url);
    }

    protected function setFlashMessage($key, $message) {
        Application::$app->session->setFlash($key, $message);
    }

    protected function getRequestBody() {
        $this->validateCsrfToken();
        return Application::$app->request->getBody();
    }

    protected function validateCsrfToken() {
        if (Application::$app->request->isPost()) {
            $token = Application::$app->request->getBody()['csrf_token'] ?? '';
            $storedToken = Application::$app->session->get('csrf_token');
            if (!$token || !hash_equals($storedToken, $token)) {
                throw new \Exception('Token CSRF inválido.');
            }
        }
    }

    protected function isPost() {
        return Application::$app->request->isPost();
    }

    protected function isGet() {
        return Application::$app->request->isGet();
    }

    protected function getUser() {
        return Application::$app->session->getUserData();
    }

    protected function isAuthenticated() {
        return Application::$app->session->isAuthenticated();
    }

    protected function requireAuth() {
        if (!$this->isAuthenticated()) {
            $this->setFlashMessage('error', 'Você precisa estar logado para acessar esta página.');
            $this->redirect('/login');
        }
    }

    protected function requireAdmin() {
        if (!$this->isAuthenticated() || $this->getUser()['role'] !== 'admin') {
            $this->setFlashMessage('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
            $this->redirect('/');
        }
    }
}
