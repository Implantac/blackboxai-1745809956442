<?php

namespace App\Core;

class Cache {
    private string $cacheDir;

    public function __construct() {
        $this->cacheDir = Application::$ROOT_DIR . '/cache';
        if (!is_dir($this->cacheDir)) {
            mkdir($this->cacheDir, 0777, true);
        }
    }

    public function get(string $key) {
        $file = $this->getCacheFilePath($key);
        if (!file_exists($file)) {
            return null;
        }
        $data = file_get_contents($file);
        $cache = unserialize($data);
        if ($cache['expires_at'] < time()) {
            unlink($file);
            return null;
        }
        return $cache['value'];
    }

    public function set(string $key, $value, int $ttl = 3600) {
        $file = $this->getCacheFilePath($key);
        $cache = [
            'value' => $value,
            'expires_at' => time() + $ttl
        ];
        file_put_contents($file, serialize($cache));
    }

    public function delete(string $key) {
        $file = $this->getCacheFilePath($key);
        if (file_exists($file)) {
            unlink($file);
        }
    }

    private function getCacheFilePath(string $key): string {
        return $this->cacheDir . '/' . md5($key) . '.cache';
    }
}
