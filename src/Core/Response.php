<?php

namespace App\Core;

class Response {
    public function setStatusCode(int $code) {
        http_response_code($code);
    }

    public function redirect($url) {
        header("Location: $url");
        exit;
    }

    public function json($data, $statusCode = 200) {
        $this->setStatusCode($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit;
    }

    public function setHeader($header, $value) {
        header("$header: $value");
    }

    public function setCookie(
        string $name,
        string $value = "",
        int $expires = 0,
        string $path = "",
        string $domain = "",
        bool $secure = false,
        bool $httponly = false
    ) {
        setcookie($name, $value, $expires, $path, $domain, $secure, $httponly);
    }

    public function download($filePath, $fileName = null) {
        if (!file_exists($filePath)) {
            $this->setStatusCode(404);
            return false;
        }

        $fileName = $fileName ?? basename($filePath);

        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
        header('Content-Length: ' . filesize($filePath));

        readfile($filePath);
        exit;
    }

    public function error($message, $code = 500) {
        $this->setStatusCode($code);
        return $this->json([
            'error' => true,
            'message' => $message
        ], $code);
    }

    public function success($data = [], $message = 'Operação realizada com sucesso', $code = 200) {
        return $this->json([
            'error' => false,
            'message' => $message,
            'data' => $data
        ], $code);
    }
}
