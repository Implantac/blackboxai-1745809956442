<?php

use App\Core\Application;

// Definir diretório raiz
define('ROOT_DIR', dirname(__DIR__));

// Carregar autoloader do Composer
require_once ROOT_DIR . '/vendor/autoload.php';

// Carregar variáveis de ambiente
$dotenv = Dotenv\Dotenv::createImmutable(ROOT_DIR);
$dotenv->load();

// Configurar error reporting
error_reporting(E_ALL);
ini_set('display_errors', $_ENV['APP_ENV'] === 'development' ? '1' : '0');
ini_set('log_errors', '1');
ini_set('error_log', ROOT_DIR . '/logs/error.log');

// Configurar timezone
date_default_timezone_set('America/Sao_Paulo');

// Iniciar a aplicação
$app = new Application(ROOT_DIR);

// Registrar manipuladores de erro
set_error_handler(function($errno, $errstr, $errfile, $errline) {
    if (!(error_reporting() & $errno)) {
        return false;
    }
    
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});

set_exception_handler(function($e) use ($app) {
    error_log($e->getMessage());
    
    if ($_ENV['APP_ENV'] === 'development') {
        echo '<pre>';
        echo $e->getMessage() . "\n";
        echo $e->getTraceAsString();
        echo '</pre>';
    } else {
        $app->response->setStatusCode(500);
        echo $app->router->renderView('_error', [
            'code' => 500,
            'message' => 'Ocorreu um erro interno no servidor.'
        ]);
    }
});

// Carregar rotas
$routes = require_once ROOT_DIR . '/src/Config/routes.php';
$routes($app->router);

// Executar a aplicação
$app->run();
