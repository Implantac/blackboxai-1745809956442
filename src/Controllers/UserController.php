<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Middlewares\AuthMiddleware;
use App\Core\Request;
use App\Core\Response;
use App\Models\User;

class UserController extends Controller {
    public function __construct() {
        $this->registerMiddleware(new AuthMiddleware());
    }

    public function twoFactorSetup(Request $request, Response $response) {
        $user = new \App\Models\User();
        $userData = $user->findOne(['id' => $this->getUser()['id']]);

        $google2fa = new \PragmaRX\Google2FA\Google2FA();

        if ($request->isPost()) {
            $action = $request->getBody()['action'] ?? null;
            $code = $request->getBody()['two_factor_code'] ?? null;

            if ($action === 'enable') {
                if (!$userData['two_factor_secret']) {
                    $secret = $google2fa->generateSecretKey();
                    $userData['two_factor_secret'] = $secret;
                    $user->update($userData['id'], ['two_factor_secret' => $secret]);
                } else {
                    $secret = $userData['two_factor_secret'];
                }

                if ($google2fa->verifyKey($secret, $code)) {
                    $this->setFlashMessage('success', '2FA ativado com sucesso.');
                } else {
                    $this->setFlashMessage('error', 'Código 2FA inválido.');
                }
            } elseif ($action === 'disable') {
                $user->update($userData['id'], ['two_factor_secret' => null]);
                $this->setFlashMessage('success', '2FA desativado com sucesso.');
            }

            return $response->redirect('/configuracoes/usuarios/2fa');
        }

        if (!$userData['two_factor_secret']) {
            $secret = $google2fa->generateSecretKey();
            $qrCodeUrl = $google2fa->getQRCodeUrl(
                $_ENV['APP_NAME'],
                $userData['email'],
                $secret
            );
        } else {
            $secret = $userData['two_factor_secret'];
            $qrCodeUrl = $google2fa->getQRCodeUrl(
                $_ENV['APP_NAME'],
                $userData['email'],
                $secret
            );
        }

        return $this->render('users/2fa_setup', [
            'qrCodeUrl' => $qrCodeUrl,
            'secret' => $secret
        ]);
    }

    public function index() {
        $userModel = new User();
        $users = $userModel->findAll();
        return $this->render('users/index', ['users' => $users]);
    }

    public function create() {
        return $this->render('users/create');
    }

    public function store(Request $request, Response $response) {
        if ($request->isPost()) {
            $user = new User();
            $user->loadData($request->getBody());

            if ($user->register($request->getBody())) {
                $this->setFlashMessage('success', 'Usuário criado com sucesso.');
                $response->redirect('/configuracoes/usuarios');
                return;
            }
        }
        return $this->render('users/create', ['user' => $user]);
    }

    public function edit($id) {
        $userModel = new User();
        $user = $userModel->findOne(['id' => $id]);
        if (!$user) {
            $this->setFlashMessage('error', 'Usuário não encontrado.');
            return $this->redirect('/configuracoes/usuarios');
        }
        return $this->render('users/edit', ['user' => $user]);
    }

    public function update(Request $request, Response $response, $id) {
        if ($request->isPost()) {
            $userModel = new User();
            $user = $userModel->findOne(['id' => $id]);
            if (!$user) {
                $this->setFlashMessage('error', 'Usuário não encontrado.');
                $response->redirect('/configuracoes/usuarios');
                return;
            }
            $userModel->loadData($request->getBody());
            if ($userModel->update($id, $request->getBody())) {
                $this->setFlashMessage('success', 'Usuário atualizado com sucesso.');
                $response->redirect('/configuracoes/usuarios');
                return;
            }
        }
        return $this->render('users/edit', ['user' => $userModel]);
    }

    public function delete(Request $request, Response $response, $id) {
        if ($request->isPost()) {
            $userModel = new User();
            if ($userModel->delete($id)) {
                $this->setFlashMessage('success', 'Usuário excluído com sucesso.');
            } else {
                $this->setFlashMessage('error', 'Erro ao excluir o usuário.');
            }
            $response->redirect('/configuracoes/usuarios');
        }
    }
}
