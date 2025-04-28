<?php

use App\Controllers\AuthController;
use App\Controllers\DashboardController;

/**
 * Define as rotas da aplicação
 * @param \App\Core\Router $router
 */
return function($router) {
    // Rotas de Autenticação
    $router->get('/login', [AuthController::class, 'login']);
    $router->post('/login', [AuthController::class, 'login']);
    $router->post('/logout', [AuthController::class, 'logout']);
    $router->get('/esqueci-senha', [AuthController::class, 'forgotPassword']);
    $router->post('/esqueci-senha', [AuthController::class, 'forgotPassword']);
    $router->get('/redefinir-senha', [AuthController::class, 'resetPassword']);
    $router->post('/redefinir-senha', [AuthController::class, 'resetPassword']);

    // Dashboard
    $router->get('/', [DashboardController::class, 'index']);
    $router->get('/dashboard', [DashboardController::class, 'index']);

    // Quartos
    $router->get('/quartos', 'RoomController@index');
    $router->get('/quartos/novo', 'RoomController@create');
    $router->post('/quartos/novo', 'RoomController@store');
    $router->get('/quartos/{id}', 'RoomController@show');
    $router->get('/quartos/{id}/editar', 'RoomController@edit');
    $router->post('/quartos/{id}/editar', 'RoomController@update');
    $router->post('/quartos/{id}/excluir', 'RoomController@delete');
    $router->post('/quartos/{id}/status', 'RoomController@updateStatus');

    // Reservas
    $router->get('/reservas', 'BookingController@index');
    $router->get('/reservas/nova', 'BookingController@create');
    $router->post('/reservas/nova', 'BookingController@store');
    $router->get('/reservas/{id}', 'BookingController@show');
    $router->post('/reservas/{id}/checkout', 'BookingController@checkout');
    $router->post('/reservas/{id}/cancelar', 'BookingController@cancel');

    // Financeiro
    $router->get('/financeiro', 'FinanceController@index');
    $router->get('/financeiro/relatorios', 'FinanceController@reports');
    $router->get('/financeiro/relatorios/diario', 'FinanceController@dailyReport');
    $router->get('/financeiro/relatorios/mensal', 'FinanceController@monthlyReport');

    // Configurações
    $router->get('/configuracoes', 'SettingsController@index');
    $router->post('/configuracoes', 'SettingsController@update');
    $router->get('/configuracoes/usuarios', 'UserController@index');
    $router->get('/configuracoes/usuarios/novo', 'UserController@create');
    $router->post('/configuracoes/usuarios/novo', 'UserController@store');
    $router->get('/configuracoes/usuarios/{id}/editar', 'UserController@edit');
    $router->post('/configuracoes/usuarios/{id}/editar', 'UserController@update');
    $router->post('/configuracoes/usuarios/{id}/excluir', 'UserController@delete');

    // Backup automático
    $router->post('/configuracoes/backup', 'BackupController@createBackup');

    // API Routes para AJAX
    $router->get('/api/quartos/disponiveis', 'Api\RoomController@available');
    $router->get('/api/reservas/ativas', 'Api\BookingController@active');
    $router->get('/api/dashboard/stats', 'Api\DashboardController@stats');
};
