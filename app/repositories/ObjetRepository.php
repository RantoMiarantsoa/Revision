<?php
    class ObjetRepository {
        private $pdo;

        public function __construct(PDO $pdo) {
            $this->pdo = $pdo;
        }

        public function getAll() {
            $stmt = $this->pdo->query("SELECT * FROM Objet");
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }

        public function getById($id) {
            $stmt = $this->pdo->prepare("SELECT * FROM Objet WHERE id_obj = ?");
            $stmt->execute([$id]);
            return $stmt->fetch(\PDO::FETCH_ASSOC);
        }

        public function create($nom, $description, $prix, $id_cat, $id_user) {
            $stmt = $this->pdo->prepare("INSERT INTO Objet (nom, description, prix, id_cat, id_user) VALUES (?, ?, ?, ?, ?)");
            return $stmt->execute([$nom, $description, $prix, $id_cat, $id_user]);
        }

        public function update($id, $nom, $description, $prix, $id_cat, $id_user) {
            $stmt = $this->pdo->prepare("UPDATE Objet SET nom = ?, description = ?, prix = ?, id_cat = ?, id_user = ? WHERE id_obj = ?");
            return $stmt->execute([$nom, $description, $prix, $id_cat, $id_user, $id]);
        }

        public function delete($id) {
            $stmt = $this->pdo->prepare("DELETE FROM Objet WHERE id_obj = ?");
            return $stmt->execute([$id]);
        }

        public function getByCategory($id_cat) {
            $stmt = $this->pdo->prepare("SELECT * FROM Objet WHERE id_cat = ?");
            $stmt->execute([$id_cat]);
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        }
    }