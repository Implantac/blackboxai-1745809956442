<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Application;
use App\Models\User;
use App\Models\AuditLog;
use App\Core\Request;
use App\Core\Response;

class AuthController extends Controller {
    public function __construct() {
        $this->setLayout('auth');
    }

    public function getLayout() {
        return $this->layout;
    }

    public function login(Request $request, Response $response) {
        if ($request->isPost()) {
            $email = $request->getBody()['email'] ?? '';
            $password = $request->getBody()['password'] ?? '';
            $twoFactorCode = $request->getBody()['two_factor_code'] ?? null;
            $rememberMe = isset($request->getBody()['remember_me']);

            $user = new User();
            $userData = $user->findOne(['email' => $email]);

            if (!$userData || !password_verify($password, $userData['password'])) {
                Application::$app->session->setFlash('error', 'Email ou senha inválidos');
                return $this->render('auth/login_final_v2');
            }

            // Check if 2FA is enabled
            if (!empty($userData['two_factor_secret'])) {
                if (!$twoFactorCode) {
                    // Prompt for 2FA code
                    return $this->render('auth/login_final_v2', ['require2FA' => true, 'email' => $email]);
                }

                // Verify 2FA code
                $google2fa = new \PragmaRX\Google2FA\Google2FA();
                if (!$google2fa->verifyKey($userData['two_factor_secret'], $twoFactorCode)) {
                    Application::$app->session->setFlash('error', 'Código 2FA inválido');
                    return $this->render('auth/login_final_v2', ['require2FA' => true, 'email' => $email]);
                }
            }

            // Login success
            unset($userData['password']);
            Application::$app->session->setUserData($userData);

            if ($rememberMe) {
                $token = bin2hex(random_bytes(32));
                Application::$app->session->set('remember_token', $token);
            }

            // Log login event
            $auditLog = new AuditLog();
            $auditLog->logAction($userData['id'], 'login', 'user', $userData['id'], ['ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown']);

            Application::$app->session->setFlash('success', 'Bem-vindo de volta!');
            return $response->redirect('/dashboard');
        }

        return $this->render('auth/login_final_v2');
    }

    public function logout(Request $request, Response $response) {
        $user = Application::$app->session->getUserData();
        if ($user) {
            $auditLog = new AuditLog();
            $auditLog->logAction($user['id'], 'logout', 'user', $user['id'], ['ip' => $_SERVER['REMOTE_ADDR'] ?? 'unknown']);
        }

        Application::$app->session->remove('user');
        Application::$app->session->remove('user_id');
        Application::$app->session->destroy();
        Application::$app->session->regenerate();

        return $response->redirect('/login');
    }

    public function forgotPassword(Request $request, Response $response) {
        if ($request->isPost()) {
            $email = $request->getBody()['email'] ?? '';

            $user = new User();
            if ($user->requestPasswordReset($email)) {
                Application::$app->session->setFlash('success',
                    'Se o email existir em nossa base, você receberá instruções para redefinir sua senha.');
                return $response->redirect('/login');
            }
        }

        return $this->render('auth/forgot-password');
    }

    public function resetPassword(Request $request, Response $response) {
        $token = $request->getBody()['token'] ?? '';

        if ($request->isPost()) {
            $password = $request->getBody()['password'] ?? '';
            $passwordConfirm = $request->getBody()['password_confirm'] ?? '';

            if ($password !== $passwordConfirm) {
                Application::$app->session->setFlash('error', 'As senhas não coincidem');
                return $this->render('auth/reset-password', ['token' => $token]);
            }

            $user = new User();
            if ($user->resetPassword($token, $password)) {
                Application::$app->session->setFlash('success', 'Senha alterada com sucesso!');
                return $response->redirect('/login');
            }

            Application::$app->session->setFlash('error', 'Token inválido ou expirado');
        }

        return $this->render('auth/reset-password', ['token' => $token]);
    }

    protected function generateCsrfToken() {
        $token = bin2hex(random_bytes(32));
        Application::$app->session->set('csrf_token', $token);
        return $token;
    }

    // Removed validateCsrfToken to inherit from base Controller
}
