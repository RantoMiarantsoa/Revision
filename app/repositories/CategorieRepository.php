<?php
    class CategorieRepository {
    private $pdo;

        public function __construct(PDO $pdo) {
            $this->pdo = $pdo;
        }
        
        public function getAll() {
            $stmt = $this->pdo->query("SELECT * FROM takalo_Categorie");
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function getById($id) {
            $stmt = $this->pdo->prepare("SELECT * FROM takalo_Categorie WHERE id_cat = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        public function create($description) {
            $stmt = $this->pdo->prepare("INSERT INTO takalo_Categorie (description) VALUES (?)");
            return $stmt->execute([$description]);
        }

        public function update($id, $description) {
            $stmt = $this->pdo->prepare("UPDATE takalo_Categorie SET description = ? WHERE id_cat = ?");
            return $stmt->execute([$description, $id]);
        }

        public function delete($id) {
            $stmt = $this->pdo->prepare("DELETE FROM takalo_Categorie WHERE id_cat = ?");
            return $stmt->execute([$id]);
        }
    }