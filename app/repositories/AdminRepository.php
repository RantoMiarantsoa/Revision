<?php

class AdminRepository {
    private $pdo;

    public function __construct(PDO $pdo) {
        $this->pdo = $pdo;
    }

    public function getAdmin($nom) {
        $stmt = $this->pdo->prepare("SELECT * FROM takalo_admin WHERE nom = ? LIMIT 1");
        $stmt->execute([$nom]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getAdminById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM takalo_admin WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}
