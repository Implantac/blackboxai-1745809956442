<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Core\Middlewares\AuthMiddleware;
use App\Core\Request;
use App\Core\Response;

class BackupController extends Controller {
    public function __construct() {
        $this->registerMiddleware(new AuthMiddleware());
    }

    public function createBackup(Request $request, Response $response) {
        $backupScript = __DIR__ . '/../Config/backup_db.php';
        ob_start();
        include $backupScript;
        $output = ob_get_clean();

        $this->setFlashMessage('success', "Backup realizado com sucesso.\n$output");
        return $response->redirect('/configuracoes');
    }
}
