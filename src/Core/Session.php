<?php

namespace App\Core;

class Session {
    protected const FLASH_KEY = 'flash_messages';
    protected const LAST_ACTIVITY_KEY = 'last_activity';
    
    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $this->checkSessionTimeout();

        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        foreach ($flashMessages as $key => &$flashMessage) {
            // Mark to be removed
            $flashMessage['remove'] = true;
        }
        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }

    protected function checkSessionTimeout() {
        $timeout = (int) ($_ENV['SESSION_LIFETIME'] ?? 120) * 60; // in seconds
        $now = time();
        $lastActivity = $_SESSION[self::LAST_ACTIVITY_KEY] ?? $now;
        
        if (($now - $lastActivity) > $timeout) {
            $this->destroy();
            session_start();
            $_SESSION[self::LAST_ACTIVITY_KEY] = $now;
            // Optionally set a flash message or flag for timeout
            $_SESSION[self::FLASH_KEY]['error'] = [
                'remove' => false,
                'value' => 'Sua sessão expirou por inatividade. Por favor, faça login novamente.'
            ];
        } else {
            $_SESSION[self::LAST_ACTIVITY_KEY] = $now;
        }
    }

    public function setFlash($key, $message) {
        $_SESSION[self::FLASH_KEY][$key] = [
            'remove' => false,
            'value' => $message
        ];
    }

    public function getFlash($key) {
        return $_SESSION[self::FLASH_KEY][$key]['value'] ?? false;
    }

    public function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    public function get($key) {
        return $_SESSION[$key] ?? false;
    }

    public function remove($key) {
        unset($_SESSION[$key]);
    }

    public function destroy() {
        session_destroy();
    }

    public function regenerate() {
        session_regenerate_id(true);
    }

    public function __destruct() {
        $flashMessages = $_SESSION[self::FLASH_KEY] ?? [];
        foreach ($flashMessages as $key => $flashMessage) {
            if ($flashMessage['remove']) {
                unset($flashMessages[$key]);
            }
        }
        $_SESSION[self::FLASH_KEY] = $flashMessages;
    }

    public function isAuthenticated() {
        return isset($_SESSION['user_id']);
    }

    public function getUserId() {
        return $_SESSION['user_id'] ?? null;
    }

    public function setUserData($userData) {
        $_SESSION['user'] = $userData;
        $_SESSION['user_id'] = $userData['id'];
    }

    public function getUserData() {
        return $_SESSION['user'] ?? null;
    }
}
