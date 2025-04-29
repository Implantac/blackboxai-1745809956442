<?php

namespace App\Controllers\Api;

use App\Core\Controller;
use App\Core\Middlewares\AuthMiddleware;
use App\Core\Request;
use App\Core\Response;
use App\Models\MinibarItem;

class MinibarController extends Controller {
    public function __construct() {
        $this->registerMiddleware(new AuthMiddleware());
    }

    public function index(Request $request, Response $response) {
        $minibarModel = new MinibarItem();
        $items = $minibarModel->findAll();

        return $response->json([
            'items' => $items
        ]);
    }

    // Additional methods for consumption tracking can be added here
}
