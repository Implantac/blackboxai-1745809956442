<?php

namespace App\Models;

use App\Core\Model;
use App\Core\Application;

class User extends Model {
    protected string $table = 'users';
    
    public string $id = '';
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $role = '';
    public string $status = '';
    public string $two_factor_secret = '';
    public string $permissions = '[]';
    public string $created_at = '';
    public string $updated_at = '';

    public function tableName(): string {
        return 'users';
    }

    public function getPermissions(): array {
        return json_decode($this->permissions, true) ?? [];
    }

    public function setPermissions(array $permissions): void {
        $this->permissions = json_encode($permissions);
    }

    public function login(string $email, string $password): bool {
        $user = $this->findOne(['email' => $email]);

        if (!$user) {
            return false;
        }

        if (!password_verify($password, $user['password'])) {
            return false;
        }

        if ($user['status'] !== 'active') {
            return false;
        }

        // Remove senha antes de armazenar na sessão
        unset($user['password']);
        
        Application::$app->session->setUserData($user);
        return true;
    }

    public function register(array $data): bool {
        if ($this->findOne(['email' => $data['email']])) {
            $this->addError('email', 'Este email já está em uso');
            return false;
        }

        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        try {
            $columns = implode(',', array_keys($data));
            $values = implode(',', array_fill(0, count($data), '?'));
            
            $sql = "INSERT INTO {$this->table} ($columns) VALUES ($values)";
            return $this->db->execute($sql, array_values($data));
        } catch (\Exception $e) {
            $this->addError('register', 'Erro ao registrar usuário');
            return false;
        }
    }

    public function requestPasswordReset(string $email): bool {
        $user = $this->findOne(['email' => $email]);
        
        if (!$user) {
            return false;
        }

        $token = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));

        try {
            $sql = "INSERT INTO password_resets (user_id, token, expires_at) VALUES (?, ?, ?)";
            $this->db->execute($sql, [$user['id'], $token, $expires]);

            // TODO: Enviar email com link de reset
            // $this->sendPasswordResetEmail($user['email'], $token);

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }

    public function resetPassword(string $token, string $password): bool {
        $sql = "SELECT user_id FROM password_resets WHERE token = ? AND expires_at > NOW() AND used = 0";
        $reset = $this->db->fetch($sql, [$token]);

        if (!$reset) {
            return false;
        }

        try {
            $this->db->beginTransaction();

            // Atualiza a senha
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $this->update($reset['user_id'], ['password' => $hashedPassword]);

            // Marca o token como usado
            $sql = "UPDATE password_resets SET used = 1 WHERE token = ?";
            $this->db->execute($sql, [$token]);

            $this->db->commit();
            return true;
        } catch (\Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function rules(): array {
        return [
            'name' => [self::RULE_REQUIRED],
            'email' => [self::RULE_REQUIRED, self::RULE_EMAIL],
            'password' => [self::RULE_REQUIRED, [self::RULE_MIN, 'min' => 8]],
        ];
    }

    public function labels(): array {
        return [
            'name' => 'Nome',
            'email' => 'Email',
            'password' => 'Senha',
            'role' => 'Função',
            'status' => 'Status'
        ];
    }
}
