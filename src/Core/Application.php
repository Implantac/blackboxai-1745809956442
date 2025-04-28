<?php

namespace App\Core;

class Application {
    public static string $ROOT_DIR;
    public Router $router;
    public Request $request;
    public Response $response;
    public Database $db;
    public Session $session;
    public static Application $app;
    public ?Controller $controller = null;
    public string $layout = 'main';

    public function __construct($rootPath) {
        self::$ROOT_DIR = $rootPath;
        self::$app = $this;
        
        $this->request = new Request();
        $this->response = new Response();
        $this->session = new Session();

        // Check for session timeout message and redirect to login if needed
        $timeoutMessage = $this->session->getFlash('error');
        if ($timeoutMessage === 'Sua sessão expirou por inatividade. Por favor, faça login novamente.') {
            $this->response->redirect('/login');
            exit;
        }

        $this->router = new Router($this->request, $this->response);
        
        try {
            $this->db = new Database();
        } catch (\Exception $e) {
            error_log($e->getMessage());
            die('Erro de conexão com o banco de dados. Por favor, contate o administrador.');
        }
    }

    public function run() {
        try {
            echo $this->router->resolve();
        } catch (\Exception $e) {
            error_log($e->getMessage());
            $this->response->setStatusCode(500);
            echo $this->renderError();
        }
    }

    public function setLayout($layout) {
        $this->layout = $layout;
    }

    public function getLayout() {
        return $this->layout;
    }

    public function renderError($code = 500) {
        return $this->router->renderView('_error', [
            'code' => $code,
            'message' => 'Ocorreu um erro inesperado.'
        ]);
    }

    public static function isGuest() {
        return !self::$app->session->get('user');
    }
}
