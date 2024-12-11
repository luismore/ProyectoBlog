<?php
require_once '../config/config.php';

class CategoryController {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    // Método para crear una nueva categoría
    public function createCategory($name) {
        if ($this->isAdmin()) {
            $stmt = $this->db->prepare("INSERT INTO categories (name) VALUES (:name)");
            $stmt->bindParam(':name', $name);
            return $stmt->execute();
        } else {
            throw new Exception("No tienes permiso para crear categorías.");
        }
    }

    // Método para editar una categoría existente
    public function editCategory($id, $newName) {
        if ($this->isAdmin()) {
            $stmt = $this->db->prepare("UPDATE categories SET name = :name WHERE id = :id");
            $stmt->bindParam(':name', $newName);
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } else {
            throw new Exception("No tienes permiso para editar categorías.");
        }
    }

    // Método para borrar una categoría
    public function deleteCategory($id) {
        if ($this->isAdmin()) {
            $stmt = $this->db->prepare("DELETE FROM categories WHERE id = :id");
            $stmt->bindParam(':id', $id);
            return $stmt->execute();
        } else {
            throw new Exception("No tienes permiso para borrar categorías.");
        }
    }

    private function isAdmin() {
        return isset($_SESSION['user_role']) && $_SESSION['user_role'] === 'admin';
    }
}