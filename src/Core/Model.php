<?php

namespace App\Core;

abstract class Model {
    protected Database $db;
    protected string $table;
    public array $errors = [];

    public function __construct() {
        $this->db = Application::$app->db;
    }

    public function validate($data): bool {
        return true;
    }

    public function loadData($data) {
        foreach ($data as $key => $value) {
            if (property_exists($this, $key)) {
                $this->{$key} = $value;
            }
        }
    }

    public function save(): bool {
        return false;
    }

    public function findOne($conditions) {
        $tableName = $this->table;
        $attributes = array_keys($conditions);
        $sql = implode(" AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
        $stmt = $this->db->prepare("SELECT * FROM $tableName WHERE $sql");
        foreach ($conditions as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }
        $stmt->execute();
        return $stmt->fetch();
    }

    public function findAll($conditions = [], $orderBy = '', $limit = null) {
        $tableName = $this->table;
        $sql = "SELECT * FROM $tableName";
        
        if (!empty($conditions)) {
            $attributes = array_keys($conditions);
            $sql .= " WHERE " . implode(" AND ", array_map(fn($attr) => "$attr = :$attr", $attributes));
        }
        
        if ($orderBy) {
            $sql .= " ORDER BY $orderBy";
        }
        
        if ($limit) {
            $sql .= " LIMIT $limit";
        }
        
        $stmt = $this->db->prepare($sql);
        
        if (!empty($conditions)) {
            foreach ($conditions as $key => $value) {
                $stmt->bindValue(":$key", $value);
            }
        }
        
        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function update($id, $attributes) {
        $tableName = $this->table;
        $params = array_map(fn($attr) => "$attr = :$attr", array_keys($attributes));
        $sql = "UPDATE $tableName SET " . implode(",", $params) . " WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $attributes['id'] = $id;
        return $stmt->execute($attributes);
    }

    public function delete($id) {
        $tableName = $this->table;
        $sql = "DELETE FROM $tableName WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    public function addError($attribute, $message) {
        $this->errors[$attribute][] = $message;
    }

    public function hasError($attribute) {
        return !empty($this->errors[$attribute]);
    }

    public function getFirstError($attribute) {
        return $this->errors[$attribute][0] ?? '';
    }

    protected function labels(): array {
        return [];
    }

    public function getLabel($attribute) {
        return $this->labels()[$attribute] ?? $attribute;
    }

    protected function rules(): array {
        return [];
    }
}
