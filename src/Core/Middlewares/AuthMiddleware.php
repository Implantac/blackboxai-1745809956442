<?php

namespace App\Core\Middlewares;

use App\Core\Application;
use App\Core\Middleware;
use App\Core\Exception\ForbiddenException;

class AuthMiddleware implements Middleware {
    protected array $actions = [];

    public function __construct(array $actions = []) {
        $this->actions = $actions;
    }

    public function execute() {
        if (Application::isGuest()) {
            if (empty($this->actions) || in_array(Application::$app->controller->action, $this->actions)) {
                Application::$app->session->setFlash('error', 'Você precisa estar logado para acessar esta página.');
                Application::$app->response->redirect('/login');
            }
        }
    }

    public static function isAdmin() {
        if (!Application::isGuest()) {
            $user = Application::$app->session->getUserData();
            return $user['role'] === 'admin';
        }
        return false;
    }

    public static function requireAdmin() {
        if (!self::isAdmin()) {
            Application::$app->session->setFlash('error', 'Acesso negado. Você não tem permissão para acessar esta página.');
            Application::$app->response->redirect('/');
            exit;
        }
    }

    public static function requirePermission($permission) {
        if (!Application::isGuest()) {
            $user = Application::$app->session->getUserData();
            $userPermissions = $user['permissions'] ?? [];
            
            if (!in_array($permission, $userPermissions)) {
                Application::$app->session->setFlash('error', 'Acesso negado. Você não tem permissão para realizar esta ação.');
                Application::$app->response->redirect('/');
                exit;
            }
        } else {
            Application::$app->session->setFlash('error', 'Você precisa estar logado para acessar esta página.');
            Application::$app->response->redirect('/login');
            exit;
        }
    }
}
