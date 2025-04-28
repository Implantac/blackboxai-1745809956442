<?php
// server.php - Script para roteamento do servidor de desenvolvimento

// Verificar se o arquivo solicitado existe
$uri = urldecode(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH));

// Se o arquivo existir, servir diretamente
if ($uri !== '/' && file_exists(__DIR__ . '/public' . $uri)) {
    return false;
}

// Caso contrário, redirecionar todas as requisições para o index.php
require_once __DIR__ . '/public/index.php';
